<?php
namespace App\Controllers;

use MF\Controller\Action;
use MF\Model\Container;

class AppController extends Action
{
    public function timeline()
    {
        $this->validateAuth();

        $tweet = Container::getModel('Tweet');
        $tweet->__set('id_user', $_SESSION['id']);
        $tweets = $tweet->getAll();
        $this->view->tweets = $tweets;
        $this->render('timeline');
    }

    public function tweet()
    {
        $this->validateAuth();

        $tweet = Container::getModel('Tweet');
        $tweet->__set('tweet', $_POST['tweet']);
        $tweet->__set('id_user', $_SESSION['id']);
        $tweet->save();
        header('Location: /timeline');
    }

    public function whoToFollow()
    {
        $this->validateAuth();
        $searchBy = isset($_GET['searchBy']) ? $_GET['searchBy'] : '';
        $users = array();

        if ($searchBy != '') {
            $user = Container::getModel('User');
            $user->__set('name', $searchBy);
            $user->__set('id', $_SESSION['id']);
            $users = $user->getAll();
        }

        $this->view->users = $users;
        $this->render('whoToFollow');
    }

    public function userAction()
    {
        $this->validateAuth();
        $action = isset($_GET['action']) ? $_GET['action'] : '';
        $id_user_following = isset($_GET['id_user']) ? $_GET['id_user'] : '';
        $user = Container::getModel('User');
        $user->__set('id', $_SESSION['id']);

        if ($action == 'follow') {
            $user->follow($id_user_following);
        } elseif ($action == 'unfollow') {
            $user->unfollow($id_user_following);
        }

        header('Location: /who_to_follow');
    }

    public function validateAuth()
    {
        session_start();
        if (!isset($_SESSION['id']) || $_SESSION['id'] == '' ||
            !isset($_SESSION['name']) || $_SESSION['name'] == '') {
            header('Location: /?login=unauthorized');
        }
    }
}