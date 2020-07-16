<?php
namespace App\Controllers;

use MF\Controller\Action;
use MF\Model\Container;

class IndexController extends Action 
{   
    public function index() 
    {
        $this->view->login = isset($_GET['login']) ? $_GET['login'] : '';
        $this->render('index');
    }

    public function signup()
    {
        $this->view->user = array(
            'name' => '',
            'email' => '',
            'password' => ''
        );
        $this->view->registrationError = false;
        $this->render('signup');
    }

    public function register()
    {
        $user = Container::getModel('User');
        $user->__set('name', $_POST['name']);
        $user->__set('email', $_POST['email']);
        $user->__set('password', md5($_POST['password']));
        
        if ($user->validateAccount() && count($user->getUserByMail()) == 0) {
            $user->save();
            $this->render('registration');
        } else {
            $this->view->user = array(
                'name' => $_POST['name'],
                'email' => $_POST['email'],
            );
            $this->view->registrationError = true;
            $this->render('signup');
        }
        
    }
}