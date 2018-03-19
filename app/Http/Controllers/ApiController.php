<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use League\Fractal\Manager;
use League\Fractal\Resource\Item;
use League\Fractal\Resource\Collection;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use Project\Serializers\OptionalDataArraySerializer;

class ApiController extends Controller
{
    const STATUS_OK = 200;
    const STATUS_CREATED = 201;

    protected $statusCode;

    protected $fractal;

    protected $transformer;

    protected $user;

    public function __construct()
    {
        $this->fractal = new Manager();

        $this->fractal->setSerializer(new OptionalDataArraySerializer);

        if (request()->has('include')) {

            $this->fractal->parseIncludes(request('include'));
        }
    }

    /**
     * @return int
     */
    public function getStatusCode()
    {
        return $this->statusCode ?: self::STATUS_OK;
    }

    /**
     * @param $statusCode
     * @return $this
     */
    public function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;

        return $this;
    }

    /**
     * @param $transformer
     * @return $this
     */
    public function setTransformer($transformer)
    {
        $this->transformer = $transformer;

        return $this;
    }

    /**
     * @param $item
     * @param $resourceKey
     * @return \Illuminate\Http\JsonResponse
     */
    public function transformItem($item, $resourceKey = 'data')
    {
        $resource = new Item($item, $this->transformer, $resourceKey);

        return $this->fractal->createData($resource)->toArray();
    }

    /**
     * @param $collection
     * @param string $resourceKey
     * @return \Illuminate\Http\JsonResponse
     */
    public function transformCollection($collection, $resourceKey = 'data')
    {
        $resource = new Collection($collection, $this->transformer, $resourceKey);

        return $this->fractal->createData($resource)->toArray();
    }


    /**
     * @param $paginator
     * @param $transformer
     * @param string $resourceKey
     * @return array
     */
    public function paginatedCollection($paginator, $resourceKey = 'data')
    {
        $resource = new Collection($paginator->getCollection(), $this->transformer, $resourceKey);

        $resource->setPaginator(new IlluminatePaginatorAdapter($paginator));

        return $this->fractal->createData($resource)->toArray();
    }


    /**
     * @param $data
     * @param array $headers
     * @return \Illuminate\Http\JsonResponse
     */
    public function respond($data, $headers = [])
    {
        return response()->json($data, $this->getStatusCode(), $headers);
    }


    /**
     * @param string $message
     * @return \Illuminate\Http\JsonResponse
     */
    public function respondNotFound($message = 'Not found')
    {
        return $this->setStatusCode(404)->respondWithError($message);
    }


    public function respondValidationFailed($details)
    {
        return $this->setStatusCode(422)
            ->respondWithError('Validation failed', ['details' => $details]);
    }

    /**
     * @param $message
     * @param array $details
     * @return \Illuminate\Http\JsonResponse
     */
    public function respondWithError($message, array $details = NULL)
    {
        $error = [
            'message' => $message
        ];

        if (!$this->getStatusCode()) {
            $this->setStatusCode(400);
        }

        if ($details) {
            $error = array_merge($error, $details);
        }

        return $this->respond($error);
    }

}
