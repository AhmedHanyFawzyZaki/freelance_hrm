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
	\$model->{$nameColumn},
);\n";
?>

$this->menu=array(
	array('label'=>Yii::t('translate', 'List <?php echo $this->modelClass; ?>'),'url'=>array('index')),
	array('label'=>Yii::t('translate', 'Create <?php echo $this->modelClass; ?>'),'url'=>array('create')),
	array('label'=>Yii::t('translate', 'Update <?php echo $this->modelClass; ?>'),'url'=>array('update','id'=>$model-><?php echo $this->tableSchema->primaryKey; ?>)),
	array('label'=>Yii::t('translate', 'Delete <?php echo $this->modelClass; ?>'),'url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model-><?php echo $this->tableSchema->primaryKey; ?>),'confirm'=>'Are you sure you want to delete this item?')),
);
?>

<?php echo "<?php"; ?> $this->pageTitlecrumbs = Yii::t('translate', 'View <?php echo $this->modelClass."'). ' \"'.\$model->{$this->tableSchema->primaryKey}.'\"'; ?>"; ?>


<?php echo "<?php"; ?> $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
<?php
foreach($this->tableSchema->columns as $column)
if($column->name != 'id'){
	echo "\t\t'".$column->name."',\n";
}
?>
	),
)); ?>
