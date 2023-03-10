<?php

namespace Specifications\OpenApi\Responses;

use GoldSpecDigital\ObjectOrientedOAS\Contracts\SchemaContract;
use GoldSpecDigital\ObjectOrientedOAS\Objects\MediaType;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Response;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use Vyuldashev\LaravelOpenApi\Factories\ResponseFactory as BaseResponseFactory;

abstract class ResponseFactory extends BaseResponseFactory
{
    use ResponseFactoryTrait;

    protected ?string $id = null;

    protected int $statusCode = \Symfony\Component\HttpFoundation\Response::HTTP_OK;

    protected string $description = '';

    protected string $status = 'success';

    public function build(): Response
    {
        $response = Response::create($this->id)
            ->statusCode($this->statusCode)
            ->description($this->description);
        $definition = $this->definition();

        switch ($this->status) {
            case 'success':
                $definition = [
                    Schema::object('data')->properties(...$definition),
                ];
                break;
            case 'error':
                $definition = [
                    Schema::object('error')->properties(...$definition),
                ];
                break;
        }

        $definition = $this->mutateSchema($definition);

        if (!empty($definition)) {
            $content = MediaType::json()->schema(
                Schema::object()->properties(
                    ...$definition
                )
            );
            $response = $response->content($content);
        }
        return $response;
    }

    /**
     * @return SchemaContract[]
     */
    abstract public function definition(): array;

    protected function mutateSchema(array $definition): array
    {
        return $definition;
    }
}
