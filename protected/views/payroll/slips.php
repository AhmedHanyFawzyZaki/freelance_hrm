<?php
$this->breadcrumbs = array(
    'Payrolls' => array('index'),
    'Manage',
);

$this->menu = array(
    array('label' => Yii::t('translate', 'List Pay Slips'), 'url' => array('slip')),
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

<?php $this->pageTitlecrumbs = Yii::t('translate', 'My Pay Slips'); ?>

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
        'time_from'=>array(
            'name'=>'time_from',
            'value'=>'Timeoff::getTime($data->time_from)'
        ),
        'time_to'=>array(
            'name'=>'time_to',
            'value'=>'Timeoff::getTime($data->time_to)'
        ),
        /*'user_id' => array(
            'name' => 'user_id',
            'value' => '$data->user->username',
            'filter' => Helper::ListEmployee()
        ),*/
        //'date_created',
        array(
            'class' => 'bootstrap.widgets.TbButtonColumn',
            'template'=>'{view}',
            'buttons'=>array(
                'view'=>array(
                    'url'=>'"slip?num=".$data->id'
                )
            )
        ),
    ),
));
?>
