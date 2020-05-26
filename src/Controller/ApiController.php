<?php
namespace App\Controller;


use App\Controller\AppController;
use App\Controller\Services\EmailService;
use App\Model\Table\AppritiatespostsTables;
use App\Model\Table\BannersTables;
use App\Model\Table\CatebooksTables;
use App\Model\Table\CategorysTables;
use App\Model\Table\ClassexammapsTables;
use App\Model\Table\ClasssTables;
use App\Model\Table\ExamexercisessTables;
use App\Model\Table\ExamquestionsTables;
use App\Model\Table\ExamsTables;
use App\Model\Table\Examsubjects;
use App\Model\Table\ExercisessTables;
use App\Model\Table\GenerateexamsTables;
use App\Model\Table\HistorysTables;
use App\Model\Table\MaterialsTables;
use App\Model\Table\McqsTables;
use App\Model\Table\NoticesTables;
use App\Model\Table\NotificationsTables;
use App\Model\Table\PostsTables;
use App\Model\Table\ProfilesTables;
use App\Model\Table\SubjectsTables;
use App\Model\Table\TestimonialsTables;
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
        $this->History=$this->loadModel(HistorysTables::class);
        $this->Materials=$this->loadModel(MaterialsTables::class);

        $this->ExamSubject=$this->loadModel(Examsubjects::class);
        $this->ExamExercise=$this->loadModel(ExamexercisessTables::class);
        $this->Exam=$this->loadModel(ExamsTables::class);
        $this->ClassMap=$this->loadModel(ClassexammapsTables::class);

        $this->Notice=$this->loadModel(NoticesTables::class);
        $this->Category=$this->loadModel(CategorysTables::class);
        $this->Catebook=$this->loadModel(CatebooksTables::class);

        $this->Testimonial=$this->loadModel(TestimonialsTables::class);

        $this->Banner=$this->loadModel(BannersTables::class);

        $session = $this->getRequest()->getSession();
        // $this->authorize();

        $this->Users=$this->loadModel("User");

        $this->key = 'wt1U5MACWJFTXGenFoZoiLwQGrLgdbHA';

        $this->set("title","Dashboard");
    }

    public function getBanner(){
        if ($this->request->is("post")) {


            $date = date("Y-m-d");
            $data = $this->request->data;
            if ( $data['user_id'] == '' ) {
                $send['error'] = 1;
                $send['msg'] = "Parameters should not empty";

                echo json_encode($send);
                exit;
            }
            $this->auth($data['user_id']);
            $datacat=$this->Banner->find("all")->toArray();
/*
            if($data['type']==0){
    $datacat=$this->Banner->find("all")->where(['type'=>0])->toArray();


}
            if($data['type']==1){
    $datacat=$this->Banner->find("all")->where(['type'=>1])->toArray();

}
*/
$data=[];
            $host = Router::getRequest(true)->host();

            foreach ($datacat as $b){
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

echo json_encode($data);
            exit;

        }

    }

    public function setTestimonial(){
        if ($this->request->is("post")) {


            $date = date("Y-m-d");
            $data = $this->request->data;
            if ($data['c_id'] == '' || $data['user_id'] == '' ||  $data['des'] == '') {
                $send['error'] = 1;
                $send['msg'] = "Parameters should not empty";

                echo json_encode($send);
                exit;
            }
            $this->auth($data['user_id']);
            $testimonial=$this->Testimonial->newEntity();
            $testimonial->user_id=$data['user_id'];
            $testimonial->description=$data['des'];
            $testimonial->class=$data['c_id'];
            $testimonial->create_date=date("Y-m-d H:i:s");
            if(isset($_POST['image'])){

                $imgname = $_POST['image'];
                $imsrc = base64_decode($_POST['image']);
                $fp = fopen($imgname, 'w');
                fwrite($fp, "userimage/".$imsrc);
                if(fclose($fp)){
                    echo "Image uploaded";
                }else{
                    echo "Error uploading image";
                }


            }
            $this->Testimonial->save($testimonial);
            $send=[];
            $send['error']=0;
            $send['msg']="Done";
            echo json_encode($send);
            exit;

        }
    }

    public function getTestimonial(){
        if ($this->request->is("post")) {


            $date = date("Y-m-d");
            $data = $this->request->data;
            if ($data['user_id'] == '' ) {
                $send['error'] = 1;
                $send['msg'] = "Parameters should not empty";

                echo json_encode($send);
                exit;
            }
            $this->auth($data['user_id']);
            $u_id=$data['user_id'];
            $testi=$this->Testimonial->find("all")->where(['user_id'=>$u_id])->toArray();
            echo json_encode($testi);
            exit;

        }

    }

    public function getCategory(){
        $datanotice=$this->Category->find("all")->toArray();
        echo json_encode($datanotice);
        exit;

    }

    public function getEbook(){
        if ($this->request->is("post")) {


            $date = date("Y-m-d");
            $data = $this->request->data;
            if ($data['cat_id'] == '' || $data['user_id'] == '' ) {
                $send['error']=1;
                $send['msg']="Parameters should not empty";

                echo json_encode($send);
                exit;
            }
            $this->auth($data['user_id']);
            $cat_id=$data['cat_id'];
            $datacat=$this->Catebook->find("all")->where(['cat_id'=>$cat_id])->toArray();
            $data=[];
            $host = Router::getRequest(true)->host();

            foreach ($datacat as $d){
                $tmp=[];
                $tmp['id']=$d['id'];
                $tmp['name']=$d['name'];
                $tmp['file']=$host."/ebook/".$d['hash_id']."/".$d['file'];

                array_push($data,$tmp);

            }



            echo json_encode($data);
            exit;
        }

    }

    public function getNotice(){
        $datanotice=$this->Notice->find("all")->toArray();
        echo json_encode($datanotice);
        exit;
    }

    public function getExam(){
        if ($this->request->is("post")) {


            $date = date("Y-m-d");
            $data = $this->request->data;

            if ($data['c_id'] == '' || $data['user_id'] == '' ) {
                $send['error']=1;
                $send['msg']="Parameters should not empty";

                echo json_encode($send);
                exit;
            }
            $this->auth($data['user_id']);

            $classobj = $this->ClassMap->find('all')->where(['c_id'=>$data['c_id']])->group('exam_id')->toArray();
            $record=[];
            foreach($classobj as $c){
                $exam = $this->Exam->find('all')->where(['id'=>$c['exam_id']])->first()->toArray();
                $tmp=[];
                $tmp['id']=$exam['id'];
                $tmp['name']=$exam['exam_name'];

                array_push($record,$tmp);

            }

            $send['error'] = 0;
            $send['data'] = $record;
            //  $send['id'] = $userobj->id;

            echo json_encode($send);
            exit;



        }

    }

    public function getExamSubject(){

        if ($this->request->is("post")) {


            $date = date("Y-m-d");
            $data = $this->request->data;

            if ($data['exam_id'] == '' || $data['user_id'] == '' ) {
                $send['error']=1;
                $send['msg']="Parameters should not empty";

                echo json_encode($send);
                exit;
            }
            $this->auth($data['user_id']);

            $classobj = $this->ExamSubject->find()->where(['c_id'=>$data['exam_id']])->toArray();

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

    public function getExamChapters(){

        if ($this->request->is("post")) {


            $date = date("Y-m-d");
            $data = $this->request->data;

            if ($data['exam_id'] == '' || $data['examsubject_id'] == '' || $data['user_id']=='' ) {
                $send['error']=1;
                $send['msg']="Parameters should not empty";

                echo json_encode($send);
                exit;
            }
            $this->auth($data['user_id']);

            $classobj = $this->ExamExercise->find()->where(['c_id'=>$data['exam_id'],'s_id'=>$data['examsubject_id']])->toArray();

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





    public function getMaterials(){
        $host = Router::getRequest(true)->host();
        if ($this->request->is("post")) {
            $date = date("Y-m-d");
            $data = $this->request->data;
            if ($data['user_id']=='' or $data['c_id']=='' or  $data['s_id']=='' or  $data['ch_id']==''  or  $data['type']==''  ) {
                $send['error'] = 1;
                $send['msg'] = "Parameters should not empty";

                echo json_encode($send);
                exit;
            }
            $this->auth($data['user_id']);
            $c_id=$data['c_id'];
            $s_id=$data['s_id'];
            $ch_id=$data['ch_id'];
            $type=0;
            $type=$data['type'];
            $mat=$this->Materials->find('all')->where(['c_id'=>$c_id,'s_id'=>$s_id,'ch_id'=>$ch_id,'upload_for'=>$type])->toArray();

            $data=[];
            foreach ($mat as $m){

                $temp=[];
                $temp['id']=$m['id'];
                $temp['name']=$m['name'];
                $temp['type']=$m['type'];
                $temp['file']=$host.'/materials/'.$m['hash_id'].'/'.$m['file'];
                $temp['link']=$m['link'];
                array_push($data,$temp);
            }

            echo json_encode($data);
            exit;
        }
    }

    public function auth($user_id){

        $data=$this->Users->find()->where(["id"=>$user_id])->first();

        if($data==null){
            $send['error']=1;
            $send['msg']="User Not exist";

            echo json_encode($send);
            exit;

        }

    }



    public function setTestResult()
    {

        if ($this->request->is("post")) {
            $date = date("Y-m-d");
            $data = $this->request->data;
            if ( $data['user_id'] == ''  ||  $data['exam_id'] == '' || $data['marks'] == '' || $data['total_correct_marks'] == '' ||
                $data['total_wrong_marks'] == '' || $data['time_taken'] == '' || $data['accuracy'] == '' || $data['total_question'] == '' || $data['total_time'] == ''

                ||  $data['total_correct_question'] == '' ||  $data['total_wrong_question'] == '' ||  $data['total_attempted'] == '') {
                $send['error'] = 1;
                $send['msg'] = "Parameters should not empty";

                echo json_encode($send);
                exit;
            }
            $this->auth($data['user_id']);
            $exam_id=$data['exam_id'];
            $generatedata=$this->GenerateExam->find("all")->where(['id'=>$exam_id])->toArray();
            if($generatedata==null) {
                $send['error'] = 1;
                $send['msg'] = "Exam Not Found";

                echo json_encode($send);
                exit;

            }
            try{
                $history=$this->History->newEntity();
                $history->exam_id=$data['exam_id'];
                $history->user_id=$data['user_id'];
                $history->no_correct_marks=$data['total_correct_marks'];
                $history->no_wrong_marks=$data['total_wrong_marks'];
                $history->marks=$data['marks'];
                $history->total_correct_question=$data['total_correct_question'];
                $history->total_wrong_question=$data['total_wrong_question'];
                $history->total_attempted=$data['total_attempted'];

                $history->time_taken=$data['time_taken'];
                $history->accuracy=$data['accuracy'];
                $history->total_time=$data['total_time'];
                $history->total_question=$data['total_question'];
                $history->create_date=date("Y-m-d H:i:s");

                $this->History->save($history);

                $send['error'] = 0;
                $send['msg'] = "Added";
                $send['data']=$history;

                echo json_encode($send);
                exit;

            }catch(\Exception $e){
                // var_dump($e->getMessage());
                $send['error']=1;
                $send['msg']=$e->getMessage();

                echo json_encode($send);
                exit;
            }

        }

    }

    public function getTestHistory()
    {

        if ($this->request->is("post")) {
            $date = date("Y-m-d");
            $data = $this->request->data;
            if ( $data['user_id'] == ''   ) {
                $send['error'] = 1;
                $send['msg'] = "Parameters should not empty";

                echo json_encode($send);
                exit;
            }
            $this->auth($data['user_id']);
            // $examid=$data['exam_id'];
            $user_id=$data['user_id'];
            $history=$this->History->find('all')->where(['user_id'=>$user_id])->contain(['Generateexam'])->toArray();


            $send['error'] = 0;
            $send['data'] = $history;

            echo json_encode($send);
            exit;

        }

    }

    public function getexamdata($id){
        $send=[];
        if ($this->request->is("post")) {


            $date = date("Y-m-d");
            $data = $this->request->data;


            $data=[];
            $tmpdata=[];
            $totalmarks=0;
            $generatedata=$this->GenerateExam->find("all")->where(['id'=>$id])->first()->toArray();
            if($generatedata){
                $data['totaltime']=$generatedata['total_time'];
                $data['Instruction']=$generatedata['instruction'];
                $examquestion=$this->ExamQuestion->find("all")->where(['generateexam_id'=>$id])->toArray();
                foreach ($examquestion as $ex){
                    $q_id=$ex['q_id'];
                    $mcq=$this->Mcq->find("all")->where(['id'=>$q_id])->first()->toArray();
                    $has=$mcq['hash_id'];
                    $getmarks=$this->Uploadfiles->find('all')->where(['hashid'=>$has])->first()->toArray();

                    $temp=[];
                    $temp['question_id']=$mcq['id'];
                    $temp['question']=$mcq['data'];
                    $temp['type']=$mcq['type'];
                    $temp['correctmark']=$getmarks['correct_mark'];
                    $temp['wrongmark']=$getmarks['wrong_mark'];
                    $totalmarks=$totalmarks+$getmarks['correct_mark'];
                    array_push($tmpdata,$temp);

                }
                $data['total_mark']=$totalmarks;
                $data['questiondata']=$tmpdata;
                $send['error'] = 0;
                $send['data'] = $data;
                //  $send['id'] = $userobj->id;

                return $data;


            }
            $send['error'] = 1;
            $send['msg'] = "No Exam Added";
            //  $send['id'] = $userobj->id;

            echo json_encode($send);
            exit;


        }


    }

    public function gettest(){

        if ($this->request->is("post")) {
            $date = date("Y-m-d");
            $data = $this->request->data;
            if ($data['c_id'] == '' || $data['user_id'] == ''     ) {
                $send['error']=1;
                $send['msg']="Parameters should not empty";

                echo json_encode($send);
                exit;
            }
            $this->auth($data['user_id']);
            $user_id=$data['user_id'];
            $c_id=$data['c_id'];
            $s_id=$data['s_id'];
            $ch_id=$data['ch_id'];
            $type=$data['type'];
            $level=$data['level'];
            if($type==0){
                $generatedata=$this->GenerateExam->find("all")->where(['c_id'=>$c_id,'s_id'=>$s_id,'ex_id'=>$ch_id,'exam_type'=>0,'level'=>$level])->toArray();


            }
            if($type==1){
                $generatedata=$this->GenerateExam->find("all")->where(['c_id'=>$c_id,'exam_type'=>1])->toArray();


            }
            if($type==2){
                $generatedata=$this->GenerateExam->find("all")->where(['c_id'=>$c_id,'s_id'=>$s_id,'ex_id'=>$ch_id,'exam_type'=>2])->toArray();


            }

            $data=[];

            foreach ($generatedata as $d){
                $dataquestion=$this->getexamdata($d['id']);
                $exam_id=$d['id'];
                $history=$this->History->find('all')->where(['user_id'=>$user_id,'exam_id'=>$exam_id])->first();
                $exam_taken=0;
                if($history){
                    $exam_taken=1;
                }

                $temp=[];
                $temp['exam_name']=$d['name'];
                $temp['exam_attempted']=$exam_taken;
                $temp['exam_id']=$d['id'];
                $temp['exam_data']=$dataquestion;

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

            if ($data['c_id'] == '' || $data['user_id'] == '' ) {
                $send['error']=1;
                $send['msg']="Parameters should not empty";

                echo json_encode($send);
                exit;
            }
            $this->auth($data['user_id']);

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

    public function getexercise()
    {

        if ($this->request->is("post")) {


            $date = date("Y-m-d");
            $data = $this->request->data;

            if ($data['c_id'] == '' || $data['s_id'] == '' || $data['user_id']=='' ) {
                $send['error']=1;
                $send['msg']="Parameters should not empty";

                echo json_encode($send);
                exit;
            }
            $this->auth($data['user_id']);

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



            $userobj = $this->Users->findById($data['user_id'])->first();

            if($userobj==null){
                $send['error'] = 1;
                $send['msg'] = "User not exist ";
                //  $send['id'] = $userobj->id;

                echo json_encode($send);
                exit;
            }

            // $userobj=$this->Users->newEntity();

            $userobj->gender=$data['gender'];
            $userobj->class = $data['c_id'];
            $userobj->dob = $data['dob'];
            $userobj->f_name = $data['name'];
            $userobj->email = $data['email'];
            $userobj->mobile = $data['mobile'];
            if(isset($_POST['image'])){

                $imgname = $_POST['image'];
                $imsrc = base64_decode($_POST['image']);
                $fp = fopen($imgname, 'w');
                fwrite($fp, "userimage/".$imsrc);
                if(fclose($fp)){
                    echo "Image uploaded";
                }else{
                    echo "Error uploading image";
                }


            }

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
                    $claaobj = $this->Class->findById($data['c_id'])->first()->toArray();
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

            if($data['f_name']==''  || $data['mobile']=='' || $data['password']=='' || $data['c_id']==''){

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

            $userobj->class = $data['c_id'];
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
                    $claaobj = $this->Class->findById($data['c_id'])->first()->toArray();
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