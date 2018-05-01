<?php
$this->breadcrumbs=array(
	'System Logs'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>Yii::t('translate', 'List SystemLog'),'url'=>array('index')),
	array('label'=>Yii::t('translate', 'Create SystemLog'),'url'=>array('create')),
	array('label'=>Yii::t('translate', 'View SystemLog'),'url'=>array('view','id'=>$model->id)),
);
?>

<?php $this->pageTitlecrumbs = Yii::t('translate', 'Update SystemLog'). ' "'.$model->id.'"'; ?>
<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>