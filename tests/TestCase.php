<?php

namespace Tests;

use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use WithLogin;
    use LazilyRefreshDatabase;

    protected string $adminToken;
    protected array $userData;
    protected string $userToken;

    protected function setUp(): void
    {
        parent::setUp();
        $this->adminToken = $this->newLoggedAdmin()['token'];
        $this->userData = $this->newLoggedUser();
        $this->userToken = $this->userData['token'];
    }
}
