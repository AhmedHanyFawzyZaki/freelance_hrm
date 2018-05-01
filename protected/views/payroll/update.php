<?php
$this->breadcrumbs=array(
	'Payrolls'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>Yii::t('translate', 'List Payroll'),'url'=>array('index')),
	array('label'=>Yii::t('translate', 'Create Payroll'),'url'=>array('create')),
	array('label'=>Yii::t('translate', 'View Payroll'),'url'=>array('view','id'=>$model->id)),
);
?>

<?php $this->pageTitlecrumbs = Yii::t('translate', 'Update Payroll') . ' "' . $model->time_from . ' => ' . $model->time_to . '"'; ?>
<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>