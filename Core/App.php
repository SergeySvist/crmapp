<?php

namespace Core;

require_once '../config/app.php';
require_once '../config/routes.php';
require_once '../config/db.php';

use Core\Routing\Router;

class App
{
    public function run()
    {
        $router = new Router();
        $router->run();
    }
}
