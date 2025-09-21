<?php

declare(strict_types=1);

namespace App\Core\Router;

use Nette\Application\Routers\RouteList;

final class RouterFactory
{
    public static function create(): RouteList
    {
        return new RouteList()->addRoute('[<sid>]', 'Front:Content:article');
    }
}