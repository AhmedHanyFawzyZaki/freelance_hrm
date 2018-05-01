<?php
/**
 * EAjaxUpload class file.
 * This extension is a wrapper of http://valums.com/ajax-upload/
 *
 * @author Vladimir Papaev <kosenka@gmail.com>
 * @version 0.1
 * @license http://www.opensource.org/licenses/bsd-license.php
 */

/**
        How to use:

        view:
        *
        *
        *
        *
 <? $this->widget('ext.Euploader.Euploader',
 array(
 'name'=>'myfile',
 'config'=>array(
 'action'=>Yii::app()->createUrl('test/upload'),
 'allowedExtensions'=>array("jpg"),//array("jpg","jpeg","gif","exe","mov" and etc...

 )
 )); ?>

        controller:

	public function actionUpload()
	{
 $output_dir= $_SERVER["DOCUMENT_ROOT"].'/olivepharmacy/media/';// folder for uploaded files

 if(isset($_FILES["myfile"]))
 {
 $ret = array();

 $error =$_FILES["myfile"]["error"];
 if(!is_array($_FILES["myfile"]["name"])) //single file
 {
 $fileName = $_FILES["myfile"]["name"];
 move_uploaded_file($_FILES["myfile"]["tmp_name"],$output_dir. $_FILES["myfile"]["name"]);
 $ret[$fileName]= $output_dir.$fileName;
 }
 else
 {
 $fileCount = count($_FILES["myfile"]["name"]);
 for($i=0; $i < $fileCount; $i++)
 {
 $fileName = $_FILES["myfile"]["name"][$i];
 $ret[$fileName]= $output_dir.$fileName;
 move_uploaded_file($_FILES["myfile"]["tmp_name"][$i],$output_dir.$fileName );
 }

 }
 echo json_encode($ret);
 }


*
*
*
	}

*/
class Euploader extends CWidget
{
        public $name="fileUploader";
	public $formid="form1";
	public $postParams=array();
	public $config=array();
	public $css=null;

        public function run()
        {


        	if(empty($this->name))
        	{
        		throw new CException('EUploader: param "name" cannot be empty.');
        	}


        	if(empty($this->formid))
        	{
        		throw new CException('EUploader: param "formid" cannot be empty.');
        	}






     	if(empty($this->config['action']))
		{
		      throw new CException('EUploader: param "action" cannot be empty.');
                }

		if(empty($this->config['allowedExtensions']))
		{
		      throw new CException('EUploader: param "allowedExtensions" cannot be empty.');
                }



            //    unset($this->config['element']);



        $this->render("fupload",array("allowextension"=>implode(",",$this->config['allowedExtensions'] ) ,"name"=>$this->name));




	}


}