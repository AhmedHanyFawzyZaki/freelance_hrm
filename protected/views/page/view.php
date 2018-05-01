<?php

$this->breadcrumbs = array(
    'Pages' => array('index'),
    $model->title,
);

$this->menu = array(
    array('label' => Yii::t('translate', 'List Page'), 'url' => array('index')),
    array('label' => Yii::t('translate', 'Create Page'), 'url' => array('create')),
    array('label' => Yii::t('translate', 'Update Page'), 'url' => array('update', 'id' => $model->id)),
    array('label' => Yii::t('translate', 'Delete Page'), 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->id), 'confirm' => 'Are you sure you want to delete this item?')),
);
?>

<?php $this->pageTitlecrumbs = Yii::t('translate', 'View Page') . ' "' . $model->id . '"'; ?>

<?php

$this->widget('bootstrap.widgets.TbDetailView', array(
    'data' => $model,
    'attributes' => array(
        'title',
        'details' => array(
            'name' => 'details',
            'value' => $model->details,
            'type' => 'raw'
        ),
    ),
));
?>
