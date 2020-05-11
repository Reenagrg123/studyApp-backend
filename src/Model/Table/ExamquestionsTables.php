<?php

namespace App\Model\Table;

use Cake\ORM\Table;

class ExamquestionsTables extends Table{

    public function initialize(array $config)
    {

        parent::initialize($config);


        $this->setTable('examquestion');
        $this->setPrimaryKey('id');
        $this->addBehavior('Timestamp');



    }





}

?>