<?php
$this->breadcrumbs = array(
    'Faqs' => array('index'),
    'Manage',
);

if (Yii::app()->user->getState('usertype') == Yii::app()->params['Admin']) {
    $columns = array(
        'name'=>array(
            'name'=>'name',
            'value' => '"<a href=\''.Yii::app()->request->getBaseUrl(true).'/faq/view/$data->id\'>".$data->name."</a>"',
            'type'=>'raw',
        ),
        'description',
        array(
            'class' => 'bootstrap.widgets.TbButtonColumn',
        ),
    );

    $this->menu = array(
        array('label' => Yii::t('translate', 'List Faq'), 'url' => array('index')),
        array('label' => Yii::t('translate', 'Create Faq'), 'url' => array('create')),
    );
} else {
    $columns = array(
        'name'=>array(
            'name'=>'name',
            'value' => '"<a href=\''.Yii::app()->request->getBaseUrl(true).'/faq/view/$data->id\'>".$data->name."</a>"',
            'type'=>'raw',
        ),
        'description',
    );
}

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('faq-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<?php $this->pageTitlecrumbs = Yii::t('translate', 'Manage Faqs'); ?>

<!--<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search', '#', array('class' => 'search-button btn')); ?>
<div class="search-form" style="display:none">
<?php
$this->renderPartial('_search', array(
    'model' => $model,
));
?>
</div><!-- search-form -->

<?php
$this->widget('bootstrap.widgets.TbGridView', array(
    'id' => 'faq-grid',
    'type' => 'striped  condensed',
    'dataProvider' => $model->search(),
    'filter' => $model,
    'columns' => $columns,
));
?>
