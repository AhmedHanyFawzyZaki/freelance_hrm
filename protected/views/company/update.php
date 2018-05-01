<?php

$this->breadcrumbs = array(
    'Companies' => array('index'),
    $model->name => array('view', 'id' => $model->id),
    'Update',
);

$this->menu = array(
    array('label' => Yii::t('translate', 'List Company'), 'url' => array('index')),
    array('label' => Yii::t('translate', 'Create Company'), 'url' => array('create')),
    array('label' => Yii::t('translate', 'View Company'), 'url' => array('view', 'id' => $model->id)),
);
?>

<?php $this->pageTitlecrumbs = Yii::t('translate', 'Update Company') . ' "' . $model->name . '"'; ?>
<?php echo $this->renderPartial('_form', array('model' => $model, 'model_expansion' => $model_expansion)); ?>