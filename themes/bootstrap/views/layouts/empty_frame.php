<!DOCTYPE html>
<!--[if lt IE 7]>
<html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>
<html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>
<html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js"> <!--<![endif]-->
    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?php echo CHtml::encode($this->pageTitle); ?></title>
        <meta name="description" content="<?php echo CHtml::encode($this->pageTitle); ?>">
        <meta name="author" content="Ahmed Hany">

        <style>
            .box .body, .box .block{
                min-height: 372px !important;
            }
        </style>

        <?php
        //if (Yii::app()->getLanguage() == 'en') {
        echo '<link type="text/css" rel="stylesheet" href="' . Yii::app()->request->baseUrl . '/css/style.css">';
		Yii::app()->bootstrap->register();
        ?>

        <!--<link type="text/css" rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/chat/css/screen.css" />-->

        <!--<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/autocomplete/jquery-ui-1.10.4.js"></script>-->
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/main.js"></script>
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/date.js"></script>

        <!--<link type="text/css" rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/fullcalendar.css" />-->
        <link type="text/css" rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/Font-awesome/css/font-awesome.min.css" />

        <link type="text/css" rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/os_temp.css"/>
        <link type="text/css" rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/jquery.window.css"/>
        <link type="text/css" rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/morris-0.4.3.min.css" />
        
    </head>
    
    <body class="hide-sidebar" >

        <div>

            <!-- #content -->
            <div>
                <!-- .outer -->
                <div class="">
                    <div class="row-fluid">
                        <!-- .inner -->
                        <div class="span12 inner">
                            <!--Begin Datatables-->
                            <div class="row-fluid">
                                <div class="span12">
                                    <div id="collapse4" class="body">
										<?php echo $content; ?>

                                    </div>
                                </div>
                                <!--End Datatables-->
                            </div>
                            <!-- /.row-fluid -->
                        </div>
                        <!-- /.outer -->
                    </div>
                </div>
                
                
                </body>
                </html>