<?php
namespace App\Models;

use MF\Model\Model;

class Tweet extends Model
{
    private $id;
    private $id_user;
    private $tweet;
    private $date;

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
        $query = "insert into tweets(id_user, tweet) values (:id_user, :tweet)";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id_user', $this->__get('id_user'));
        $stmt->bindValue(':tweet', $this->__get('tweet'));
        $stmt->execute();

        return $this;
    }

    public function getAll()
    {
        $query = "select t.id, t.id_user, u.name, t.tweet, DATE_FORMAT(t.date, '%d/%m/%y %H:%i') as date 
        from tweets as t 
        left join users as u
        on t.id_user = u.id
        where t.id_user = :id_user 
        order by t.date desc";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id_user', $this->__get('id_user'));
        $stmt->execute();
        
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}