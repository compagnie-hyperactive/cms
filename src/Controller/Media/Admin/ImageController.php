<?php
/**
 * Created by PhpStorm.
 * User: matthieu
 * Date: 01/02/18
 * Time: 11:21
 */

namespace App\Controller\Media\Admin;

use App\Entity\Media\Image;
use App\Media\Event\Image\ImageDownloadEvent;
use App\Media\ImageEvents;
use App\Media\ImageManager;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AdminController as BaseAdminController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ImageController extends BaseAdminController
{
    /** @var ImageManager  */
    private $imageManager;

    public function __construct(ImageManager $imageManager)
    {
        $this->imageManager = $imageManager;
    }

    public function newAjaxAction()
    {
        $entity = $this->executeDynamicMethod('createNew<EntityName>Entity');

        $easyadmin = $this->request->attributes->get('easyadmin');
        $easyadmin['item'] = $entity;
        $this->request->attributes->set('easyadmin', $easyadmin);

        $fields = $this->entity['new']['fields'];

        $newForm = $this->executeDynamicMethod('create<EntityName>NewForm', [
            $entity,
            $fields,
        ]);

        $newForm->handleRequest($this->request);

        if ($newForm->isSubmitted() && $newForm->isValid()) {

            try {
                $this->executeDynamicMethod('prePersist<EntityName>Entity', array($entity));
                $this->executeDynamicMethod('persist<EntityName>Entity', array($entity));

                //$path = $this->helper->asset($entity, 'imageFile');
                $path = $this->imageManager->getPath($entity);

                return new JsonResponse([
                    'id' => $entity->getId(),
                    'name' => $entity->getTitle(),
                    'image' => $path,
                ]);
            } catch (\Exception $e) {
                return new Response(
                    $e->getMessage(),
                    $e->getCode()
                );
            }

        }

        return $this->render('EasyAdmin/Image/newAjax.html.twig', [
            'form' => $newForm->createView(),
            'entity_fields' => $fields,
            'entity' => $entity,
        ]);
    }

    public function listAjaxAction()
    {
        $fields = $this->entity['list']['fields'];
        $paginator = $this->findAll(
            $this->entity['class'],
            $this->request->query->get('page', 1),
            $this->config['list']['max_results'],
            $this->request->query->get('sortField'),
            $this->request->query->get('sortDirection'),
            $this->entity['list']['dql_filter']
        );

        return $this->render('EasyAdmin/Image/listAjax.html.twig', [
            'paginator' => $paginator,
            'fields' => $fields,
        ]);
    }

    protected function searchAjaxAction()
    {
        //$this->dispatch(EasyAdminEvents::PRE_SEARCH);

        $query = trim($this->request->query->get('query'));
        // if the search query is empty, redirect to the 'list' action
        if ('' === $query) {
            $queryParameters = array_replace($this->request->query->all(), array('action' => 'list', 'query' => null));
            $queryParameters = array_filter($queryParameters);

            return $this->redirect($this->get('router')->generate('easyadmin', $queryParameters));
        }

        $searchableFields = $this->entity['search']['fields'];
        $paginator = $this->findBy(
            $this->entity['class'],
            $query,
            $searchableFields,
            $this->request->query->get('page', 1),
            $this->config['list']['max_results'],
            isset($this->entity['search']['sort']['field']) ? $this->entity['search']['sort']['field'] : $this->request->query->get('sortField'),
            isset($this->entity['search']['sort']['direction']) ? $this->entity['search']['sort']['direction'] : $this->request->query->get('sortDirection'),
            $this->entity['search']['dql_filter']
        );
        $fields = $this->entity['list']['fields'];

//        $this->dispatch(EasyAdminEvents::POST_SEARCH, array(
//            'fields' => $fields,
//            'paginator' => $paginator,
//        ));

        return $this->render('EasyAdmin/Image/listAjax.html.twig', [
            'paginator' => $paginator,
            'fields' => $fields,
        ]);
    }

    /**
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function downloadAction()
    {
        $easyadmin = $this->request->attributes->get('easyadmin');

        /** @var Image $entity */
        $entity = $easyadmin['item'];

        $event = new ImageDownloadEvent($entity);
        $this->get('event_dispatcher')->dispatch(ImageEvents::PRE_DOWNLOAD, $event);

        // Check if user is authorized to download this document
        //$this->denyAccessUnlessGranted('download', $entity);

        // Dispatch DocumentDownloadEvent
        $event = new ImageDownloadEvent($entity);
        $this->get('event_dispatcher')->dispatch(ImageEvents::POST_DOWNLOAD, $event);

        $filename = $this->imageManager->sanitizeOutputName($event->getFilename().'.'.$event->getFile()->getExtension());

        // Return file
        return $this->file($event->getFile(), $filename);
    }

}