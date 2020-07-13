<?php
namespace App\Controllers;

use MF\Controller\Action;
use MF\Model\Container;

class AuthController extends Action
{
    public function auth()
    {
        $user = Container::getModel('User');
        $user->__set('email', $_POST['email']);
        $user->__set('password', md5($_POST['password']));

        $user->auth();

        if($user->__get('id') != '' && $user->__get('name')) {
            session_start();
            $_SESSION['id'] = $user->__get('id');
            $_SESSION['name'] = $user->__get('name');
            header('Location: /timeline');
        } else {
            header('Location: /?login=error');
        }
    }

    public function logout()
    {
        session_start();
        session_destroy();
        header('Location: /');
    }
}