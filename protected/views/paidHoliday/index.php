<?php
$this->breadcrumbs = array(
    'Paid Holidays' => array('index'),
    'Manage',
);

$this->menu = array(
    array('label' => Yii::t('translate', 'List PaidHoliday'), 'url' => array('index')),
    array('label' => Yii::t('translate', 'Create PaidHoliday'), 'url' => array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('paid-holiday-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<?php $this->pageTitlecrumbs = Yii::t('translate', 'Manage Paid Holidays'); ?>

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
if (Yii::app()->user->getState('usertype') != Yii::app()->params['Admin']) {
    $columns = array(
        'name'=>array(
            'name'=>'name',
            'value' => '"<a href=\''.Yii::app()->request->getBaseUrl(true).'/paidHoliday/view/$data->id\'>".$data->name."</a>"',
            'type'=>'raw',
        ),
        'month',
        'day',
        array(
            'class' => 'bootstrap.widgets.TbButtonColumn',
        ),
    );
} else {
    $columns = array(
        'name'=>array(
            'name'=>'name',
            'value' => '"<a href=\''.Yii::app()->request->getBaseUrl(true).'/paidHoliday/view/$data->id\'>".$data->name."</a>"',
            'type'=>'raw',
        ),
        'month',
        'day',
        'company_id' => array(
            'name' => 'company_id',
            'value' => '$data->company->name',
            'filter' => Helper::ListCompany()
        ),
        array(
            'class' => 'bootstrap.widgets.TbButtonColumn',
        ),
    );
}

$this->widget('bootstrap.widgets.TbGridView', array(
    'id' => 'paid-holiday-grid',
    'type' => 'striped  condensed',
    'dataProvider' => $model->search(),
    'filter' => $model,
    'columns' => $columns,
));
?>
