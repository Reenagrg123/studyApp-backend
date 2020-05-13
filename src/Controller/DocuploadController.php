<?php

namespace App\Controller;

use App\Controller\AppController;
use App\Controller\Services\ExecuteService;
use App\Controller\Services\McqService;
use App\Model\Table\ClasssTables;
use App\Model\Table\ExercisessTables;
use App\Model\Table\McqsTables;
use App\Model\Table\SubjectsTables;
use App\Model\Table\UploadfilesTables;
use Cake\Datasource\ConnectionManager;
use Cake\Routing\Router;


class DocuploadController extends AppController{
    public $base_url;

    public function initialize()
    {
        parent::initialize();
        $this->viewBuilder()->layout("adminlayout");
        $this->base_url = Router::url("/", true);
        $connection = ConnectionManager::get('default');
        $this->Users=$this->loadModel("User");
        $this->Class=$this->loadModel(ClasssTables::class);
        $this->Subject=$this->loadModel(SubjectsTables::class);
        $this->Exercise=$this->loadModel(ExercisessTables::class);
        $this->Uploadfiles=$this->loadModel(UploadfilesTables::class);
        $this->Mcq=$this->loadModel(McqsTables::class);
        $session = $this->getRequest()->getSession();
        $t= $session->read('user');
        if( $t=="" || $t==null ){

            $this->redirect(array("controller" => "Main",
                "action" => "login"));

            return;
        }


        $this->set("title","Dashboard");

    }


public function view(){


    $id=$this->request->getQuery('id');
    $records=$this->Mcq->find("all")->where(['hash_id'=>$id])->toArray();


    $this->set('data',$records);


    $this->set("title","Dashboard");

}

public function test(){


}
public function materials(){



}


public function getdata(){

    if($this->request->is("post")) {

        $data = $this->request->data;
        $date = date("Y-m-d");
          $type=$data['type'];

          if($type=='subject'){
              $clas=$data['class'];
              $class=$this->Subject->find("all")->where(['c_id'=>$clas])->toArray();
              $name='subject_name';

          }

          if($type=='excersise'){

              $clas=$data['class'];
              $sub=$data['subject'];
            //  var_dump($clas.$sub);exit;
              $class=$this->Exercise->find("all")->where(['c_id'=>$clas,'s_id'=>$sub])->toArray();
              $name='title';

          }

          $dt='<option value="">Select Option</option>';
foreach ($class as $d){

$id=$d['id'];
$dt.='<option value="'.$id.'">'.$d[$name].'</option>';

   // array_push($datalist,$d);

}

echo $dt;
exit;
    }
return;
    }

