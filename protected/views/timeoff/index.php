<?php
$this->breadcrumbs = array(
    'Timeoffs' => array('index'),
    'Manage',
);

$this->menu = array(
    array('label' => Yii::t('translate', 'List Timeoff'), 'url' => array('index')),
    array('label' => Yii::t('translate', 'Create Timeoff'), 'url' => array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('timeoff-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<?php $this->pageTitlecrumbs = Yii::t('translate', 'Manage Timeoffs'); ?>

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
$crit = '';
if (Yii::app()->user->hasState('company')) {
    $crit = new CDbCriteria;
    $crit->condition = 'company_id=' . Yii::app()->user->getState('company');
}
if (Yii::app()->user->getState('usertype') == Yii::app()->params['Normal']) {
    $columns = array(
        //'id',
        'time_from' => array(
            'name' => 'time_from',
            'value' => '"<a href=\'' . Yii::app()->request->getBaseUrl(true) . '/timeoff/view/$data->id\'>".Timeoff::getTime($data->time_from)."</a>"',
            'type' => 'raw',
        ),
        'time_to' => array(
            'name' => 'time_to',
            'value' => 'Timeoff::getTime($data->time_to)'
        ),
        'status' => array(
            'name' => 'status',
            'value' => 'Timeoff::getStatus($data->status)',
            'filter' => array('0' => 'Pending', '1' => 'Approved', '2' => 'Declined')
        ),
        'request_type' => array(
            'name' => 'request_type',
            'value' => '$data->requestType->name',
            'filter' => CHtml::listData(RequestType::model()->findAll($crit), 'id', 'name'),
        ),
        'comments',
        /*
          'date_created',
          'payroll_id',
          'employee_approval',
          'company_id',
          'request_type',
         */
        array(
            'class' => 'bootstrap.widgets.TbButtonColumn',
        ),
    );
} elseif (Yii::app()->user->getState('usertype') == Yii::app()->params['subAdmin']) {
    $columns = array(
        //'id',

        'time_from' => array(
            'name' => 'time_from',
            'value' => '"<a href=\'' . Yii::app()->request->getBaseUrl(true) . '/timeoff/view/$data->id\'>".Timeoff::getTime($data->time_from)."</a>"',
            'type' => 'raw',
        ),
        'time_to' => array(
            'name' => 'time_to',
            'value' => 'Timeoff::getTime($data->time_to)'
        ),
        'user_id' => array(
            'name' => 'user_id',
            'value' => '$data->user->username',
            'filter' => Helper::ListEmployee()
        ),
        'status' => array(
            'name' => 'status',
            'value' => 'Timeoff::getStatus($data->status)',
            'filter' => array('0' => 'Pending', '1' => 'Approved', '2' => 'Declined')
        ),
        'request_type' => array(
            'name' => 'request_type',
            'value' => '$data->requestType->name',
            'filter' => CHtml::listData(RequestType::model()->findAll($crit), 'id', 'name'),
        ),
        /*
          'date_created',
          'payroll_id',
          'employee_approval',
          'company_id',
          'request_type',
         */
        array(
            'class' => 'bootstrap.widgets.TbButtonColumn',
        ),
    );
} else {
    $columns = array(
        //'id',

        'time_from' => array(
            'name' => 'time_from',
            'value' => '"<a href=\'' . Yii::app()->request->getBaseUrl(true) . '/timeoff/view/$data->id\'>".Timeoff::getTime($data->time_from)."</a>"',
            'type' => 'raw',
        ),
        'time_to' => array(
            'name' => 'time_to',
            'value' => 'Timeoff::getTime($data->time_to)'
        ),
        'company_id' => array(
            'name' => 'company_id',
            'value' => '$data->company->name',
            'filter' => Helper::ListCompany()
        ),
        'user_id' => array(
            'name' => 'user_id',
            'value' => '$data->user->username',
            'filter' => Helper::ListEmployee()
        ),
        'status' => array(
            'name' => 'status',
            'value' => 'Timeoff::getStatus($data->status)',
            'filter' => array('0' => 'Pending', '1' => 'Approved', '2' => 'Declined')
        ),
        'request_type' => array(
            'name' => 'request_type',
            'value' => '$data->requestType->name',
            'filter' => CHtml::listData(RequestType::model()->findAll($crit), 'id', 'name'),
        ),
        /*
          'date_created',
          'payroll_id',
          'employee_approval',
          'company_id',
          'request_type',
         */
        array(
            'class' => 'bootstrap.widgets.TbButtonColumn',
        ),
    );
}

$this->widget('bootstrap.widgets.TbGridView', array(
    'id' => 'timeoff-grid',
    'type' => 'striped  condensed',
    'dataProvider' => $model->search(),
    'filter' => $model,
    'columns' => $columns,
));
?>
 