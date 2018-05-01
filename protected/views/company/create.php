<?php

$this->breadcrumbs = array(
    'Companies' => array('index'),
    'Create',
);

$this->menu = array(
    array('label' => Yii::t('translate', 'List Company'), 'url' => array('index')),
);
?>

<?php $this->pageTitlecrumbs = Yii::t('translate', 'Create Company'); ?>

<?php echo $this->renderPartial('_form', array('model' => $model, 'model_expansion' => $model_expansion)); ?>