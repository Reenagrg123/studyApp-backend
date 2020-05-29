<?php

namespace App\Controller;

use App\Controller\AppController;
use App\Controller\Services\ExecuteService;
use App\Controller\Services\McqService;
use App\Model\Table\ClasssTables;
use App\Model\Table\ExamexercisessTables;
use App\Model\Table\ExamsTables;
use App\Model\Table\Examsubjects;
use App\Model\Table\ExercisessTables;
use App\Model\Table\MaterialsTables;
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
        $this->Materials=$this->loadModel(MaterialsTables::class);


        $this->ExamSubject=$this->loadModel(Examsubjects::class);
        $this->ExamExercise=$this->loadModel(ExamexercisessTables::class);
        $this->Exam=$this->loadModel(ExamsTables::class);


        $session = $this->getRequest()->getSession();
        $t= $session->read('user');
        if( $t=="" || $t==null ){

            $this->redirect(array("controller" => "Main",
                "action" => "login"));

            return;
        }


        $this->set("title","Dashboard");

    }

    public function delquestion(){
        $uploadid=$this->request->getQuery('upload');
        $qid=$this->request->getQuery('id');
        $records=$this->Mcq->findById($qid)->first();
        if($records){
            $this->Mcq->delete($records);
        }

        $this->Flash->success('Data Removed');
        $this->redirect(array("controller" => "Docupload",
            "action" => "view","id"=>$uploadid));

    }

    public function delmaterial(){

        $id=$this->request->getQuery('id');
        $records=$this->Materials->findById($id)->first();
if($records){
    if($records->hash_id)
        $this->delete_directory('materials/'.$records->hash_id.'/');


    $this->Materials->delete($records);
    $this->Flash->success('Data Removed');
    $this->redirect(array("controller" => "Docupload",
        "action" => "materials"));

}

    }


    public function exammaterials(){

        $class=$this->Exam->find("all")->toArray();
        $records=$this->Materials->find('all')->where(['upload_for'=>1])->contain(['Exam','Examsubject'])->toArray();
        $save=0;
        // $records=$this->Uploadfiles->find("all")->contain(['class','subject','exercises'])->toArray();
        $this->set('class',$class);

        if($this->request->is("post")) {

            $data = $this->request->data;
            $date = date("Y-m-d");
            $hasid=$data['class'].rand(100,2000);

            $material=$this->Materials->newEntity();


            if($data['upload_type']==0){
                $material->type=0;

                $filename=$_FILES['file']['name'];
                $path = $hasid.$_FILES['file']['name'];
                $imageFileType = pathinfo($path, PATHINFO_EXTENSION);



                if($imageFileType !== "pdf" && $imageFileType !== "doc" && $imageFileType !== "docx") {
                    $this->Flash->error('Wrong File Format');
                    $this->redirect(array("controller" => "Docupload",
                        "action" => "exammaterials"));
                    return;

                }

                if (!file_exists('materials/'.$hasid)) {
                    mkdir('materials/'.$hasid, 0777, true);
                }

                $uploadPath ='materials/'.$hasid.'/';
                $uploadFile = $uploadPath.$path;

                if(move_uploaded_file($this->request->data['file']['tmp_name'],$uploadFile)) {

                    $save=1;
                    $material->file=$path;

                }

                $material->hash_id=$hasid;




            }
            if($data['upload_type']==1){
                $material->type=1;
                $material->link=$data['link'];
                $material->hash_id=$hasid;
                $save=1;

            }
            if($data['upload_type']==2){
                $material->link=$data['link'];
                $material->type=2;
                $material->hash_id=$hasid;

                $filename=$_FILES['file']['name'];
                $path = $hasid.$_FILES['file']['name'];
                $imageFileType = pathinfo($path, PATHINFO_EXTENSION);



                if($imageFileType !== "pdf" && $imageFileType !== "doc" && $imageFileType !== "docx") {
                    $this->Flash->success('Wrong File Format');
                    $this->redirect(array("controller" => "Docupload",
                        "action" => "exammaterials"));
                    return;

                }
                if (!file_exists('materials/'.$hasid)) {
                    mkdir('materials/'.$hasid, 0777, true);
                }

                $uploadPath ='materials/'.$hasid.'/';
                $uploadFile = $uploadPath.$path;

                if(move_uploaded_file($this->request->data['file']['tmp_name'],$uploadFile)) {

                    $save=1;
                    $material->file=$path;

                }


            }
            $material->c_id=$data['class'];
            $material->s_id=$data['subject'];
            $material->ch_id=$data['ch_id'];
            $material->name=$data['title'];
            $material->create_date=date("Y-m-d H:i:s");
            $material->upload_for=$data['upload_for'];
            if($save==1){
                $this->Materials->save($material);
                $this->Flash->success('Data Saved');
                $this->redirect(array("controller" => "Docupload",
                    "action" => "exammaterials"));

                return;

            }else{
                $this->Flash->success('Try Again');
                $this->redirect(array("controller" => "Docupload",
                    "action" => "exammaterials"));

                return;
            }

        }
        $this->set('records',$records);





    }

    public function paragraphupdate($data){

        $q_id=$data['q_id'];
        $records=$this->Mcq->find()->where(['id'=>$q_id])->first()->toArray();
        if($records){
            $datatemp=json_decode($records['data']);
//var_dump($datatemp->innerquestion->question);exit;
            $datatemp->question=$data['question'];
            $i=0;
            foreach ($datatemp->innerquestion as $r){



                    $r->question = $data['innerquestion'][$i]['question'];
                    $r->option = $data['innerquestion'][$i]['option'];
                    $r->answer = $data['innerquestion'][$i]['answer'];
                   $r = $data['innerquestion'][$i]['solution'];
                    $i++;

            }


            $recordsupdate=$this->Mcq->find()->where(['id'=>$q_id])->first();
            $recordsupdate->data=json_encode($datatemp);
            $this->Mcq->save($recordsupdate);
//var_dump($datatemp);exit;
            // var_dump($datatemp);exit;

        }
    }


    public function integerupdate($data){
        $q_id=$data['q_id'];
        $records=$this->Mcq->find()->where(['id'=>$q_id])->first()->toArray();
        if($records){
            $datatemp=json_decode($records['data']);

            $datatemp->question=$data['question'];
            $datatemp->answer=$data['answer'];
            $datatemp->solution=$data['solution'];
          //  $datatemp->option=$data['option'];

            $recordsupdate=$this->Mcq->find()->where(['id'=>$q_id])->first();
            $recordsupdate->data=json_encode($datatemp);
            $this->Mcq->save($recordsupdate);

            // var_dump($datatemp);exit;

        }

    }
