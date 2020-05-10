<?php

namespace App\Model\Table;

use Cake\ORM\Table;

class ClassexammapsTables extends Table{

    public function initialize(array $config)
    {

        parent::initialize($config);


        $this->setTable('classexammap');
        $this->setPrimaryKey('id');






    }





}

?>