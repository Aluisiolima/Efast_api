<?php
namespace App\Core;

use App\Http\Resquest;
use App\Http\Response;
use App\Core\ControllerResolver;

class Core
{
    public static function dispatch(array $routes): void
    {
        $url = "/" . ($_GET["url"] ?? '');
        $url != "/" && $url = rtrim($url, "/");

        foreach ($routes as $route) {
            $pattern = "#^" . preg_replace("/{id}/", "([\w-]+)", $route["path"]) . "$#";

            if (preg_match($pattern, $url, $matches)) {
                array_shift($matches);

                if ($route["method"] !== Resquest::method()) {
                    Response::json(["error" => "Método inválido"], 405);
                    return;
                }

                [$controllerName, $action] = explode("@", $route["action"]);
            
                $controller = ControllerResolver::criar($controllerName);
                $controller->$action(...$matches);
                
                return;
            }
        }

        $controller = ControllerResolver::criar("NotFoundController");
        $controller->index();
    }
}
