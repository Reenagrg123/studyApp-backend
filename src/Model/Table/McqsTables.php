<?php

namespace App\Model\Table;

use Cake\ORM\Table;

class McqsTables extends Table{

    public function initialize(array $config)
    {

        parent::initialize($config);


        $this->setTable('mcq');
        $this->setPrimaryKey('id');






    }





}

?>