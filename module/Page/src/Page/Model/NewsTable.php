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
class NewsTable
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
    
    public function getNews($id)
    {
        $news = $this->tableGateway->select(array('id_news' => (int) $id));
        
        if ($news->count() == 0)
            return new News();
        else
            return $news->current();
    }
    
    public function insert($news)
    {
        try
        {
            $this->tableGateway->insert($news->toArray());
        } catch (Exception $ex)
        {
            return false;
        }
        
        return true;
    }
    
    public function update($news)
    {
        try
        {
            $news_array = $news->toArray();
            $this->tableGateway->update(
                array(
                    'id_category' => $news_array['id_category'],
                    'short_text' => $news_array['short_text'],
                    'long_text' => $news_array['long_text'],
                    'date_modify' => $news_array['date_modify'],
                    ), 
                array(
                    'id_news'=>$news_array['id_news'],
                    )
                );
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
            $this->tableGateway->delete(array('id_news' =>(int) $id));
        } catch (Exception $ex)
        {
            return false;
        }
        
        return true;
    }
}
