<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Adminpanel\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Page\Model\User;
use Page\Model\Group;

/**
 * Description of GroupController
 *
 * @author rychu
 */
class GroupController extends AbstractActionController
{
    protected $userTable;
    protected $groupTable;
    
    public function indexAction()
    {
        $this->sessionStart();
        if ($this->checkToken())
        {
            $this->layout()->user_name = $_SESSION['name'];
        }
        
        if ($this->GroupTable()->checkAccess('user', $_SESSION['access_token']) == 0)
            return $this->redirect()->toRoute('home');
        
        $groups = $this->GroupTable()->getAll();
        $groups_array = array();
        
        foreach ($groups as $group)
        {
            $group = $group->toArray();
            $group['administrator'] = ($group['administrator'] == 1)?'Tak':'Nie';
            $group['user'] = ($group['user'] == 1)?'Tak':'Nie';
            $group['news'] = ($group['news'] == 1)?'Tak':'Nie';
            $group['forum'] = ($group['forum'] == 1)?'Tak':'Nie';
            $group['access_level'] = '';
            $group['access_token'] = '';
            
            $groups_array[] = $group;
        }
        
        return new ViewModel(array('groups' => $groups_array,));
    }
    
    public function createAction()
    {
        $this->sessionStart();
        if ($this->checkToken())
        {
            $this->layout()->user_name = $_SESSION['name'];
        }
        
        if ($this->GroupTable()->checkAccess('user', $_SESSION['access_token']) == 0)
            return $this->redirect()->toRoute('home');
        
                print_r($_POST);
        
        $request = $this->getRequest();
        if ($request->isPost())
        {
            if (isset($_POST['name']) && isset($_POST['admin']) && isset($_POST['user']) && isset($_POST['news']) && isset($_POST['forum']))
            {
            }
        }
        
        return new ViewModel();
        return new ViewModel(array('groups' => $groups_array,));
    
    }
    public function editAction()
    {
        return new ViewModel();
    }
    
    public function deleteAction()
    {
        
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
    
    public function GroupTable()
    {
        if (!$this->groupTable)
        {
            $sm = $this->getServiceLocator();
            $this->groupTable = $sm->get('Page\Model\GroupTable');
        }
        
        return $this->groupTable;
    }
    
    public function sessionStart()
    {
        session_start();
        if (!isset($_SESSION['token'])) $_SESSION['token'] = "cfcd208495d565ef66e7dff9f98764da";
        if (!isset($_SESSION['id'])) $_SESSION['id'] = "0";
        if (!isset($_SESSION['access_token'])) $_SESSION['access_token'] = "6a1f7f316f50dd521f46d2eb0db7a091";
        if (!isset($_SESSION['group'])) $_SESSION['news'] = "Gość";
    }
    
    public function checkToken()
    {
        $logged = ("cfcd208495d565ef66e7dff9f98764da" == $_SESSION['token']) ? FALSE : (($this->UserTable()->tokenCheck($_SESSION['token'])) ? TRUE : FALSE);
        
        return $logged;
    }
}