public function mcqupdate($data){
   $q_id=$data['q_id'];
    $records=$this->Mcq->find()->where(['id'=>$q_id])->first()->toArray();
if($records){
    $datatemp=json_decode($records['data']);

    $datatemp->question=$data['question'];
    $datatemp->answer=$data['answer'];
    $datatemp->solution=$data['solution'];
    $datatemp->option=$data['option'];

    $recordsupdate=$this->Mcq->find()->where(['id'=>$q_id])->first();
$recordsupdate->data=json_encode($datatemp);
$this->Mcq->save($recordsupdate);

   // var_dump($datatemp);exit;

}

}

public function view(){


    $id=$this->request->getQuery('id');
    $records=$this->Mcq->find("all")->where(['hash_id'=>$id])->toArray();

    if($this->request->is("post")) {

        $data = $this->request->data;



if($data['type']=='mcq'){
    $o=0;
    foreach ($data['answer'] as $t){
        $t=strip_tags($t);
        $data['answer'][$o]=trim($t);
        //$data['answer'][$o]=strip_tags($t);
        $o++;
    }
    $this->mcqupdate($data);

}

        if($data['type']=='integer'){
            $o=0;
            foreach ($data['answer'] as $t){
                $t=strip_tags($t);
                $data['answer'][$o]=trim($t);
                //$data['answer'][$o]=strip_tags($t);
                $o++;
            }
            $this->integerupdate($data);

        }
       // var_dump($data);exit;
        if($data['type']=='paragraph'){

            $g=0;
            foreach ($data['innerquestion'] as $t){
                $o=0;
                foreach ($t['answer'] as $y) {
                    $y=strip_tags($y);
                    $data['answer'][$o] = trim($y);
                    //$data['answer'][$o]=strip_tags($t);

                    $o++;
                }

            }
$this->paragraphupdate($data);
        }

       // var_dump($data);exit;
        $this->Flash->success('Data Update');
        $this->redirect(array("controller" => "Docupload",
            "action" => "view",'id'=>$id));

//var_dump($data);exit;
    }
    $this->set('data',$records);
    $this->set('upload_id',$id);


    $this->set("title","Dashboard");

}



