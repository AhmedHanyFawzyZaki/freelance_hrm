<?php
$this->breadcrumbs=array(
	'User Pay Rate Histories'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>Yii::t('translate', 'List UserPayRateHistory'),'url'=>array('index')),
	array('label'=>Yii::t('translate', 'Create UserPayRateHistory'),'url'=>array('create')),
	array('label'=>Yii::t('translate', 'Update UserPayRateHistory'),'url'=>array('update','id'=>$model->id)),
	array('label'=>Yii::t('translate', 'Delete UserPayRateHistory'),'url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
);
?>

<?php $this->pageTitlecrumbs = Yii::t('translate', 'View UserPayRateHistory'). ' "'.$model->id.'"'; ?>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'user_id',
		'pay_rate',
		'pay_rate_period',
	),
)); ?>
