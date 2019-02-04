<?php

namespace Daikazu\FormRequestHandler\Tests;

use Daikazu\FormRequestHandler\Facades\FormRequestHandler;
use Daikazu\FormRequestHandler\ServiceProvider;
use Orchestra\Testbench\TestCase;

class FormRequestHandlerTest extends TestCase
{
    protected function getPackageProviders($app)
    {
        return [ServiceProvider::class];
    }

    protected function getPackageAliases($app)
    {
        return [
            'form-request-handler' => FormRequestHandler::class,
        ];
    }

    public function testExample()
    {
        $this->assertEquals(1, 1);
    }
}
