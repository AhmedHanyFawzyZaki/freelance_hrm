<?php

$this->breadcrumbs = array(
    'Paid Holidays' => array('index'),
    $model->name,
);

$this->menu = array(
    array('label' => Yii::t('translate', 'List PaidHoliday'), 'url' => array('index')),
    array('label' => Yii::t('translate', 'Create PaidHoliday'), 'url' => array('create')),
    array('label' => Yii::t('translate', 'Update PaidHoliday'), 'url' => array('update', 'id' => $model->id)),
    array('label' => Yii::t('translate', 'Delete PaidHoliday'), 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->id), 'confirm' => 'Are you sure you want to delete this item?')),
);
?>

<?php $this->pageTitlecrumbs = Yii::t('translate', 'View PaidHoliday') . ' "' . $model->name . '"'; ?>

<?php

if (Yii::app()->user->getState('usertype') != Yii::app()->params['Admin']) {
    $columns = array(
        'name',
        'month',
        'day',
    );
} else {
    $columns = array(
        'name',
        'month',
        'day',
        'company_id' => array(
            'name' => 'company_id',
            'value' => $model->company->name,
        ),
    );
}

$this->widget('bootstrap.widgets.TbDetailView', array(
    'data' => $model,
    'attributes' => $columns
));
?>
