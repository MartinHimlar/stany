<?php

namespace App;

use Nette;
use Nette\Application\Routers\RouteList;
use Nette\Application\Routers\Route;


class RouterFactory
{
	use Nette\StaticClass;

	/**
	 * @return Nette\Application\IRouter
	 */
	public static function createRouter()
	{
        $router = new RouteList();
        $router[] = new Route('index.php', 'Front:Homepage:default', Route::ONE_WAY);
        $frontRouter[] = new Route('prihlaseni', 'Front:Sign:in');

        $router[] = $adminRouter = new RouteList('Admin');
        $adminRouter[] = new Route('admin[/<presenter>[/<action>[/<id>]]]', 'Homepage:default');

        $router[] = $frontRouter = new RouteList('Front');
        $frontRouter[] = new Route('<presenter>/<action>[/<id>]', 'Homepage:default');
        $frontRouter[] = new Route('prihlaseni', 'Sign:in');

        $frontRouter[] = new Route('', 'Homepage:default');
        return $router;
	}

}
