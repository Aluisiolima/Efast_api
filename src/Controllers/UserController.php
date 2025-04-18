<?php 
    namespace App\Controllers;

    use App\Http\Response;
    use App\Http\Resquest;
    use App\Services\UserServices;

    class UserController
    {
        private readonly Resquest $resquest;
        private readonly Response $response;

        public function __construct(){
            $this->resquest = new Resquest;
            $this->response = new Response;
        }

        public function pegarUser()
        {
            $auth = $this->resquest::authorization();

            $user = UserServices::pegarUser($auth);

            if (isset($user["unauthorized"])){
                $this->response::json($user,401,true);
                return;
            }

            if (isset($user["error"])) {
                $this->response::json($user,400,true);
                return;
            }

            $this->response::json($user,200);
        }    

        public function login()
        {
            $body = $this->resquest::getBody();

            $user = UserServices::login($body);

            if (isset($user["error"])) {
                $this->response::json($user,400,true);
                return;
            }

            $this->response::json($user,200);
        }  

        public function inserirUser()
        {
            $body = $this->resquest::getBody();
            $auth = $this->resquest::authorization();

            $user = UserServices::inserirUser($body, $auth);

            if (isset($user["unauthorized"])){
                $this->response::json($user,401,true);
                return;
            }
            
            if (isset($user["error"])) {
                $this->response::json($user,400,true);
                return;
            }

            $this->response::json($user,200);
        } 
        public function updateUser()
        {
            $body = $this->resquest::getBody();
            $auth = $this->resquest::authorization();

            $user = UserServices::updateUser($body, $auth);

            if (isset($user["unauthorized"])){
                $this->response::json($user,401,true);
                return;
            }
            
            if (isset($user["error"])) {
                $this->response::json($user,400,true);
                return;
            }

            $this->response::json($user,200);
        }  

        public function deleteUser()
        {
            $auth = $this->resquest::authorization();

            $user = UserServices::deleteUser($auth);

            if (isset($user["unauthorized"])){
                $this->response::json($user,401,true);
                return;
            }
            
            if (isset($user["error"])) {
                $this->response::json($user,400,true);
                return;
            }

            $this->response::json($user,200);
        }
    }