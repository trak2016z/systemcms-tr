<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Adminpanel\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

/**
 * Description of CommentController
 *
 * @author rychu
 */
class CommentController extends AbstractActionController
{
    public function indexAction()
    {
        return new ViewModel();
    }
}
