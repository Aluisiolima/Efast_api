<?php 
    namespace App\Controllers;

    use App\Http\Response;
    use App\Http\Resquest;
    use App\Services\UserServices;
    use App\Controllers\ControllerBase;

    class UserController extends ControllerBase
    {
        public function __construct(
            private readonly Resquest $resquest,
            private readonly Response $response,
            private readonly UserServices $userServices
        ){
            parent::__construct($response);
        }

        public function pegarUser(): void
        {
            $auth = $this->resquest::authorization();
            $user = $this->userServices->pegarUser($auth);

            $this->responserController($user, 200);
        }    

        public function inserirUser(): void
        {
            $body = $this->resquest::getBody();
            $auth = $this->resquest::authorization();
            $user = $this->userServices->inserirUser($body, $auth);

            $this->responserController($user, 201);
        } 
        public function updateUser(): void
        {
            $body = $this->resquest::getBody();
            $auth = $this->resquest::authorization();
            $user = $this->userServices->updateUser($body, $auth);

            $this->responserController($user, 200);
        }  

        public function deleteUser(): void
        {
            $auth = $this->resquest::authorization();
            $user = $this->userServices->deleteUser($auth);

            $this->responserController($user, 200);
        }
    }