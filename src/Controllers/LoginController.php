<?php   
    namespace App\Controllers;

    use App\Controllers\ControllerBase;
    use App\Http\Response;
    use App\Http\Resquest;
    use App\Services\LoginServices;

    class LoginController extends ControllerBase
    {
        public function __construct(
            private readonly Response $response,
            private readonly Resquest $resquest,
            private readonly LoginServices $loginServices
        ) {
            parent::__construct($this->response);
        }

        public function login(): void
        {
            $body = $this->resquest::getBody();
            $login = $this->loginServices->login($body);

            $this->responserController($login, 200);
        }  

        public function refreshLoginToken(): void
        {
            $auth = $this->resquest::authorization();
            $login = $this->loginServices->refreshLoginToken($auth);

            $this->responserController($login, 200);
        }
    }