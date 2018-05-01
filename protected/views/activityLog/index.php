<?php
$this->breadcrumbs = array(
    'Time Entries' => array('index'),
    'Manage',
);

$this->menu = array(
    array('label' => Yii::t('translate', 'List Time Entries'), 'url' => array('index')),
    array('label' => Yii::t('translate', 'Create Time Entry'), 'url' => array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('activity-log-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<?php $this->pageTitlecrumbs = Yii::t('translate', 'Manage Time Entries'); ?>

<!--<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search', '#', array('class' => 'search-button btn')); ?>
<div class="search-form" style="display:none">
<?php
$this->renderPartial('_search', array(
    'model' => $model,
));
?>
</div><!-- search-form -->

<?php
if (Yii::app()->user->getState('usertype') == Yii::app()->params['Normal']) {
    $columns = array(
        'time_in' => array(
            'name' => 'time_in',
            'value' => '"<a href=\'' . Yii::app()->request->getBaseUrl(true) . '/activityLog/view/$data->id\'>".Timeoff::getTime($data->time_in)."</a>"',
            'type' => 'raw',
        ),
        'time_out' => array(
            'name' => 'time_out',
            'value' => 'Timeoff::getTime($data->time_out)'
        ),
        'status' => array(
            'name' => 'status',
            'value' => 'ActivityLog::ACLStatusValue($data->status,$data->id)',
            'filter' => ActivityLog::ACLStatusForm(),
            'type' => 'raw'
        ),
        //'comments',
        array(
            'class' => 'bootstrap.widgets.TbButtonColumn',
            'template' => '{view} {delete}'
        ),
    );
} elseif (Yii::app()->user->getState('usertype') == Yii::app()->params['subAdmin']) {
    $columns = array(
        'department_id' => array(
            'name' => 'department_id',
            'value' => '"<a href=\'' . Yii::app()->request->getBaseUrl(true) . '/activityLog/view/$data->id\'>".$data->department->name."</a>"',
            'type' => 'raw',
            'filter' => Helper::ListDepartment(),
        ),
        'user_id' => array(
            'name' => 'user_id',
            'value' => '$data->user->username',
            'filter' => Helper::ListEmployee()
        ),
        'time_in' => array(
            'name' => 'time_in',
            'value' => 'Timeoff::getTime($data->time_in)'
        ),
        'time_out' => array(
            'name' => 'time_out',
            'value' => 'Timeoff::getTime($data->time_out)'
        ),
        /*'status' => array(
            'name' => 'status',
            'value' => 'Timeoff::getStatus($data->status)',
            'filter' => array('0' => 'Pending', '1' => 'Approved', '2' => 'Declined')
        ),*/
        'status' => array(
            'name' => 'status',
            'value' => 'ActivityLog::ACLStatusValue($data->status,$data->id)',
            'filter' => ActivityLog::ACLStatusForm(),
            'type' => 'raw'
        ),
        array(
            'class' => 'bootstrap.widgets.TbButtonColumn',
        ),
    );
} else {
    $columns = array(
        'company_id' => array(
            'name' => 'company_id',
            'value' => '"<a href=\'' . Yii::app()->request->getBaseUrl(true) . '/activityLog/view/$data->id\'>".$data->company->name."</a>"',
            'type' => 'raw',
            'filter' => Helper::ListCompany()
        ),
        'department_id' => array(
            'name' => 'department_id',
            'value' => '$data->department->name',
            'filter' => Helper::ListDepartment()
        ),
        'user_id' => array(
            'name' => 'user_id',
            'value' => '$data->user->username',
            'filter' => Helper::ListEmployee()
        ),
        'time_in' => array(
            'name' => 'time_in',
            'value' => 'Timeoff::getTime($data->time_in)'
        ),
        'time_out' => array(
            'name' => 'time_out',
            'value' => 'Timeoff::getTime($data->time_out)'
        ),
        /*'status' => array(
            'name' => 'status',
            'value' => 'Timeoff::getStatus($data->status)',
            'filter' => array('0' => 'Pending', '1' => 'Approved', '2' => 'Declined')
        ),*/
        'status' => array(
            'name' => 'status',
            'value' => 'ActivityLog::ACLStatusValue($data->status,$data->id)',
            'filter' => ActivityLog::ACLStatusForm(),
            'type' => 'raw'
        ),
        array(
            'class' => 'bootstrap.widgets.TbButtonColumn',
        ),
    );
}

$this->widget('bootstrap.widgets.TbGridView', array(
    'id' => 'activity-log-grid',
    'type' => 'striped  condensed',
    'dataProvider' => $model->search(),
    'filter' => $model,
    'columns' => $columns,
));
?>
