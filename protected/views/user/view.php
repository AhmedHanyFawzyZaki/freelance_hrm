<?php
$this->breadcrumbs = array(
    'Users' => array('index'),
    $model->title,
);

$this->menu = array(
    array('label' => Yii::t('translate', 'List Employees'), 'url' => array('index')),
    array('label' => Yii::t('translate', 'Create Employee'), 'url' => array('create')),
    array('label' => Yii::t('translate', 'Update Employee'), 'url' => array('update', 'id' => $model->id)),
    array('label' => Yii::t('translate', 'Delete Employee'), 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->id), 'confirm' => 'Are you sure you want to delete this item?')),
);
?>

<?php
if ($model->company_id)
    $crum = $model->company->name . ' >> ';

if ($model->department_id)
    $crum.=$model->department->name . ' >> ';


//Yii::app()->request->urlReferrer
$back = '';
if (Yii::app()->user->getState('usertype') != Yii::app()->params['Normal'])
    $back = '" <a href="' . Yii::app()->request->getBaseUrl(true) . '/user" class="btn-small btn btn-info marginLeft50">Back</a>';
?>

<?php $this->pageTitlecrumbs = $crum . ' "' . $model->username . $back; ?>

<div class="well">
    <table class="table">
        <tr><th>(Paid) Vacation Credit</th><th>(Paid) Vacation Renewal Date</th><th>(Paid) Sick Leave Credit</th><th>(Paid) Sick Leave Renewal Date</th></tr>
        <tr><td><?= $model->vacation_credit ? $model->vacation_credit . ' Hours' : 'Not Allowed' ?></td>
            <td><?= $model->vacation_date ? date(Yii::app()->params['dateFormatPHP'], strtotime($model->vacation_date)) : 'Not Allowed' ?></td>
            <td><?= $model->sickleave_credit ? $model->sickleave_credit . ' Hours' : 'Not Allowed' ?></td>
            <td><?= $model->sickleave_date ? date(Yii::app()->params['dateFormatPHP'], strtotime($model->sickleave_date)) : 'Not Allowed' ?></td></tr>
    </table>
</div>

<?php
echo '<div class="well">';
$this->widget('bootstrap.widgets.TbDetailView', array(
    'data' => $model,
    'attributes' => array(
        'employee_id',
        'email' => array(
            'label' => 'Access email',
            'value' => $model->email != '' ? $model->email : User::NotSet('email', $model->id, 'access'),
            'type' => 'raw'
        ),
        'username',
        'user_type' => array(
            'name' => 'user_type',
            'value' => $model->userType->title
        ),
        'title' => array(
            'name' => 'title',
            'value' => $model->title != '' ? $model->title : User::NotSet('title', $model->id, 'optional'),
            'type' => 'raw'
        ),
        'hire_date',
        'image' => array(
            'name' => 'image',
            'value' => Helper::showImage($model->image, $model->username, $model->username, 'users', 'tiny', 'defaultUser.jpg'),
            'type' => 'raw'
        ),
        'active' => array(
            'name' => 'active',
            'value' => $model->active ? 'Yes' : 'No'
        ),
        //'url',
        'company_id' => array(
            'name' => 'company_id',
            'value' => $model->company->name
        ),
        'department_id' => array(
            'name' => 'department_id',
            'value' => $model->department->name
        ),
        'pay_rate',
        'checkinout_notification' => array(
            'name' => 'checkinout_notification',
            'value' => $model->checkinout_notification ? 'Yes' : 'No'
        ),
        'pay_rate_period' => array(
            'name' => 'pay_rate_period',
            'value' => $model->pay_rate_period != '' ? $model->payRatePeriod->name : User::NotSet('pay_rate_period', $model->id, 'optional'),
            'type' => 'raw'
        ),
        'checkinout_email' => array(
            'label' => 'checks-in or out email',
            'value' => $model->checkinout_email != '' ? $model->checkinout_email : User::NotSet('checkinout_email', $model->id, 'notif'),
            'type' => 'raw'
        ),
        'checkin_notification' => array(
            'name' => 'checkin_notification',
            'value' => $model->checkin_notification ? 'Yes' : 'No'
        ),
        'checkout_notification' => array(
            'name' => 'checkout_notification',
            'value' => $model->checkout_notification ? 'Yes' : 'No'
        ),
        'checkin_late_notification' => array(
            'name' => 'checkin_late_notification',
            'value' => $model->checkin_late_notification ? 'Yes' : 'No'
        ),
        'checkin_late_email' => array(
            'label' => 'checks-in late email',
            'value' => $model->checkin_late_email != '' ? $model->checkin_late_email : User::NotSet('checkin_late_email', $model->id, 'notif'),
            'type' => 'raw'
        ),
        'holiday_pay' => array(
            'name' => 'holiday_pay',
            'value' => $model->holiday_pay ? 'Yes' : 'No'
        ),
        'holiday_pay_period' => array(
            'name' => 'holiday_pay_period',
            'value' => $model->holiday_pay_period != '' ? Helper::RulesValue($model->holiday_pay_period) : User::NotSet('holiday_pay_period', $model->id, 'holiday'),
            'type' => 'raw'
        ),
        'overtime' => array(
            'name' => 'overtime',
            'value' => $model->overtime ? 'Yes' : 'No'
        ),
        'overtime_period' => array(
            'name' => 'overtime_period',
            'value' => $model->overtime_period != '' ? Helper::RulesValue($model->overtime_period) : User::NotSet('overtime_period', $model->id, 'overtime'),
            'type' => 'raw'
        ),
        'sick_leave' => array(
            'name' => 'sick_leave',
            'value' => $model->sick_leave ? 'Yes' : 'No'
        ),
        'sick_leave_period' => array(
            'name' => 'sick_leave_period',
            'value' => $model->sick_leave_period != '' ? Helper::RulesValue($model->sick_leave_period) : User::NotSet('sick_leave_period', $model->id, 'timeoff'),
            'type' => 'raw'
        ),
        'paid_timeoff' => array(
            'name' => 'paid_timeoff',
            'value' => $model->paid_timeoff ? 'Yes' : 'No',
        ),
        'paid_timeoff_period' => array(
            'name' => 'paid_timeoff_period',
            'value' => $model->paid_timeoff_period != '' ? Helper::RulesValue($model->paid_timeoff_period) : User::NotSet('paid_timeoff_period', $model->id, 'timeoff'),
            'type' => 'raw'
        ),
        'date_created',
    ),
));
echo '</div>';
$criteria = new CDbCriteria;
$criteria->condition = 'user_id=' . $model->id;
$criteria->order = 'id desc';
?>

