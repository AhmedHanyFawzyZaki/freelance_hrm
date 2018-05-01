
<style type="text/css">


    body.dragging, body.dragging * {
        cursor: move !important;
    }

    .dragged {
        position: absolute;
        opacity: 0.5;
        z-index: 2000;
    }

    ol.example li.placeholder {
        position: relative;
        /** More li styles **/
    }
    ol.example li.placeholder:before {
        position: absolute;
        /** Define arrowhead **/
    }
    .example{

        width: 100%;
    }
    ol.example li{
        float: left;
        width: 48%;
    }
</style>


<link href="<?php echo Yii::app()->theme->baseUrl; ?>/css/inettuts.css" rel="stylesheet" type="text/css" />
<link href="<?php echo Yii::app()->theme->baseUrl; ?>/css/inettuts.js.css" rel="stylesheet" type="text/css" />


<link href="<?php echo Yii::app()->theme->baseUrl; ?>/css/im.css" type="text/css" rel="stylesheet" />

<div id="columns">
    <?php
    if (Yii::app()->user->hasState('company') && Yii::app()->user->getState('company') != '') {
        ?>
        <div class="row-fluid">
            <?php
            if (Yii::app()->user->hasFlash('added')) {
                echo '<div class="alert alert-success text-center">' . Yii::app()->user->getFlash('added') . '</div>';
            }
            ?>
            <div class="span8 block2">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#1" data-toggle="tab">Recent Time Off Requests</a></li>
                    <li><a href="#2" data-toggle="tab">Recent Time Cards Submitted</a></li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="1">
                        <?php
                        $offs = Timeoff::model()->findAll(array('condition' => 'user_id=' . Yii::app()->user->id, 'order' => 'id desc', 'limit' => 20));
                        if ($offs) {
                            echo '<table class="table no-border"><tr><th>Time From</th><th>Time To</th><th>Status</th><th>Request Type</th><th>Comment</th></tr>';
                            foreach ($offs as $toff) {
                                echo '<tr><td>' . Timeoff::getTime($toff->time_from) . '</td><td>' . Timeoff::getTime($toff->time_to) . '</td><td>' . Timeoff::getStatus($toff->status) . '</td><td>' . $toff->requestType->name . '</td><td>' . $toff->comments . '</td></tr>';
                            }
                            echo '</table>';
                        } else {
                            echo '<strong>No time offs found.</strong>';
                        }
                        ?>
                    </div>
                    <div class="tab-pane" id="2">
                        <?php
                        $ats = ActivityLog::model()->findAll(array('condition' => 'user_id=' . Yii::app()->user->id, 'order' => 'id desc', 'limit' => 20));
                        if ($ats) {
                            echo '<table class="table no-border"><tr><th>Time In</th><th>Time Out</th><th>Status</th></tr>';
                            foreach ($ats as $at) {
                                echo '<tr><td>' . Timeoff::getTime($at->time_in) . '</td><td>' . Timeoff::getTime($at->time_out) . '</td><td>' . ActivityLog::ACLStatusValue($at->status, $at->id) . '</td></tr>';
                            }
                            echo '</table>';
                        } else {
                            echo '<strong>No time offs found.</strong>';
                        }
                        ?>
                    </div>
                </div>
            </div>
            <div class="span4 block2">
                <h4 class="alert alert-info text-center">QUICK ACCESS &nbsp;<i class="icon-plus-sign-alt"></i></h4>
                <div class="accordion" id="accordion2">
                    <!--<div class="accordion-group">
                        <div class="accordion-heading">
                            <a class="accordion-toggle anchor" href="<?= Yii::app()->request->getBaseUrl(true) ?>/user/create">
                                <i class="icon-plus-sign"></i> &nbsp;Create New Employee
                            </a>
                        </div>
                    </div>-->
                    <div class="accordion-group">
                        <!--<div class="accordion-heading">
                            <a class="accordion-toggle anchor" href="<?= Yii::app()->request->getBaseUrl(true) ?>/activityLog/create">
                                <i class="icon-bell-alt"></i> &nbsp;Manual Punch
                            </a>
                        </div>-->
                        <div class="accordion-heading">
                            <a class="accordion-toggle anchor" data-toggle="collapse" data-parent="#accordion2" href="#collapseOne">
                                <i class="icon-bell-alt"></i> &nbsp;Manual Punch
                            </a>
                        </div>
                        <div id="collapseOne" class="accordion-body collapse offwhite">
                            <div class="accordion-inner">
                                <?php
                                $this->renderPartial('//activityLog/_form-quick', array('model' => $acLog));
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="accordion-group">
                        <!--<div class="accordion-heading">
                            <a class="accordion-toggle anchor" href="<?= Yii::app()->request->getBaseUrl(true) ?>/timeOff/create">
                                <i class="icon-calendar"></i> &nbsp;Time Off
                            </a>
                        </div>-->
                        <div class="accordion-heading">
                            <a class="accordion-toggle anchor" data-toggle="collapse" data-parent="#accordion2" href="#collapseTwo">
                                <i class="icon-calendar"></i> &nbsp;Time Off
                            </a>
                        </div>
                        <div id="collapseTwo" class="accordion-body collapse offwhite">
                            <div class="accordion-inner">
                                <?php
                                $this->renderPartial('//timeoff/_form-quick', array('model' => $tioff));
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="accordion-group">
                        <div class="accordion-heading">
                            <a class="accordion-toggle anchor" href="<?= Yii::app()->request->getBaseUrl(true) ?>/payroll/slip">
                                <i class="icon-money"></i> &nbsp;Pay Slip
                            </a>
                        </div>
                    </div>
                    <div class="accordion-group">
                        <div class="accordion-heading">
                            <a class="accordion-toggle anchor" href="<?= Yii::app()->request->getBaseUrl(true) ?>/user/<?= Yii::app()->user->id ?>">
                                <i class="icon-user"></i> &nbsp;Profile
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
    ?>

    <div class="row-fluid">

       <!-- <div class="span12 block2 box-header">
            <h3>Worked Hours (vs) Time Off</h3>

            <div class="panel panel-default">

                <div class="panel-body">
                    <div id="morris-line-chart"></div>
                </div>
            </div>
        </div>-->

        <!--<div class="span6 block2 box-header2">
            <h3>Employees</h3>

            <div class="panel panel-default">

                <div class="panel-body">
                    <div id="morris-donut-chart"></div>
                </div>
            </div>
        </div>-->
    </div>
    <?php
    /*$y = date('Y');
    for ($i = $y - 5; $i <= $y; $i++) {
        $twt = 0;
        $tot = 0;
        $condition = ' and user_id=' . Yii::app()->user->id;
        $actLs = ActivityLog::model()->findAll(array('condition' => 'status=1 and year(time_in)=' . $i . $condition));
        if ($actLs) {
            foreach ($actLs as $acl) {
                $twt+=((strtotime($acl->time_out) - strtotime($acl->time_in)) / (60 * 60));
            }
        }
        $tLs = Timeoff::model()->findAll(array('condition' => 'status=1 and year(time_from)=' . $i . $condition));
        if ($tLs) {
            foreach ($tLs as $tl) {
                $tot+=((strtotime($tl->time_to) - strtotime($tl->time_from)) / (60 * 60));
            }
        }
        $data[] = array('y' => (string) $i, 'a' => $twt, 'b' => $tot);
    }*/
    ?>
    <!--<script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/jquery.metisMenu.js"></script>
    <script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/morris/raphael-2.1.0.min.js"></script>
    <script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/morris/morris.js"></script>
    <script>
        //var active_users =<?= Yii::app()->user->hasState('company') ? User::model()->count(array('condition' => 'user_type=3 and company_id=' . Yii::app()->user->getState('company'))) : User::model()->count(array('condition' => 'user_type=3 and active=1')) ?>;
        //var inactive_users =<?= Yii::app()->user->hasState('company') ? User::model()->count(array('condition' => 'user_type=1 and company_id=' . Yii::app()->user->getState('company'))) : User::model()->count(array('condition' => 'user_type=1 and active=1')) ?>;
        var data = <?= json_encode($data); ?>;
    </script>
    <script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/custom1.js"></script>-->

</div>
<!-- END CONTENT -->
