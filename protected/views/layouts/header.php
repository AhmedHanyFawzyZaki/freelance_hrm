<!DOCTYPE html>
<html lang="en"><!-- InstanceBegin template="/Templates/index.dwt" codeOutsideHTMLIsLocked="false" -->
    <head>
        <meta charset="utf-8">
        <!-- InstanceBeginEditable name="doctitle" -->
        <title><?= Yii::app()->name ?></title>
        <!-- InstanceEndEditable -->
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="author" content="Designed By : Ahmed Hany Fawzy">

        <!-- Le styles -->
        <link href="<?= Yii::app()->request->getBaseUrl(true) ?>/css/bootstrap.css" rel="stylesheet">
        <link href="<?= Yii::app()->request->getBaseUrl(true) ?>/css/bootstrap-responsive.css" rel="stylesheet">
        <link href="<?= Yii::app()->request->getBaseUrl(true) ?>/css/style.css" rel="stylesheet">
        <link href="<?= Yii::app()->request->getBaseUrl(true) ?>/css/font-awesome.css" rel="stylesheet">
        <script src="<?= Yii::app()->request->getBaseUrl(true) ?>/js/jquery.js"></script>
        <script src="<?= Yii::app()->request->getBaseUrl(true) ?>/js/bootstrap.js"></script>
        <script>
            function toggleMenuClass(el) {
                if (el.hasClass('fa-list')) {
                    el.removeClass('fa-list');
                    el.addClass('fa-close');
                    $('.menu-items').show(1000);
                } else {
                    el.removeClass('fa-close');
                    el.addClass('fa-list');
                    $('.menu-items').hide(1000);
                }
            }
        </script>

        <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
        <!--[if lt IE 9]>
          <script src="<?= Yii::app()->request->getBaseUrl(true) ?>/js/html5shiv.js"></script>
        <![endif]-->

        <!-- Le fav and touch icons -->
        <link rel="shortcut icon" href="<?= Yii::app()->request->getBaseUrl(true) ?>/img/logo-black.png">
        <!-- InstanceBeginEditable name="head" -->
        <!-- InstanceEndEditable -->
    </head>
    <body data-spy="scroll" data-target=".bs-docs-sidebar">

        <!-- header
        ================================================== --> 
        <header>
            <div class="menu">
                <div class="menu-control">
                    <i class="fa fa-list font28" id="menu-icon" onclick="toggleMenuClass($(this))"></i>
                </div>
                <div class="menu-name">
                    <a href="<?= Yii::app()->request->getBaseUrl(true) ?>/home"><?= Yii::app()->name ?></a>
                    <?php
                    if (Yii::app()->controller->action->id == 'page') {
                        echo '<a class="menu-append" href="#">' . Page::model()->findByAttributes(array('url' => $_REQUEST['slug'], 'active' => 1))->title . '</a>';
                    }elseif (Yii::app()->controller->action->id == 'blog' || Yii::app()->controller->action->id == 'article') {
                        echo '<a class="menu-append" href="#">Articles</a>';
                    }
                    ?>
                </div>
            </div>
            <div class="menu-items">
                <div class="menu-scroll">
                    <div class="row-fluid">
                        <a class="menu-link" href="<?= Yii::app()->request->getBaseUrl(true) ?>/_why-we-exist">Why We Exist</a>
                        <a class="menu-link" href="<?= Yii::app()->request->getBaseUrl(true) ?>/_how-we-can-help">How We Can Help</a>
                        <a class="menu-link" href="<?= Yii::app()->request->getBaseUrl(true) ?>/_our-investment-philosophy">Our Investment Philosophy</a>
                        <a class="menu-link" href="<?= Yii::app()->request->getBaseUrl(true) ?>/_leadership">Leadership</a>
                        <a class="menu-link" href="<?= Yii::app()->request->getBaseUrl(true) ?>/_financial-education">Financial Education & Speaking</a>
                        <a class="menu-link" href="<?= Yii::app()->request->getBaseUrl(true) ?>/_talk-to-us">Talk To Us</a>
                        <a class="menu-link" href="<?= Yii::app()->request->getBaseUrl(true) ?>/home/blog">Articles</a>
                    </div>
                    <!--<div class="row-fluid">
                        <div class="span3 item"><a href="<?= Yii::app()->request->getBaseUrl(true) ?>/home/why-we-exist"><i class="fa fa-building-o item-icon"></i><br><br>Why We Exist</a></div>
                        <div class="span3 item"><a href="<?= Yii::app()->request->getBaseUrl(true) ?>/home/our-values"><i class="fa fa-diamond item-icon"></i><br><br>Our Values</a></div>
                        <div class="span3 item"><a href="<?= Yii::app()->request->getBaseUrl(true) ?>/home/how-we-can-help"><i class="fa fa-exclamation-circle item-icon"></i><br><br>How We Can Help</a></div>
                        <div class="span3 item"><a href="<?= Yii::app()->request->getBaseUrl(true) ?>/home/our-investment-philosophy"><i class="fa fa-university item-icon"></i><br><br>Our Investment Philosophy</a></div>
                    </div>
                    <div class="row-fluid margintop10">
                        <div class="span3 item"><a href="<?= Yii::app()->request->getBaseUrl(true) ?>/home/leadership"><i class="fa fa-street-view item-icon"></i><br><br>Leadership</a></div>
                        <div class="span3 item"><a href="<?= Yii::app()->request->getBaseUrl(true) ?>/home/financial-education"><i class="fa fa-money item-icon"></i><br><br>Financial Education & Speaking</a></div>
                        <div class="span3 item"><a href="<?= Yii::app()->request->getBaseUrl(true) ?>/home/talk-to-us"><i class="fa fa-users item-icon"></i><br><br>Talk To Us</a></div>
                        <div class="span3 item"><a href="<?= Yii::app()->request->getBaseUrl(true) ?>/home/articles"><i class="fa fa-pencil-square-o item-icon"></i><br><br>Articles</a></div>
                    </div>-->
                    <div class="menu-logo"><img src="<?= Yii::app()->request->getBaseUrl(true) ?>/img/logo-white.png" width="90"></div>
                </div>
            </div>
        </header>
        <!--End Header-->