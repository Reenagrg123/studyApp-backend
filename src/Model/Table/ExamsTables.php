<?php

namespace App\Model\Table;

use Cake\ORM\Table;

class ExamsTables extends Table{

    public function initialize(array $config)
    {

        parent::initialize($config);


        $this->setTable('exam');
        $this->setPrimaryKey('id');






    }





}

?>