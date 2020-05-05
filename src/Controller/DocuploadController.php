<?php

namespace App\Controller;

use App\Controller\AppController;
use App\Controller\Services\ExecuteService;
use Cake\Datasource\ConnectionManager;
use Cake\Routing\Router;


class DocuploadController extends AppController{
    public $base_url;

    public function initialize()
    {
        parent::initialize();
        $this->viewBuilder()->layout("adminlayout");
        $this->base_url = Router::url("/", true);
        $connection = ConnectionManager::get('default');


    }



    public function index(){




        if($this->request->is("post")) {

           $date=date("Y-m-d");


            $data = $this->request->data;
            $exercise=$data['exercise'];
            $hashid=rand(200,500);
            $filename=$_FILES['file']['name'];
            $path = $hashid.$_FILES['file']['name'];
            $imageFileType = pathinfo($path, PATHINFO_EXTENSION);



            if($imageFileType != "zip" && $imageFileType != "png" && $imageFileType != "jpeg"
                && $imageFileType != "gif" ) {

              var_dump("wrong");exit;

            }


            if (!file_exists('tempzip/'.$exercise)) {
                mkdir('tempzip/'.$exercise, 0777, true);
            }

            $uploadPath ='tempzip/'.$exercise.'/';
            $uploadFile = $uploadPath.$path;


            if(move_uploaded_file($this->request->data['file']['tmp_name'],$uploadFile)){


//unzip
                $this->unzip($uploadFile,'mcq/'.$exercise.'/'.$hashid.'/',$exercise,$hashid);



                 var_dump("upload");exit;


            }else{
                $this->Flash->set('Unable to Upload Status.', [
                    'element' => 'error'
                ]);

                return;


            }






        }

        //var_dump("sdfsadfdsaf");
    }

public function unzip($filename,$path,$exercise,$hashid){
    if (!file_exists('mcq/'.$exercise.'/'.$hashid)) {
        mkdir('mcq/'.$exercise.'/'.$hashid, 0777, true);
    }

    if (!file_exists('mcq/'.$exercise)) {
        mkdir('mcq/'.$exercise, 0777, true);
    }
    $zip = new \ZipArchive();
    $res = $zip->open($filename);
    if ($res === TRUE) {

        // Extract file
        $zip->extractTo($path);
        $zip->close();

        return true;
    } else {
       return false;
    }
}

}
?>