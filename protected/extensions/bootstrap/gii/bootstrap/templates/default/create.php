<?php
/**
 * The following variables are available in this template:
 * - $this: the BootCrudCode object
 */
?>
<?php
echo "<?php\n";
$label=$this->pluralize($this->class2name($this->modelClass));
echo "\$this->breadcrumbs=array(
	'$label'=>array('index'),
	'Create',
);\n";
?>

$this->menu=array(
	array('label'=>Yii::t('translate', 'List <?php echo $this->modelClass; ?>'),'url'=>array('index')),
);
?>

<?php echo "<?php"; ?> $this->pageTitlecrumbs = Yii::t('translate', 'Create <?php echo $this->modelClass;?>');?>

<?php echo "<?php echo \$this->renderPartial('_form', array('model'=>\$model)); ?>"; ?>
