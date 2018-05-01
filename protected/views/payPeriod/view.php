<?php

$this->breadcrumbs = array(
    'Pay Periods' => array('index'),
    $model->name,
);

$this->menu = array(
    array('label' => Yii::t('translate', 'List PayPeriod'), 'url' => array('index')),
    array('label' => Yii::t('translate', 'Create PayPeriod'), 'url' => array('create')),
    array('label' => Yii::t('translate', 'Update PayPeriod'), 'url' => array('update', 'id' => $model->id)),
    array('label' => Yii::t('translate', 'Delete PayPeriod'), 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->id), 'confirm' => 'Are you sure you want to delete this item?')),
);
?>

<?php $this->pageTitlecrumbs = Yii::t('translate', 'View PayPeriod') . ' "' . $model->name . '"'; ?>

<?php

if (Yii::app()->user->getState('usertype') != Yii::app()->params['Admin']) {
    $columns = array(
        'name',
        'period',
    );
} else {
    $columns = array(
        'name',
        'period',
        'company_id' => array(
            'name' => 'company_id',
            'value' => $model->company->name,
        ),
    );
}

$this->widget('bootstrap.widgets.TbDetailView', array(
    'data' => $model,
    'attributes' => $columns,
));
?>