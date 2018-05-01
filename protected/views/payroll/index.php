<?php
$this->breadcrumbs = array(
    'Payrolls' => array('index'),
    'Manage',
);

$this->menu = array(
    array('label' => Yii::t('translate', 'List Payroll'), 'url' => array('index')),
    array('label' => Yii::t('translate', 'Create Payroll'), 'url' => array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('payroll-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<?php $this->pageTitlecrumbs = Yii::t('translate', 'Manage Payrolls'); ?>

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
$this->widget('bootstrap.widgets.TbGridView', array(
    'id' => 'payroll-grid',
    'type' => 'striped  condensed',
    'dataProvider' => $model->search(),
    'filter' => $model,
    'columns' => array(
        /* 'company_id' => array(
          'name' => 'company_id',
          'value' => '"<a href=\'' . Yii::app()->request->getBaseUrl(true) . '/payroll/view/$data->id\'>".$data->company->name."</a>"',
          'type' => 'raw',
          'filter' => Helper::ListCompany()
          ), */
        'time_from' => array(
            'name' => 'time_from',
            'value' => '"<a href=\'' . Yii::app()->request->getBaseUrl(true) . '/payroll/view/$data->id\'>".Timeoff::getTime($data->time_from)."</a>"',
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
        'user_id' => array(
            'name' => 'user_id',
            'value' => '$data->user->username',
            'filter' => Helper::ListEmployee()
        ),
        //'date_created',
        array(
            'class' => 'bootstrap.widgets.TbButtonColumn',
        ),
    ),
));
?>
