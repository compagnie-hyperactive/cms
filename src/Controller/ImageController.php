<?php
/**
 * Created by PhpStorm.
 * User: matthieu
 * Date: 01/02/18
 * Time: 11:21
 */

namespace App\Controller;

use EasyCorp\Bundle\EasyAdminBundle\Controller\AdminController as BaseAdminController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Vich\UploaderBundle\Templating\Helper\UploaderHelper;

class ImageController extends BaseAdminController
{
    /**
     * @var UploaderHelper
     */
    private $helper;

    public function __construct(UploaderHelper $helper)
    {
        $this->helper = $helper;
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

                $path = $this->helper->asset($entity, 'imageFile');

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
}