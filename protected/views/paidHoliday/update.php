<?php

$this->breadcrumbs = array(
    'Paid Holidays' => array('index'),
    $model->name => array('view', 'id' => $model->id),
    'Update',
);

$this->menu = array(
    array('label' => Yii::t('translate', 'List PaidHoliday'), 'url' => array('index')),
    array('label' => Yii::t('translate', 'Create PaidHoliday'), 'url' => array('create')),
    array('label' => Yii::t('translate', 'View PaidHoliday'), 'url' => array('view', 'id' => $model->id)),
);
?>

<?php $this->pageTitlecrumbs = Yii::t('translate', 'Update PaidHoliday') . ' "' . $model->name . '"'; ?>
<?php echo $this->renderPartial('_form', array('model' => $model)); ?>