<?php

namespace Tjwenke\Alidayu\Facades;

use Illuminate\Support\Facades\Facade as LaravelFacade;

class Code extends LaravelFacade
{

    protected static function getFacadeAccessor()
    {
        return 'alidayu.code';
    }

}
