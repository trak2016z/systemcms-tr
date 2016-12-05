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
class Group
{
    public $id_group;
    public $name;
    public $access_level;
    public $administrator;
    public $user;
    public $news;
    public $comment;
    public $forum;
    public $access_token;
    
    public function exchangeArray($data)
    {
        $this->id_group = (!empty($data['id_group'])) ? $data['id_group'] : null;
        $this->name = (!empty($data['name'])) ? $data['name'] : null;
        $this->access_level = (!empty($data['access_level'])) ? $data['access_level'] : null;
        $this->administrator = (!empty($data['administrator'])) ? $data['administrator'] : null;
        $this->user = (!empty($data['user'])) ? $data['user'] : null;
        $this->news = (!empty($data['news'])) ? $data['news'] : null;
        $this->comment = (!empty($data['comment'])) ? $data['comment'] : null;
        $this->forum = (!empty($data['forum'])) ? $data['forum'] : null;
        $this->access_token = (!empty($data['access_token'])) ? $data['access_token'] : null;
    }
    
    public function toArray()
    {
        return array(
            'id_group' => $this->id_group,
            'name' => $this->name,
            'access_level' => $this->access_level,
            'administrator' => $this->administrator,
            'user' => $this->user,
            'news' => $this->news,
            'comment' => $this->comment,
            'forum' => $this->forum,
            'access_token' => $this->access_token,
        );
    }
}
