<?php

$this->breadcrumbs = array(
    'Request Types' => array('index'),
    $model->name,
);

$this->menu = array(
    array('label' => Yii::t('translate', 'List RequestType'), 'url' => array('index')),
    array('label' => Yii::t('translate', 'Create RequestType'), 'url' => array('create')),
    array('label' => Yii::t('translate', 'Update RequestType'), 'url' => array('update', 'id' => $model->id)),
    array('label' => Yii::t('translate', 'Delete RequestType'), 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->id), 'confirm' => 'Are you sure you want to delete this item?')),
);
?>

<?php $this->pageTitlecrumbs = Yii::t('translate', 'View RequestType') . ' "' . $model->name . '"'; ?>

<?php

if (Yii::app()->user->getState('usertype') != Yii::app()->params['Admin']) {
    $columns = array(
        'name',
        'paid' => array(
            'name' => 'paid',
            'value' => $model->paid ? "Yes" : "No",
        ),
        'vacation_sick_leave' => array(
            'name' => 'vacation_sick_leave',
            'value' => $model->vacation_sick_leave ? "Sick Leave" : "Vacation",
        ),
    );
} else {
    $columns = array(
        'name',
        'paid' => array(
            'name' => 'paid',
            'value' => $model->paid ? "Yes" : "No",
        ),
        'vacation_sick_leave' => array(
            'name' => 'vacation_sick_leave',
            'value' => $model->vacation_sick_leave ? "Sick Leave" : "Vacation",
        ),
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
