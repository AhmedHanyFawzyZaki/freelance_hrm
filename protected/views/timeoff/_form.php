<div id="msg" style="width:100%; display:<?= strtolower(Yii::app()->controller->id) == 'dashboard' ? 'none' : 'table' ?>;">
</div>

<?php
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id' => 'timeoff-form',
    'enableAjaxValidation' => false,
    'type' => strtolower(Yii::app()->controller->id) == 'dashboard' ? 'vertical' : 'horizontal',
        ));
?>

        <!--<p class="help-block">Fields with <span class="required">*</span> are required.</p>-->

<?php echo $form->errorSummary($model); ?>

<label class="clear text-center checkbox dis_tab marginmiddle" onclick="calculate()">
    <input type="checkbox" id="allDay" name="allday" value="1"> All Day
</label>
<br>

<div class="control-group ">
    <?php echo $form->labelEx($model, 'time_from', array('class' => 'control-label')) ?>
    <div class="controls">
        <?php
        $this->widget('application.extensions.CJuiDateTimePicker.CJuiDateTimePicker', array(
            'model' => $model, //Model object
            'attribute' => 'time_from', //attribute name
            'language' => '',
            'mode' => 'datetime', //use "time","date" or "datetime" (default)
            'options' => array(
                "dateFormat" => Yii::app()->params['dateFormatJS'],
                'changeMonth' => 'true',
                'changeYear' => 'true',
                'showOtherMonths' => true, // Show Other month in jquery
                'showButtonPanel' => true,
                'showOn' => 'both',
                'buttonText' => '<i class="icon-calendar" style="display: table; padding: 5.6px 0;"></i>',
            ), // jquery plugin options
            'htmlOptions' => array(
                'class' => 'span8',
                'style' => 'border-radius: 5px 0 0 5px;border-right: 0 none;',
                'onchange' => '$("#Timeoff_time_to").datepicker("option", "minDate", $("#Timeoff_time_from").val());$("#Timeoff_time_to").datepicker("setDate", $("#Timeoff_time_from").val());calculate();',
            ),
        ));
        ?>
    </div>
</div>

<div class="control-group ">
    <?php echo $form->labelEx($model, 'time_to', array('class' => 'control-label')) ?>
    <div class="controls">
        <?php
        $this->widget('application.extensions.CJuiDateTimePicker.CJuiDateTimePicker', array(
            'model' => $model, //Model object
            'attribute' => 'time_to', //attribute name
            'language' => '',
            'mode' => 'datetime', //use "time","date" or "datetime" (default)
            'options' => array(
                "dateFormat" => Yii::app()->params['dateFormatJS'],
                'changeMonth' => 'true',
                'changeYear' => 'true',
                'showOtherMonths' => true, // Show Other month in jquery
                'showButtonPanel' => true,
                'showOn' => 'both',
                'buttonText' => '<i class="icon-calendar" style="display: table; padding: 5.6px 0;"></i>'
            ), // jquery plugin options
            'htmlOptions' => array(
                'class' => 'span8',
                'style' => 'border-radius: 5px 0 0 5px;border-right: 0 none;',
                'onchange' => 'calculate();',
            ),
        ));
        ?>
    </div>
</div>

<?php
if ($model->isNewRecord && Yii::app()->user->getState('usertype') == Yii::app()->params['Normal']) {
    $model->user_id = Yii::app()->user->id;
    echo $form->hiddenField($model, 'user_id');
} elseif (!$model->isNewRecord && Yii::app()->user->getState('usertype') == Yii::app()->params['Normal']) {
    //do nothing keep the user id the same
} else {
    ?>
    <div class="control-group">
        <?php echo $form->labelEx($model, 'user_id', array('class' => 'control-label')) ?>
        <?php
        $this->widget('Select2', array(
            'model' => $model,
            'attribute' => 'user_id',
            'data' => Helper::ListEmployee(),
            'htmlOptions' => array('class' => "span7", 'empty' => ' '),
        ));
        ?>
    </div>

    <?php
}
?>

<!--<div class="control-group">
<?php /* echo $form->labelEx($model, 'user_id', array('class' => 'control-label')) ?>
  <?php
  $this->widget('Select2', array(
  'model' => $model,
  'attribute' => 'user_id',
  'data' => Helper::ListEmployee(),
  'htmlOptions' => array('class' => "span7", 'empty' => ' ', 'onchange' => 'calculate()'),
  )); */
?>
</div>-->

<div class="control-group">
    <?php echo $form->labelEx($model, 'request_type', array('class' => 'control-label')) ?>
    <?php
    $crit = '';
    if (Yii::app()->user->hasState('company')) {
        $crit = new CDbCriteria;
        $crit->condition = 'company_id=' . Yii::app()->user->getState('company');
    }
    $this->widget('Select2', array(
        'model' => $model,
        'attribute' => 'request_type',
        'data' => CHtml::listData(RequestType::model()->findAll($crit), 'id', 'name', 'paid_title'),
        'htmlOptions' => array('class' => "span7", "empty" => " ", 'onchange' => 'calculate()'),
    ));
    ?>
</div>

<?php
$cl = '';
if ($model->isNewRecord && Yii::app()->user->getState('usertype') == Yii::app()->params['Normal']) {
    $cl = 'hide';
}
?>
<div class="<?= $cl ?>">
    <?php echo $form->radioButtonListRow($model, 'status', array('0' => 'Pending', '1' => 'Approved', '2' => 'Declined')); ?>
</div>

<?php echo $form->textAreaRow($model, 'comments', array('rows' => 6, 'cols' => 50, 'class' => 'span8')); ?>

<div class="form-actions clear">
    <?php
    $this->widget('bootstrap.widgets.TbButton', array(
        'buttonType' => 'submit',
        'type' => 'primary',
        'label' => $model->isNewRecord ? 'Create' : 'Save',
    ));
    ?>
</div>

<?php $this->endWidget(); ?>

<script>
    $(document).ready(function () {
        calculate();
    });

    function calculate() {
        if(document.getElementById('allDay').checked){
            document.getElementById('Timeoff_time_from').disabled='disabled';
            document.getElementById('Timeoff_time_to').disabled='disabled';
            $('#Timeoff_time_from').val($('#Timeoff_time_from').val().split(" ")[0]+' 09:00');
            $('#Timeoff_time_to').val($('#Timeoff_time_to').val().split(" ")[0]+' 17:00');
        }else{
            document.getElementById('Timeoff_time_from').disabled='';
            document.getElementById('Timeoff_time_to').disabled='';
        }
        var from = $('#Timeoff_time_from').val();
        var to = $('#Timeoff_time_to').val();
        var user = $('#Timeoff_user_id').val();
        var request = $('#Timeoff_request_type').val();
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