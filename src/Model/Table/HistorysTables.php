<?php

namespace App\Model\Table;

use Cake\ORM\Table;

class HistorysTables extends Table{

    public function initialize(array $config)
    {

        parent::initialize($config);


        $this->setTable('history');
        $this->setPrimaryKey('id');






    }





}

?>