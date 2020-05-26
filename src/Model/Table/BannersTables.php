<?php

namespace App\Model\Table;

use Cake\ORM\Table;

class BannersTables extends Table{

    public function initialize(array $config)
    {

        parent::initialize($config);


        $this->setTable('banner');
        $this->setPrimaryKey('id');
        $this->setDisplayField('id');





    }





}

?>