<?php
namespace App\Controller;


use App\Controller\AppController;
use App\Controller\Services\EmailService;
use App\Model\Table\AppritiatespostsTables;
use App\Model\Table\CategorysTables;
use App\Model\Table\ClassexammapsTables;
use App\Model\Table\ClasssTables;
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



class AdminController extends AppController{
    public $base_url;

    public function initialize(){
        parent::initialize();
        $this->viewBuilder()->layout("adminlayout");
        $this->base_url=Router::url("/",true);
        $connection = ConnectionManager::get('default');
        // $this->table=TableRegistry::get("user");
        $this->Users=$this->loadModel("User");
        $this->Class=$this->loadModel(ClasssTables::class);
        $this->Subject=$this->loadModel(SubjectsTables::class);
        $this->Exercise=$this->loadModel(ExercisessTables::class);
        $this->Uploadfiles=$this->loadModel(UploadfilesTables::class);
        $this->ClassMap=$this->loadModel(ClassexammapsTables::class);
        $this->GenerateExam=$this->loadModel(GenerateexamsTables::class);
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

    public function delexercise(){
        $id=$this->request->getQuery('id');
        $dataclass=$this->Exercise->findById($id)->first();
        if($dataclass){

            $this->Exercise->delete($dataclass);


              $exerciserecord=$this->Uploadfiles->find('all')->where(['ex_id'=>$id]);
            foreach ($exerciserecord as $e){
                $hasid=$e['hashid'];
                $exerciserecord=$this->Mcq->find('all')->where(['hash_id'=>$hasid]);
                foreach ($exerciserecord as $t)
                    $this->Mcq->delete($t);

                $this->Uploadfiles->delete($e);
            }


            $exerciserecord=$this->GenerateExam->find('all')->where(['ex_id'=>$id]);
            foreach ($exerciserecord as $e)
                $this->GenerateExam->delete($e);

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

            $exerciserecord=$this->Uploadfiles->find('all')->where(['s_id'=>$id]);
            foreach ($exerciserecord as $e){
                $hasid=$e['hashid'];
                $exerciserecord=$this->Mcq->find('all')->where(['hash_id'=>$hasid]);
                foreach ($exerciserecord as $t)
                    $this->Mcq->delete($t);

                $this->Uploadfiles->delete($e);
            }

            $exerciserecord=$this->GenerateExam->find('all')->where(['s_id'=>$id]);
            foreach ($exerciserecord as $e)
                $this->GenerateExam->delete($e);


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
        $dataclass=$this->Class->findById($id)->first();
        if($dataclass){

            $this->Class->delete($dataclass);

            $subjectrec=$this->Subject->find('all')->where(['c_id'=>$id]);
            foreach ($subjectrec as $s)
                $this->Subject->delete($s);

            $exerciserecord=$this->Exercise->find('all')->where(['c_id'=>$id]);
            foreach ($exerciserecord as $e)
                $this->Exercise->delete($e);

            $exerciserecord=$this->Uploadfiles->find('all')->where(['c_id'=>$id]);
            foreach ($exerciserecord as $e){
                $hasid=$e['hashid'];
                $exerciserecord=$this->Mcq->find('all')->where(['hash_id'=>$hasid]);
                foreach ($exerciserecord as $t)
                    $this->Mcq->delete($t);

                $this->Uploadfiles->delete($e);
            }


            $exerciserecord=$this->ClassMap->find('all')->where(['c_id'=>$id]);
            foreach ($exerciserecord as $e)
                $this->ClassMap->delete($e);

            $exerciserecord=$this->GenerateExam->find('all')->where(['c_id'=>$id]);
            foreach ($exerciserecord as $e)
                $this->GenerateExam->delete($e);



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
    public function classadd(){

        $data=$this->Class->find("all")->toArray();
        $id=$this->request->getQuery('id');

        if($this->request->is("post")) {

            $data = $this->request->data();
            $classname=$data['class'];

            //   $data=$this->Users->get(2);
            if($id){
                $dataclass=$this->Class->findById($id)->first();
                $dataclass->class_name=$data['class'];

                $this->Class->save($dataclass);

                $this->Flash->success('Data Updated');


                $this->redirect(array("controller" => "Admin",
                    "action" => "classadd"));

                return;


            }

            $classobj=$this->Class->newEntity();

            $classobj->class_name=$data['class'];


            $classobj->create_date = date("Y-m-d H:i:s");

            $this->Class->save($classobj);

            // $this->Flash->set(' Class Added.', [
            //     'element' => 'Success'
            // ]);
            $this->Flash->success('Class Added');

            $this->redirect(array("controller" => "Admin",
                "action" => "classadd"));


            return;

        }
        if($id){
            $dataclass=$this->Class->findById($id)->first()->toArray();
            if($data){
                $this->set("edit",1);
                $this->set("editdata",$dataclass);

            }
            // var_dump("asfasfasf");exit;
        }

        $this->set("class",$data);


    }

    public function subject(){

        $datacl=$this->Class->find("all")->toArray();
        $subd=$this->Subject->find("all")->contain(['class'])->toArray();
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
                $this->redirect(array("controller" => "Admin",
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

            $this->redirect(array("controller" => "Admin",
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

        $datac=$this->Class->find("all")->toArray();
        $exdata=$this->Exercise->find("all")->contain(['class','subject'])->toArray();
        $id=$this->request->getQuery('id');

        $subject=$this->Subject->find("all")->toArray();
        if($this->request->is("post")) {

            $data = $this->request->data();

            $ex=$data['exercise'];

            //  $data=$this->Subject->find("all")->where(["c_id"=>$c_id,"subject_name"=>$sub_name])->toArray();
            //   $data=$this->Users->get(2);
            if($id){
                $datasub=$this->Exercise->findById($id)->first();

                $datasub->title=$ex;

                $this->Exercise->save($datasub);

                $this->Flash->success('Chapter Updated');
                $this->redirect(array("controller" => "Admin",
                    "action" => "excersise"));

                return;

            }
            $sub_name=$data['s_id'];
            $c_id=$data['c_id'];
            $classobj=$this->Exercise->newEntity();
            $classobj->c_id=$c_id;
            $classobj->s_id=$sub_name;
            $classobj->title=$ex;
            // $encryptpass = Security::encrypt($data['password'], $this->key);

            // $resultr = Security::decrypt($result, $this->key);

            $classobj->create_date = date("Y-m-d H:i:s");


            $this->Exercise->save($classobj);
            $this->Flash->success('Exercise Added');


            $this->redirect(array("controller" => "Admin",
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