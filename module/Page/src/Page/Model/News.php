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
class News
{
    public $id_news;
    public $id_user;
    public $id_category;
    public $title;
    public $short_text;
    public $long_text;
    public $date_create;
    public $date_modify;
    
    
    public function exchangeArray($data)
    {
        $this->id_news = (!empty($data['id_news'])) ? $data['id_news'] : null;
        $this->id_user = (!empty($data['id_user'])) ? $data['id_user'] : null;
        $this->id_category = (!empty($data['id_category'])) ? $data['id_category'] : null;
        $this->title = (!empty($data['title'])) ? $data['title'] : null;
        $this->short_text = (!empty($data['short_text'])) ? $data['short_text'] : null;
        $this->long_text = (!empty($data['long_text'])) ? $data['long_text'] : null;
        $this->date_create = (!empty($data['date_create'])) ? $data['date_create'] : null;
        $this->date_modify = (!empty($data['date_modify'])) ? $data['date_modify'] : null;
    }
    
    public function toArray()
    {
        return array(
            'id_news' => $this->id_news,
            'id_user' => $this->id_user,
            'id_category' => $this->id_category,
            'title' => $this->title,
            'short_text' => $this->short_text,
            'long_text' => $this->long_text,
            'date_create' => $this->date_create,
            'date_modify' => $this->date_modify,
        );
    }
}
