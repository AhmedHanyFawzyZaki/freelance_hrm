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

        <?php
        echo '<link type="text/css" rel="stylesheet" href="' . Yii::app()->theme->baseUrl . '/css/style.css">';
        Yii::app()->bootstrap->register();
        ?>

        <script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/main.js"></script>
        <script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/date.js"></script>

        <link type="text/css" rel="stylesheet" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/Font-awesome/css/font-awesome.min.css" />
        <link type="text/css" rel="stylesheet" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/os_temp.css"/>
        <link type="text/css" rel="stylesheet" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/jquery.window.css"/>
        <link type="text/css" rel="stylesheet" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/morris-0.4.3.min.css" />

        <?php
        /*         * ******************fancyBox Class********************** */
        $this->widget('application.extensions.fancybox.EFancyBox', array(
            'target' => '.s_frame',
            'config' => array(
                'maxWidth' => '100%',
                'maxHeight' => '100%',
                //'fitToView' => true,
                //'width' => '50%',
                //'height' => '60%',
                //'autoSize' => false,
                //'closeClick' => true,
                //'openEffect' => 'none',
                //'closeEffect' => 'none',
                'type' => 'iframe',
                'afterClose' => 'js:function(){window.location.reload();}'
            ),
        ));
        ?>

    </head>
    
    <body class="hide-sidebar" >

        <div id="wrap">

            <!-- #top -->
            <div id="top">

                <!-- .navbar -->
                <div class="navbar navbar-inverse navbar-static-top">
                    <div class="navbar-inner">
                        <div class="container-fluid">

                            <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </a>
                            <a class="brand" href="<?php echo Yii::app()->request->baseUrl; ?>/dashboard">
                                <?php echo Yii::t('translate', Yii::app()->name); ?>
                            </a>

                        </div>
                    </div>
                </div>
                <!-- /.navbar -->
            </div>

            <!-- #content -->
            <div id="content">
                <!-- .outer -->
                <div class="container-fluid outer">
                    <div class="row-fluid">
                        <!-- .inner -->
                        <div class="span12 inner">
                            <!--Begin Datatables-->
                            <div class="row-fluid">
                                <div class="span12">
                                    <div class="box dark">
                                        <header>
                                            <div class="icons"><i class="icon-eye-open"></i></div>
                                            <?php
                                            if (Yii::app()->controller->id == 'dashboard' and in_array(strtolower(Yii::app()->controller->action->id), array('index', 'invalidpermission','error'))) {
                                                echo "<h5>Error</h5>";
                                            } else {
                                                echo "<h5>" . $this->pageTitlecrumbs . "</h5>";
                                            }
                                            ?>
                                            <!-- .toolbar -->
                                            <div class="toolbar">
                                                <?php if (Yii::app()->controller->id != 'dashboard') { ?> <ul class="nav">
                                                        <li class="dropdown">
                                                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                                                <i class="icon-th-large"></i>
                                                            </a>
                                                            <ul class="dropdown-menu">
                                                                <?php
                                                                $this->beginWidget('zii.widgets.CPortlet', array(
                                                                ));
                                                                $this->widget('bootstrap.widgets.TbMenu', array(
                                                                    'items' => $this->menu,
                                                                    'htmlOptions' => array('class' => 'nav'),
                                                                ));
                                                                $this->endWidget();
                                                                ?>
                                                            </ul>
                                                        </li>
                                                        <li>
                                                        </li>
                                                    </ul>
                                                <?php } else {
                                                    ?>
                                                    <?php
                                                    if (Yii::app()->user->hasState('company') && Yii::app()->user->getState('company') != '') {
                                                        $in_time = ActivityLog::model()->find(array('condition' => 'user_id=' . Yii::app()->user->id . ' and DATE_FORMAT(time_in,"%Y-%m-%d") = "' . date('Y-m-d') . '" and (time_out is null or time_out="")'));
                                                        if ($in_time) {
                                                            echo '<a class="btn btn-info pull-left margintop5" id="punch_id" href="javascript:void(0)" onclick="punch()">Punch Out</a>';
                                                        } else {
                                                            echo '<a class="btn btn-info pull-left margintop5" id="punch_id" href="javascript:void(0)" onclick="punch()">Punch In</a>';
                                                        }
                                                    }
                                                    ?>
                                                    <script>
                                                        function punch() {
                                                            $.ajax({
                                                                url: '<?= Yii::app()->request->getBaseUrl(true) ?>/activityLog/punch',
                                                                success: function (data) {
                                                                    var arr = jQuery.parseJSON(data);
                                                                    if (arr['status'] == 1)
                                                                        $('#punch_id').html('Punch Out');
                                                                    else if (arr['status'] == 2) {
                                                                        //$('#punch_id').addClass('hide');
                                                                        $('#punch_id').html('Punch In');
                                                                    }
                                                                    alert(arr['msg']);
                                                                }
                                                            });
                                                        }
                                                    </script>
                                                <?php }
                                                ?>
                                            </div>
                                            <!-- /.toolbar -->
                                        </header>

                                        <div id="collapse4" class="body">
                                            <?php echo $content; ?>

                                        </div>

                                    </div>
                                </div>
                                <!--End Datatables-->
                            </div>
                            <!-- /.row-fluid -->
                        </div>
                        <!-- /.outer -->
                    </div>
                    <!-- /#content -->
                    <!-- #push do not remove -->
                    <div id="push"></div>
                    <!-- /#push -->
                </div>
                <!-- /#wrap -->
                <div id="footer">
                    <p><?php echo date('Y'); ?> &copy; Ahmed Hany</p>
                </div>

                <script>
                    $("document").ready(function () {
                        $("#changeSidebarPos").click(function () {
                            $.ajax({
                                url: "<?php echo Yii::app()->createUrl('dashboard/ajaxRequest'); ?>",
                                success: function () {
                                }
                            });
                        });
                    });
                </script>



                <!---------Crop and upload----------------->

                <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
                <!--[if lt IE 9]>
                  <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
                  <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
                <![endif]-->

                </body>
                </html>