<?php

class FloaraController extends CExtController {

    public function actionUpload() {
        // Allowed extentions.
        $allowedExts = array("gif", "jpeg", "jpg", "png");

        $temp = explode(".", $_FILES["file"]["name"]);

        $extension = end($temp);

        if ((($_FILES["file"]["type"] == "image/gif") || ($_FILES["file"]["type"] == "image/jpeg") || ($_FILES["file"]["type"] == "image/jpg") || ($_FILES["file"]["type"] == "image/pjpeg") || ($_FILES["file"]["type"] == "image/x-png") || ($_FILES["file"]["type"] == "image/png")) && in_array($extension, $allowedExts)) {
            // Generate new random name.
            $name = sha1(microtime()) . "." . $extension;

            // Save file in the uploads folder.
            move_uploaded_file($_FILES["file"]["tmp_name"], Yii::app()->basePath."/../media/editor/" . $name);

            // Generate response.
            $response = new StdClass;
            $response->link = Yii::app()->baseUrl."/media/editor/" . $name;
            echo stripslashes(json_encode($response));
        }
    }

}
