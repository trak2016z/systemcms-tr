<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Application\Model;

/**
 * Description of NewsForm
 *
 * @author rychu
 */
class NewsForm
{
    public function __construct()
    {
    }
    
    public function putNews($news)
    {
        ?>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"> <?= $news['title'] ?></h3>
            </div>
            <div class="panel-heading">
                <i class="fa fa-calendar"> <?= $news['date'] ?></i> <i class="fa fa-user"> <?= $news['author'] ?></i>
            </div>
            <div class="panel-body">
                <?= $news['text'] ?>
            </div>
            <div class="panel-footer">
                <!--<a href="<?= '' /*$this->redirect()->toRoute('news',array('id' => $news['id_news'], 'title' => $this->DPC($news['title']),))*/?>" class="btn btn-default">Czytaj więcej</a> <a href="" class="btn btn-default">Komentarze (ilość)</a>-->
                <a href="<?= $this->DPC($news['title']) ?>" class="btn btn-default">Czytaj więcej</a> <a href="" class="btn btn-default">Komentarze (ilość)</a>
            </div>
        </div>
        <?php
    }
    
    public function DPC($string)
    {
        return strtr($string, 'ĘÓĄŚŁŻŹĆŃęóąśłżźćń', 'EOASLZZCNeoaslzzcn');
    }
}