public function edit(){
$id=$this->getRequest()->getQuery('id');
    $records=$this->Materials->findById($id)->contain(['class','subject','exercises'])->first();
    if($this->request->is("post")) {

        $data = $this->request->data;

        $filename=$_FILES['file']['name'];
        $path = rand().$_FILES['file']['name'];
        $imageFileType = pathinfo($path, PATHINFO_EXTENSION);
        $hasid=$records->hash_id;

        echo $hasid;
if($filename){
$oldfile=$records->file;
    if($imageFileType !== "pdf" && $imageFileType !== "doc" && $imageFileType !== "docx") {
        $this->Flash->error('Wrong File Format');
        $this->redirect(array("controller" => "Docupload",
            "action" => "materials"));
        return;

    }

    if (!file_exists('materials/'.$hasid)) {
        mkdir('materials/'.$hasid, 0777, true);
    }

    $uploadPath ='materials/'.$hasid.'/';
    $uploadFile = $uploadPath.$path;

    if(move_uploaded_file($this->request->data['file']['tmp_name'],$uploadFile)) {
        $data['file']=$path;
if($oldfile)
unlink('materials/'.$hasid.'/'.$oldfile);

    }

}else{
    unset($data['file']);
}


       // var_dump($data);exit;
        $userdata=$this->Materials->patchEntity($records,$data);
        $this->Materials->save($userdata);
        $this->Flash->success('Data Updated');

        $this->redirect(array("controller" => "Docupload",
            "action" => "materials"));
    }

if($records){
    $class= $this->Class->find('all')->select(['id','class_name'])->toArray();
    $subject= $this->Subject->find('all')->select(['id','subject_name'])->where(['c_id'=>$records->c_id])->toArray();
    $chapter= $this->Exercise->find('all')->select(['id','title'])->where(['c_id'=>$records->c_id,'s_id'=>$records->s_id])->toArray();

    $classlist=[];
    $sublectlist=[];
    $chapterlist=[];

    foreach ($class as $c)
        $classlist[$c['id']]=$c['class_name'];

    foreach ($subject as $c)
        $sublectlist[$c['id']]=$c['subject_name'];

    foreach ($chapter as $c)
        $chapterlist[$c['id']]=$c['title'];



    $this->set('subjectlist',$sublectlist);
    $this->set('s_id',$records->s_id);
    $this->set('name',$records->name);
    $this->set('link',$records->link);
    $this->set('type',$records->type);
    $this->set('chapterlist',$chapterlist);
    $this->set('ch_id',$records->c_id);

    $this->set('classlist',$classlist);
    $this->set('c_id',$records->c_id);
    $this->set('file',$records->file);
}

}

