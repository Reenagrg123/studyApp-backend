<?php

namespace App\Model\Table;

use Cake\ORM\Table;

class ClasssTables extends Table{

    public function initialize(array $config)
    {

        parent::initialize($config);


        $this->setTable('Class');
        $this->setPrimaryKey('id');
        $this->setDisplayField('id');






    }





}

?>