<?php
$this->breadcrumbs = array(
    'Activity Logs' => array('index'),
    $model->id,
);

$this->menu = array(
    array('label' => Yii::t('translate', 'List Time Entries'), 'url' => array('index')),
    array('label' => Yii::t('translate', 'Create Time Entry'), 'url' => array('create')),
    array('label' => Yii::t('translate', 'Time Correction'), 'url' => array('update', 'id' => $model->id)),
    array('label' => Yii::t('translate', 'Delete Time Entry'), 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->id), 'confirm' => 'Are you sure you want to delete this item?')),
);
?>

<?php $this->pageTitlecrumbs = Yii::t('translate', 'View Time Entry For') . ' "' . $model->user->username . '"'; ?>

<?php
echo '<div class="well">';
$this->widget('bootstrap.widgets.TbDetailView', array(
    'data' => $model,
    'attributes' => array(
        'user_id' => array(
            'name' => 'user_id',
            'value' => $model->user->username
        ),
        'status' => array(
            'name' => 'status',
            //'value' => Timeoff::getStatus($model->status) . ActivityLog::changeStatus($model->status, $model->id),
            'value' => ActivityLog::ACLStatusValue($model->status,$model->id),
            'type' => 'raw'
        ),
        'time_in' => array(
            'name' => 'time_in',
            'value' => Timeoff::getTime($model->time_in)
        ),
        'time_out' => array(
            'name' => 'time_out',
            'value' => Timeoff::getTime($model->time_out)
        ),
        array(
            'label' => 'Department',
            'value' => $model->user->department->name
        ),
        /* 'company_id' => array(
          'name' => 'company_id',
          'value' => $model->company->name
          ), */
        'comments',
    //'date_created',
    ),
));

echo '</div>';
$criteria = new CDbCriteria;
$criteria->condition = 'user_id=' . $model->user_id . ' and id!=' . $model->id;
$criteria->order = 'id desc';
?>


<!--timesheets-->
<div >
    <header class="acc_col_head">
        <div class="icons"><i class="icon-bell"></i></div>
        <h5><?= Yii::t('translate', 'Related Time Cards') ?></h5>
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

    <div id="activityLog" class="collapse in acc_col">
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
                /* 'status' => array(
                  'name' => 'status',
                  'value' => 'Timeoff::getStatus($data->status,1, "' . Yii::app()->request->getBaseUrl(true) . '/activityLog/update/' . $model->id . '?frame=1")',
                  'type' => 'raw'
                  ), */
                'status' => array(
                    'name' => 'status',
                    'value' => 'ActivityLog::ACLStatusValue($data->status,$data->id)',
                    'filter' => ActivityLog::ACLStatusForm(),
                    'type' => 'raw'
                ),
            ),
        ));
        ?>
    </div>
</div>