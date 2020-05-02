<?php
namespace App\Controller;


use App\Controller\AppController;
use App\Controller\Services\EmailService;
use App\Model\Table\AppritiatespostsTables;
use App\Model\Table\CategorysTables;
use App\Model\Table\NotificationsTables;
use App\Model\Table\PostsTables;
use App\Model\Table\ProfilesTables;
use App\Model\Table\TrafficsTables;
use App\Model\Table\TransactionsTables;
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


        $session = $this->getRequest()->getSession();
        // $this->authorize();

        $this->Users=$this->loadModel("User");

        $this->key = 'wt1U5MACWJFTXGenFoZoiLwQGrLgdbHA';



        $this->set("title","Dashboard");
    }



public function profile(){

    if($this->request->is("post")) {


        $date = date("Y-m-d");
        $data = $this->request->data;

        if($data['gender']==''  || $data['class']=='' || $data['dob']=='' || $data['userid']==''){

            $send['error']=1;
            $send['msg']="Parameters should not empty";

            echo json_encode($send);
            exit;
        }

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
        $userobj->class = $data['class'];
        $userobj->dob = $data['dob'];

        // $encryptpass = Security::encrypt($data['password'], $this->key);


        // $resultr = Security::decrypt($result, $this->key);

        $userobj->update_date = date("Y-m-d H:i:s");

            if ($this->Users->save($userobj)) {

                $send['error'] = 0;
                $send['msg'] = "Updated successfully ";
                //$send['id'] = $userobj->id;

                echo json_encode($send);
                exit;

            }







    }



        var_dump("fsdfsdfsd");exit;


}


    public function index(){


        var_dump("ASfasfasf");exit;

    }

    public function signup(){
        $send=[];

        if($this->request->is("post")) {




            $date=date("Y-m-d");
            $data = $this->request->data;

            if($data['f_name']==''  || $data['mobile']=='' || $data['password']==''){

                $send['error']=1;
                $send['msg']="Parameters should not empty";

                echo json_encode($send);
                exit;
            }




            $userobj=$this->Users->newEntity();

            $userobj->mobile=$data['mobile'];
            $userobj->f_name = $data['f_name'];
            $userobj->email = $data['email'];

            // $encryptpass = Security::encrypt($data['password'], $this->key);


            // $resultr = Security::decrypt($result, $this->key);

            $userobj->create_date = date("Y-m-d H:i:s");


            $userobj->password=md5($data['password']);

            try{

                if ($this->Users->save($userobj)) {

                    $send['error']=0;
                    $send['msg']="Added successfully ";
                    $send['id']=$userobj->id;

                    echo json_encode($send);
                    exit;
                }


            }catch(\Exception $e){
                var_dump($e->getMessage());
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

            if($data['phone']==''  || $data['password']==''){

                $send['error']=1;
                $send['msg']="Parameters should not empty";

                echo json_encode($send);
                exit;
            }

            $dataphone=$this->Users->find()->where(["mobile"=>$data['phone']])->first();

            if($dataphone==null){
                $send['error']=1;
                $send['msg']="User Not exist";

                echo json_encode($send);
                exit;

            }


            $datauser=$this->Users->find()->where(["mobile"=>$data['phone'],"password"=>md5($data['password'])])->first();

            //   var_dump($datauser);exit;
            //   $data=$this->Users->get(2);

            if($datauser){

                $send['error']=0;
                $send['msg']="Data Mached";
                $send['id']=$datauser->toArray()['id'];

                echo json_encode($send);
                exit;

            }else{
                $send['error']=1;
                $send['msg']="Wrong Password or Username";

                echo json_encode($send);
                exit;
            }



        }

    }


}

?>