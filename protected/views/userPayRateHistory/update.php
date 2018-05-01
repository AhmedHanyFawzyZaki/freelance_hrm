<?php
$this->breadcrumbs=array(
	'User Pay Rate Histories'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>Yii::t('translate', 'List UserPayRateHistory'),'url'=>array('index')),
	array('label'=>Yii::t('translate', 'Create UserPayRateHistory'),'url'=>array('create')),
	array('label'=>Yii::t('translate', 'View UserPayRateHistory'),'url'=>array('view','id'=>$model->id)),
);
?>

<?php $this->pageTitlecrumbs = Yii::t('translate', 'Update UserPayRateHistory'). ' "'.$model->id.'"'; ?>
<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>