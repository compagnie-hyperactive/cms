<?php
/**
 * Created by PhpStorm.
 * User: matthieu
 * Date: 14/02/18
 * Time: 14:53
 */

namespace App\Controller\Admin;

use App\Entity\Article;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AdminController as BaseAdminController;
use EasyCorp\Bundle\EasyAdminBundle\Event\EasyAdminEvents;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ArticleController extends BaseAdminController
{
    public function exportAction()
    {
        $searchQuery = trim($this->request->query->get('query'));
        $status = trim($this->request->query->get('status'));
        $dqlFilter = $this->entity['search']['dql_filter'];
        $searchableFields = $this->entity['search']['fields'];

        if ('' !== $status) {

            if ($status === 'published') {
                $statusFilter = 'entity.published = 1';
            } elseif ($status === 'non-published') {
                $statusFilter = 'entity.published = 0';
            }
            if (isset($statusFilter)) {
                $dqlFilter = isset($dqlFilter) ? $dqlFilter .' AND '.$statusFilter : $statusFilter;
            }
        }

        $queryBuilder = $this->createSearchQueryBuilder($this->entity['class'], $searchQuery, $searchableFields, null, null, $dqlFilter);

        $results = $queryBuilder->getQuery()->execute();

        $columns = ['Titre','Status'];

        $response = new StreamedResponse();
        $response->setCallback(function () use ($results, $columns) {
            $handle = fopen('php://output', 'w+');
            // Add header
            fputcsv($handle, $columns);
            array_map(function(Article $article) use ($handle) {
                //return [$article->getTitle(), $article->getPublished()];
                fputcsv($handle, [$article->getTitle(), $article->getPublished() === true ? 'Publié' : 'Non publié']);
            }, $results);
            fclose($handle);
        });
        $filename = $this->request->query->get('entity').'-'.(new \DateTime())->format('d-m-y').'.csv';
        $response->headers->set('Content-Type', 'text/csv; charset=utf-8');
        $response->headers->set('Content-Disposition', 'attachment; filename="' . $filename . '"');
        return $response;
    }

    protected function searchAction()
    {
        $this->dispatch(EasyAdminEvents::PRE_SEARCH);

        $query = trim($this->request->query->get('query'));
        $status = trim($this->request->query->get('status'));

        // if the search query is empty, redirect to the 'list' action
        if ('' === $query && '' === $status) {
            $queryParameters = array_replace($this->request->query->all(), array('action' => 'list', 'query' => null));
            $queryParameters = array_filter($queryParameters);

            return $this->redirect($this->get('router')->generate('easyadmin', $queryParameters));
        }

        if ('' !== $status) {
            if ($status === 'published') {
                $statusFilter = 'entity.published = 1';
            } elseif ($status === 'non-published') {
                $statusFilter = 'entity.published = 0';
            }
            if (isset($statusFilter)) {
                $this->entity['search']['dql_filter'] = isset($this->entity['search']['dql_filter']) ? $this->entity['search']['dql_filter'] .' AND '.$statusFilter : $statusFilter;
            }
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

        $this->dispatch(EasyAdminEvents::POST_SEARCH, array(
            'fields' => $fields,
            'paginator' => $paginator,
        ));

        return $this->render($this->entity['templates']['list'], array(
            'paginator' => $paginator,
            'fields' => $fields,
            'delete_form_template' => $this->createDeleteForm($this->entity['name'], '__id__')->createView(),
        ));
    }
}