<!--timesheets-->
<div >
    <header class="acc_col_head">
        <div class="icons"><i class="icon-bell"></i></div>
        <h5><?= Yii::t('translate', 'Timesheet') ?></h5>
        <div class="toolbar">
            <ul class="nav">
                <li class="widthAuto">
                    <a class="accordion-toggle minimize-box collapsed" data-toggle="collapse" href="#activityLog">
                        <i class="icon-chevron-down"></i>
                    </a>
                </li>
            </ul>
        </div>
    </header>

    <div id="activityLog" style="height: 0px;" class="collapse acc_col">
        <?php
        $this->widget('bootstrap.widgets.TbGridView', array(
            'id' => 'activity-log-grid',
            'dataProvider' => new CActiveDataProvider('ActivityLog', array(
                'criteria' => $criteria,
                    )),
            'columns' => array(
                'time_in' => array(
                    'name' => 'time_in',
                    'value' => 'Timeoff::getTime($data->time_in)'
                ),
                'time_out' => array(
                    'name' => 'time_out',
                    'value' => 'Timeoff::getTime($data->time_out)'
                ),
                'status' => array(
                    'name' => 'status',
                    'value' => 'ActivityLog::ACLStatusValue($data->status,$data->id)',
                    'type' => 'raw'
                ),
            ),
        ));
        ?>
    </div>
</div>

<!--time off-->
<div >
    <header class="acc_col_head">
        <div class="icons"><i class="icon-calendar-empty"></i></div>
        <h5><?= Yii::t('translate', 'Time Off') ?></h5>
        <div class="toolbar">
            <ul class="nav">
                <li class="widthAuto">
                    <a class="accordion-toggle minimize-box collapsed" data-toggle="collapse" href="#timeoff">
                        <i class="icon-chevron-down"></i>
                    </a>
                </li>
            </ul>
        </div>
    </header>

    <div id="timeoff" style="height: 0px;" class="collapse acc_col">
        <?php
        $this->widget('bootstrap.widgets.TbGridView', array(
            'id' => 'time-off-grid',
            'dataProvider' => new CActiveDataProvider('Timeoff', array(
                'criteria' => $criteria,
                    )),
            'columns' => array(
                'time_from' => array(
                    'name' => 'time_from',
                    'value' => 'Timeoff::getTime($data->time_from)'
                ),
                'time_to' => array(
                    'name' => 'time_to',
                    'value' => 'Timeoff::getTime($data->time_to)'
                ),
                'status' => array(
                    'name' => 'status',
                    'value' => 'Timeoff::getStatus($data->status)',
                ),
            ),
        ));
        ?>
    </div>
</div>

<!--Pay Rate history-->
<div >
    <header class="acc_col_head">
        <div class="icons"><i class="icon-dollar"></i></div>
        <h5><?= Yii::t('translate', 'Pay rate history') ?></h5>
        <div class="toolbar">
            <ul class="nav">
                <li class="widthAuto">
                    <a class="accordion-toggle minimize-box collapsed" data-toggle="collapse" href="#rate">
                        <i class="icon-chevron-down"></i>
                    </a>
                </li>
            </ul>
        </div>
    </header>

    <div id="rate" style="height: 0px;" class="collapse acc_col">
        <?php
        $this->widget('bootstrap.widgets.TbGridView', array(
            'id' => 'time-off-grid',
            'dataProvider' => new CActiveDataProvider('UserPayRateHistory', array(
                'criteria' => $criteria,
                    )),
            'columns' => array(
                'pay_rate',
                'pay_rate_period' => array(
                    'name' => 'pay_rate_period',
                    'value' => '$data->payRatePeriod->name'
                ),
                'date_updated'
            ),
        ));
        ?>
    </div>
</div>

<script>parent.jQuery.fancybox.close();</script>
