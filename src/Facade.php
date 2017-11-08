<?php

namespace Tjwenke\Alidayu;

use Illuminate\Support\Facades\Facade as LaravelFacade;

class Facade extends LaravelFacade
{

    protected static function getFacadeAccessor()
    {
        return 'alidayu.message';
    }

    public static function message()
    {
    	return static::$app['alidayu.message'];
    }

    public static function code()
    {
        // return app('alidayu.code');
    	return static::$app['alidayu.code'];
    }

    public static function checker()
    {
    	return static::$app['alidayu.checker'];
    }
}
