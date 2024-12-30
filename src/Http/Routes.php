<?php
namespace App\Http;

/**
 * Classe responsável por gerenciar as rotas da aplicação.
 *
 * A classe `Routes` permite registrar rotas com diferentes métodos HTTP 
 * (GET, POST, PUT e DELETE) e armazená-las em um array estático.
 */
class Routes
{
    /**
     * @var array Lista estática de rotas registradas.
     */
    private static array $routes = [];

    /**
     * Retorna a lista de rotas registradas.
     *
     * @return array Um array contendo todas as rotas registradas.
     */
    public static function routes(): array
    {
        return self::$routes;
    }

    /**
     * Registra uma rota do tipo GET.
     *
     * @param string $path O caminho da rota.
     * @param string $action A ação associada à rota.
     * @return void
     */
    public static function get(string $path, string $action): void
    {
        self::$routes[] = [
            "path"      => $path,
            "action"    => $action,
            "method"    => "GET",
        ];
    }

    /**
     * Registra uma rota do tipo POST.
     *
     * @param string $path O caminho da rota.
     * @param string $action A ação associada à rota.
     * @return void
     */
    public static function post(string $path, string $action): void
    {
        self::$routes[] = [
            "path"      => $path,
            "action"    => $action,
            "method"    => "POST",
        ];
    }

    /**
     * Registra uma rota do tipo PUT.
     *
     * @param string $path O caminho da rota.
     * @param string $action A ação associada à rota.
     * @return void
     */
    public static function put(string $path, string $action): void
    {
        self::$routes[] = [
            "path"      => $path,
            "action"    => $action,
            "method"    => "PUT",
        ];
    }

    /**
     * Registra uma rota do tipo DELETE.
     *
     * @param string $path O caminho da rota.
     * @param string $action A ação associada à rota.
     * @return void
     */
    public static function delete(string $path, string $action): void
    {
        self::$routes[] = [
            "path"      => $path,
            "action"    => $action,
            "method"    => "DELETE",
        ];
    }
}
