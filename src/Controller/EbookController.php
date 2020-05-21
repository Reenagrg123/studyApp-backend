<?php

namespace App\Controller;

use App\Controller\AppController;
use App\Model\Table\CatebooksTables;
use App\Model\Table\CategorysTables;

class EbookController extends AppController{

    public function initialize()
    {
        parent::initialize();
        $this->viewBuilder()->layout("adminlayout");
        $this->Category=$this->loadModel(CategorysTables::class);
        $this->Catebook=$this->loadModel(CatebooksTables::class);
        $session = $this->getRequest()->getSession();
        $t= $session->read('user');
        if( $t=="" || $t==null ){

            $this->redirect(array("controller" => "Main",
                "action" => "login"));

            return;
        }


        $this->set("title","Dashboard");

    }

        public function index(){
            $cat=$this->Category->find("all")->toArray();
            $datac=$this->Catebook->find("all")->contain('category')->toArray();

            if($this->request->is("post")) {

                $data = $this->request->data();
                $name=$data['name'];
                $id=$data['cat_id'];
                $hasid=rand(100,2000);
                $classobj=$this->Catebook->newEntity();

                $classobj->name=$data['name'];
                $classobj->cat_id=$data['cat_id'];

                $filename=$_FILES['file']['name'];
                $path = $hasid.$_FILES['file']['name'];
                $imageFileType = pathinfo($path, PATHINFO_EXTENSION);



                if($imageFileType !== "pdf" && $imageFileType !== "doc" && $imageFileType !== "docx") {
                    $this->Flash->error('Wrong File Format');
                    $this->redirect(array("controller" => "Ebook",
                        "action" => "index"));
                    return;

                }

                if (!file_exists('ebook/'.$hasid)) {
                    mkdir('ebook/'.$hasid, 0777, true);
                }

                $uploadPath ='ebook/'.$hasid.'/';
                $uploadFile = $uploadPath.$path;

                if(move_uploaded_file($this->request->data['file']['tmp_name'],$uploadFile)) {


                    $classobj->file=$path;
                    $classobj->hash_id=$hasid;
                    $classobj->create_date = date("Y-m-d H:i:s");

                    $this->Catebook->save($classobj);


                }









                $this->Flash->success('Ebook Added');

                $this->redirect(array("controller" => "Ebook",
                    "action" => "category"));


                return;

            }



            $this->set("class",$cat);
            $this->set("data",$datac);
        }

    public function category(){

        $datac=$this->Category->find("all")->toArray();
          $id=$this->request->getQuery('id');

        if($this->request->is("post")) {

            $data = $this->request->data();
            $cat=$data['name'];
            //var_dump(array_unique($carray));exit;



            //   $data=$this->Users->get(2);
            if($id){
                $dataclass=$this->Exam->findById($id)->first();
                $dataclass->exam_name=$data['name'];

                $this->Exam->save($dataclass);

                $this->Flash->success('Data Updated');


                $this->redirect(array("controller" => "Ebook",
                    "action" => "category"));

                return;


            }

            $classobj=$this->Category->newEntity();

            $classobj->name=$data['name'];
            $classobj->create_date = date("Y-m-d H:i:s");

            $this->Category->save($classobj);


            $this->Flash->success('Category Added');

            $this->redirect(array("controller" => "Ebook",
                "action" => "category"));


            return;

        }
        if($id){
            $dataclass=$this->Exam->findById($id)->first()->toArray();
            if($dataclass){
                $this->set("edit",1);
                $this->set("editdata",$dataclass);

            }
            // var_dump("asfasfasf");exit;
        }

        $examd=[];



        $this->set("class",$datac);
        $this->set("data",$datac);

    }


}


?>