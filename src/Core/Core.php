<?php
    namespace App\Core;

    use App\Http\Resquest;
    use App\Http\Response;

    class Core
    {
        public static function dispatch(array $routes)
        {
            $url = "/";

            isset($_GET["url"]) && $url .= $_GET["url"];

            $url != "/" && $url = rtrim( $url,"/");

            $prefixController = "App\\Controllers\\";

            $routeFound = false;

            foreach ($routes as $route) {
                $pattern = "#^" . preg_replace("/{id}/","([\w-]+)", $route["path"]) ."$#";

                if(preg_match($pattern,$url,$matches)) 
                {
                    array_shift( $matches );

                    $routeFound = true;

                    if ($route["method"] !== Resquest::method()) {
                        Response::json([
                            "error"     => true,
                            "sucess"    => false,
                            "mensagem"  => "Não existe esse metodo pra essa rota!!"
                        ],401);
                        return;
                    }

                    [$controller, $action] = explode("@", $route["action"] );

                    $controller = $prefixController . $controller;
                    $extendControler = new $controller();
                    $extendControler->$action(new Resquest, new Response, $matches);
                    
                }    
            }
            if(!$routeFound)
            {
                $controller = $prefixController . "NotFoundController";
                $extendControler = new $controller();
                $extendControler->index(new Resquest, new Response);
            }

        }
    }
    