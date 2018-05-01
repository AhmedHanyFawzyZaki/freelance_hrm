<?php

class FileUploader {

    private $allowedExtensions = array();
  //  private $sizeLimit = 10485760;
    private $file;

    function __construct(){
      /*  $allowedExtensions = array_map("strtolower", $allowedExtensions);

        $this->allowedExtensions = $allowedExtensions;   */


        if (isset($_FILES['myfile'])) {
            $this->file = $_FILES['myfile']["name"];
        } else {
            $this->file = false;
        }
    }





    function handleUpload($output_dir, $replaceOldFile = FALSE){




        if (!is_writable($output_dir)){
            return array('error' => "Server error. Upload directory isn't writable.");
        }

        if (!$this->file){
            return array('error' => 'No files were uploaded.');
        }

        $size = $_FILES["myfile"]["size"];

        if ($size == 0) {
            return array('error' => 'File is empty');
        }


    		$error =$_FILES["myfile"]["error"];

    	if ($_FILES["myfile"]["error"] > 0)
    	{


    		  return array('error' => $_FILES["myfile"]["error"]);


    	}



     /*   $pathinfo = pathinfo($output_dir);
        $filename = $pathinfo['filename'];
        //$filename = md5(uniqid());
        $ext = $pathinfo['extension'];

        if($this->allowedExtensions && !in_array(strtolower($ext), $this->allowedExtensions)){
            $these = implode(', ', $this->allowedExtensions);
            return array('error' => 'File has an invalid extension, it should be one of '. $these . '.');
        }   */




    	if(isset($_FILES["myfile"]))
    	{



    		if(!is_array($_FILES["myfile"]["name"])) //single file
    		{
    			$fileName = $_FILES["myfile"]["name"];
    			move_uploaded_file($_FILES["myfile"]["tmp_name"],$output_dir. $_FILES["myfile"]["name"]);
    			return array('success'=>true,'filename'=>$filename.'.'.$ext);
    		}


    	}
    	else {
    		return array('error'=> 'Could not save uploaded file.' .
    		    'The upload was cancelled, or server error encountered');
    	}




    }
}
