<?php

$this->breadcrumbs = array(
    'Request Types' => array('index'),
    $model->name => array('view', 'id' => $model->id),
    'Update',
);

$this->menu = array(
    array('label' => Yii::t('translate', 'List RequestType'), 'url' => array('index')),
    array('label' => Yii::t('translate', 'Create RequestType'), 'url' => array('create')),
    array('label' => Yii::t('translate', 'View RequestType'), 'url' => array('view', 'id' => $model->id)),
);
?>

<?php $this->pageTitlecrumbs = Yii::t('translate', 'Update RequestType') . ' "' . $model->name . '"'; ?>
<?php echo $this->renderPartial('_form', array('model' => $model)); ?>