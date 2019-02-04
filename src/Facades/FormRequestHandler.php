<?php

namespace Daikazu\FormRequestHandler\Facades;

use Illuminate\Support\Facades\Facade;

class FormRequestHandler extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'form-request-handler';
    }
}
