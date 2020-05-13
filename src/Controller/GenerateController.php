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
        $session = $this->getRequest()->getSession();
        $t= $session->read('user');
        if( $t=="" || $t==null ){

            $this->redirect(array("controller" => "Main",
                "action" => "login"));

            return;
        }


        $this->set("title","Dashboard");
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


    public function add(){
        $classdata=$this->Class->find("all")->toArray();
        $id=$this->request->getQuery('id');

        if($this->request->is("post")) {
            $data = $this->request->data;
            $has=$data['up_id'];
            $records=$this->Mcq->find("all")->where(['hash_id'=>$has])->toArray();


            $this->set('id',$id);
            $this->set('data',$records);
            return;


        }
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

            }

            if($type=='excersise'){

                $clas=$data['class'];
                $sub=$data['subject'];
                //  var_dump($clas.$sub);exit;
                $class=$this->Exercise->find("all")->where(['c_id'=>$clas,'s_id'=>$sub])->toArray();
                $name='title';

            }

            $dt='<option>Select Option</option>';
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