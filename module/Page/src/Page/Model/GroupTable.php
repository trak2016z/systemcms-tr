<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Page\Model;

use Zend\Db\TableGateway\TableGateway;
/**
 * Description of GroupTable
 *
 * @author wojciech
 */
class GroupTable
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
    
    public function getUserGroup($id)
    {
        return $this->tableGateway->select(array('id_group' => $id));
    }
    
    public function getUserGroupName($id)
    {
        $group = $this->tableGateway->select(array('id_group' => $id))->current();
        
        return $this->tableGateway->select(array('id_group' => $id))->current()->name;
    }
    
    public function getAccessToken($id)
    {
        $group = $this->tableGateway->select(array('id_group' => $id))->current();
        
        return $this->tableGateway->select(array('id_group' => $id))->current()->access_token;
    }
    
    public function checkAccess($page, $token)
    {
        $access = 0;
        $group = $this->tableGateway->select(array('access_token' => $token))->current();
        
        switch ($page)
        {
            case 'news': $access = $group->news; break;
            case 'user': $access = $group->user; break;
        }
        
        return $access;
    }
}
