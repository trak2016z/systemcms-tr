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
class Category
{
    public $id_category;
    public $name;
    
    public function exchangeArray($data)
    {
        $this->id_category = (!empty($data['id_category'])) ? $data['id_category'] : null;
        $this->name = (!empty($data['name'])) ? $data['name'] : null;
    }
}
