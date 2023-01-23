<?php

namespace Tests\Integration;

use Illuminate\Http\Exceptions\HttpResponseException;
use Jiannei\Response\Laravel\Response;
use Tests\TestCase;

class GoogleJsonStyleResponseTest extends TestCase
{
    private Response $response;

    protected function setUp(): void
    {
        parent::setUp();

        $this->response = app(Response::class);
    }

    /**
     * @dataProvider successResponseDataProvider
     */
    public function testSuccessResponse(array $args, array $expected): void
    {
        $response = $this->app->call([$this->response, 'success'], $args);

        $this->assertEquals($expected, $response->getData(true));
    }

    /**
     * @dataProvider failedResponseDataProvider
     */
    public function testFailedResponse(array $args, array $expected): void
    {
        try {
            $response = $this->app->call([$this->response, 'fail'], $args);

            $this->assertEquals($expected, $response->getData(true));
        } catch (HttpResponseException $e) {
            $response = $e->getResponse();

            $this->assertEquals($expected, $response->getData(true));
        }
    }

    public function successResponseDataProvider(): array
    {
        return [
            'object' => [
                'args' => [
                    'data' => $this->getSampleData()[0],
                ],
                'expected' => [
                    'data' => $this->getSampleData()[0],
                ],
            ],

            'items' => [
                'args' => [
                    'data' => $this->getSampleData(3),
                ],
                'expected' => [
                    'data' => [
                        'items' => $this->getSampleData(3),
                    ],
                ],
            ],

            'collection' => [
                'args' => [
                    'data' => collect($this->getSampleData(3)),
                ],
                'expected' => [
                    'data' => [
                        'items' => $this->getSampleData(3),
                    ],
                ],
            ],
        ];
    }

    public function failedResponseDataProvider(): array
    {
        return [
            'message' => [
                'args' => [
                    'message' => 'Failed',
                ],
                'expected' => [
                    'error' => [
                        'code' => 500,
                        'message' => 'Failed',
                    ],
                ],
            ],

            'code' => [
                'args' => [
                    'code' => 400,
                    'message' => 'Bad Request',
                ],
                'expected' => [
                    'error' => [
                        'code' => 400,
                        'message' => 'Bad Request',
                    ],
                ],
            ],

            'multiple' => [
                'args' => [
                    'code' => 400,
                    'errors' => [
                        [
                            'domain' => 'global',
                            'reason' => 'VALIDATION_ERROR',
                            'message' => 'Invalid email',
                        ],
                        [
                            'domain' => 'global',
                            'reason' => 'VALIDATION_ERROR',
                            'message' => 'Invalid email',
                        ],
                    ],
                ],
                'expected' => [
                    'error' => [
                        'code' => 400,
                        'message' => 'Invalid email',
                        'errors' => [
                            [
                                'domain' => 'global',
                                'reason' => 'VALIDATION_ERROR',
                                'message' => 'Invalid email',
                            ],
                            [
                                'domain' => 'global',
                                'reason' => 'VALIDATION_ERROR',
                                'message' => 'Invalid email',
                            ],
                        ],
                    ],
                ],
            ],
        ];
    }

    private function getSampleData(int $repeat = 1): array
    {
        $data = [];

        for ($i = 0; $i < $repeat; $i++) {
            $data[] = [
                'id' => $i + 1,
                'name' => 'John Doe',
            ];
        }

        return $data;
    }
}
