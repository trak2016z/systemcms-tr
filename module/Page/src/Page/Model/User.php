<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Page\Model;

/**
 * Description of User
 *
 * @author rychu
 */
class User
{
    public $id_user;
    public $name;
    public $email;
    public $password;
    public $date_birth;
    public $date_create;
    public $token;
    
    public function exchangeArray($data)
    {
        $this->id_user = (!empty($data['id_user'])) ? $data['id_user'] : null;
        $this->name = (!empty($data['name'])) ? $data['name'] : null;
        $this->email = (!empty($data['email'])) ? $data['email'] : null;
        $this->password = (!empty($data['password'])) ? $data['password'] : null;
        $this->date_birth = (!empty($data['date_birth'])) ? $data['date_birth'] : null;
        $this->date_create = (!empty($data['date_create'])) ? $data['date_create'] : null;
        $this->token = (!empty($data['token'])) ? $data['token'] : null;
     }
}
