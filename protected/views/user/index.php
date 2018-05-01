<?php
$this->breadcrumbs = array(
    'Employees' => array('index'),
    'Manage',
);

$this->menu = array(
    array('label' => Yii::t('translate', 'List Employees'), 'url' => array('index')),
    array('label' => Yii::t('translate', 'Create Employee'), 'url' => array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('user-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<?php $this->pageTitlecrumbs = Yii::t('translate', 'Manage Employees'); ?>

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
if (Yii::app()->user->hasState('company')) {
    $column = array(
        //'id',
        'name' => array(
            'name' => 'username',
            'value' => '"<a href=\'' . Yii::app()->request->getBaseUrl(true) . '/user/view/$data->id\'>".$data->username."</a>"',
            'type' => 'raw',
        ),
        'employee_id',
        'title',
        'hire_date',
        'email',
        'department_id' => array(
            'name' => 'department_id',
            'value' => '$data->department->name',
            'filter' => Helper::ListDepartment()
        ),
        /*
          'image',
          'user_type',
          'date_created',
          'url',
          'active',
          'company_id',
          'department_id',
          'pay_rate',
          'pay_rate_period',
          'checkinout_notification',
          'checkinout_email',
          'checkin_notification',
          'checkout_notification',
          'checkin_late_notification',
          'checkin_late_email',
          'holiday_pay',
          'holiday_pay_period',
          'overtime',
          'overtime_period',
          'sick_leave',
          'sick_leave_period',
          'paid_timeoff',
          'paid_timeoff_period',
         */
        array(
            'class' => 'bootstrap.widgets.TbButtonColumn',
        ),
    );
} else {
    $column = array(
        //'id',
        'name' => array(
            'name' => 'username',
            'value' => '"<a href=\'' . Yii::app()->request->getBaseUrl(true) . '/user/view/$data->id\'>".$data->username."</a>"',
            'type' => 'raw',
        ),
        'employee_id',
        'hire_date',
        'user_type' => array(
            'name' => 'user_type',
            'value' => '$data->userType->title',
            'filter' => CHtml::listData(UserType::model()->findAll(), 'id', 'title')
        ),
        'company_id' => array(
            'name' => 'company_id',
            'value' => '$data->company->name',
            'filter' => Helper::ListCompany()
        ),
        'department_id' => array(
            'name' => 'department_id',
            'value' => '$data->department->name',
            'filter' => Helper::ListDepartment()
        ),
        array(
            'class' => 'bootstrap.widgets.TbButtonColumn',
        ),
    );
}

$this->widget('bootstrap.widgets.TbGridView', array(
    'id' => 'user-grid',
    'type' => 'striped  condensed',
    'dataProvider' => $model->search(),
    'filter' => $model,
    'columns' => $column,
));
?>
