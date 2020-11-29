<?php

namespace App\Domain\Tables\Services\Facades;

use Illuminate\Support\Facades\Facade;

class Table extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'table';
    }
}
