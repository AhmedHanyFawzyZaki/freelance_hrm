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
    <div class="row-fluid">
        <div class="span3">
            <div class="circle-tile">
                <a href="<?= Yii::app()->request->baseUrl ?>/user?type=2">
                    <div class="circle-tile-heading dark-blue">
                        <i class="icon-user mrgr-10 muted"></i>
                    </div>
                </a>
                <div class="circle-tile-content dark-blue">
                    <p>
                        <?= Yii::t('translate', 'Administrators'); ?>
                    </p>
                    <span>
                        <?php
                        if (Yii::app()->user->getState('usertype') == Yii::app()->params['Admin'])
                            echo User::model()->count(array('condition' => 'user_type=2 and id !=1'));
                        else
                            echo User::model()->count(array('condition' => 'active=1 and user_type=3 and company_id=' . Yii::app()->user->getState('company')));
                        ?>

                        <i class="ion ion-stats-bars"></i>

                    </span>
                    <a href="<?= Yii::app()->request->baseUrl ?>/user?type=3" class="circle-tile-footer"><?= Yii::t('translate', 'More Info'); ?> <i class="fa fa-chevron-circle-right"></i></a>
                </div>
            </div>
        </div>

        <div class="span3">
            <div class="circle-tile">
                <a href="<?= Yii::app()->request->baseUrl ?>/user?type=1">
                    <div class="circle-tile-heading bg-yellow">
                        <i class="icon-male mrgr-10 muted"></i>
                    </div>
                </a>
                <div class="circle-tile-content bg-yellow">
                    <p>
                        <?= Yii::t('translate', 'Employees'); ?>
                    </p>
                    <span>
                        <?php
                        if (Yii::app()->user->getState('usertype') == Yii::app()->params['Admin'])
                            echo User::model()->count(array('condition' => 'active=1 and user_type=1 and id !=1'));
                        else
                            echo User::model()->count(array('condition' => 'active=1 and user_type=1 and company_id=' . Yii::app()->user->getState('company')));
                        ?>

                        <i class="ion ion-stats-bars"></i>

                    </span>
                    <a href="<?= Yii::app()->request->baseUrl ?>/user?type=1" class="circle-tile-footer"><?= Yii::t('translate', 'More Info'); ?> <i class="fa fa-chevron-circle-right"></i></a>
                </div>
            </div>
        </div>

        <div class="span3">
            <div class="circle-tile">
                <a href="<?= Yii::app()->request->baseUrl ?>/department">
                    <div class="circle-tile-heading blue-background">
                        <i class="icon-list-alt mrgr-10 muted"></i>
                    </div>
                </a>
                <div class="circle-tile-content blue-background">
                    <p>
                        <?= Yii::t('translate', 'Departments'); ?>
                    </p>
                    <span>
                        <?php
                        if (Yii::app()->user->getState('usertype') == Yii::app()->params['Admin'])
                            echo Department::model()->count();
                        else
                            echo Department::model()->count(array('condition' => 'company_id=' . Yii::app()->user->getState('company')));
                        ?>

                        <i class="ion ion-stats-bars"></i>

                    </span>
                    <a href="<?= Yii::app()->request->baseUrl ?>/department" class="circle-tile-footer"><?= Yii::t('translate', 'More Info'); ?> <i class="fa fa-chevron-circle-right"></i></a>
                </div>
            </div>
        </div>

        <div class="span3">
            <div class="circle-tile">
                <a href="<?= Yii::app()->request->baseUrl ?>/timeoff">
                    <div class="circle-tile-heading red">
                        <i class="icon-location-arrow mrgr-10 muted"></i>
                    </div>
                </a>
                <div class="circle-tile-content red">
                    <p>
                        <?= Yii::t('translate', 'Total Timeoff'); ?>
                    </p>
                    <span>
                        <?php
                        if (Yii::app()->user->getState('usertype') == Yii::app()->params['Admin'])
                            echo Timeoff::model()->count();
                        else
                            echo Timeoff::model()->count(array('condition' => 'company_id=' . Yii::app()->user->getState('company')));
                        ?>

                        <i class="ion ion-stats-bars"></i>

                    </span>
                    <a href="<?= Yii::app()->request->baseUrl ?>/timeoff" class="circle-tile-footer"><?= Yii::t('translate', 'More Info'); ?> <i class="fa fa-chevron-circle-right"></i></a>
                </div>
            </div>
        </div>

    </div>

    <?php
    if (Yii::app()->user->hasState('company') && Yii::app()->user->getState('company') != '') {
        ?>
        <div class="row-fluid">
            <?php
            if (Yii::app()->user->hasFlash('added')) {
                echo '<div class="alert alert-success text-center">' . Yii::app()->user->getFlash('added') . '</div>';
            }
            ?>
            <div class="span7 block2">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#1" data-toggle="tab">At a Glance</a></li>
                    <li><a href="#2" data-toggle="tab">Recent Activity</a></li>
                    <li><a href="#3" data-toggle="tab">Departments</a></li>
                    <li><a href="#4" data-toggle="tab">History</a></li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="1">
                        <div class="row-fluid marginbottom20">
                            <span class="span3 pointer" onclick="$('.other').toggle();$('.cl_in').show();"><i class="icon-circle" style="color:green;font-size:16px;"></i> <i id="in_c">0</i> Clocked in</span>
                            <span class="span3 pointer" onclick="$('.other').toggle();$('.cl_out').show();"><i class="icon-circle" style="color:red;font-size:16px;"></i> <i id="out_c">0</i> Clocked out</span>
                            <span class="span3 pointer" onclick="$('.other').toggle();$('.cl_of').show();"><i class="icon-star" style="color:blue;font-size:16px;"></i> <i id="off_c">0</i> Time Off</span>
                            <span class="span3"><i class="icon-ticket" style="color:orange;font-size:16px;"></i> <i id="no_c">0</i> No Activity</span>
                        </div>
                        <?php
                        //$logs = ActivityLog::model()->findAll(array('condition' => '(DATE_FORMAT(time_in,"%Y-%m-%d")="' . date('Y-m-d') . '" OR DATE_FORMAT(time_out,"%Y-%m-%d")="' . date('Y-m-d') . '") and company_id=' . Yii::app()->user->getState('company')));
                        $logs = ActivityLog::model()->findAll(array('condition' => '(DATE_FORMAT(date_created,"%Y-%m-%d")="' . date('Y-m-d') . '" OR DATE_FORMAT(time_in,"%Y-%m-%d")="' . date('Y-m-d') . '" OR DATE_FORMAT(time_out,"%Y-%m-%d")="' . date('Y-m-d') . '") and company_id=' . Yii::app()->user->getState('company'), 'order' => 'id desc'));
                        $offs = Timeoff::model()->findAll(array('condition' => '(DATE_FORMAT(date_created,"%Y-%m-%d")="' . date('Y-m-d') . '" OR DATE_FORMAT(time_from,"%Y-%m-%d")="' . date('Y-m-d') . '" OR DATE_FORMAT(time_to,"%Y-%m-%d")="' . date('Y-m-d') . '") and company_id=' . Yii::app()->user->getState('company'), 'order' => 'id desc'));
                        /*if (!$logs && !$offs) {
                            $logs = ActivityLog::model()->findAll(array('condition' => '(DATE_FORMAT(time_in,"%Y-%m-%d")>"' . date('Y-m-d', strtotime('-1 month')) . '" OR DATE_FORMAT(time_out,"%Y-%m-%d")>"' . date('Y-m-d', strtotime('-1 month')) . '") and company_id=' . Yii::app()->user->getState('company'), 'order' => 'id desc'));
                            $offs = Timeoff::model()->findAll(array('condition' => '(DATE_FORMAT(time_from,"%Y-%m-%d")>"' . date('Y-m-d', strtotime('-1 month')) . '" OR DATE_FORMAT(time_to,"%Y-%m-%d")>"' . date('Y-m-d', strtotime('-1 month')) . '") and company_id=' . Yii::app()->user->getState('company'), 'order' => 'id desc'));
                        }*/
                        $in_c = 0;
                        $out_c = 0;
                        $off_c = 0;
                        $users_arr = array();
                        if ($logs || $offs) {
                            $emps = array();
                            echo '<table class="table table-center no-border full-table"><thead><tr><th>Type</th><th>Employee Name</th><th>Last Activity</th><th>Status</th></tr></thead><tbody class="scroll-y">';
                            if ($logs) {
                                foreach ($logs as $lg) {
                                    $users_arr[] = $lg->user_id;
                                    if ($lg->time_out and $lg->time_out != '') {
                                        $out_c++;
                                        $time = 'Out @ ' . date('H:i', strtotime($lg->time_out)) . ' on ' . date('m/d/Y', strtotime($lg->time_out));
                                        $status = '<i class="icon-circle" style="color:red;font-size:18px;"></i>';
                                        echo '<tr class="other cl_out"><td>' . $status . '</td><td>' . $lg->user->username . '</td><td><a href="'.Yii::app()->request->getBaseUrl(true).'/activityLog/'.$lg->id.'?frame=1" class="popup s_frame">' . $time . '</a></td><td>'.  Timeoff::getStatus($lg->status).'</td></tr>';
                                    }
                                    $in_c++;
                                    $time = 'In @ ' . date('H:i', strtotime($lg->time_in)) . ' on ' . date('m/d/Y', strtotime($lg->time_in));
                                    $status = '<i class="icon-circle" style="color:green;font-size:18px;"></i>';
                                    echo '<tr class="other cl_in"><td>' . $status . '</td><td>' . $lg->user->username . '</td><td>
									<a href="'.Yii::app()->request->getBaseUrl(true).'/activityLog/'.$lg->id.'?frame=1" class="popup s_frame">' . $time . '</a></td><td>'.  Timeoff::getStatus($lg->status).'</td></tr>';
                                }
                            }
                            if ($offs) {
                                foreach ($offs as $of) {
                                    $off_c++;
                                    $users_arr[] = $of->user_id;
                                    $time = 'Time off from (' . date('H:i', strtotime($of->time_from)) . ' on ' . date('m/d/Y', strtotime($of->time_from)) . ')';
                                    $time .= '<br>to (' . date('H:i', strtotime($of->time_to)) . ' on ' . date('m/d/Y', strtotime($of->time_to)) . ')';
                                    $status = '<i class="icon-star" style="color:blue;font-size:18px;"></i>';
                                    echo '<tr class="other cl_of"><td>' . $status . '</td><td>' . $of->user->username . '</td><td>
									<a href="'.Yii::app()->request->getBaseUrl(true).'/timeoff/'.$of->id.'?frame=1" class="popup s_frame">' . $time . '</a></td><td>'.  Timeoff::getStatus($of->status).'</td></tr>';
                                }
                            }
                            echo '</tbody></table>';
                        } else {
                            echo 'All employees have no activity.';
                        }
                        $no_emps = User::model()->count(array('condition' => 'company_id=' . Yii::app()->user->getState('company') . ' and id not in ("' . implode(',', $users_arr) . '")'));
                        ?>
                        <script>
                            $(document).ready(function () {
                                $('#in_c').html("<?= $in_c ?>");
                                $('#out_c').html("<?= $out_c ?>");
                                $('#off_c').html("<?= $off_c ?>");
                                $('#no_c').html("<?= $no_emps ?>");
                            });
                        </script>
                    </div>
                    <div class="tab-pane" id="2">
                        <?php
                        $sysLogs = SystemLog::model()->findAll(array('condition' => 'company_id=' . Yii::app()->user->getState('company'), 'order' => 'id desc', 'limit' => 20));
                        if ($sysLogs) {
                            echo '<table class="table no-border"><tr><th>Employee Name</th><th>Last Activity</th></tr>';
                            foreach ($sysLogs as $sl) {
                                if ($sl->comment)
                                    echo '<tr><td>' . $sl->employee->username . '</td><td>' . $sl->comment . '</td></tr>';
                            }
                            echo '</table>';
                        }
                        ?>
                    </div>
                    <div class="tab-pane" id="3">
                        <?php
                        $departments = Department::model()->findAllByAttributes(array('company_id' => Yii::app()->user->getState('company')));
                        if ($departments) {
                            echo '<table class="table no-border"><tr><th>Department</th><th>Employees</th><th>In</th><th>Out</th><th>Time Off</th></tr>';
                            foreach ($departments as $dep) {
                                $emps = User::model()->countByAttributes(array('department_id' => $dep->id));
                                $in = ActivityLog::model()->count(array('condition' => 'DATE_FORMAT(time_in,"%Y-%m-%d")="' . date('Y-m-d') . '" and department_id=' . $dep->id));
                                $out = ActivityLog::model()->count(array('condition' => 'DATE_FORMAT(time_out,"%Y-%m-%d")="' . date('Y-m-d') . '" and department_id=' . $dep->id));
                                $off = $emps - ($in + $out);
                                echo '<tr><td>' . $dep->name . '</td><td>' . $emps . '</td><td>' . $in . '</td><td>' . $out . '</td><td>' . $off . '</td></tr>';
                            }
                            echo '</table>';
                        }
                        ?>
                    </div>
                    <div class="tab-pane" id="4">
                        <?php
                        $sysLog = new SystemLog;
                        $columns = array(
                            'employee_id' => array(
                                'name' => 'employee_id',
                                'value' => '$data->employee->username',
                                'filter' => Helper::ListEmployee()
                            ),
                            'comment',
                            'date_created' => array(
                                'name' => 'date_created',
                                'filter' => $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                                    'model' => $sysLog,
                                    'attribute' => 'date_created',
                                    'language' => 'ja',
                                    'i18nScriptFile' => 'jquery.ui.datepicker-ja.js',
                                    'htmlOptions' => array(
                                        'id' => 'datepicker_for_date_created',
                                        'size' => '10',
                                    ),
                                    'defaultOptions' => array(// (#3)
                                        'showOn' => 'focus',
                                        'dateFormat' => 'yy-mm-dd',
                                        'showOtherMonths' => true,
                                        'selectOtherMonths' => true,
                                        'changeMonth' => true,
                                        'changeYear' => true,
                                    )
                                        ), true), // (#4)
                            ),
                        );
                        $this->widget('bootstrap.widgets.TbGridView', array(
                            'id' => 'system-log-grid',
                            'type' => 'striped  condensed',
                            'htmlOptions' => array('class' => 'grid-view no-border'),
                            'dataProvider' => $sysLog->search(),
                            'afterAjaxUpdate' => 'reinstallDatePicker',
                            'filter' => $sysLog,
                            'ajaxUrl' => Yii::app()->createUrl('systemLog/index'),
                            'columns' => $columns,
                        ));
                        Yii::app()->clientScript->registerScript('re-install-date-picker', "
function reinstallDatePicker(id, data) {
        //use the same parameters that you had set in your widget else the datepicker will be refreshed by default
    $('#datepicker_for_date_created').datepicker(jQuery.extend({showMonthAfterYear:false},jQuery.datepicker.regional['ja'],{'dateFormat':'yy-mm-dd'}));
}
");
                        ?>
                    </div>
                </div>
            </div>
            <div class="span5 block2">
                <h4 class="alert alert-info text-center">QUICK ACCESS &nbsp;<i class="icon-plus-sign-alt"></i></h4>
                <div class="accordion" id="accordion2">
                    <div class="accordion-group">
                        <div class="accordion-heading">
                            <a class="accordion-toggle anchor" href="<?= Yii::app()->request->getBaseUrl(true) ?>/user/create">
                                <i class="icon-plus-sign"></i> &nbsp;Create New Employee
                            </a>
                        </div>
                    </div>
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
                        <!--<div class="accordion-heading">
                            <a class="accordion-toggle anchor" href="<?= Yii::app()->request->getBaseUrl(true) ?>/timeOff/create">
                                <i class="icon-calendar"></i> &nbsp;Time Off
                            </a>
                        </div>-->
                        <div class="accordion-heading">
                            <a class="accordion-toggle anchor" data-toggle="collapse" data-parent="#accordion2" href="#collapseThree">
                                <i class="icon-time"></i> &nbsp;Print Timesheets
                            </a>
                        </div>
                        <div id="collapseThree" class="accordion-body collapse offwhite">
                            <div class="accordion-inner">
                                <?php
                                $this->renderPartial('//payroll/_form-quick', array('payroll' => $payroll));
                                ?>
                            </div>
                        </div>
                    </div>
                    <!--<div class="accordion-group">
                        <div class="accordion-heading">
                            <a class="accordion-toggle anchor" href="<?= Yii::app()->request->getBaseUrl(true) ?>/payroll/create">
                                <i class="icon-time"></i> &nbsp;Print Timesheets
                            </a>
                        </div>
                    </div>-->
                </div>
            </div>
        </div>
        <?php
    }
    ?>

    <div class="row-fluid">

        <div class="span6 block2 box-header">
            <h3>Clocked In (vs) Clocked Out 
            	<a href="javascript:void(0);" onclick="changeView(2)" id="view2" class="pull-right btn">Year</a>
            	<a href="javascript:void(0);" onclick="changeView(1)" id="view1" class="pull-right btn active">Month</a>
            </h3>

            <div class="panel panel-default">

                <div class="panel-body">
                    <div id="morris-line-chart1"></div>
                    <div id="morris-line-chart2" style="opacity:0;position:absolute;bottom:0;"></div>
                </div>
            </div>
        </div>

        <div class="span6 block2 box-header2">
            <h3>Employees</h3>

            <div class="panel panel-default">

                <div class="panel-body">
                    <div id="morris-donut-chart"></div>
                </div>
            </div>
        </div>
    </div>
    <?php
    /*$y = date('Y');
    for ($i = $y - 5; $i <= $y; $i++) {
        $condition = Yii::app()->user->hasState('company') ? ' and company_id=' . Yii::app()->user->getState('company') : '';
        $m++;
        $data[] = array('y' => (string) $i, 'a' => User::model()->count(array('condition' => 'year(hire_date)=' . $i . $condition)), 'b' => Timeoff::model()->count(array('condition' => 'year(date_created)=' . $i)));
    }*/
	$m_y=date('Y-m-');
	$data[]=array(
		'y'=>$m_y.'08', 
		'a'=>User::model()->count(array('condition' => 'id in (select user_id from tc_activity_log where DATE_FORMAT(time_in,"%Y-%m-%d") >= "' . $m_y . '01" and DATE_FORMAT(time_in,"%Y-%m-%d") <= "' . $m_y . '08")')),
		'b'=>User::model()->count(array('condition' => 'id not in (select user_id from tc_activity_log where DATE_FORMAT(time_in,"%Y-%m-%d") >= "' . $m_y . '01" and DATE_FORMAT(time_in,"%Y-%m-%d") <= "' . $m_y . '08")')));
	$data[]=array(
		'y'=>$m_y.'16', 
		'a'=>User::model()->count(array('condition' => 'id in (select user_id from tc_activity_log where DATE_FORMAT(time_in,"%Y-%m-%d") >= "' . $m_y . '09" and DATE_FORMAT(time_in,"%Y-%m-%d") <= "' . $m_y . '16")')),
		'b'=>User::model()->count(array('condition' => 'id not in (select user_id from tc_activity_log where DATE_FORMAT(time_in,"%Y-%m-%d") >= "' . $m_y . '09" and DATE_FORMAT(time_in,"%Y-%m-%d") <= "' . $m_y . '16")')));
	$data[]=array(
		'y'=>$m_y.'24', 
		'a'=>User::model()->count(array('condition' => 'id in (select user_id from tc_activity_log where DATE_FORMAT(time_in,"%Y-%m-%d") >= "' . $m_y . '17" and DATE_FORMAT(time_in,"%Y-%m-%d") <= "' . $m_y . '24")')),
		'b'=>User::model()->count(array('condition' => 'id not in (select user_id from tc_activity_log where DATE_FORMAT(time_in,"%Y-%m-%d") >= "' . $m_y . '17" and DATE_FORMAT(time_in,"%Y-%m-%d") <= "' . $m_y . '24")')));
	$data[]=array(
		'y'=>$m_y.'31', 
		'a'=>User::model()->count(array('condition' => 'id in (select user_id from tc_activity_log where DATE_FORMAT(time_in,"%Y-%m-%d") >= "' . $m_y . '25" and DATE_FORMAT(time_in,"%Y-%m-%d") <= "' . $m_y . '32")')),
		'b'=>User::model()->count(array('condition' => 'id not in (select user_id from tc_activity_log where DATE_FORMAT(time_in,"%Y-%m-%d") >= "' . $m_y . '25" and DATE_FORMAT(time_in,"%Y-%m-%d") <= "' . $m_y . '32")')));	
		
	for($i=1;$i<13;$i++){
		$mo_y=date('Y-').$i;
		$data2[]=array(
			'y'=>$mo_y, 
			'a'=>User::model()->count(array('condition' => 'id in (select user_id from tc_activity_log where DATE_FORMAT(time_in,"%Y-%m-%d") >= "' . $mo_y . '-01" and DATE_FORMAT(time_in,"%Y-%m-%d") <= "' . $mo_y . '-31")')),
			'b'=>User::model()->count(array('condition' => 'id not in (select user_id from tc_activity_log where DATE_FORMAT(time_in,"%Y-%m-%d") >= "' . $mo_y . '-01" and DATE_FORMAT(time_in,"%Y-%m-%d") <= "' . $mo_y . '-31")')));
	}
    ?>
    <script>
    	function changeView(val){
			$('#view1').removeClass('active');
			$('#view2').removeClass('active');
			$('#view'+val).addClass('active');
			$('#morris-line-chart1').hide();
			$('#morris-line-chart2').hide();
			$('#morris-line-chart'+val).show();
			$('#morris-line-chart'+val).css('opacity',1);
			$('#morris-line-chart'+val).css('position','relative');
		}
    </script>
    <script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/jquery.metisMenu.js"></script>
    <!-- MORRIS CHART SCRIPTS -->
    <script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/morris/raphael-2.1.0.min.js"></script>
    <script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/morris/morris.js"></script>
    <!-- CUSTOM SCRIPTS -->
    <script>
                        var active_users =<?= Yii::app()->user->hasState('company') ? User::model()->count(array('condition' => 'user_type=3 and company_id=' . Yii::app()->user->getState('company'))) : User::model()->count(array('condition' => 'user_type=3 and active=1')) ?>;
                        var inactive_users =<?= Yii::app()->user->hasState('company') ? User::model()->count(array('condition' => 'user_type=1 and company_id=' . Yii::app()->user->getState('company'))) : User::model()->count(array('condition' => 'user_type=1 and active=1')) ?>;
                        var data =<?= json_encode($data) ?>;
						var data2 =<?= json_encode($data2) ?>;
    </script>
    <script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/custom.js"></script>

    <div class="clear"></div>
</div>
<!-- END CONTENT -->
