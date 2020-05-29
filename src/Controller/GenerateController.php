<?php
namespace App\Controller;


use App\Controller\AppController;
use App\Controller\Services\EmailService;
use App\Model\Table\AppritiatespostsTables;
use App\Model\Table\CategorysTables;
use App\Model\Table\ClassexammapsTables;
use App\Model\Table\ClasssTables;
use App\Model\Table\ExamexercisessTables;
use App\Model\Table\ExamquestionsTables;
use App\Model\Table\ExamsTables;
use App\Model\Table\Examsubjects;
use App\Model\Table\ExercisessTables;
use App\Model\Table\FulltestsTables;
use App\Model\Table\GenerateexamsTables;
use App\Model\Table\McqsTables;
use App\Model\Table\NotificationsTables;
use App\Model\Table\PostsTables;
use App\Model\Table\ProfilesTables;
use App\Model\Table\SubjectsTables;
use App\Model\Table\TrafficsTables;
use App\Model\Table\TransactionsTables;
use App\Model\Table\UploadfilesTables;
use Cake\Network\Email\Email;
use Cake\Routing\Router;
use Cake\Mailer;
use Cake\Datasource\ConnectionManager;
use Cake\Datasource\EntityInterface;



class GenerateController extends AppController{
    public $base_url;

    public function initialize(){
        parent::initialize();
        $this->viewBuilder()->layout("adminlayout");
        $this->base_url=Router::url("/",true);
        $connection = ConnectionManager::get('default');
        // $this->table=TableRegistry::get("user");
        $this->Users=$this->loadModel("User");
        $this->Class=$this->loadModel(ClasssTables::class);
        $this->Upload=$this->loadModel(UploadfilesTables::class);
        $this->Subject=$this->loadModel(SubjectsTables::class);
        $this->Exercise=$this->loadModel(ExercisessTables::class);
        $this->Exam=$this->loadModel(ExamsTables::class);
        $this->ClassMap=$this->loadModel(ClassexammapsTables::class);
        $this->GenerateExam=$this->loadModel(GenerateexamsTables::class);
        $this->Mcq=$this->loadModel(McqsTables::class);
        $this->ExamQuestion=$this->loadModel(ExamquestionsTables::class);


        $this->Fulltest=$this->loadModel(FulltestsTables::class);
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

public function delexam(){

        $type=1;
    $id=$this->getRequest()->getQuery('id');
    $records=$this->GenerateExam->find("all")->where(['id'=>$id])->first();
    if($records){
        $type=$records->exam_type;
        $mcq=$this->ExamQuestion->find("all")->where(['generateexam_id'=>$id]);

        foreach ($mcq as $m)
            $this->ExamQuestion->delete($m);

        $this->GenerateExam->delete($records);



    }
    $this->Flash->error('Data Deleted');
if($type==1)
    $this->redirect(array("controller" => "Generate", "action" => "fullsyllabus"));

    if($type==2)
        $this->redirect(array("controller" => "Generate", "action" => "generateexam"));

    if($type==0)
        $this->redirect(array("controller" => "Generate", "action" => "practicetest"));


    $this->redirect(array("controller" => "Generate", "action" => "practicetest"));
   return;



}

    public function loaddetail(){

        if($this->request->is("post")) {
            $data = $this->request->data;
$type=$data['type'];
            $id=$data['id'];
if($type==0){
    $generatedata=$this->GenerateExam->findById($id)->where(['exam_type'=>0])->contain(['class','subject','exercises'])->first()->toArray();
    // $exam=$this->Exam->find("all")->where(["id"=>$generatedata['c_id']])->first()->toArray();
    $level='Beginner';
    if($generatedata['level']==1){
        $level='Intermediate';
    }
    if($generatedata['level']==2){
        $level='Advance';
    }

    $data='   
                <p>  Class Name: '.$generatedata["Class"]["class_name"].'</p>
                     <p>  Subject Name: '.$generatedata['Subject']["subject_name"].'</p>
                          <p>  Chapter Name: '.$generatedata['Exercises']["title"].'</p>
                <p> Level:  '.$level.'</p>
                <p>  Test Name: '.$generatedata["name"].'</p>
                <p>  Duration: '.$generatedata["total_time"].'</p>
                   <p>  Create Date: '.$generatedata["create_date"].'</p>
                    <p>  Instruction: '.$generatedata["instruction"].'</p>
                '

    ;



    echo $data;
    exit;

}
            if($type==1){
                $generatedata=$this->GenerateExam->find("all")->where(['exam_type'=>1,'id'=>$id])->first()->toArray();
                $exam=$this->Exam->find("all")->where(["id"=>$generatedata['c_id']])->first()->toArray();
                $level='Beginner';
                if($generatedata['level']==1){
                    $level='Intermediate';
                }
                if($generatedata['level']==2){
                    $level='Advance';
                }

                $data='   
                <p>  Exam Name: '.$exam["exam_name"].'</p>
                <p> Level:  '.$level.'</p>
                <p>  Test Name: '.$generatedata["name"].'</p>
                <p>  Duration: '.$generatedata["total_time"].'</p>
                   <p>  Create Date: '.$generatedata["create_date"].'</p>
                     <p>  Instruction: '.$generatedata["instruction"].'</p>
                '

                ;



echo $data;
exit;
            }

            if($type==2){
                $generatedata=$this->GenerateExam->findById($id)->where(['exam_type'=>2])->contain(['Exam','Examsubject','Examexercises'])->first()->toArray();
               // $exam=$this->Exam->find("all")->where(["id"=>$generatedata['c_id']])->first()->toArray();
                $level='Beginner';
                if($generatedata['level']==1){
                    $level='Intermediate';
                }
                if($generatedata['level']==2){
                    $level='Advance';
                }

                $data='   
                <p>  Exam Name: '.$generatedata['exam']["exam_name"].'</p>
                     <p>  Subject Name: '.$generatedata['examsubject']["subject_name"].'</p>
                          <p>  Chapter Name: '.$generatedata['examexercise']["title"].'</p>
                <p> Level:  '.$level.'</p>
                <p>  Test Name: '.$generatedata["name"].'</p>
                <p>  Duration: '.$generatedata["total_time"].'</p>
                   <p>  Create Date: '.$generatedata["create_date"].'</p>
                     <p>  Instruction: '.$generatedata["instruction"].'</p>
                '

                ;



                echo $data;
                exit;
            }




        }
        }

        public function edit(){
            $classdata=$this->Class->find("all")->toArray();
            $id=$this->request->getQuery('id');
            $type=$this->request->getQuery('type');





            if($type==1){

                $generatedata=$this->GenerateExam->find("all")->where(['exam_type'=>1,'id'=>$id])->first();


                if($this->request->is("post")) {

                    $data = $this->request->data;

                    $userdata=$this->GenerateExam->patchEntity($generatedata,$data);
                    $this->GenerateExam->save($userdata);
                    $this->Flash->success('Data Updated');

                    $this->redirect(array("controller" => "Generate",
                        "action" => "edit","id"=>$id,"type"=>$type));
                }

                $exam= $this->Exam->find('all')->select(['id','exam_name'])->toArray();

                $classlist=[];

                foreach ($exam as $c) {

                    $classlist[$c['id']]=$c['exam_name'];
                    //  $tmp['id']=$c['id'];
                    // array_push($classlist, $tmp);

                }


                $this->set('type',1);
                $this->set('total_time',$generatedata->total_time);
                $this->set('instruction',$generatedata->instruction);
                $this->set('name',$generatedata->name);
                $this->set('exam_id',$generatedata->c_id);
                $this->set('examlist',$classlist);

return;

            }

            if($type==2){

                $generatedata=$this->GenerateExam->find("all")->where(['exam_type'=>2,'id'=>$id])->first();


                if($this->request->is("post")) {

                    $data = $this->request->data;

                    $userdata=$this->GenerateExam->patchEntity($generatedata,$data);
                    $this->GenerateExam->save($userdata);
                    $this->Flash->success('Data Updated');

                    $this->redirect(array("controller" => "Generate",
                        "action" => "edit","id"=>$id,"type"=>$type));
                }

                $exam= $this->Exam->find('all')->select(['id','exam_name'])->toArray();
                $examsubject= $this->ExamSubject->find('all')->select(['id','subject_name'])->where(['c_id'=>$generatedata->c_id])->toArray();
                $examchapter= $this->ExamExercise->find('all')->select(['id','title'])->where(['c_id'=>$generatedata->c_id,'s_id'=>$generatedata->ex_id])->toArray();

                $classlist=[];
                foreach ($exam as $c)
                    $classlist[$c['id']]=$c['exam_name'];

                $subjectlist=[];
                foreach ($examsubject as $c)
                    $subjectlist[$c['id']]=$c['subject_name'];

                $chapterlist=[];
                foreach ($examchapter as $c)
                    $chapterlist[$c['id']]=$c['title'];


                $this->set('type',2);
                $this->set('total_time',$generatedata->total_time);
                $this->set('instruction',$generatedata->instruction);
                $this->set('name',$generatedata->name);
                $this->set('exam_id',$generatedata->c_id);
                $this->set('examlist',$classlist);
                $this->set('subjectlist',$subjectlist);
                $this->set('chapterist',$chapterlist);


                $this->set('s_id',$generatedata->s_id);
                $this->set('ex_id',$generatedata->ex_id);
                return;

            }

            if($type==0){

                $generatedata=$this->GenerateExam->find("all")->where(['exam_type'=>0,'id'=>$id])->first();


                if($this->request->is("post")) {

                    $data = $this->request->data;

                    $userdata=$this->GenerateExam->patchEntity($generatedata,$data);
                    $this->GenerateExam->save($userdata);
                    $this->Flash->success('Data Updated');

                    $this->redirect(array("controller" => "Generate",
                        "action" => "edit","id"=>$id,"type"=>$type));
                }

                $exam= $this->Class->find('all')->select(['id','class_name'])->toArray();
                $examsubject= $this->Subject->find('all')->select(['id','subject_name'])->where(['c_id'=>$generatedata->c_id])->toArray();
                $examchapter= $this->Exercise->find('all')->select(['id','title'])->where(['c_id'=>$generatedata->c_id,'s_id'=>$generatedata->s_id])->toArray();
                $classlist=[];
                foreach ($exam as $c)
                    $classlist[$c['id']]=$c['class_name'];

                $subjectlist=[];
                foreach ($examsubject as $c)
                    $subjectlist[$c['id']]=$c['subject_name'];

                $chapterlist=[];
                foreach ($examchapter as $c)
                    $chapterlist[$c['id']]=$c['title'];


                $this->set('type',0);
                $this->set('total_time',$generatedata->total_time);
                $this->set('instruction',$generatedata->instruction);
                $this->set('name',$generatedata->name);
                $this->set('exam_id',$generatedata->c_id);
                $this->set('examlist',$classlist);
                $this->set('subjectlist',$subjectlist);
                $this->set('chapterist',$chapterlist);


                $this->set('s_id',$generatedata->s_id);
                $this->set('ex_id',$generatedata->ex_id);
                return;

            }


        }

    public function fullsyllabus(){
        $classdata=$this->Exam->find("all")->toArray();
        $generatedata=$this->GenerateExam->find("all")->where(['exam_type'=>1])->contain(['exam'])->toArray();
        if($this->request->is("post")) {
            $data = $this->request->data;
            $date = date("Y-m-d");


            $generate=$this->GenerateExam->newEntity();

            $generate->c_id=$data['c_id'];
            $generate->exam_type=$data['exam_type'];
            $generate->name=$data['name'];
            $generate->total_time=$data['total_time'];
            $generate->instruction=$data['instruction'];
            $generate->create_date=date("Y-m-d H:i:s");
            $this->GenerateExam->save($generate);

            $this->Flash->success('Exam Saved , Please Select Questions');
            $this->redirect(array("controller" => "Generate",
                "action" => "fullsyllabus"));

            return;



        }



        $this->set("class",$classdata);
        $this->set("generatedata",$generatedata);



    }

    public function practicetest(){
        $classdata=$this->Class->find("all")->toArray();
        $generatedata=$this->GenerateExam->find("all")->where(['exam_type'=>0])->contain(['class','subject','exercises'])->toArray();
        if($this->request->is("post")) {
            $data = $this->request->data;
            $date = date("Y-m-d");


            $generate=$this->GenerateExam->newEntity();
            $generate->c_id=$data['c_id'];
            $generate->s_id=$data['s_id'];
            $generate->ex_id=$data['ex_id'];
            $generate->c_id=$data['c_id'];
            $generate->name=$data['name'];
            $generate->level=$data['level'];
            $generate->exam_type=$data['exam_type'];
            $generate->instruction=$data['instruction'];
            $generate->total_time=$data['total_time'];
            $generate->create_date=date("Y-m-d H:i:s");
            $this->GenerateExam->save($generate);

            $this->Flash->success('Exam Saved , Please Select Questions');
            $this->redirect(array("controller" => "Generate",
                "action" => "practicetest"));

            return;



        }



        $this->set("class",$classdata);
        $this->set("generatedata",$generatedata);




    }
    public function generateexam(){
        $classdata=$this->Exam->find("all")->toArray();
        $generatedata=$this->GenerateExam->find("all")->where(['exam_type'=>2])->contain(['Exam','Examsubject','Examexercises'])->toArray();
        if($this->request->is("post")) {
            $data = $this->request->data;
            $date = date("Y-m-d");

            $generate=$this->GenerateExam->newEntity();
            $generate->c_id=$data['c_id'];
            $generate->s_id=$data['s_id'];
            $generate->ex_id=$data['ex_id'];
            $generate->c_id=$data['c_id'];
            $generate->name=$data['name'];
            $generate->level=$data['level'];
            $generate->exam_type=$data['exam_type'];
            $generate->instruction=$data['instruction'];
            $generate->total_time=$data['total_time'];
            $generate->create_date=date("Y-m-d H:i:s");
            $this->GenerateExam->save($generate);

            $this->Flash->success('Exam Saved , Please Select Questions');
            $this->redirect(array("controller" => "Generate",
                "action" => "generateexam"));

            return;



        }



        $this->set("class",$classdata);
        $this->set("generatedata",$generatedata);




    }


    public function getupload(){

        if($this->request->is("post")) {

            $data = $this->request->data;
            $date = date("Y-m-d");
            $type=$data['type'];

            if($type=='upload'){
                $clas=$data['class'];
                $sub=$data['subject'];
                $ch=$data['chapter'];
                $class=$this->Upload->find("all")->where(['c_id'=>$clas,'s_id'=>$sub,'ex_id'=>$ch])->toArray();
                $name='title';

            }


            $dt='<option>Select Option</option>';
            foreach ($class as $d){

                $id=$d['hashid'];
                $dt.='<option value="'.$id.'">'.$d[$name].'</option>';

                // array_push($datalist,$d);

            }

            echo $dt;
            exit;
        }
        return;
    }

    public function addquestion(){
        $send=[];
        if($this->request->is("post")) {
            $data = $this->request->data;
            $id=$data['id'];
            $qid=$data['qid'];

            $records=$this->ExamQuestion->find("all")->where(['generateexam_id'=>$id,'q_id'=>$qid])->toArray();

            if(! $records){

                $examq=$this->ExamQuestion->newEntity();

                $examq->generateexam_id=$id;
                $examq->q_id=$qid;
                $examq->create_date=date("Y-m-d H:i:s");
                $this->ExamQuestion->save($examq);
                $send['err']=0;
                $send['add']=1;
                $send['msg']='Added';
                echo json_encode($send);
                exit;

            }
            $recordsdel=$this->ExamQuestion->find("all")->where(['generateexam_id'=>$id,'q_id'=>$qid])->first();

         $this->ExamQuestion->delete($recordsdel);

            $send['err']=1;
            $send['add']=0;
            $send['msg']='Deleted';
            echo json_encode($send);
            exit;


        }


    }



    public function view(){
        $classdata=$this->Class->find("all")->toArray();
        $id=$this->request->getQuery('id');



            $records=$this->ExamQuestion->find("all")->where(['generateexam_id'=>$id])->toArray();
            $datarecords=[];
            foreach ($records as $r){
                $q_id=$r['q_id'];

                $checkadd=$this->Mcq->find('all')->where(['id'=>$q_id])->first();

                if($checkadd){

                    array_push($datarecords,$checkadd->toArray());
                }

            }
            $this->set('id',$id);
            $this->set('exam_id',$id);
            $this->set("class",$classdata);
            $this->set('data',$datarecords);






    }



    public function add(){
        $classdata=$this->Class->find("all")->toArray();
        $id=$this->request->getQuery('id');

        if($this->request->is("post")) {
            $data = $this->request->data;
            $has=$data['up_id'];
            $examid=$data['exam_id'];

            $records=$this->Mcq->find("all")->where(['hash_id'=>$has])->toArray();
$datarecords=[];
foreach ($records as $r){
    $q_id=$r['id'];

    $checkadd=$this->ExamQuestion->find('all')->where(['generateexam_id'=>$examid,'q_id'=>$q_id])->toArray();
    if($checkadd){


}else{
        array_push($datarecords,$r);
    }


}
            $this->set('id',$id);
            $this->set('exam_id',$id);
            $this->set("class",$classdata);
            $this->set('data',$datarecords);
            return;


        }
        $this->set('exam_id',$id);
        $this->set("class",$classdata);



    }
    public function index(){

        $classdata=$this->Class->find("all")->toArray();
        $generatedata=$this->GenerateExam->find("all")->contain(['class','subject','exercises'])->toArray();
        if($this->request->is("post")) {
            $data = $this->request->data;
            $date = date("Y-m-d");


            $generate=$this->GenerateExam->newEntity();
            $generate->c_id=$data['c_id'];
            $generate->s_id=$data['s_id'];
            $generate->ex_id=$data['ex_id'];
            $generate->c_id=$data['c_id'];
            $generate->name=$data['name'];
            $generate->level=$data['level'];
            $generate->exam_type=$data['exam_type'];
            $generate->total_time=$data['total_time'];
            $generate->create_date=date("Y-m-d H:i:s");
            $this->GenerateExam->save($generate);

            $this->Flash->success('Exam Saved , Please Select Questions');
            $this->redirect(array("controller" => "Generate",
                "action" => "index"));

            return;



        }



        $this->set("class",$classdata);
        $this->set("generatedata",$generatedata);



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





}?>