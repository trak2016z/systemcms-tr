<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Page\Model;

use Zend\Db\TableGateway\TableGateway;

/**
 * Description of UserTable
 *
 * @author rychu
 */
class UserTable
{
    protected $tableGateway;
    
    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }
    
    public function getAll()
    {
        return $this->tableGateway->select();
    }
    
    public function getUser($id)
    {
        $id = (int) $id;
        $row = $this->tableGateway->select(array('id_user' => $id))->current();
        if (!$row) throw new \Exception("Brak użytkownika o id $id");
        
        $user = new User();
        $user->exchangeArray(array('name' => $row->name, 'email' => $row->email, 'date_birth' => $row->date_birth));
        
        return $user;
        //return $row->current();
    }
    
    public function getIdUser($token)
    {
        $row = $this->tableGateway->select(array('token' => $token))->current();
        if (!$row) throw new \Exception("Brak użytkownika z tokenem $token");
        
        return $row->id_user;
        //return $row->current();
    }

        public function checkUser($email, $pwd)
    {
        $id = -1;
        $row = $this->tableGateway->select(array('email' => $email, 'password' => $pwd));
        
        if ($row->count() == 1)
            $id = $row->current()->id_user;
        
        return $id;
    }
    
    public function insert(User $user)
    {
        $data = array(
            'id_user' => $user->id_user,
            'name' => $user->name,
            'email' => $user->email,
            'password' => $user->password,
            'date_birth' => $user->date_birth,
            'date_create' => $user->date_create,
        );
        
        $this->tableGateway->insert($data);
    }
    
    public function setToken($id_user, $token)
    {
        $this->tableGateway->update(array('token' => $token), array('id_user'=>$id_user));
    }

    public function tokenCheck($token)
    {
        if ($this->tableGateway->select(array('token' => $token))->count() == 0)
            return FALSE;
        else
            return TRUE;
    }
}
