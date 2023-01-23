<?php

namespace Src\Common\Infrastructure\Laravel;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Pagination\AbstractPaginator;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Config;
use Jiannei\Response\Laravel\Contracts\Format;

/**
 * Based on Google JSON Style Guide, with some modifications.
 *
 * @link https://google.github.io/styleguide/jsoncstyleguide.xml
 */
class ResponseFormatter implements Format
{
    public function __construct(protected array $config = [])
    {
    }

    /**
     * Format return data structure.
     *
     * @param array|null  $data
     * @param string|null $message
     * @param int         $code
     * @param null        $errors
     * @return array
     */
    public function data(?array $data, ?string $message, int $code, $errors = null): array
    {
        if (!is_null($errors) || !$data) {
            // If there are errors, or no data (means error), return the error structure.

            if (!is_null($errors)) {
                // if there are multiple errors
                $data = [
                    'error' => [
                        'code' => $code,
                        'message' => $errors[0]['message'], // we use the first error message
                        'errors' => $errors,
                    ],
                ];
            } else {
                // if there is only one error
                $data = [
                    'error' => [
                        'code' => $code,
                        'message' => $this->formatMessage($code, $message),
                    ],
                ];
            }
        } else {
            // If there is data, return the success structure.
            if (Arr::isAssoc($data)) {
                // Object
                $data = [
                    'data' => $data,
                ];
            } else {
                // Array
                $data = [
                    'data' => [
                        'items' => $data,
                    ],
                ];
            }
        }

        return $this->formatDataFields($data, $this->config);
    }


    /**
     * Http status code.
     *
     * @param $code
     * @return int
     */
    public function statusCode($code): int
    {
        return (int)substr($code, 0, 3);
    }

    /**
     * Format paginator data.
     *
     * @param AbstractPaginator $resource
     * @param string            $message
     * @param int               $code
     * @param array             $headers
     * @param int               $option
     * @return array
     */
    public function paginator(AbstractPaginator $resource, string $message = '', int $code = 200, array $headers = [], int $option = 0): array
    {
        $paginated = $resource->toArray();

        $paginationInformation = $this->formatPaginatedData($paginated);

        $data = array_merge_recursive(['data' => $paginated['data']], $paginationInformation);

        return $this->data($data, $message, $code);
    }

    /**
     * Format collection resource data.
     *
     * @param ResourceCollection $resource
     * @param string             $message
     * @param int                $code
     * @param array              $headers
     * @param int                $option
     * @return array
     */
    public function resourceCollection(ResourceCollection $resource, string $message = '', int $code = 200, array $headers = [], int $option = 0): array
    {
        $data = array_merge_recursive(['data' => $resource->resolve(request())], $resource->with(request()), $resource->additional);
        if ($resource->resource instanceof AbstractPaginator) {
            $paginated = $resource->resource->toArray();
            $paginationInformation = $this->formatPaginatedData($paginated);

            $data = array_merge_recursive($data, $paginationInformation);
        }

        return $this->data($data, $message, $code);
    }

    /**
     * Format JsonResource Data.
     *
     * @param JsonResource $resource
     * @param string       $message
     * @param int          $code
     * @param array        $headers
     * @param int          $option
     * @return array
     */
    public function jsonResource(JsonResource $resource, string $message = '', int $code = 200, array $headers = [], int $option = 0): array
    {
        $resourceData = array_merge_recursive($resource->resolve(request()), $resource->with(request()), $resource->additional);

        return $this->data($resourceData, $message, $code);
    }

    /**
     * Format return message.
     *
     * @param int         $code
     * @param string|null $message
     * @return string
     */
    protected function formatMessage(int $code, ?string $message): ?string
    {
        if (!$message && class_exists($enumClass = Config::get('response.enum'))) {
            $message = $enumClass::fromValue($code)->description;
        }

        return $message;
    }

    /**
     * Format http status description.
     *
     * @param int $code
     * @return string
     */
    protected function formatStatus(int $code): string
    {
        $statusCode = $this->statusCode($code);
        if ($statusCode >= 400 && $statusCode <= 499) {// client error
            $status = 'error';
        } elseif ($statusCode >= 500 && $statusCode <= 599) {// service error
            $status = 'fail';
        } else {
            $status = 'success';
        }

        return $status;
    }

    /**
     * Format paginated data.
     *
     * @param array $paginated
     * @return array
     */
    protected function formatPaginatedData(array $paginated): array
    {
        return [
            'meta' => [
                'pagination' => [
                    'total' => $paginated['total'] ?? 0,
                    'count' => $paginated['to'] ?? 0,
                    'per_page' => $paginated['per_page'] ?? 0,
                    'current_page' => $paginated['current_page'] ?? 0,
                    'total_pages' => $paginated['last_page'] ?? 0,
                    'links' => [
                        'previous' => $paginated['prev_page_url'] ?? '',
                        'next' => $paginated['next_page_url'] ?? '',
                    ],
                ],
            ],
        ];
    }

    /**
     * Format response data fields.
     *
     * @param array $responseData
     * @param array $dataFieldsConfig
     * @return array
     */
    protected function formatDataFields(array $responseData, array $dataFieldsConfig = []): array
    {
        if (empty($dataFieldsConfig)) {
            return $responseData;
        }

        foreach ($responseData as $field => $value) {
            $fieldConfig = Arr::get($dataFieldsConfig, $field);
            if (is_null($fieldConfig)) {
                continue;
            }

            if ($value && is_array($value) && in_array($field, ['data', 'meta', 'pagination', 'links'])) {
                $value = $this->formatDataFields($value, Arr::get($dataFieldsConfig, "{$field}.fields", []));
            }

            $alias = $fieldConfig['alias'] ?? $field;
            $show = $fieldConfig['show'] ?? true;
            $map = $fieldConfig['map'] ?? null;
            unset($responseData[$field]);

            if ($show) {
                $responseData[$alias] = $map[$value] ?? $value;
            }
        }

        return $responseData;
    }
}
