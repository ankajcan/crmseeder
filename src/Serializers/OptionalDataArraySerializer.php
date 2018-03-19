<?php

/**
 * This file removes 'data' wrapper in included collections or items
 */
namespace Project\Serializers;
use League\Fractal\Serializer\DataArraySerializer;
use League\Fractal\Pagination\PaginatorInterface;

class OptionalDataArraySerializer extends DataArraySerializer
{
    /**
     * @param string $resourceKey
     * @param array $data
     * @return array
     */
    public function collection($resourceKey, array $data)
    {
        return ($resourceKey) ? array($resourceKey => $data) : $data;
    }

    /**
     * @param string $resourceKey
     * @param array $data
     * @return array
     */
    public function item($resourceKey, array $data)
    {
        return ($resourceKey) ? array($resourceKey => $data) : $data;
    }



    /**
     * Serialize the paginator
     *
     * @param  PaginatorInterface $paginator
     * @return array
     **/
    public function paginator(PaginatorInterface $paginator)
    {
        $currentPage = (int) $paginator->getCurrentPage();
        $lastPage = (int) $paginator->getLastPage();

        $pagination = array(
            'total' => (int) $paginator->getTotal(),
            'count' => (int) $paginator->getCount(),
            'perPage' => (int) $paginator->getPerPage(),
            'currentPage' => $currentPage,
            'totalPages' => $lastPage,
        );

//        $pagination['links'] = array();

        if ($currentPage > 1) {
//            $pagination['links']['previous'] = $paginator->getUrl($currentPage - 1);
            $pagination['previousPage'] = $currentPage - 1;
        }

        if ($currentPage < $lastPage) {
//            $pagination['links']['next'] = $paginator->getUrl($currentPage + 1);
            $pagination['nextPage'] = $currentPage + 1;
        }

        return array('pagination' => $pagination);
    }




}