public function materials(){

    $class=$this->Class->find("all")->toArray();
    $records=$this->Materials->find('all')->contain(['class','subject','exercises'])->toArray();
$save=0;
   // $records=$this->Uploadfiles->find("all")->contain(['class','subject','exercises'])->toArray();
$this->set('class',$class);

    if($this->request->is("post")) {

        $data = $this->request->data;
        $date = date("Y-m-d");
$hasid=$data['class'].rand(100,2000);

        $material=$this->Materials->newEntity();


if($data['upload_type']==0){
    $material->type=0;

    $filename=$_FILES['file']['name'];
    $path = $hasid.$_FILES['file']['name'];
    $imageFileType = pathinfo($path, PATHINFO_EXTENSION);



    if($imageFileType !== "pdf" && $imageFileType !== "doc" && $imageFileType !== "docx") {
        $this->Flash->error('Wrong File Format');
        $this->redirect(array("controller" => "Docupload",
            "action" => "materials"));
        return;

    }

    if (!file_exists('materials/'.$hasid)) {
        mkdir('materials/'.$hasid, 0777, true);
    }

    $uploadPath ='materials/'.$hasid.'/';
    $uploadFile = $uploadPath.$path;

    if(move_uploaded_file($this->request->data['file']['tmp_name'],$uploadFile)) {

$save=1;
        $material->file=$path;

    }

    $material->hash_id=$hasid;




        }
        if($data['upload_type']==1){
            $material->type=1;
            $material->link=$data['link'];
            $material->hash_id=$hasid;
            $save=1;

        }
        if($data['upload_type']==2){
            $material->link=$data['link'];
$material->type=2;
            $material->hash_id=$hasid;

            $filename=$_FILES['file']['name'];
            $path = $hasid.$_FILES['file']['name'];
            $imageFileType = pathinfo($path, PATHINFO_EXTENSION);



            if($imageFileType !== "pdf" && $imageFileType !== "doc" && $imageFileType !== "docx") {
                $this->Flash->success('Wrong File Format');
                $this->redirect(array("controller" => "Docupload",
                    "action" => "materials"));
                return;

            }
            if (!file_exists('materials/'.$hasid)) {
                mkdir('materials/'.$hasid, 0777, true);
            }

            $uploadPath ='materials/'.$hasid.'/';
            $uploadFile = $uploadPath.$path;

            if(move_uploaded_file($this->request->data['file']['tmp_name'],$uploadFile)) {

                $save=1;
                $material->file=$path;

            }


        }
        $material->c_id=$data['class'];
        $material->s_id=$data['subject'];
        $material->ch_id=$data['ch_id'];
        $material->name=$data['title'];
        $material->create_date=date("Y-m-d H:i:s");
        $material->upload_for=$data['upload_for'];
        if($save==1){
            $this->Materials->save($material);
            $this->Flash->success('Data Saved');
            $this->redirect(array("controller" => "Docupload",
                "action" => "materials"));

            return;

        }else{
            $this->Flash->success('Try Again');
            $this->redirect(array("controller" => "Docupload",
                "action" => "materials"));

            return;
        }









    }
$this->set('records',$records);


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
  if(isset($data['for'])){
      $class=$this->ExamSubject->find("all")->where(['c_id'=>$clas])->toArray();
      $name='subject_name';
  }
          }

          if($type=='excersise'){

              $clas=$data['class'];
              $sub=$data['subject'];

              //  var_dump($clas.$sub);exit;
              $class=$this->Exercise->find("all")->where(['c_id'=>$clas,'s_id'=>$sub])->toArray();
              $name='title';
              if(isset($data['for'])){
                  $class=$this->ExamExercise->find("all")->where(['c_id'=>$clas,'s_id'=>$sub])->toArray();
                  $name='title';
              }
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

    public function delupload(){
$id=$this->getRequest()->getQuery('id');
        $records=$this->Uploadfiles->find("all")->where(['id'=>$id])->first();
if($records){
    $mcq=$this->Mcq->find("all")->where(['hash_id'=>$records->hashid]);

    foreach ($mcq as $m)
        $this->Mcq->delete($m);

$this->Uploadfiles->delete($records);



}
        $this->Flash->error('Data Deleted');
        $this->redirect(array("controller" => "Docupload",
            "action" => "index"));

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



            if($imageFileType != "zip" ) {

                $this->Flash->error('Wrong Format');
                $this->redirect(array("controller" => "Docupload",
                    "action" => "index"));
                return ;

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
    $this->redirect(array("controller" => "Docupload",
        "action" => "index"));

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
                    $mcq->data=json_encode(utf8_encode($d));
                    $mcq->hash_id=$hashid;
                    $mcq->type=$d['type'];
                    $mcq->create_date = date("Y-m-d H:i:s");
                    $this->Mcq->save($mcq);

                }

exit;
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
        $content = str_replace('[Q]', "\n [Q]", $content);
        $content = str_replace('[A]', "\n [A]", $content);
        $content = str_replace('[B]', "\n [B]", $content);
        $content = str_replace('[C]', "\n[C]", $content);
        //    $content = str_replace('src="', 'src="1', $content);
        $content = preg_replace('/style[^>]*/', '', $content);
        $contents= str_replace('[D]', "\n [D]", $content);
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


                   if($ext){
if($ext[1]=='html' || $ext[1]=='Html' || $ext[1]=='htm' ){


    $send=['er'=>0,'filename'=>$file];
    break;

}

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