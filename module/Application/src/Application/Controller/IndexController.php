<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Page\Model\News;
use Page\Model\Comment;

class IndexController extends AbstractActionController
{
    protected $userTable;
    protected $newsTable;
    protected $commentTable;
    
    public function indexAction()
    {
        $this->sessionStart();
        if ($this->checkToken())
        {
            $this->layout()->user_name = $_SESSION['name'];
        }
        
        $all_news = $this->NewsTable()->getAll();
        $news_array = array();
        
        if ($all_news->count() > 0)
        {
            foreach ($all_news as $news)
            {
                $news_array[] = array(
                    'id_news' => $news->id_news, 
                    'title' => $news->title, 
                    'author' => $this->UserTable()->getName($news->id_user),
                    'text' => $news->short_text,
                    'date' => $news->date_create,
                    'comments' => $this->CommentTable()->countcomments($news->id_news),
                    );
            }
            
            //return new ViewModel(array('all_news' => $news_array,));
            //return new ViewModel(array('all_news' => $all_news,'news_count' => $all_news->count(), ));
            return new ViewModel(array('all_news' => $news_array,'news_count' => $all_news->count(), ));
        }
        else
            return new ViewModel(array('news_count' => $all_news->count(),));
            //return new ViewModel();
        //$all_news = '';
        
        //return new ViewModel(array('all_news' => $all_news,'news_count' => 'Neg', ));
        //return new ViewModel();
    }
    
    public function newsAction()
    {
        $this->sessionStart();
        if ($this->checkToken())
        {
            $this->layout()->user_name = $_SESSION['name'];
        }
        
        $id = $this->getEvent()->getRouteMatch()->getParam('id');
        $title = $this->getEvent()->getRouteMatch()->getParam('title');
        
        $request = $this->getRequest();
        if ($request->isPost() && $this->checkToken())
        {
            $date = date('Y-m-d H:i:s');
            $comment = new Comment();
            $comment->exchangeArray(array(
                'id_user' => $_SESSION['id'],
                'id_news' => $id,
                'text' => $_POST['text'],
                'date_create' => $date,
                'date_modify' => $date,
            ));
            
            $this->CommentTable()->insert($comment);
            
            return $this->redirect()->toRoute('news', array('id' => $id, 'title' => $title));
        }
        
        if ($id != NULL)
        {
            $news = $this->NewsTable()->getNews((int)$id);
            $comments = $this->CommentTable()->getAll2N((int)$id);
            $comments_array = array();
            
            //if ($comments->count() > 0)
            //{
            $id_user = 0;
            
                foreach ($comments as $comment)
                {
                    $date2 = $comment->date_create;
                    $id_user = $this->UserTable()->getName($comment->id_user);
                    $comments_array[] = array(
                        'author' => $id_user,
                        'text' => $comment->text,
                        'date_create' => $this->getTime($comment->date_create),
                        'side' => ($_SESSION['id'] == $comment->id_user)?"right":"left",
                    );
                    
                    //$;
                    //echo '<br>';
                    
                    //$date3 = $date - $date2;
                    //echo $date3 . " , ";
                }
            //}
            
            if ($news != new News())
            {
                if ($title == $this->clean($news->title))
                {
                    return new ViewModel(array(
                        'id_news' => $news->id_news,
                        'title' => $news->title, 
                        'author' => $this->UserTable()->getName($news->id_user), 
                        'short_text' => $news->short_text, 
                        'long_text' => $news->long_text,
                        'date' => $news->date_create,
                        'comments' => $comments_array,
                        'logged' => ($this->checkToken())?1:0,
                        ));
                }
            }
        }
        
        $this->redirect()->toRoute('home');
    }
    
    public function commentAction()
    {
        
        $this->sessionStart();
        if ($this->checkToken())
        {
            $this->layout()->user_name = $_SESSION['name'];
        }
    }

    private function clean($string)
    {
        $string = str_replace('', '-', $string); // Replaces all spaces with hyphens.
        return preg_replace('/[^A-Za-z0-9\-]/', '-', $string); // Removes special chars.
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
        if (!isset($_SESSION['group'])) $_SESSION['group'] = "Gość";
    }
    
    public function checkToken()
    {
        $logged = ("cfcd208495d565ef66e7dff9f98764da" == $_SESSION['token']) ? FALSE : (($this->UserTable()->tokenCheck($_SESSION['token'])) ? TRUE : FALSE);
        
        return $logged;
    }
    
    public function getGroup($id)
    {
        //return $this->UserTable()->getUserGroup($id);
        $this->UserTable()->getUserGroup($id);
    }
    
    private function getTime($date)
    {
        $minutes = 60;
        $hours = 60 * $minutes;
        $days = 24 * $hours;
        
        $time = strtotime(date('Y-m-d H:i:s')) - strtotime($date);
        
        if (intval($time/$days))
            return $date;
        elseif (intval($time/$hours))
            return intval($time/$hours) . " godz. temu";
        elseif (intval($time/$minutes))
            return intval($time/$minutes) . " min temu";
        else
            return intval($time) . " sek temu";
    }
}
