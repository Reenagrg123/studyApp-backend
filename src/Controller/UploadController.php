<?php

namespace App\Controller;

use App\Controller\AppController;
use App\Controller\Services\ExecuteService;
use Cake\Http\Response;
use Cake\Http\ServerRequest;
use Cake\Routing\Router;


class UploadController extends AppController{

    public $path;
    public $exercise;
    public $hasid;



    public function __construct($p,$ex,$has)
    {
  $this->path=$p;
  $this->exercise=$ex;
  $this->hasid=$has;


     }


     public function fitertext(){


     }



    public function index(){
        print_r($this->request->params['pass']);

        $this->set("name","shubhendu");
        $this->set("last","kumar");

        $d=array("author"=>"rrk","nash"=>"sarv");
        $this->set("data",$d);



    }

    public function upload(){
        $this->extractquestion();
        exit;
        $pieces = parse_url(Router::url('/', true));

        $file="sahil.docx";

         $msqservice=new ExecuteService($file);

       // echo "<pre>".$msqservice->convertToText()."</pre>";
        $myfile = fopen("newfilie.txt", "w") or die("Unable to open file!");
        fwrite($myfile, $msqservice->convertToText());
$msqservice->extractImages();
        var_dump($msqservice->displayImages());
        var_dump("dsgsdgdsg");exit;

    }
public function checkpattern($line,$arr){

foreach ($arr as $a){
    if (strpos($line,$a) !== false) {

        return true;

    }else{
        return false;
    }
}

}

public function getquestion($file){
$question=[];
$option=[];
$answer=[];
$solution=[];
$qadd=false;
$qline='';
$qpattern=["Q.","q."];
$anspattern=["Ans","ans"];

    while (($line = fgets($file)) !== false) {

$qch=$this->checkpattern($line,$qpattern);
if($qch || $qadd){
    $qadd=true;
    if($this->checkpattern($line,$anspattern)){
        continue;
    }else{
        $qline.=$line;
    }

}
       // echo $line."<br/>";
    }

    echo $qline;
}
    public function extractquestion(){
        $handle = fopen("newfilie.txt", "r");
$this->getquestion($handle);



    }



    public function ren(){
        $this->autoRender=false;


    }

}


?>