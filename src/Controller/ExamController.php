<?php
namespace App\Controller;


use App\Controller\AppController;
use App\Controller\Services\EmailService;
use App\Model\Table\AppritiatespostsTables;
use App\Model\Table\CategorysTables;
use App\Model\Table\ClassexammapsTables;
use App\Model\Table\ClasssTables;
use App\Model\Table\ExamexercisessTables;
use App\Model\Table\ExamsTables;
use App\Model\Table\Examsubjects;
use App\Model\Table\ExercisessTables;
use App\Model\Table\NotificationsTables;
use App\Model\Table\PostsTables;
use App\Model\Table\ProfilesTables;
use App\Model\Table\SubjectsTables;
use App\Model\Table\TrafficsTables;
use App\Model\Table\TransactionsTables;
use Cake\Network\Email\Email;
use Cake\Routing\Router;
use Cake\Mailer;
use Cake\Datasource\ConnectionManager;
use Cake\Datasource\EntityInterface;



class ExamController extends AppController{
    public $base_url;

    public function initialize(){
        parent::initialize();
        $this->viewBuilder()->layout("adminlayout");
        $this->base_url=Router::url("/",true);
        $connection = ConnectionManager::get('default');
        // $this->table=TableRegistry::get("user");
        $this->Users=$this->loadModel("User");
        $this->Class=$this->loadModel(ClasssTables::class);
        $this->Subject=$this->loadModel(Examsubjects::class);
        $this->Exercise=$this->loadModel(ExamexercisessTables::class);
        $this->Exam=$this->loadModel(ExamsTables::class);
        $this->ClassMap=$this->loadModel(ClassexammapsTables::class);
        $session = $this->getRequest()->getSession();
        $t= $session->read('user');
        if( $t=="" || $t==null ){

            $this->redirect(array("controller" => "Main",
                "action" => "login"));

            return;
        }


        $this->set("title","Dashboard");
    }
    public function exam(){

    }

    public function delexercise(){
        $id=$this->request->getQuery('id');
        $dataclass=$this->Exercise->findById($id)->first();
        if($dataclass){

            $this->Exercise->delete($dataclass);


            $this->Flash->success('Data Deleted');


            $this->redirect(array("controller" => "Admin",
                "action" => "excersise"));

            return;
        }
        $this->Flash->error('Data Not Found');
        $this->redirect(array("controller" => "Admin",
            "action" => "excersise"));

        return;


    }
    public function delsub(){
        $id=$this->request->getQuery('id');
        $dataclass=$this->Subject->findById($id)->first();
        if($dataclass){

            $this->Subject->delete($dataclass);

            $exerciserecord=$this->Exercise->find('all')->where(['s_id'=>$id]);
            foreach ($exerciserecord as $e)
                $this->Exercise->delete($e);


            $this->Flash->success('Data Deleted');


            $this->redirect(array("controller" => "Admin",
                "action" => "subject"));

            return;
        }
        $this->Flash->error('Data Not Found');
        $this->redirect(array("controller" => "Admin",
            "action" => "subject"));

        return;


    }
    public function delclass(){
        $id=$this->request->getQuery('id');
        $dataclass=$this->Exam->findById($id)->first();
        if($dataclass){

            $this->Exam->delete($dataclass);

            $subjectrec=$this->Subject->find('all')->where(['c_id'=>$id]);
            foreach ($subjectrec as $s)
                $this->Subject->delete($s);

            $exerciserecord=$this->Exercise->find('all')->where(['c_id'=>$id]);
            foreach ($exerciserecord as $e)
                $this->Exercise->delete($e);


            $this->Flash->success('Data Deleted');


            $this->redirect(array("controller" => "Admin",
                "action" => "classadd"));

            return;
        }
        $this->Flash->error('Data Not Found');
        $this->redirect(array("controller" => "Admin",
            "action" => "classadd"));

        return;

    }
    public function examadd(){

        $data=$this->Class->find("all")->toArray();
        $dataexam=$this->Exam->find("all")->toArray();
        $id=$this->request->getQuery('id');

        if($this->request->is("post")) {

            $data = $this->request->data();
            $classid=$data['c_id'];
            $carray=array_unique(explode(',',$classid));
            //var_dump(array_unique($carray));exit;



            //   $data=$this->Users->get(2);
            if($id){
                $dataclass=$this->Exam->findById($id)->first();
                $dataclass->exam_name=$data['name'];

                $this->Exam->save($dataclass);

                $this->Flash->success('Data Updated');


                $this->redirect(array("controller" => "Exam",
                    "action" => "examadd"));

                return;


            }

            $classobj=$this->Exam->newEntity();

            $classobj->exam_name=$data['name'];
            $classobj->create_date = date("Y-m-d H:i:s");

            $this->Exam->save($classobj);


            foreach ($carray as $ids){
                if($ids){
                    $map=$this->ClassMap->newEntity();
                    $map->c_id=$ids;
                    $map->exam_id=$classobj->id;
                    $this->ClassMap->save($map);

                }


            }


            // $this->Flash->set(' Class Added.', [
            //     'element' => 'Success'
            // ]);
            $this->Flash->success('Exam Added');

            $this->redirect(array("controller" => "Exam",
                "action" => "examadd"));


            return;

        }
        if($id){
            $dataclass=$this->Exam->findById($id)->first()->toArray();
            if($data){
                $this->set("edit",1);
                $this->set("editdata",$dataclass);

            }
            // var_dump("asfasfasf");exit;
        }

        $this->set("class",$data);
        $this->set("exam",$dataexam);


    }

