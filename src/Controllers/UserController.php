<?php 
    namespace App\Controllers;

    use App\Http\Response;
    use App\Http\Resquest;
    use App\Services\UserServices;

    class UserController
    {
    // Routes::post("/pegarUser", "UserController@pegarUser");
    // Routes::post("/login", "UserController@login");
    // Routes::post("/inseirUser", "UserController@inseirUser");
    // Routes::put("/updateUser", "UserController@updateUser");
    // Routes::delete("/deleteUser", "UserController@deleteUser");
        public function pegarUser(Resquest $resquest, Response $response)
        {
            $auth = $resquest::authorization();

            $user = UserServices::pegarUser($auth);

            if (isset($user["unauthorized"])){
                $response::json($user,401,true);
                return;
            }

            if (isset($user["error"])) {
                $response::json($user,400,true);
                return;
            }

            $response::json($user,200);
        }    

        public function login(Resquest $resquest, Response $response)
        {
            $body = $resquest::getBody();

            $user = UserServices::login($body);

            if (isset($user["error"])) {
                $response::json($user,400,true);
                return;
            }

            $response::json($user,200);
        }  

        public function inserirUser(Resquest $resquest, Response $response)
        {
            $body = $resquest::getBody();
            $auth = $resquest::authorization();

            $user = UserServices::inserirUser($body, $auth);

            if (isset($user["unauthorized"])){
                $response::json($user,401,true);
                return;
            }
            
            if (isset($user["error"])) {
                $response::json($user,400,true);
                return;
            }

            $response::json($user,200);
        }  
    }