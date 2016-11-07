<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Page\Plugin;

use Page\Model\User;

class AuthService
{
    protected $userTable;
//    public function __construct()
//    {
//    }
    
    public function checkToken()
    {
        //$uc = new UserController();
        //$x = $uc->UserTable()->tokenCheck($_SESSION['token']);
        //$logged = ("cfcd208495d565ef66e7dff9f98764da" == $_SESSION['token']) ? FALSE : (($x) ? TRUE : FALSE);
        $logged = ("cfcd208495d565ef66e7dff9f98764da" == $_SESSION['token']) ? FALSE : (($this->UserTable()->tokenCheck($_SESSION['token'])) ? TRUE : FALSE);
        
        return $logged;
    }
    
    public function UserTable()
    {
        if (!$this->userTable)
        {
            $sm = $this->getServiceLocator();
            $this->userTable = $sm->get('Page\Model\UserTable');
        }
        
        return $this->userTable;
    }
}
