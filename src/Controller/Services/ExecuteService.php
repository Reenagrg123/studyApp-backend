<?php

namespace App\Controller\Services;

use App\Controller\AppController;
use Cake\Network\Email\Email;
use Cake\Routing\Router;
use Cake\Mailer;
use Composer\Package\Archiver\ZipArchiver;
use Composer\Util\Zip;


class ExecuteService extends AppController{
    public $base_url;
    private $file;
    private $indexes = [ ];
    /** Local directory name where images will be saved */
    private $savepath = '';
    public function initialize(){
        parent::initialize();
        $this->viewBuilder()->layout("adminlayout");
        $this->base_url=Router::url("/",true);

    }
    public function __construct($DocxFilePath)
    {
        $this->document = $DocxFilePath;
       // $this->extractImages();
    }




    function extractImages() {
        $ZipArchive = new \ZipArchive();
        if ( true === $ZipArchive->open( $this->document ) ) {

            for ( $i = 0; $i < $ZipArchive->numFiles; $i ++ ) {
                $zip_element = $ZipArchive->statIndex( $i );
                //	var_dump($zip_element['name']);
                if ( preg_match( "([^\s]+(\.(?i)(jpg|jpeg|png|gif|bmp))$)", $zip_element['name'] ) ) {

                    $imagename                   = explode( '/', $zip_element['name'] );
                    $imagename                   = end( $imagename );
                    $this->indexes[ $imagename ] = $i;
                }
            }
        }else{

        }
    }
    function saveAllImages() {
        if ( count( $this->indexes ) == 0 ) {
            echo 'No images found';
        }
        //var_dump($this->indexes);
        foreach ( $this->indexes as $key => $index ) {
            $zip = new \ZipArchive();
            if ( true === $zip->open( $this->document ) ) {

                file_put_contents($_SERVER['DOCUMENT_ROOT']."/studyApp-backend/webroot/"
                 . $key, $zip->getFromIndex( $index ) );
            }
            $zip->close();
        }
    }
    function displayImages() {
$image=[];

        $this->saveAllImages();
        if ( count( $this->indexes ) == 0 ) {
            return 'No images found';
        }
        $images = '';
        foreach ( $this->indexes as $key => $index ) {
            $path = $key;

            $type = pathinfo($path, PATHINFO_EXTENSION);
            $data = file_get_contents($path);
            $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
            array_push($image,$base64);
            //$data = base64_encode($path);

// Display the output
            $im=" <img style='display:block; width:100px;height:100px;' id='base64image'                 
       src='".$base64."' />";
         //  echo $im;
//echo $base64;

            $images .= '<img src="' . $path . '" alt="' . $key . '"/> <br>';
        }

        return $image;
        //	echo $images;
    }

    public function convertToText()
    {

        if (isset($this->document) && !file_exists($this->document)) {
            return 'File Does Not exists';
        }

        $fileInformation = pathinfo($this->document);
        $extension = $fileInformation['extension'];
      //  echo $extension;
        if ($extension == 'doc' || $extension == 'docx') {
            if ($extension == 'doc') {
                return $this->extract_doc();
            } elseif ($extension == 'docx') {
                return $this->extract_docx();
            }
        } else {
            return 'Invalid File Type, please use doc or docx word document file.';
        }
    }

    private function extract_doc()
    {
        $fileHandle = fopen($this->document, 'r');
        $allLines = @fread($fileHandle, filesize($this->document));
        $lines = explode(chr(0x0D), $allLines);
        $document_content = '';
        foreach ($lines as $line) {
            $pos = strpos($line, chr(0x00));
            if (($pos !== false) || (strlen($line) == 0)) {
            } else {
                $document_content .= $line . ' ';
            }
        }
        $document_content = preg_replace("/[^a-zA-Z0-9\s\,\.\-\n\r\t@\/\_\(\)]/", '', $document_content);
        return $document_content;
    }

    private function extract_docx()
    {
        $document_content = '';
        $content = '';

        $zip = zip_open($this->document);

        if (!$zip || is_numeric($zip)) {
            return false;
        }

        while ($zip_entry = zip_read($zip)) {
            if (zip_entry_open($zip, $zip_entry) == false) {
                continue;
            }

            if (zip_entry_name($zip_entry) != 'word/document.xml') {
                continue;
            }



            //	echo zip_entry_name($zip_entry);
            $content .= zip_entry_read($zip_entry, zip_entry_filesize($zip_entry));

            zip_entry_close($zip_entry);
        }

        zip_close($zip);
        //var_dump($content);exit;
        // $content = str_replace("</w:p>", "\r\n", $content);
        $content = str_replace('</w:r></w:p></w:tc><w:tc>', ' ', $content);
        $content = str_replace('</w:r></w:p>', "\r\n", $content);
        $document_content = strip_tags($content);

        return $document_content;
    }



}


?>