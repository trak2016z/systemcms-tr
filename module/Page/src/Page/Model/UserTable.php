<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Page\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Expression;
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
        $user->exchangeArray(array('name' => $row->name, 'email' => $row->email, 'date_birth' => $row->date_birth, 'id_group' => $row->id_group));
        
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
        
        try
        {
        $this->tableGateway->insert($data);
        } catch (Exception $e) { return FALSE; }
        
        return TRUE;
    }
    
    public function update(User $user)
    {
        try
        {
            $data = array(
                'name' => $user->name,
                'password' => $user->password,
                'date_birth' => $user->date_birth,
                'id_group' => $user->id_group,
            );
            print_r($data);
            print_r($user);
            $this->tableGateway->update($data, array('id_user' => $user->id_user,));
        } catch (Exception $ex)
        {
            print_r($ex);
            return false;
        }
        
        return true;
        
    }
    
    public function delete($id)
    {
        try
        {
            $this->tableGateway->delete(array('id_user' =>(int) $id));
        } catch (Exception $ex)
        {
            return false;
        }
        
        return true;
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
    
    public function getUserGroup($id)
    {
//        print_r($id);
//        $u = $this->tableGateway->select(function (Select $select){
//           $select->join(array('g' => 'group'),"g.id_group = user.id_group");
//           $select->where(array('user.id_user' => 1));
//        });
//        print_r($u->current());
        $user = $this->tableGateway->select(array('id_user' => $id))->current();
        return $user->id_group;
    }
    
    public function getUserPermissions($id)
    {
        $user = $this->tableGateway->select(array('id_user' => $id))->current();
        
    }
    
    public function getName($id)
    {
        $id = (int) $id;
        $row = $this->tableGateway->select(array('id_user' => $id))->current();
        if (!$row) throw new \Exception("Brak użytkownika o id $id");
        
        return $row->name;
    }
    
    public function getPassword($id)
    {
        $id = (int) $id;
        $row = $this->tableGateway->select(array('id_user' => $id))->current();
        if (!$row) throw new \Exception("Brak użytkownika o id $id");
        
        return $row->password;
    }
}
