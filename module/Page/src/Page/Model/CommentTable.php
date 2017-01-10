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
 * Description of CommentTable
 *
 * @author rychu
 */
class CommentTable
{
    protected $tableGateway;
    
    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }
    
    public function getAll()
    {
        return $this->tableGateway->select(function (Select $select){
            $select->order('date_create DESC');
        });
    }
    
    public function getAll2N($id_news)
    {
        //return $this->tableGateway->select(array('id_news' => (int) $id_news));
        return $this->tableGateway->select(function (Select $select) use ($id_news) {
            $select->where(array('id_news' => (int) $id_news));
            //$select->where(array('id_news' => 6));
            $select->order('date_create ASC');
        });
    }
    
    public function countcomments($id_news)
    {
        //return $this->tableGateway->select(array('id_news' => (int)id_news))->count();
        //return $this->tableGateway->select(array('id_news' => 6))->count();
        return $this->getAll2N($id_news)->count();
    }
    
    public function insert($comment)
    {
        try
        {
            $this->tableGateway->insert($comment->toArray());
        } catch (Exception $ex)
        {
            return false;
        }
        
        return true;
    }
    
    public function delete($id)
    {
        try
        {
            $this->tableGateway->delete(array('id_comment' =>(int) $id));
        } catch (Exception $ex)
        {
            return false;
        }
        
        return true;
    }
}
