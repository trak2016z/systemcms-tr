<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Page\Model;

/**
 * Description of Comment
 *
 * @author rychu
 */
class Comment
{
    public $id_comment;
    public $id_user;
    public $id_news;
    public $text;
    public $date_create;
    public $date_modify;
    
    public function exchangeArray($data)
    {
        $this->id_comment = (!empty($data['id_comment'])) ? $data['id_comment'] : null;
        $this->id_user = (!empty($data['id_user'])) ? $data['id_user'] : null;
        $this->id_news = (!empty($data['id_news'])) ? $data['id_news'] : null;
        $this->text = (!empty($data['text'])) ? $data['text'] : null;
        $this->date_create = (!empty($data['date_create'])) ? $data['date_create'] : null;
        $this->date_modify = (!empty($data['date_modify'])) ? $data['date_modify'] : null;
    }
    
    public function toArray()
    {
        return array(
            'id_comment' => $this->id_comment,
            'id_user' => $this->id_user,
            'id_news' => $this->id_news,
            'text' => $this->text,
            'date_create' => $this->date_create,
            'date_modify' => $this->date_modify,
        );
    }
}
