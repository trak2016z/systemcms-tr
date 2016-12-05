<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Application\Model;

/**
 * Description of LinkModify
 *
 * @author rychu
 */
class LinkModify
{
    public function __construct()
    {
    }
    
    public function DPC($string)
    {
        return strtr($string, 'ĘÓĄŚŁŻŹĆŃęóąśłżźćń', 'EOASLZZCNeoaslzzcn');
    }
}
