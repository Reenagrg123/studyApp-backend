<?php

namespace App\Model\Table;

use Cake\ORM\Table;

class SubjectsTables extends Table{

    public function initialize(array $config)
    {

        parent::initialize($config);


        $this->setTable('subject');
        $this->setPrimaryKey('id');
        $this->setDisplayField('id');






    }





}

?>