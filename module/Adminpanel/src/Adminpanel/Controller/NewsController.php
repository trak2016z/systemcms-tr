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
/**
 * Description of NewsController
 *
 * @author rychu
 */
class NewsController extends AbstractActionController
{
    protected $userTable;
    protected $newsTable;
    protected $categoryTable;
    protected $groupTable;

    public function indexAction()
    {
        $this->sessionStart();
        if ($this->checkToken())
        {
            $this->layout()->user_name = $_SESSION['name'];
        }
        
        if ($this->GroupTable()->checkAccess('news', $_SESSION['access_token']) == 0)
            return $this->redirect()->toRoute('home');
        
        $all_news = $this->NewsTable()->getAll();
        $news_array = array();
        
        foreach ($all_news as $news)
            $news_array[] = array(
                'id_news' => $news->id_news,
                'title' => $news->title,
                'author' => $this->UserTable()->getName($news->id_user),
                'category' => $this->CategoryTable()->getName($news->id_category),
                'date_create' => $news->date_create,
                'date_modify' => $news->date_modify
            );
        
        return new ViewModel(array('all_news' => $news_array,));
    }
    
    public function createAction()
    {
        $this->sessionStart();
        if ($this->checkToken())
        {
            $this->layout()->user_name = $_SESSION['name'];
        }
        
        if ($this->GroupTable()->checkAccess('news', $_SESSION['access_token']) == 0)
            return $this->redirect()->toRoute('home');
        
        $all_category = $this->CategoryTable()->getAll();
        
        $news = new News();
        
        $request = $this->getRequest();
        if ($request->isPost())
        {
            if (isset($_POST['title']) && isset($_POST['category']) && isset($_POST['short_text']) && isset($_POST['long_text']))
            {
                $date = date('Y-m-d H:i:s');
                
                $news->exchangeArray(array(
                    'id_user' => $_SESSION['id'],
                    'id_category' => $_POST['category'],
                    'title' => $_POST['title'],
                    'short_text' => $_POST['short_text'],
                    'long_text' => $_POST['long_text'],
                    'date_create' => $date,
                    'date_modify' => $date,
                    ));
                
                if($this->NewsTable()->insert($news))
                    return $this->redirect()->toRoute('adminnews');
            }
        }
        
        return new ViewModel(array('$news' => $news, 'categories' => $all_category,));
    }
    
    public function editAction()
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
            return $this->redirect()->toRoute('adminnews');
        
        $news = $this->NewsTable()->getNews((int)$id);

        if ($news == new News())
            return $this->redirect()->toRoute('adminnews');
        
        $news_array = $news->toArray();
        
        $all_category = $this->CategoryTable()->getAll();
        
        $request = $this->getRequest();
        if ($request->isPost())
        {
            if (isset($_POST['title']) && isset($_POST['category']) && isset($_POST['short_text']) && isset($_POST['long_text']))
            {
                $date = date('Y-m-d H:i:s');
                
                $news->exchangeArray(array(
                    'id_news' => $news_array['id_news'],
                    'id_user' => $news_array['id_user'],
                    'id_category' => $_POST['category'],
                    'title' => $news_array['title'],
                    'short_text' => $_POST['short_text'],
                    'long_text' => $_POST['long_text'],
                    'date_create' => $news_array['date_create'],
                    'date_modify' => $date,
                    ));
                
                if($this->NewsTable()->update($news))
                    return $this->redirect()->toRoute('adminnews');
            }
        }
        
        //return new ViewModel(array('$news' => $news_array, 'categories' => $all_category, 'id' => $id, '$news_x' => $news_array,));
        return new ViewModel(array(
            'categories' => $all_category, 
            'id' => $id,
            'title' => $news->title, 
            'author' => $this->UserTable()->getName($news->id_user), 
            'short_text' => $news->short_text, 
            'long_text' => $news->long_text,
            'date' => $news->date_create,
            ));
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
            return $this->redirect()->toRoute('adminnews');
        
        $this->NewsTable()->delete($id);
        
        return $this->redirect()->toRoute('adminnews');
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
