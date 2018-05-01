<html>
    <head>
        <title><?= Yii::app()->name ?> - Login & Register</title>
        <link rel="stylesheet" href="<?php echo Yii::app()->theme->baseUrl; ?>/login/style.default.css" type="text/css" />
        <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/font-awesome.css" type="text/css" />
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="Login & Register">
        <meta name="author" content="Ahmed Hany">
        
        <style>
            #LoginForm_password_em_{
                color:red;
            }
        </style>
        <?php
        //Yii::app()->bootstrap->register();
        /*         * ******************fancyBox Class********************** */
        $this->widget('application.extensions.fancybox.EFancyBox', array(
            'target' => '.s_frame',
            'config' => array(
                'maxWidth' => '50%',
                'maxHeight' => '100%',
                //'fitToView' => true,
                //'width' => '50%',
                //'height' => '60%',
                //'autoSize' => false,
                //'closeClick' => true,
                //'openEffect' => 'none',
                //'closeEffect' => 'none',
                'type' => 'iframe',
                //'afterClose' => 'js:function(){window.location.reload();}'
            ),
        ));
        ?>
    </head>
    <body class="loginpage">
        <div class="row-fluid">
            <h1 class="app-head"><?=Yii::app()->name?></h1>
            <?php
            if(Yii::app()->user->hasFlash('done')){
                echo '<div class="alert alert-success span8 offset2">'.Yii::app()->user->getFlash('done').'</div>';
            }elseif(Yii::app()->user->hasFlash('wrong')){
                echo '<div class="alert alert-error span8 offset2">'.Yii::app()->user->getFlash('wrong').'</div>';
            }
            ?>
        </div>
        <div class="row-fluid">
            <div class="span4 offset1">
                <?php $this->renderPartial('login', array('model' => $model)) ?>
                <?php $this->renderPartial('forgot') ?>
            </div>
            <div class="span2"></div>
            <div class="span4">
                <?php $this->renderPartial('register', array('model' => $company, 'user'=>$user)) ?>
            </div>
        </div>
    </body>
</html>