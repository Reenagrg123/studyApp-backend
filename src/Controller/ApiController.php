<?php
namespace App\Controller;


use App\Controller\AppController;
use App\Controller\Services\EmailService;
use App\Model\Table\AppritiatespostsTables;
use App\Model\Table\CategorysTables;
use App\Model\Table\ClasssTables;
use App\Model\Table\ExamquestionsTables;
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
use Cake\Utility\Security;



class ApiController extends AppController{




    public $base_url;
    public $key;

    public function initialize(){
        parent::initialize();
        $this->viewBuilder()->layout("adminlayout");
        $this->base_url=Router::url("/",true);
        $connection = ConnectionManager::get('default');
        // $this->table=TableRegistry::get("user");

        $this->Class=$this->loadModel(ClasssTables::class);


        $this->Subject=$this->loadModel(SubjectsTables::class);

        $this->Exercise=$this->loadModel(ExercisessTables::class);
        $this->Uploadfiles=$this->loadModel(UploadfilesTables::class);
        $this->GenerateExam=$this->loadModel(GenerateexamsTables::class);
        $this->ExamQuestion=$this->loadModel(ExamquestionsTables::class);

        $this->Mcq=$this->loadModel(McqsTables::class);

        $session = $this->getRequest()->getSession();
        // $this->authorize();

        $this->Users=$this->loadModel("User");

        $this->key = 'wt1U5MACWJFTXGenFoZoiLwQGrLgdbHA';



        $this->set("title","Dashboard");
    }

    public function getexamdata(){
        $send=[];
        if ($this->request->is("post")) {
            $date = date("Y-m-d");
            $data = $this->request->data;
            $id=$data['exam_id'];
            $data=[];
            $tmpdata=[];
            $generatedata=$this->GenerateExam->find("all")->where(['id'=>$id])->first()->toArray();
            if($generatedata){
                $tmp=[];
                $tmp['exam_type']=$generatedata['exam_type'];
                $tmp['correct_mark']=$generatedata['correct_mark'];
                $tmp['wrong_mark']=$generatedata['wrong_mark'];
                $tmp['total_time']=$generatedata['total_time'];

                $data['otherinfo']=$tmp;


                $hashid=$generatedata['id'];

                $examquestion=$this->ExamQuestion->find("all")->where(['generateexam_id'=>$id])->toArray();
                foreach ($examquestion as $ex){
                    $q_id=$ex['q_id'];
                    $mcq=$this->Mcq->find("all")->where(['id'=>$q_id])->first()->toArray();
                    $temp=[];
                    $temp['question_id']=$mcq['id'];
                    $temp['question']=$mcq['data'];
                    $temp['type']=$mcq['type'];
                    $temp['correctmarks']=1;
                    $temp['wrongmarks']=2;



                    array_push($tmpdata,$temp);

                }
                $data['questiondata']=$tmpdata;
                $send['error'] = 0;
                $send['data'] = $data;
                //  $send['id'] = $userobj->id;

                echo json_encode($send);
                exit;



            }
            $send['error'] = 1;
            $send['msg'] = "No Exam Added";
            //  $send['id'] = $userobj->id;

            echo json_encode($send);
            exit;


        }


    }

    public function generatedtest(){
        if ($this->request->is("post")) {
            $date = date("Y-m-d");
            $data = $this->request->data;
            $c_id=$data['c_id'];
            $s_id=$data['s_id'];
            $ch_id=$data['ch_id'];
            $generatedata=$this->GenerateExam->find("all")->where(['c_id'=>$c_id,'s_id'=>$s_id,'ex_id'=>$ch_id])->toArray();
            $data=[];

            foreach ($generatedata as $d){
                $temp=[];
                $temp['name']=$d['name'];
                $temp['id']=$d['id'];
                array_push($data,$temp);
            }
            echo json_encode($data);
            exit;

        }




    }


    public function getclass(){

        $classobj = $this->Class->find('all')->toArray();

        $data=[];
        foreach($classobj as $c){
            $tm=[];
            $tm['id']=$c['id'];
            $tm['name']=$c['class_name'];

            array_push($data,$tm);

        }
        $send['error'] = 0;
        $send['data'] = $data;
        //  $send['id'] = $userobj->id;

        echo json_encode($send);
        exit;

    }

    public function getsubject(){
        if ($this->request->is("post")) {


            $date = date("Y-m-d");
            $data = $this->request->data;

            if ($data['c_id'] == '' ) {
                $send['error']=1;
                $send['msg']="Parameters should not empty";

                echo json_encode($send);
                exit;
            }

            $classobj = $this->Subject->find()->where(['c_id'=>$data['c_id']])->toArray();

            $data=[];
            foreach($classobj as $c){
                $tm=[];
                $tm['id']=$c['id'];
                $tm['name']=$c['subject_name'];

                array_push($data,$tm);

            }
            $send['error'] = 0;
            $send['data'] = $data;
            //  $send['id'] = $userobj->id;

            echo json_encode($send);
            exit;



        }
    }

    public function getexcersice()
    {

        if ($this->request->is("post")) {


            $date = date("Y-m-d");
            $data = $this->request->data;

            if ($data['c_id'] == '' || $data['s_id'] == '' ) {
                $send['error']=1;
                $send['msg']="Parameters should not empty";

                echo json_encode($send);
                exit;
            }
            $classobj = $this->Exercise->find()->where(['c_id'=>$data['c_id'],'s_id'=>$data['s_id']])->toArray();

            $data=[];
            foreach($classobj as $c){
                $tm=[];
                $tm['id']=$c['id'];
                $tm['name']=$c['title'];

                array_push($data,$tm);

            }
            $send['error'] = 0;
            $send['data'] = $data;
            //  $send['id'] = $userobj->id;

            echo json_encode($send);
            exit;



        }
    }

