<?php   
   namespace App\Core;

    use ReflectionClass;

    class ControllerResolver
    {

        public static function criar(string $nomeController)
        {
            $classe = "App\\Controllers\\" . $nomeController;

            return self::instanciarController($classe);
        }
        public static function instanciarController(string $classe)
        {
            $refClass = new ReflectionClass($classe);
            $constructor = $refClass->getConstructor();

            if (!$constructor) {
                return new $classe();
            }

            $dependencias = [];

            foreach ($constructor->getParameters() as $param) {
                $tipo = $param->getType();

                if (!$tipo) {

                    $dependencias[] = null;
                    continue;
                }

                $nomeClasse = $tipo->getName();

                $dependencias[] = self::instanciarController($nomeClasse);
            }

            return $refClass->newInstanceArgs($dependencias);
        }
    }
