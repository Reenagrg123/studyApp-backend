<?php

namespace App\Model\Table;

use Cake\ORM\Table;

class HistorysTables extends Table{

    public function initialize(array $config)
    {

        parent::initialize($config);


        $this->setTable('history');
        $this->setPrimaryKey('id');



        $this->hasOne('Generateexam',['classname'=>'class_id'])->setForeignKey('id')->setBindingKey([
            'exam_id'
        ]);





    }





}

?>