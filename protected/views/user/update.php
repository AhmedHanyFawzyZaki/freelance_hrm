<?php

$this->breadcrumbs = array(
    'Users' => array('index'),
    $model->title => array('view', 'id' => $model->id),
    'Update',
);

$this->menu = array(
    array('label' => Yii::t('translate', 'List Employees'), 'url' => array('index')),
    array('label' => Yii::t('translate', 'Create Employee'), 'url' => array('create')),
    array('label' => Yii::t('translate', 'View Employee'), 'url' => array('view', 'id' => $model->id)),
);
?>
<?php

if ($model->company_id)
    $crum = $model->company->name . ' >> ';

if ($model->department_id)
    $crum.=$model->department->name . ' >> ';
?>

<?php $this->pageTitlecrumbs = $crum . ' "' . $model->username . '"'; ?>
<?php echo $this->renderPartial('_form', array('model' => $model, 'model_permission' => $model_permission)); ?>