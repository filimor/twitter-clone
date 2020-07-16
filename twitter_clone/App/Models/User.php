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
        $stmt->bindValue(':password', $this->__get('password'));
        $stmt->execute();

        return $this;
    }

    public function validateAccount()
    {
        $valid = true;

        if (
            strlen($this->__get('name')) <= 3 ||
            strlen($this->__get('email')) <= 3 ||
            strlen($this->__get('password')) <= 3
        ) {
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
        if ($user['id'] != '' && $user['name'] != '') {
            $this->__set('id', $user['id']);
            $this->__set('name', $user['name']);
        }

        return $this;
    }

    public function getAll()
    {
        $query = "select u.id, u.name, u.email,
            (select count(*)
                from followers as f
                where f.id_user = :id_user and f.id_user_following = u.id) as isfollowing
            from users as u
            where u.name like :name and u.id != :id_user";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':name', '%' . $this->__get('name') . '%');
        $stmt->bindValue(':id_user', $this->__get('id'));
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function follow($id_user_following)
    {
        $query = "insert into followers(id_user, id_user_following)
            values(:id_user, :id_user_following)";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id_user', $this->__get('id'));
        $stmt->bindValue(':id_user_following', $id_user_following);
        $stmt->execute();

        return true;
    }

    public function unfollow($id_user_following)
    {
        $query = "delete from followers where id_user = :id_user
            and id_user_following = :id_user_following";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id_user', $this->__get('id'));
        $stmt->bindValue(':id_user_following', $id_user_following);
        $stmt->execute();

        return true;
    }
}
