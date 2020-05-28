<?php
namespace App\Controller;


use App\Controller\AppController;
use App\Controller\Services\EmailService;
use App\Model\Table\AppritiatespostsTables;
use App\Model\Table\BannersTables;
use App\Model\Table\CategorysTables;
use App\Model\Table\ClassexammapsTables;
use App\Model\Table\ClasssTables;
use App\Model\Table\ExamsTables;
use App\Model\Table\Examsubjects;
use App\Model\Table\ExercisessTables;
use App\Model\Table\GenerateexamsTables;
use App\Model\Table\McqsTables;
use App\Model\Table\NoticesTables;
use App\Model\Table\NotificationsTables;
use App\Model\Table\PostsTables;
use App\Model\Table\ProfilesTables;
use App\Model\Table\SubjectsTables;
use App\Model\Table\TrafficsTables;
use App\Model\Table\TransactionsTables;
use App\Model\Table\UploadfilesTables;
use App\Model\Table\UsersTables;
use Cake\Database\Expression\QueryExpression;
use Cake\Network\Email\Email;
use Cake\ORM\Query;
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
        $this->Users=$this->loadModel(UsersTables::class);
        $this->Class=$this->loadModel(ClasssTables::class);
        $this->Exam=$this->loadModel(ExamsTables::class);
        $this->Subject=$this->loadModel(SubjectsTables::class);
        $this->Exercise=$this->loadModel(ExercisessTables::class);
        $this->Uploadfiles=$this->loadModel(UploadfilesTables::class);
        $this->ClassMap=$this->loadModel(ClassexammapsTables::class);
        $this->GenerateExam=$this->loadModel(GenerateexamsTables::class);
        $this->Mcq=$this->loadModel(McqsTables::class);
        $this->Notice=$this->loadModel(NoticesTables::class);
        $this->ExamSubject=$this->loadModel(Examsubjects::class);
        $this->Banner=$this->loadModel(BannersTables::class);
        $session = $this->getRequest()->getSession();
        $t= $session->read('user');
        if( $t=="" || $t==null ){

            $this->redirect(array("controller" => "Main",
                "action" => "login"));

            return;
        }


        $this->set("title","Dashboard");
    }

    public function edituser(){
        $id=$this->request->getQuery('id');
        $userdata=$this->Users->findById($id)->first();
        if(! $userdata){
            $this->Flash->success('Data Not Found');


            $this->redirect(array("controller" => "Admin",
                "action" => "users"));

        }

        if($this->request->is("post")) {

            $data = $this->request->data;
            $userdata=$this->Users->patchEntity($userdata,$data);
            $this->Users->save($userdata);
            $this->Flash->success('Data Updated');


            $this->redirect(array("controller" => "Admin",
                "action" => "users"));
        }
       $classobj= $this->Class->find('all')->select(['id','class_name'])->toArray();
      // var_dump($classobj);exit;

       $classlist=[];

       foreach ($classobj as $c) {

           $classlist[$c['id']]=$c['class_name'];
     //  $tmp['id']=$c['id'];
      // array_push($classlist, $tmp);

       }

        $this->set('classlist',$classlist);
       // $this->set('classlist',$classlist );
        $this->set("name",$userdata->f_name);
        $this->set("gender",$userdata->gender);
        $this->set("email",$userdata->email);
        $this->set("mob",$userdata->mobile);
        $this->set("class",$userdata->class);
        $this->set("dob",$userdata->dob);

        }

    public function getdata(){

        if($this->request->is("post")) {

            $data = $this->request->data;
            $date = date("Y-m-d");
            $type=$data['type'];

            if($type=='5'){
                $for=$data['for'];
                $class=$data['class'];
                if($for==0){

                    $class=$this->Subject->find("all")->where(['c_id'=>$class])->toArray();
                    $name='subject_name';
                }


                if($for==1){

                    $class=$this->ExamSubject->find("all")->where(['c_id'=>$class])->toArray();
                    $name='subject_name';
                }




            }


            if($type=='0'){
                $class=$this->Class->find("all")->toArray();
                $name='class_name';

            }

            if($type=='1'){

                //  var_dump($clas.$sub);exit;
                $class=$this->Exam->find("all")->toArray();
                $name='exam_name';

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


public function delbanner(){
    $id=$this->request->getQuery('id');
    $dataclass=$this->Banner->findById($id)->first();

    if($dataclass) {
        unlink('banner/'.$dataclass->file);
        $this->Banner->delete($dataclass);
    }
    $this->Flash->success('Data Deleted');


    $this->redirect(array("controller" => "Admin",
        "action" => "banner"));

}
    public function banner(){
        $banner=$this->Banner->find("all")->toArray();
        if($this->request->is("post")) {
            $data = $this->request->data();

            $banner=$this->Banner->newEntity();
            $banner->c_id=$data['c_id'];
            $banner->s_id=$data['s_id'];
            $banner->type=$data['type'];
            $banner->msg=$data['msg'];
            $banner->date=date("Y-m-d H:i:s");

            $filename=$_FILES['file']['name'];
            $path = rand(100,2000).$_FILES['file']['name'];
            $imageFileType = pathinfo($path, PATHINFO_EXTENSION);


            if($imageFileType !== "jpg" && $imageFileType !== "jpeg" && $imageFileType !== "png" && $imageFileType !== "PNG") {
                $this->Flash->error('Wrong File Format');
                $this->redirect(array("controller" => "Admin",
                    "action" => "banner"));
                return;

            }

            if (!file_exists('banner/')) {
                mkdir('banner/', 0777, true);
            }

            $uploadPath ='banner/';
            $uploadFile = $uploadPath.$path;

            if(move_uploaded_file($this->request->data['file']['tmp_name'],$uploadFile)) {

                $save=1;
                $banner->file=$path;

            }

            $this->Banner->save($banner);

            $this->Flash->success('Added');
            $this->redirect(array("controller" => "Admin",
                "action" => "banner"));
            return;




        }
        $host = Router::getRequest(true)->host();
        $data=[];
        foreach ($banner as $b){
            $tmp=[];
            $c_id=$b['c_id'];
            $s_id=$b['s_id'];
            $type="Learn";
            if($b['type']==0){
                $class=$this->Class->find("all")->where(['id'=>$c_id])->first();
                $subject=$this->Subject->find("all")->where(['id'=>$s_id])->first();
$tmp['class']=$class->class_name;
                $tmp['subject']=$subject->subject_name;

            }else{
                $type="Exam";
                $class=$this->Exam->find("all")->where(['id'=>$c_id])->first();
                $subject=$this->ExamSubject->find("all")->where(['id'=>$s_id])->first();
                $tmp['class']=$class->exam_name;
                $tmp['subject']=$subject->subject_name;
            }
$tmp['type']=$type;
            $tmp['msg']=$b['msg'];
            $tmp['file']=$host.'/banner/'.$b['file'];
            $tmp['id']=$b['id'];

array_push($data,$tmp);
        }

      $this->set('banner',$data);

        }
    public function notice(){
    $datanotice=$this->Notice->find("all")->toArray();
            if($this->request->is("post")) {
                $data = $this->request->data();
                $notice=$data['notice'];



                $classobj=$this->Notice->newEntity();

                $classobj->notice=$notice;

                // $encryptpass = Security::encrypt($data['password'], $this->key);
                // $resultr = Security::decrypt($result, $this->key);

                $classobj->create_date = date("Y-m-d H:i:s");

                $this->Notice->save($classobj);
                $this->Flash->success('Notice Added');

                $this->redirect(array("controller" => "Admin",
                    "action" => "notice"));

                return;

            }


            $this->set("data",$datanotice);


    }
    public function deluser(){
        $id=$this->request->getQuery('id');
        $dataclass=$this->Users->findById($id)->first();
        if($dataclass) {
            $this->Users->delete($dataclass);
        }
        $this->Flash->success('Data Deleted');


        $this->redirect(array("controller" => "Admin",
            "action" => "Users"));

    }

    public function testimonials(){

    }
public function users(){
    $users=$this->Users->find('all')->contain('class')->toArray();
    $this->set("users",$users);
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