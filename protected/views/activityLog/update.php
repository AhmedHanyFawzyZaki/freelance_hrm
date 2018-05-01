<?php

$this->breadcrumbs = array(
    'Activity Logs' => array('index'),
    $model->id => array('view', 'id' => $model->id),
    'Update',
);

$this->menu = array(
    array('label' => Yii::t('translate', 'List Time Entries'), 'url' => array('index')),
    array('label' => Yii::t('translate', 'Create Time Entry'), 'url' => array('create')),
    array('label' => Yii::t('translate', 'View Time Entry'), 'url' => array('view', 'id' => $model->id)),
);
?>

<?php $this->pageTitlecrumbs = Yii::t('translate', 'Time Correction For') . ' "' . $model->user->username . '"'; ?>
<?php echo $this->renderPartial('_form', array('model' => $model)); ?>