    public function index(){

        $class=$this->Class->find("all")->toArray();

        $records=$this->Uploadfiles->find("all")->contain(['class','subject','exercises'])->toArray();

        if($this->request->is("post")) {

           $date=date("Y-m-d");


            $data = $this->request->data;
            $exercise=$data['ex_id'];
            $hashid=rand(200,500);
            $filename=$_FILES['file']['name'];
            $path = $hashid.$_FILES['file']['name'];
            $imageFileType = pathinfo($path, PATHINFO_EXTENSION);



            if($imageFileType != "zip" && $imageFileType != "png" && $imageFileType != "jpeg"
                && $imageFileType != "gif" ) {

              var_dump("wrong");exit;

            }


            if (!file_exists('tempzip/'.$exercise)) {
                mkdir('tempzip/'.$exercise, 0777, true);
            }

            $uploadPath ='tempzip/'.$exercise.'/';
            $uploadFile = $uploadPath.$path;

try{
            if(move_uploaded_file($this->request->data['file']['tmp_name'],$uploadFile)){


//unzip
                $this->unzip($uploadFile,'mcq/'.$exercise.'/'.$hashid.'/',$exercise,$hashid);
// unzip complete

$filename=$this->getfilename('mcq/'.$exercise.'/'.$hashid.'/');
if($filename['filename']=='' && $filename['er']==1){

    $this->Flash->error('File Format Not Correct ');
return;
    // echo $filename['filename'];
}

$textfile=$this->createtextfile($filename['filename'],'mcq/'.$exercise.'/'.$hashid.'/');
if($textfile['textfile']==''){

    $this->Flash->error('File Format Not Correct , HTML File not found');
    return;

}


       $mcqservice=new McqService('mcq/'.$exercise.'/'.$hashid.'/'.$textfile['textfile'],$exercise,$hashid);
       $upload=$mcqservice->fitertext();

                $uploadfiles=$this->Uploadfiles->newEntity();

                $uploadfiles->c_id=$data['c_id'];
                $uploadfiles->s_id=$data['s_id'];
                $uploadfiles->ex_id=$data['ex_id'];
                $uploadfiles->hashid=$hashid;
                $uploadfiles->question_type=$data['q_type'];
                $uploadfiles->upload_for=$data['upload_for'];
                $uploadfiles->correct_mark=$data['correct_mark'];
                $uploadfiles->wrong_mark=$data['wrong_mark'];


                $uploadfiles->title=$data['title'];

                $uploadfiles->create_date = date("Y-m-d H:i:s");
                $this->Uploadfiles->save($uploadfiles);


                foreach ($upload as $d){
                    $mcq=$this->Mcq->newEntity();
                    $mcq->data=json_encode($d);
                    $mcq->hash_id=$hashid;
                    $mcq->type=$d['type'];
                    $mcq->create_date = date("Y-m-d H:i:s");
                    $this->Mcq->save($mcq);

                }


                $this->Flash->success('Questions Saved');
                $this->redirect(array("controller" => "Docupload",
                    "action" => "index"));

                return;

            }else{
                $this->Flash->error('Unable to upload');

                return;

            }


        }catch(\Exception $e){
    $this->Flash->error('Unable to upload');

    return;


}

        }


        $this->set("class",$class);
        $this->set("record",$records);
        //var_dump("sdfsadfdsaf");
    }

    public function createtextfile($filename,$path){


        $content = file_get_contents($path.$filename);
        $content = str_replace('<p>', ' ', $content);
        $content = str_replace('</p>', "\r\n", $content);

        $tags = array("<p>", "</p>", "<font>", "</font>");
//$string = "<p><font>Hello World of PHP</font></p>";
//echo str_replace($tags, "", $content);

        $strip_list = array('<style>', 'p', '<div>','<img>');
        $content = preg_replace('/{.*?\}/is', '', $content);
//$content = preg_replace('/(B)/', \n'(B)', $content);
        $content = str_replace('Q.', "\n\n Q.", $content);
        $content = str_replace('(A)', "\n (A).", $content);
        $content = str_replace('(B)', "\n (B)", $content);
        $content = str_replace('(C)', "\n(C).", $content);
        //    $content = str_replace('src="', 'src="1', $content);
        $content = preg_replace('/style[^>]*/', '', $content);
        $contents= str_replace('(D)', "\n (D).", $content);
        $contents=strip_tags($content,'<p><img><div>');
        $ext = explode('.', $filename);
        $myfile = fopen($path.$ext[0].".txt", "w") or die("Unable to open file!");
       // $txt = "John Doe\n";
        fwrite($myfile, $contents);

        return ['textfile'=>$ext[0].".txt"];
       // $handle = fopen("newfile34.txt", "r");

    }

    public function getfilename($path){
$send=['er'=>1,'filename'=>''];
$ext ='';
        if (is_dir($path)){
            if ($dh = opendir($path)){
                while (($file = readdir($dh)) !== false){
//echo $file;
                    $ext = explode('.', $file);
if($ext[1]=='html' || $ext[1]=='Html' ){


    $send=['er'=>0,'filename'=>$file];

}


                 //   echo "filename:" . $ext[1] . "<br>";
                }
                closedir($dh);
            }
        }

return $send;
}
public function unzip($filename,$path,$exercise,$hashid){
    if (!file_exists('mcq/'.$exercise.'/'.$hashid)) {
        mkdir('mcq/'.$exercise.'/'.$hashid, 0777, true);
    }

    if (!file_exists('mcq/'.$exercise)) {
        mkdir('mcq/'.$exercise, 0777, true);
    }
    $zip = new \ZipArchive();
    $res = $zip->open($filename);
    if ($res === TRUE) {

        // Extract file
        $zip->extractTo($path);
        $zip->close();

        return true;
    } else {
       return false;
    }
}

}
?>