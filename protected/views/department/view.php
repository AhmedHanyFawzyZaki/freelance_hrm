<?php

$this->breadcrumbs = array(
    'Departments' => array('index'),
    $model->name,
);

$this->menu = array(
    array('label' => Yii::t('translate', 'List Department'), 'url' => array('index')),
    array('label' => Yii::t('translate', 'Create Department'), 'url' => array('create')),
    array('label' => Yii::t('translate', 'Update Department'), 'url' => array('update', 'id' => $model->id)),
    array('label' => Yii::t('translate', 'Delete Department'), 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->id), 'confirm' => 'Are you sure you want to delete this item?')),
);

//Yii::app()->request->urlReferrer
?>

<?php $this->pageTitlecrumbs = Yii::t('translate', 'View Department') . ' "' . $model->name . '" <a href="' . Yii::app()->request->getBaseUrl(true) . '/department" class="btn-small btn btn-info marginLeft50">Back</a>'; ?>

<?php

if (Yii::app()->user->getState('usertype') == Yii::app()->params['Admin']) {
    $attr = array(
        'name',
        'code',
        'in_time',
        'out_time',
        'company_id' => array(
            'name' => 'company_id',
            'value' => $model->company->name
        ),
    );
} else {
    $attr = array(
        'name',
        'code',
        'in_time',
        'out_time',
    );
}
$this->widget('bootstrap.widgets.TbDetailView', array(
    'data' => $model,
    'attributes' => $attr,
));
?>
