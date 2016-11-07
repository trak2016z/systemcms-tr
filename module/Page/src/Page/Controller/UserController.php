<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Page\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Page\Model\User;

class UserController extends AbstractActionController
{
    protected $userTable;
    
    public function indexAction()
    {
        return new ViewModel();
    }
    
    public function signupAction() // Rejestracja
    {
        $this->sessionStart();
        if ($this->checkToken())
            return $this->redirect()->toRoute('home');
        
        $user_reg = array('name' => '', 'email' => '', 'pwd1' => '', 'pwd2' => '', 'date_birth' => '', 'agree' => false);
        $request = $this->getRequest();
        if ($request->isPost())
        {
            $user_reg['name']=$_POST['name'];
            $user_reg['email']=$_POST['email'];
            $user_reg['date_birth']=$_POST['date_birth'];
            $pwd = md5($_POST['pwd1']);
            
            $users = $this->UserTable()->getAll();
            
            $isName = FALSE;
            $isEmail = FALSE;
            
            if($users->Count() > 0)
            {
                foreach ($users as $user)
                {
                    if ($user->name == $user_reg['name']) $isName = TRUE;
                    if ($user->email == $user_reg['email']) $isName = TRUE;
                }
            }
            
            if (!($isName || $isEmail))
            {
                $user = new User();
                $date = date('Y-m-d H:i:s');
                $data = array(
                    'id_user' => "",
                    'name' => $user_reg['name'],
                    'email' => $user_reg['email'],
                    'password' => $pwd,
                    'date_birth' => $user_reg['date_birth'],
                    'date_create' => $date,
                );
                $user->exchangeArray($data);
                $this->UserTable()->insert($user);
                
                return $this->redirect()->toRoute('signin');
            }
        }
        return new ViewModel(array('user_reg' => $user_reg));
    }
    
    public function signinAction() // Logowanie
    {
        $this->sessionStart();
        if ($this->checkToken())
            return $this->redirect()->toRoute('home');
        
        $request = $this->getRequest();
        if ($request->isPost())
        {
            $email = $_POST['email'];
            $pwd = md5($_POST['pwd']);
            
            $id = $this->UserTable()->checkUser($email, $pwd);
            
            if($id != -1)
            {
                $user = $this->UserTable()->getUser($id);
                $token = md5($id . $email . rand($id - 5, $id + 5));
                $_SESSION['token'] = $token;
                $_SESSION['name'] = $user->name;
                $this->UserTable()->setToken($id,$token);
                return $this->redirect()->toRoute('home');
            }
        }
        
        return new ViewModel();
    }
    
    public function signoutAction() // Wylogowanie
    {
        $this->sessionStart();
        
        if ($this->checkToken())
        {
            $this->UserTable()->setToken($id,$this->UserTable()->getIdUser($_SESSION['token']));
            session_destroy();
        }
        
        return $this->redirect()->toRoute('home');
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
    
    public function sessionStart()
    {
        session_start();
        if (!isset($_SESSION['token'])) $_SESSION['token'] = "cfcd208495d565ef66e7dff9f98764da";
    }
    
    public function checkToken()
    {
        return ("cfcd208495d565ef66e7dff9f98764da" == $_SESSION['token']) ? FALSE : (($this->UserTable()->tokenCheck($_SESSION['token'])) ? TRUE : FALSE);
    }
}
