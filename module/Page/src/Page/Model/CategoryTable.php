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
class CategoryTable
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
    
    public function getName($id)
    {
        $row = $this->tableGateway->select(array('id_category' => $id));
        
        return ($row->count() == 1)?$row->current()->name:'Brak kategorii';
    }
}
