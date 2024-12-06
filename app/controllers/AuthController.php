<?php
include("app/models/UserModel.php");

class AuthController {
    public function login() {
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $username = $_POST['username'];
            $password = $_POST['password'];
            
            $user = new UserModel();
            $user_list = $user->authenticate($username, $password);
            if(!empty($user_list)){
                session_start();
                $_SESSION['user'] = $user_list;
                header('Location: ../Password/index');
            }else{
                $this->logout();
            }
            
        }else{
            header("Location: ../Login/index");
            
        }
    }

    public function logout() {
        session_start();
        session_destroy();
        header("Location: ../Login/index");
    }
}
