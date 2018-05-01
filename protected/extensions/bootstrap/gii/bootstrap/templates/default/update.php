<?php
/**
 * The following variables are available in this template:
 * - $this: the BootCrudCode object
 */
?>
<?php
echo "<?php\n";
$nameColumn=$this->guessNameColumn($this->tableSchema->columns);
$label=$this->pluralize($this->class2name($this->modelClass));
echo "\$this->breadcrumbs=array(
	'$label'=>array('index'),
	\$model->{$nameColumn}=>array('view','id'=>\$model->{$this->tableSchema->primaryKey}),
	'Update',
);\n";
?>

$this->menu=array(
	array('label'=>Yii::t('translate', 'List <?php echo $this->modelClass; ?>'),'url'=>array('index')),
	array('label'=>Yii::t('translate', 'Create <?php echo $this->modelClass; ?>'),'url'=>array('create')),
	array('label'=>Yii::t('translate', 'View <?php echo $this->modelClass; ?>'),'url'=>array('view','id'=>$model-><?php echo $this->tableSchema->primaryKey; ?>)),
);
?>

<?php echo "<?php"; ?> $this->pageTitlecrumbs = Yii::t('translate', 'Update <?php echo $this->modelClass."'). ' \"'.\$model->{$this->tableSchema->primaryKey}.'\"'; ?>"; ?>

<?php echo "<?php echo \$this->renderPartial('_form',array('model'=>\$model)); ?>"; ?>