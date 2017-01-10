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

class UserController extends AbstractActionController
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
                
        $users = $this->UserTable()->getAll();
        $users_array = array();
        
        foreach ($users as $user)
            $users_array[] = array(
                'id_user' => $user->id_user, 
                'name' => $user->name, 
                'email' => $user->email,
                'group' => $this->GroupTable()->getUserGroupName($user->id_group),
                'date_birth' => $user->date_birth,
                'date_create' => $user->date_create,
                );
        
        return new ViewModel(array('users' => $users_array));
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
        
        $user = new User();
        $groups = $this->GroupTable()->getAll();
        
        $request = $this->getRequest();
        if ($request->isPost())
        {
            if (isset($_POST['name']) && isset($_POST['email']) && isset($_POST['password']) && isset($_POST['date_birth']) && isset($_POST['group']))
            {
                $date = date('Y-m-d H:i:s');
                
                $user->exchangeArray(array(
                    'name' => $_POST['name'],
                    'email' => $_POST['email'],
                    'password' => md5($_POST['password']),
                    'date_birth' => $_POST['date_birth'],
                    'date_create' => $date,
                    'id_group' => $_POST['id_group'],
                ));
                
                if ($this->UserTable()->insert($user))
                    return $this->redirect()->toRoute('adminuser');
                else
                    $user->password = '';
            }
        }
        
        return new ViewModel(array('user' => $user, 'groups' => $groups,));
    }
    
    public function editAction()
    {
        $this->sessionStart();
        if ($this->checkToken())
        {
            $this->layout()->user_name = $_SESSION['name'];
        }
        
        if ($this->GroupTable()->checkAccess('user', $_SESSION['access_token']) == 0)
            return $this->redirect()->toRoute('home');
        
        $id = $this->getEvent()->getRouteMatch()->getParam('id');
        
        if ($id == NULL)
            return $this->redirect()->toRoute('adminuser');
        
        $user = $this->UserTable()->getUser($id);
        $groups = $this->GroupTable()->getAll();
        
        $request = $this->getRequest();
        if ($request->isPost())
        {
            if (isset($_POST['name']) && isset($_POST['date_birth']) && isset($_POST['group']))
            {
                $date = date('Y-m-d H:i:s');
                
                $user->exchangeArray(array(
                    'id_user' => $id,
                    'name' => $_POST['name'],
                    'password' => ($_POST['password'] == "") ? $this->UserTable()->getPassword($id) : md5($_POST['password']),
                    'date_birth' => $_POST['date_birth'],
                    'id_group' => $_POST['group'],
                ));
                
                if ($this->UserTable()->update($user))
                    return $this->redirect()->toRoute('adminuser');
                    //return new ViewModel(array('user' => $user, 'groups' => $groups, 'id' => $id));
                else
                    $user->password = '';
            }
        }
        
        return new ViewModel(array('user' => $user, 'groups' => $groups, 'id' => $id));
    }
    
    public function deleteAction()
    {
        $this->sessionStart();
        if ($this->checkToken())
        {
            $this->layout()->user_name = $_SESSION['name'];
        }
        
        if ($this->GroupTable()->checkAccess('user', $_SESSION['access_token']) == 0)
            return $this->redirect()->toRoute('home');
        
        $id = $this->getEvent()->getRouteMatch()->getParam('id');
        
        if ($id == NULL)
            return $this->redirect()->toRoute('adminuser');
        
        $this->UserTable()->delete($id);
        
        return $this->redirect()->toRoute('adminuser');
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
        if (!isset($_SESSION['access_token'])) $_SESSION['access_token'] = "6a1f7f316f50dd521f46d2eb0db7a091";
        if (!isset($_SESSION['group'])) $_SESSION['group'] = "Gość";
    }
    
    public function checkToken()
    {
        $logged = ("cfcd208495d565ef66e7dff9f98764da" == $_SESSION['token']) ? FALSE : (($this->UserTable()->tokenCheck($_SESSION['token'])) ? TRUE : FALSE);
        
        return $logged;
    }
}