    public function profile(){

        if($this->request->is("post")) {


            $date = date("Y-m-d");
            $data = $this->request->data;



            $userobj = $this->Users->findById($data['userid'])->first();

            if($userobj==null){
                $send['error'] = 1;
                $send['msg'] = "User not exist ";
                //  $send['id'] = $userobj->id;

                echo json_encode($send);
                exit;
            }

            // $userobj=$this->Users->newEntity();

            $userobj->gender=$data['gender'];
            $userobj->class = $data['class_id'];
            $userobj->dob = $data['dob'];
            $userobj->f_name = $data['name'];
            $userobj->email = $data['email'];
            $userobj->mobile = $data['mobile'];
            // $encryptpass = Security::encrypt($data['password'], $this->key);


            // $resultr = Security::decrypt($result, $this->key);

            $userobj->update_date = date("Y-m-d H:i:s");

            try{


                if ($this->Users->save($userobj)) {

                    $send['error'] = 0;
                    $send['msg'] = "Updated successfully ";
                    $send['id'] = $userobj->id;
                    $send['name']=$userobj->f_name;
                    $send['mobile']=$userobj->mobile;
                    $send['email']=$userobj->email;
                    $send['class_id']=$userobj->class;
                    $send['gender']=$userobj->gender;
                    $send['dob']=$userobj->dob;
                    $claaobj = $this->Class->findById($data['class_id'])->first()->toArray();
                    $send['class_name']=$claaobj['class_name'];



                    echo json_encode($send);
                    exit;

                }



            }catch(\Exception $e){
                // var_dump($e->getMessage());
                $send['error']=1;
                $send['msg']="Try Again";

                echo json_encode($send);
                exit;
            }



        }



        //    var_dump("fsdfsdfsd");exit;


    }


    public function index(){


        var_dump("ASfasfasf");exit;

    }

    public function signup(){
        $send=[];

        if($this->request->is("post")) {

            $date=date("Y-m-d");
            $data = $this->request->data;

            if($data['f_name']==''  || $data['mobile']=='' || $data['password']=='' || $data['class_id']==''){

                $send['error']=1;
                $send['msg']="Parameters should not empty";

                echo json_encode($send);
                exit;
            }

            $datausercheck=$this->Users->find()->where(["mobile"=>$data['mobile'] ])->toList();

            if(!$datausercheck==null){
                $send['error']=1;
                $send['msg']="User Already Exist";

                echo json_encode($send);
                exit;
            }


            $userobj=$this->Users->newEntity();

            $userobj->mobile=$data['mobile'];
            $userobj->f_name = $data['f_name'];
            if(isset($_POST['email'])){

                $userobj->email = $data['email'];

            }



            $userobj->class = $data['class_id'];
            // $encryptpass = Security::encrypt($data['password'], $this->key);


            // $resultr = Security::decrypt($result, $this->key);

            $userobj->create_date = date("Y-m-d H:i:s");


            $userobj->password=md5($data['password']);

            try{

                if ($this->Users->save($userobj)) {

                    $send['error']=0;
                    $send['msg']="Added successfully ";
                    $send['id']=$userobj->id;
                    $datauser=$this->Users->findById($userobj->id)->first()->toArray();
                    $send['name']=$datauser['f_name'];
                    $send['mobile']=$datauser['mobile'];
                    $send['email']=$datauser['email'];
                    $send['class_id']=$datauser['class'];
                    $send['gender']=$datauser['gender'];
                    $claaobj = $this->Class->findById($data['class_id'])->first()->toArray();
                    $send['class_name']=$claaobj['class_name'];


                    echo json_encode($send);
                    exit;
                }


            }catch(\Exception $e){
                // var_dump($e->getMessage());
                $send['error']=1;
                $send['msg']="Try Again";

                echo json_encode($send);
                exit;
            }


        }else{
            $send['error']=1;
            $send['msg']="Only Use Post Method";

            echo json_encode($send);
            exit;

        }

    }


    public function login(){

        $send=[];

        if($this->request->is("post")) {

            $data = $this->request->data;

            if($data['mobile']==''  || $data['password']==''){

                $send['error']=1;
                $send['msg']="Parameters should not empty";

                echo json_encode($send);
                exit;
            }

            $dataphone=$this->Users->find()->where(["mobile"=>$data['mobile']])->first();

            if($dataphone==null){
                $send['error']=1;
                $send['msg']="User Not exist";

                echo json_encode($send);
                exit;

            }

            $datauser=$this->Users->find()->where(["mobile"=>$data['mobile'],"password"=>md5($data['password'])])->first();

            //   var_dump($datauser);exit;
            //   $data=$this->Users->get(2);
            try{

                if($datauser){

                    $send['error']=0;
                    $send['msg']="Data Mached";
                    $send['id']=$datauser->toArray()['id'];
                    $send['name']=$datauser->toArray()['f_name'];
                    $send['mobile']=$datauser->toArray()['mobile'];
                    $send['email']=$datauser->toArray()['email'];
                    $send['class_id']=$datauser->toArray()['class'];
                    $send['gender']=$datauser->toArray()['gender'];
                    $send['dob']=$datauser->toArray()['dob'];
                    $claaobj = $this->Class->findById($datauser->toArray()['class'])->first()->toArray();
                    $send['class_name']=$claaobj['class_name'];

                    echo json_encode($send);
                    exit;

                }else{
                    $send['error']=1;
                    $send['msg']="Wrong Password or Username";

                    echo json_encode($send);
                    exit;
                }

            }catch(\Exception $e){
                // var_dump($e->getMessage());
                $send['error']=1;
                $send['msg']="Try Again";

                echo json_encode($send);
                exit;
            }

        }

    }


}

?>