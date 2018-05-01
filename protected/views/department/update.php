<?php

$this->breadcrumbs = array(
    'Departments' => array('index'),
    $model->name => array('view', 'id' => $model->id),
    'Update',
);

$this->menu = array(
    array('label' => Yii::t('translate', 'List Department'), 'url' => array('index')),
    array('label' => Yii::t('translate', 'Create Department'), 'url' => array('create')),
    array('label' => Yii::t('translate', 'View Department'), 'url' => array('view', 'id' => $model->id)),
);
?>

<?php $this->pageTitlecrumbs = Yii::t('translate', 'Update Department') . ' "' . $model->name . '"'; ?>
<?php echo $this->renderPartial('_form', array('model' => $model)); ?>