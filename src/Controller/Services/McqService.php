<?php

namespace App\Controller\Services;

use App\Controller\AppController;
use Cake\Network\Email\Email;
use Cake\Routing\Router;
use Cake\Mailer;
use Composer\Package\Archiver\ZipArchiver;
use Composer\Util\Zip;


class McqService extends AppController{
    public $path;
    public $exercise;
    public $hasid;
    public $data;



    public function __construct($p,$ex,$has)
    {
        $this->path=$p;
        $this->exercise=$ex;
        $this->hasid=$has;


    }


    public function extractquestion($file){

        $questionarry=[];
        $question= explode('Q.',$file);
        $checkquestionpattern=['Ans','Sol'];
$i=0;

        foreach ($question as $q){
         //   echo $q;
            $ch=0;
            foreach ($checkquestionpattern as $k){
                if (strpos($q, $k) !== false) {
                    $ch=1;
                }
            }
if($ch==1){
    $temp=[];
    $temp['question']=$q;
    $temp['id']=$i;
    $temp['innerquestion']='';
    $temp['solution']='';
    $temp['hashid']=$this->hasid;
    $temp['type']='';
    $temp['option']='';
    $temp['answer']='';

    array_push($questionarry, $temp);

    $i++;
}


            //  echo $q;

        }
return $questionarry;
    }

    public function fitertext(){

      //  $handle = fopen($this->path, "r");
$file=file_get_contents($this->path);
$srcto='src="mcq/'.$this->exercise.'/'.$this->hasid.'/';
        $file = str_replace('src="', $srcto,$file);
        $file = str_replace('@font-face', " ",$file);
        $file = str_replace('@page', " ",$file);

        $file = str_replace('@font-face', " ",$file);


$question=$this->extractquestion($file);
$this->data=$question;
$this->innserquestion();
$answer=$this->extractanswer();
$option=$this->getoption();
$solution=$this->getsolution();
$this->filterquestion();

        $myfile = fopen("mcq/".$this->exercise.'/'.$this->hasid.'/'."data.txt", "w") or die("Unable to open file!");
        // $txt = "John Doe\n";
        fwrite($myfile, json_encode($this->data));

        return $this->data;
//var_dump($this->data);exit;



    }

    public function filterquestion(){

        $data=$this->data;

        $i=0;

        foreach($data as $d){
            //  var_dump($data[$i]['type']);
            if( $data[$i]['type']=="mcq" ){
                // var_dump("dsfsdfs");
                $exans= explode('(A)',$d['question']);


                $data[$i]['question']=$exans[0];

            }
            if($data[$i]['type']=="integer"){

                $exans= explode('Sol',$d['question']);
                $data[$i]['question']=$exans[0];
            }

            $i++;

        }

        $this->data=$data;
    }
public function innerquestionfetch($q){
$data=[];
   // $question= explode('[q]',$q);
    $checkpara=["(B)","(C)","(D)"];
    $checkquestionpattern=['Ans','Sol'];
$i=0;
foreach ($q as $qu){
    $temp=[];
    if($i>0){

        if($this->checkpresence($qu,$checkquestionpattern)){
             $question= explode('(A)',$qu);
             $temp['id']=$i;
$temp['question']=$question[0];
            $option= explode('Ans',$question[1]);
            if(! $option==null){
                $optionline=$this->replace($option[0],$checkpara);

$temp['option']=explode(',',$optionline);
$temp['type']='mcq';
            }else{
$temp['option']='';
                $temp['type']='integer';
            }

            $answer= explode('Ans',$qu);
            $answersol=explode('Sol',$answer[1]);
            $temp['answer']=explode(',',$answersol[0]);

            $soution= explode('Sol',$qu);
           $t=0;
           $sol=[];
            foreach ($soution as $s){
                if($t>0){
                   array_push($sol,trim($s));
                }
            }

            $temp['solution']=$sol;

array_push($data,$temp);



        }

    }
    $i++;
}

return $data;

}

    public function innserquestion(){
$data=$this->data;

$i=0;
foreach($data as $d){

    $innerq= explode('[q]',$d['question']);

if(count($innerq)>1){
    $data[$i]['innerquestion']=$this->innerquestionfetch($innerq);
    $data[$i]['question']=$innerq[0];
   // echo $d['question'];exit;

    $data[$i]['type']="paragraph";

//array_push($d,$temp);


}
$i++;
}
$this->data=$data;



    }

    public function checkpresence($line,$arr){


        foreach ($arr as $a){
            if (strpos($line,$a) !== false) {

                return true;

            }else{
                return false;
            }
        }
    }

    public function replace($line,$arr){
        foreach ($arr as $a){
          $line=str_replace($a,',',$line);
        }
       return $line;
    }

    public function getsolution(){
        $data=$this->data;
        $checkpara=["(B)","(C)","(D)"];
        $i=0;

        foreach($data as $d){
          //  var_dump($data[$i]['type']);
            if( $data[$i]['type']=="mcq" || $data[$i]['type']=="integer" ){
               // var_dump("dsfsdfs");
                $exans= explode('Sol',$d['question']);

                $j=0;
                $sol=[];
                foreach ($exans as $er){
                    if($j>0){
                        array_push($sol,trim($er));
                    }
                    $j++;
                }
                $data[$i]['solution']=$sol;




            }




            $i++;

        }

        $this->data=$data;
    }


    public function getoption(){

        $data=$this->data;
$checkpara=["(B)","(C)","(D)"];
        $i=0;
        foreach($data as $d){
            if(! $data[$i]['type']=='paragraph'){
                $exans= explode('(A)',$d['question']);
            if(array_key_exists(1,$exans) && $this->checkpresence($exans[1],$checkpara)){

                $sol=explode('Ans',$exans[1]);
                $getans=$sol[0];
                $getans=$this->replace($getans,$checkpara);
                $data[$i]['option']=explode(',',trim($getans));
                $data[$i]['type']='mcq';

            }
if($data[$i]['option']==''){

    $data[$i]['type']='integer';
}

            }
            $i++;

        }

        $this->data=$data;

    }

public function extractanswer(){
    $data=$this->data;

    $i=0;
    foreach($data as $d){
        if(! $data[$i]['type']=='paragraph'){
            $exans= explode('Ans',$d['question']);

            $sol=explode('Sol',$exans[1]);
            $getans=$sol[0];
            $data[$i]['answer']=explode(',',trim($getans));
        }




$i++;

    }
    $this->data=$data;


}

}


?>