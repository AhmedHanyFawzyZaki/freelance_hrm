<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class HomeController extends FrontController {

    public function actionPage() {
        $this->layout=' ';
        if (isset($_REQUEST['slug'])) {
            $model = Page::model()->findByAttributes(array('slug' => $_REQUEST['slug']));
            if ($model) {
                /* Yii::app()->clientScript->registerMetaTag($model->meta_tags, 'keywords');
                  Yii::app()->clientScript->registerMetaTag($model->meta_description, 'description'); */
                $this->render('page', array('model' => $model));
            } else {
                echo '<img src="' . Yii::app()->request->getBaseUrl(true) . '/img/cons.gif" style="width:100%">';
            }
        } else {
            echo '<img src="' . Yii::app()->request->getBaseUrl(true) . '/img/cons.gif" style="width:100%">';
        }
    }

}
