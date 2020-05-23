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
    function delete_directory($dirname) {
        if (is_dir($dirname))
            $dir_handle = opendir($dirname);
        if (!$dir_handle)
            return false;
        while($file = readdir($dir_handle)) {
            if ($file != "." && $file != "..") {
                if (!is_dir($dirname."/".$file))
                    unlink($dirname."/".$file);
                else
                    $this->delete_directory($dirname.'/'.$file);
            }
        }
        closedir($dir_handle);
        rmdir($dirname);
        return true;
    }
    public function delebook()
    {
        $id = $this->request->getQuery('id');
        $dataclass = $this->Catebook->findById($id)->first();
        if ($dataclass) {
            $this->delete_directory('ebook/'.$dataclass->hash_id."/");

            $this->Catebook->delete($dataclass);

        }
        $this->Flash->success('Data Deleted');


        $this->redirect(array("controller" => "Ebook",
            "action" => "index"));
    }

    public function editebook(){
        $id=$this->request->getQuery('id');
        $cat=$this->Category->find("all")->toArray();

        $dataclass=$this->Catebook->findById($id)->first()->toArray();
        if($dataclass) {
            if($this->request->is("post")) {

                $data = $this->request->data();
                $name=$data['name'];

                $dataobj=$this->Catebook->findById($id)->first();
              //  var_dump($dataobj);
                $hasid=$dataobj->hash_id;
                $dataobj->name=$data['name'];
                $dataobj->cat_id=$data['cat_id'];

                $filename=$_FILES['file']['name'];
                $path = $hasid.$_FILES['file']['name'];
                $imageFileType = pathinfo($path, PATHINFO_EXTENSION);

                if($_FILES['file']['name']) {


                    if ($imageFileType !== "pdf" && $imageFileType !== "doc" && $imageFileType !== "docx") {
                        $this->Flash->error('Wrong File Format');
                        $this->redirect(array("controller" => "Ebook",
                            "action" => "index"));
                        return;

                    }

                    if (!file_exists('ebook/' . $hasid)) {
                        mkdir('ebook/' . $hasid, 0777, true);
                    }
                }
                $uploadPath ='ebook/'.$hasid.'/';
                $uploadFile = $uploadPath.$path;

                if(move_uploaded_file($this->request->data['file']['tmp_name'],$uploadFile)) {

                    $dataobj->file=$path;

                    $this->Catebook->save($dataobj);

                }else{


                    $this->Catebook->save($dataobj);


                }

                $this->Flash->success("Data Updated");

                $this->redirect(array("controller" => "Ebook",
                    "action" => "index"));


                return;

            }

            $this->set("data",$dataclass);
$this->set('class',$cat);
        }


    }


    public function delcateory(){
        $id=$this->request->getQuery('id');
        $dataclass=$this->Category->findById($id)->first();
        if($dataclass) {
            $this->Category->delete($dataclass);
            $exerciserecord=$this->Catebook->find('all')->where(['cat_id'=>$id]);

            foreach ($exerciserecord as $t){
                $this->delete_directory('ebook/'.$t->hash_id."/");

                $this->Catebook->delete($t);
            }



        }
        $this->Flash->success('Data Deleted');


        $this->redirect(array("controller" => "Ebook",
            "action" => "category"));

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
                    "action" => "index"));


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
                $dataclass=$this->Category->findById($id)->first();
                $dataclass->name=$data['name'];

                $this->Category->save($dataclass);

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
            $dataclass=$this->Category->findById($id)->first()->toArray();
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