<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Adminpanel\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Page\Model\News;
use Page\Model\Comment;

/**
 * Description of CommentController
 *
 * @author rychu
 */
class CommentController extends AbstractActionController
{
    protected $userTable;
    protected $newsTable;
    protected $categoryTable;
    protected $groupTable;
    protected $commentTable;
    protected $library = array('kurwa','kurewsko','skurwysyn','kurwić','chuj','huj','pierdol','pierdole','spierdalaj','pierdolić','jebać','jebany','srom');

    public function indexAction()
    {
        $this->sessionStart();
        if ($this->checkToken())
        {
            $this->layout()->user_name = $_SESSION['name'];
        }
        
        if ($this->GroupTable()->checkAccess('news', $_SESSION['access_token']) == 0)
            return $this->redirect()->toRoute('home');
        
        $comments = $this->CommentTable()->getAll();
        $comments_array = array();
        
        foreach ($comments as $comment)
            $comments_array[] = array(
                'id_comment' => $comment->id_comment,
                'author' => $this->UserTable()->getName($comment->id_user),
                'news' => $this->NewsTable()->getName($comment->id_news),
                'date_create' => $comment->date_create,
                'date_modify' => $comment->date_modify,
                'vulgarity' => $this->searchVulgar($comment->text),
                'text' => $this->checkVulgar($comment->text),
                //'text' => $comment->text,
            );
        
        return new ViewModel(array('comments' => $comments_array,));
    }
    
    public function deleteAction()
    {
        $this->sessionStart();
        if ($this->checkToken())
        {
            $this->layout()->user_name = $_SESSION['name'];
        }
        
        if ($this->GroupTable()->checkAccess('news', $_SESSION['access_token']) == 0)
            return $this->redirect()->toRoute('home');
        
        $id = $this->getEvent()->getRouteMatch()->getParam('id');
        
        if ($id == NULL)
            return $this->redirect()->toRoute('admincomment');
        
        $this->CommentTable()->delete($id);
        
        return $this->redirect()->toRoute('admincomment');
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
    
    public function NewsTable()
    {
        if (!$this->newsTable)
        {
            $sm = $this->getServiceLocator();
            $this->newsTable = $sm->get('Page\Model\NewsTable');
        }
        
        return $this->newsTable;
    }
    
    public function CategoryTable()
    {
        if (!$this->categoryTable)
        {
            $sm = $this->getServiceLocator();
            $this->categoryTable = $sm->get('Page\Model\CategoryTable');
        }
        
        return $this->categoryTable;
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
    
    public function CommentTable()
    {
        if (!$this->commentTable)
        {
            $sm = $this->getServiceLocator();
            $this->commentTable = $sm->get('Page\Model\CommentTable');
        }
        
        return $this->commentTable;
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
    
    private function searchVulgar($text)
    {
        foreach ($this->library as $word)
        {
            if (strpos($text, $word)) return 1;
        }
        
        return 0;
    }
    
    private function checkVulgar($text)
    {
        foreach ($this->library as $word)
            if (strpos($text, $word))
                $text = str_replace($word, '<font color="red">' . $word . '</font>', $text);
            
        return $text;
    }
}
