<?php

namespace App\Model\Table;

use Cake\ORM\Table;

class ClasssTables extends Table{

    public function initialize(array $config)
    {

        parent::initialize($config);


        $this->setTable('class');
        $this->setPrimaryKey('id');






    }





}

?>