<?php

namespace Tjwenke\Alidayu\Facades;

use Illuminate\Support\Facades\Facade as LaravelFacade;

class Message extends LaravelFacade
{

    protected static function getFacadeAccessor()
    {
        return 'alidayu.message';
    }

}
