<?php

$this->breadcrumbs = array(
    'Pay Periods' => array('index'),
    $model->name => array('view', 'id' => $model->id),
    'Update',
);

$this->menu = array(
    array('label' => Yii::t('translate', 'List PayPeriod'), 'url' => array('index')),
    array('label' => Yii::t('translate', 'Create PayPeriod'), 'url' => array('create')),
    array('label' => Yii::t('translate', 'View PayPeriod'), 'url' => array('view', 'id' => $model->id)),
);
?>

<?php $this->pageTitlecrumbs = Yii::t('translate', 'Update PayPeriod') . ' "' . $model->name . '"'; ?>
<?php echo $this->renderPartial('_form', array('model' => $model)); ?>