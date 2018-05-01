<?php

$this->breadcrumbs = array(
    'Payrolls' => array('index'),
    $model->id,
);

$this->menu = array(
    array('label' => Yii::t('translate', 'List Payroll'), 'url' => array('index')),
    array('label' => Yii::t('translate', 'Create Payroll'), 'url' => array('create')),
    array('label' => Yii::t('translate', 'Update Payroll'), 'url' => array('update', 'id' => $model->id)),
    array('label' => Yii::t('translate', 'Delete Payroll'), 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->id), 'confirm' => 'Are you sure you want to delete this item?')),
);
?>

<?php $this->pageTitlecrumbs = Yii::t('translate', 'View Payroll') . ' "' . $model->time_from . ' => ' . $model->time_to . '"'; ?>

<?php

$this->widget('application.extensions.fancybox.EFancyBox', array(
    'target' => '.sFancy',
    'config' => array(
        'target' => '.sFancy'
    )
));


echo '<div class="well">';
$this->widget('bootstrap.widgets.TbDetailView', array(
    'data' => $model,
    'attributes' => array(
        'time_from' => array(
            'name' => 'time_from',
            'value' => Timeoff::getTime($model->time_from)
        ),
        'time_to' => array(
            'name' => 'time_to',
            'value' => Timeoff::getTime($model->time_to)
        ),
        'status' => array(
            'name' => 'status',
            'value' => Timeoff::getStatus($model->status),
        ),
        'user_id' => array(
            'name' => 'user_id',
            'value' => $model->user->username
        ),
    //'date_created',
    ),
));
echo '</div>';
$offs = Timeoff::model()->findAllByAttributes(array('payroll_id' => $model->id, 'status' => 0));
$times = ActivityLog::model()->findAllByAttributes(array('payroll_id' => $model->id, 'status' => 0));

if (($offs || $times)) {
    echo '<div class="well">';
    if ($offs) {
        echo '
        <div class="well">
            <div class="alert alert-danger">
                <i class="icon-info-sign"></i> Please investigate the following <i><strong>time off requests</i></strong> in order to be able to print this payroll timesheets.
            </div>
            <table class="table">
                <tr><th>Employee Name</th><th>From</th><th>To</th><th>Action</th></tr>';
        foreach ($offs as $toff) {
            echo '<tr><td>' . $toff->user->username . '</td><td>' . Timeoff::getTime($toff->time_from) . '</td><td>' . Timeoff::getTime($toff->time_to) . '
                    </td><td><a href="' . Yii::app()->request->getBaseUrl(true) . '/timeoff/update/' . $toff->id . '?frame=1" class="s_frame" title="Update"><i class="icon-tags"></i></a></td></tr>';
        }
        echo '
            </table>
        </div>';
    }
    if ($times) {
        echo '
        <div class="well">
            <div class="alert alert-danger">
                <i class="icon-info-sign"></i> Please investigate the following <i><strong>time activities</strong></i> in order to be able to print this payroll timesheets.
            </div>
            <table class="table">
                <tr><th>Employee Name</th><th>In</th><th>Out</th><th>Action</th></tr>';
        foreach ($times as $toff) {
            echo '<tr><td>' . $toff->user->username . '</td><td>' . Timeoff::getTime($toff->time_in) . '</td><td>' . Timeoff::getTime($toff->time_out) . '
                    </td><td><a href="' . Yii::app()->request->getBaseUrl(true) . '/activityLog/update/' . $toff->id . '?frame=1" class="s_frame" title="Update"><i class="icon-tags"></i></a></td></tr>';
        }
        echo '
            </table>
        </div>';
    }
    echo '<a href="' . Yii::app()->request->getBaseUrl(true) . '/payroll/generate/' . $model->id . '" class="btn btn-success marginleft10">Approve & Proceed</a>
        </div>';
} else {
    echo '
        <div class="well">
            <div class="alert alert-success">
                <i class="icon-info-sign"></i> We see you are getting ready to print this payroll timesheets.
                <a href="' . Yii::app()->request->getBaseUrl(true) . '/payroll/generate/' . $model->id . '" class="btn btn-success marginleft10">Proceed</a>
            </div>
        </div>';
}
?>
