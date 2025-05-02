<?php   
   namespace App\Core;

    use ReflectionClass;

    class ControllerResolver
    {
        public static function criar(string $nomeController)
        {
            $classe = "App\\Controllers\\" . $nomeController;

            $refClass = new ReflectionClass($classe);
            $constructor = $refClass->getConstructor();

            // Se o controller não tem __construct, só cria e retorna
            if (!$constructor) {
                return new $classe();
            }

            $dependencias = [];

            foreach ($constructor->getParameters() as $param) {
                $tipo = $param->getType();

                if (!$tipo) {
                    // Sem tipo definido, injeta null
                    $dependencias[] = null;
                    continue;
                }

                $nomeClasse = $tipo->getName();

                // Aqui criamos a instância do service automaticamente
                $dependencias[] = new $nomeClasse();
            }

            // Cria o controller com os serviços necessários
            return $refClass->newInstanceArgs($dependencias);
        }
    }
