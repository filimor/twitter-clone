<?php
namespace App\Models;

use MF\Model\Model;

class User extends Model
{
    private $id;
    private $name;
    private $email;
    private $password;

    public function __get($attribute)
    {
        return $this->$attribute;
    }

    public function __set($attribute, $value)
    {
        $this->$attribute = $value;
    }

    public function save()
    {
        $query = "insert into users(name, email, password)values(:name, :email, :password)";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':name', $this->__get('name'));
        $stmt->bindValue(':email', $this->__get('email'));
        $stmt->bindValue(':password', $this->__get('password')); // TODO: MD5
        $stmt->execute();

        return $this;
    }
    
    public function validateAccount()
    {
        $valid = true;

        if(strlen($this->__get('name')) <= 3 ||
            strlen($this->__get('email')) <= 3 ||
            strlen($this->__get('password')) <= 3) {
                $valid = false;
            }

        return $valid;
    }

    public function getUserByMail()
    {
        $query = "select name, email from users where email = :email";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':email', $this->__get('email'));
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function auth()
    {
        $query = "select id, name, email from users where email = :email and password = :password";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':email', $this->__get('email'));
        $stmt->bindValue(':password', $this->__get('password'));
        $stmt->execute();

        $user = $stmt->fetch(\PDO::FETCH_ASSOC);
        if($user['id'] != '' && $user['name'] != '') {
            $this->__set('id', $user['id']);
            $this->__set('name', $user['name']);
        }

        return $this;
    }

    public function getAll()
    {
        $query = "select id, name, email from users where name like :name";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':name', '%'.$this->__get('name').'%');
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}