    public function subject(){

        $datacl=$this->Exam->find("all")->toArray();
        $subd=$this->Subject->find("all")->contain(['exam'])->toArray();
        $id=$this->request->getQuery('id');
        if($this->request->is("post")) {
            $data = $this->request->data();
            $sub_name=$data['sub_name'];
            $c_id=$data['c_id'];

            //   $data=$this->Users->get(2);
            if($id){
                $datasub=$this->Subject->findById($id)->first();

                $datasub->subject_name=$sub_name;
                $this->Subject->save($datasub);
                $this->Flash->success('Subject Updated');
                $this->redirect(array("controller" => "Exam",
                    "action" => "subject"));

                return;

            }

            $classobj=$this->Subject->newEntity();

            $classobj->c_id=$c_id;
            $classobj->subject_name=$sub_name;
            // $encryptpass = Security::encrypt($data['password'], $this->key);
            // $resultr = Security::decrypt($result, $this->key);

            $classobj->create_date = date("Y-m-d H:i:s");

            $this->Subject->save($classobj);
            $this->Flash->success('Subject Added');

            $this->redirect(array("controller" => "Exam",
                "action" => "subject"));

            return;

        }

        if($id){
            $dataclass=$this->Subject->findById($id)->first()->toArray();
            if($dataclass){
                $this->set("edit",1);
                $this->set("editdata",$dataclass);

            }
            // var_dump("asfasfasf");exit;
        }
        $this->set("data",$subd);
        $this->set("class",$datacl);

    }

    public function excersise(){

        $datac=$this->Exam->find("all")->toArray();
        $exdata=$this->Exercise->find("all")->contain(['exam','examsubject'])->toArray();
        $id=$this->request->getQuery('id');

        $subject=$this->Subject->find("all")->toArray();
        if($this->request->is("post")) {

            $data = $this->request->data();
            $sub_name=$data['s_id'];
            $c_id=$data['c_id'];
            $ex=$data['exercise'];

            //  $data=$this->Subject->find("all")->where(["c_id"=>$c_id,"subject_name"=>$sub_name])->toArray();
            //   $data=$this->Users->get(2);
            if($id){
                $datasub=$this->Exercise->findById($id)->first();

                $datasub->title=$ex;

                $this->Exercise->save($datasub);

                $this->Flash->success('data Updated');
                $this->redirect(array("controller" => "Exam",
                    "action" => "excersise"));

                return;

            }

            $classobj=$this->Exercise->newEntity();
            $classobj->c_id=$c_id;
            $classobj->s_id=$sub_name;
            $classobj->title=$ex;
            // $encryptpass = Security::encrypt($data['password'], $this->key);

            // $resultr = Security::decrypt($result, $this->key);

            $classobj->create_date = date("Y-m-d H:i:s");


            $this->Exercise->save($classobj);
            $this->Flash->success('Exercise Added');


            $this->redirect(array("controller" => "Exam",
                "action" => "excersise"));

            return;

        }


        if($id){
            $dataclass=$this->Exercise->findById($id)->first()->toArray();
            if($dataclass){
                $this->set("edit",1);
                $this->set("editdata",$dataclass);

            }


        }

        $this->set("class",$datac);
        $this->set("subject",$subject);
        $this->set("exdata",$exdata);

    }



    public function authorize(){

        $session = $this->getRequest()->getSession();
        $uid=$session->read('user');
        if($uid== null ){

            $this->Flash->set('Please Login', [
                'element' => 'error'
            ]);

            $this->redirect(array("controller" => "Main",
                "action" => "login"),302);
            return false;

        }
        return true;

    }





}?>