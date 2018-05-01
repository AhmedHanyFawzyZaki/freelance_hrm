<?php
$this->breadcrumbs = array(
    'Timeoffs' => array('index'),
    $model->id,
);

$this->menu = array(
    array('label' => Yii::t('translate', 'List Timeoff'), 'url' => array('index')),
    array('label' => Yii::t('translate', 'Create Timeoff'), 'url' => array('create')),
    array('label' => Yii::t('translate', 'Update Timeoff'), 'url' => array('update', 'id' => $model->id)),
    array('label' => Yii::t('translate', 'Delete Timeoff'), 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->id), 'confirm' => 'Are you sure you want to delete this item?')),
);
?>

<?php $this->pageTitlecrumbs = Yii::t('translate', 'View Timeoff'); ?>

<div id="msg" style="width:100%; display:table;">
</div>
<script>
    $(document).ready(function () {
        calculate();
    });

    function calculate() {
        var from = "<?= $model->time_from ?>";
        var to = "<?= $model->time_to ?>";
        var user = "<?= $model->user_id ?>";
        var request = "<?= $model->request_type ?>";
        if (from != '' && to != '' && user != '' && request != '') {
            $.ajax({
                url: '<?= Yii::app()->request->getBaseUrl(true); ?>/timeoff/calculate',
                data: {from: from, to: to, user: user, request: request},
                type: 'POST',
                success: function (data) {
                    $('#msg').html(data);
                }
            });
        }
    }
</script>
<br>
<div class="well">
    <?php
    $this->widget('bootstrap.widgets.TbDetailView', array(
        'data' => $model,
        'attributes' => array(
            'user_id' => array(
                'name' => 'user_id',
                'value' => $model->user->username
            ),
            array(
                'label' => 'Department',
                'value' => $model->user->department->name
            ),
            'time_from' => array(
                'name' => 'time_from',
                'value' => Timeoff::getTime($model->time_from),
            ),
            'request_type' => array(
                'name' => 'request_type',
                'value' => $model->requestType->name,
            ),
            'time_to' => array(
                'name' => 'time_to',
                'value' => Timeoff::getTime($model->time_to),
            ),
            'status' => array(
                'name' => 'status',
                'value' => Timeoff::getStatus($model->status) . Timeoff::changeStatus($model->status, $model->id),
                'type' => 'raw'
            ),
            /* 'company_id' => array(
              'name' => 'company_id',
              'value' => $model->company->name
              ), */
            'comments',
        //'date_created',
        ),
    ));
    ?>
</div>
