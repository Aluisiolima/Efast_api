<?php
namespace App\Core;

use App\Http\Resquest;
use App\Http\Response;

class Core
{
    /**
     * Processa as rotas e direciona a requisição ao controller correto.
     *
     * @param array $routes Lista de rotas definidas pela aplicação.
     * @return void
     */
    public static function dispatch(array $routes): void
    {
        $url = "/";

        // Captura a URL solicitada
        isset($_GET["url"]) && $url .= $_GET["url"];
        $url != "/" && $url = rtrim($url, "/");

        $prefixController = "App\\Controllers\\";
        $routeFound = false;

        // Itera pelas rotas registradas
        foreach ($routes as $route) {
            $pattern = "#^" . preg_replace("/{id}/", "([\w-]+)", $route["path"]) . "$#";

            if (preg_match($pattern, $url, $matches)) {
                array_shift($matches);
                $routeFound = true;

                if ($route["method"] !== Resquest::method()) {
                    Response::json(["error" => "Error nao existe esse metodo pra essa rota"], 401,true);
                    return;
                }

                [$controller, $action] = explode("@", $route["action"]);
                $controller = $prefixController . $controller;
                $extendControler = new $controller();
                $extendControler->$action(new Resquest, new Response, $matches);
                return;
            }
        }

        // Rota não encontrada
        if (!$routeFound) {
            $controller = $prefixController . "NotFoundController";
            $extendControler = new $controller();
            $extendControler->index(new Resquest, new Response);
        }
    }
}
