<?php

$this->breadcrumbs = array(
    'Timeoffs' => array('index'),
    $model->id => array('view', 'id' => $model->id),
    'Update',
);

$this->menu = array(
    array('label' => Yii::t('translate', 'List Timeoff'), 'url' => array('index')),
    array('label' => Yii::t('translate', 'Create Timeoff'), 'url' => array('create')),
    array('label' => Yii::t('translate', 'View Timeoff'), 'url' => array('view', 'id' => $model->id)),
);
?>

<?php $this->pageTitlecrumbs = Yii::t('translate', 'Update Timeoff'); ?>
<?php echo $this->renderPartial('_form', array('model' => $model)); ?>