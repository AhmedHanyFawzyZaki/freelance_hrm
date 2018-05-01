<?php

$this->breadcrumbs = array(
    'Faqs' => array('index'),
    $model->name => array('view', 'id' => $model->id),
    'Update',
);

$this->menu = array(
    array('label' => Yii::t('translate', 'List Faq'), 'url' => array('index')),
    array('label' => Yii::t('translate', 'Create Faq'), 'url' => array('create')),
    array('label' => Yii::t('translate', 'View Faq'), 'url' => array('view', 'id' => $model->id)),
);
?>

<?php $this->pageTitlecrumbs = Yii::t('translate', 'Update Faq') . ' "' . $model->name . '"'; ?>
<?php echo $this->renderPartial('_form', array('model' => $model)); ?>