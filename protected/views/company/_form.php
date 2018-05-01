<?php
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id' => 'company-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
        ));
?>

        <!--<p class="help-block">Fields with <span class="required">*</span> are required.</p>-->

<?php echo $form->errorSummary($model); ?>

<?php echo $form->textFieldRow($model, 'name', array('class' => 'span9', 'maxlength' => 255)); ?>

<?php echo $form->textFieldRow($model, 'email', array('class' => 'span9', 'maxlength' => 255)); ?>

<?php echo $form->textFieldRow($model, 'address', array('class' => 'span9', 'maxlength' => 255)); ?>

<?php echo $form->textFieldRow($model, 'phone', array('class' => 'span9', 'maxlength' => 255));  ?>

<?php
if (Yii::app()->user->hasState('company')) {
    ?>
    <div class="control-group">
        <?php echo $form->labelEx($model, 'pay_period', array('class' => 'control-label')) ?>
        <?php
        $this->widget('Select2', array(
            'model' => $model,
            'attribute' => 'pay_period',
            'data' => CHtml::listData(PayPeriod::model()->findAllByAttributes(array('company_id' => Yii::app()->user->getState('company'))), 'id', 'name'),
            'htmlOptions' => array('class' => "span7", 'empty' => ' ', 'multiple' => 'multiple'),
        ));
        ?>
    </div>
    <?php
} else {
    ?>
    <div class="control-group">
        <?php echo $form->labelEx($model, 'pay_period', array('class' => 'control-label')) ?>
        <?php
        $this->widget('Select2', array(
            'model' => $model,
            'attribute' => 'pay_period',
            'data' => CHtml::listData(PayPeriod::model()->findAll(), 'id', 'name', 'company.name'),
            'htmlOptions' => array('class' => "span7", 'empty' => ' ', 'multiple' => 'multiple'),
        ));
        ?>
    </div>
    <?php
}
?>

<div class="control-group ">
    <?php echo $form->labelEx($model, 'start_on', array('class' => 'control-label')) ?>
    <div class="controls">
        <?php
        $this->widget('application.extensions.CJuiDateTimePicker.CJuiDateTimePicker', array(
            'model' => $model, //Model object
            'attribute' => 'start_on', //attribute name
            'language' => '',
            'mode' => 'date', //use "time","date" or "datetime" (default)
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
            ),
        ));
        ?>
    </div>
</div>

<div class="control-group">
    <?php echo $form->labelEx($model, 'weekly_holiday', array('class' => 'control-label')) ?>
    <?php
    $this->widget('Select2', array(
        'model' => $model,
        'attribute' => 'weekly_holiday',
        'data' => array('sun' => 'Sunday', 'mon' => 'Monday', 'tue' => 'Tuesday', 'wed' => 'Wednesday', 'thu' => 'Thursday', 'fri' => 'Friday', 'sat' => 'Saturday'),
        'htmlOptions' => array('class' => "span7", 'multiple' => 'multiple'),
    ));
    ?>
</div>

<!--<div class="control-group">
<?php echo $form->labelEx($model, 'start_on', array('class' => 'control-label')) ?>
<?php
$this->widget('Select2', array(
    'model' => $model,
    'attribute' => 'start_on',
    'data' => Helper::getWeek(),
    'htmlOptions' => array('class' => "span7", 'empty' => ' '),
));
?>
</div>

<div class="control-group">
<?php echo $form->labelEx($model, 'end_on', array('class' => 'control-label')) ?>
<?php
$this->widget('Select2', array(
    'model' => $model,
    'attribute' => 'end_on',
    'data' => Helper::getWeek(),
    'htmlOptions' => array('class' => "span7", 'empty' => ' '),
));
?>
</div>-->

<!--<div class="control-group ">
<?php echo $form->labelEx($model, 'renewal_date', array('class' => 'control-label')) ?>
    <div class="controls">
<?php
$this->widget('application.extensions.CJuiDateTimePicker.CJuiDateTimePicker', array(
    'model' => $model, //Model object
    'attribute' => 'renewal_date', //attribute name
    'language' => '',
    'mode' => 'date', //use "time","date" or "datetime" (default)
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
    ),
));
?>
    </div>
</div>-->

<?php //echo $form->textFieldRow($model, 'address', array('class' => 'span9', 'maxlength' => 255));  ?>

<div class="well clear">
    <h4 class="text-center">Sick Leave Policy</h4>
    <hr>
    <label class="radio">
        <?php echo $form->radioButton($model, 'sick_fixed_accrued', array('value' => 0, 'uncheckValue' => null, 'onchange' => 'fixed(this.value)')); ?>
        Fixed Amount Per Year
    </label>
    <?php //echo $form->radioButtonList($model, 'sick_fixed_accrued', array(0 => 'Fixed Amount Per Year', 1 => 'Accrued Time'), array('onchange' => 'fixed(this.value)'));  ?>
    <div id="fixed" class="offset1">
        Pay 
        <div class="input-append">
            <?php echo $form->textField($model, 'sick_fixed_pay', array('style' => 'width:35px !important', 'maxlength' => 4)); ?> 
            <span class="add-on">hours</span>
        </div>
        per year (instant access)<br><br>
        <div class="offset1">
            <label class="checkbox"><?php echo $form->checkBox($model, 'sick_fixed_rollover'); ?>Check box to allow rollover</label>
        </div>
        <div class="offset2">
            Rollover allowed per year
            <div class="input-append">
                <?php echo $form->textField($model, 'sick_fixed_rollover_pay', array('style' => 'width:35px !important', 'maxlength' => 4)); ?> 
                <span class="add-on">hours</span>
            </div>
        </div>
        <div>
            Max accumulated hours per year <?php echo $form->textField($model, 'sick_fixed_max_hours', array('style' => 'width:35px !important', 'maxlength' => 4)); ?> 
        </div>
    </div>
    <br>
    <label class="radio">
        <?php echo $form->radioButton($model, 'sick_fixed_accrued', array('value' => 1, 'uncheckValue' => null, 'onchange' => 'fixed(this.value)')); ?>
        Accrued Time
    </label>
    <div id="accrued" class="hide offset1">
        Accrue 
        <div class="input-append">
            <?php echo $form->textField($model, 'sick_accrue_hour', array('style' => 'width:35px !important', 'maxlength' => 4)); ?> 
            <span class="add-on">hour(s)</span>
        </div>
        per 
        <div class="input-append">
            <?php echo $form->textField($model, 'sick_accrue_per_hour', array('style' => 'width:35px !important', 'maxlength' => 4)); ?> 
            <span class="add-on">hour(s)</span>
        </div>
        worked.<br><br>
        <div class="offset1">
            <label class="checkbox"><?php echo $form->checkBox($model, 'sick_accrue_rollover'); ?>Check box to allow rollover</label>
        </div>
        <div class="offset2">
            Rollover allowed per year
            <div class="input-append">
                <?php echo $form->textField($model, 'sick_accrue_rollover_pay', array('style' => 'width:35px !important', 'maxlength' => 4)); ?> 
                <span class="add-on">hours</span>
            </div>
        </div>
        <div>
            Max accrued hours per year <?php echo $form->textField($model, 'sick_accrue_max_hours', array('style' => 'width:35px !important', 'maxlength' => 4)); ?> 
        </div>
    </div>
</div>

<div class="well clear">
    <h4 class="text-center">Vacation Policy</h4>
    <hr>
    <label class="radio">
        <?php echo $form->radioButton($model, 'vacation_fixed_accrued', array('value' => 0, 'uncheckValue' => null, 'onchange' => 'fixedVacation(this.value)')); ?>
        Fixed Amount Per Year
    </label>
    <?php //echo $form->radioButtonList($model, 'sick_fixed_accrued', array(0 => 'Fixed Amount Per Year', 1 => 'Accrued Time'), array('onchange' => 'fixed(this.value)'));  ?>
    <div id="fixed_vacation" class="offset1">
        Initial amount of hours earned per year 
        <div class="input-append">
            <?php echo $form->textField($model, 'vacation_fixed_pay', array('style' => 'width:35px !important', 'maxlength' => 4)); ?> 
            <span class="add-on">hours</span>
        </div>
        <br><br>
        <div class="offset1">
            <label class="checkbox"><?php echo $form->checkBox($model, 'vacation_fixed_rollover'); ?>Check box to allow rollover</label>
        </div>
        <div class="offset2">
            Rollover allowed per year
            <div class="input-append">
                <?php echo $form->textField($model, 'vacation_fixed_rollover_pay', array('style' => 'width:35px !important', 'maxlength' => 4)); ?> 
                <span class="add-on">hours</span>
            </div>
        </div>
        <div>
            Max accumulated hours per year <?php echo $form->textField($model, 'vacation_fixed_max_hours', array('style' => 'width:35px !important', 'maxlength' => 4)); ?> 
        </div>
        <div class="span5 no-margin ver-margin10 posrel">
            <div class="clone clear pull-left">
                After <?php echo $form->textField($model_expansion, 'years[]', array('style' => 'width:35px !important')); ?> years increase hours to <?php echo $form->textField($model_expansion, 'hours[]', array('style' => 'width:35px !important')); ?> per year.
            </div>
            <?php
            if (!$model->isNewRecord) {
                $expansions = CompanyExpansion::model()->findAllByAttributes(array('company_id' => $model->id));
                if ($expansions) {
                    foreach ($expansions as $i => $ex) {
                        ?>
                        <div class="clone clear pull-left copy<?= $i + 1 ?>">
                            After <?php echo $form->textField($model_expansion, 'years[]', array('style' => 'width:35px !important', 'value' => $ex->years)); ?> years increase hours to <?php echo $form->textField($model_expansion, 'hours[]', array('style' => 'width:35px !important', 'value' => $ex->hours)); ?> per year.
                            <a onclick="$(this).parent().slideUp(function () {
                                                    $(this).remove()
                                                });
                                                return false" href="#" class="pull-right margin10 icon-minus"></a>
                        </div>
                        <?php
                    }
                }
            }

            $this->widget('ext.reCopy.ReCopyWidget', array(
                'targetClass' => 'clone',
                'addButtonLabel' => '',
                'addButtonCssClass' => 'pull-right add-more icon-plus',
                'removeButtonLabel' => '',
                'removeButtonCssClass' => 'pull-right margin10 icon-minus',
                'limit' => 10,
            ));
            ?>
        </div>
    </div>
    <br>
    <label class="radio clear">
        <?php echo $form->radioButton($model, 'vacation_fixed_accrued', array('value' => 1, 'uncheckValue' => null, 'onchange' => 'fixedVacation(this.value)')); ?>
        Accrued Time
    </label>
    <div id="accrued_vacation" class="hide offset1">
        Accrue 
        <div class="input-append">
            <?php echo $form->textField($model, 'vacation_accrue_hour', array('style' => 'width:35px !important', 'maxlength' => 4)); ?> 
            <span class="add-on">hour(s)</span>
        </div>
        per 
        <div class="input-append">
            <?php echo $form->textField($model, 'vacation_accrue_per_hour', array('style' => 'width:35px !important', 'maxlength' => 4)); ?> 
            <span class="add-on">hour(s)</span>
        </div>
        worked.<br><br>
        <div class="offset1">
            <label class="checkbox"><?php echo $form->checkBox($model, 'vacation_accrue_rollover'); ?>Check box to allow rollover</label>
        </div>
        <div class="offset2">
            Rollover allowed per year
            <div class="input-append">
                <?php echo $form->textField($model, 'vacation_accrue_rollover_pay', array('style' => 'width:35px !important', 'maxlength' => 4)); ?> 
                <span class="add-on">hours</span>
            </div>
        </div>
        <div>
            Max accrued hours per year <?php echo $form->textField($model, 'vacation_accrue_max_hours', array('style' => 'width:35px !important', 'maxlength' => 4)); ?> 
        </div>
    </div>
</div>

<div class="well clear">
    <h4 class="text-center">Overtime Policy</h4>
    <hr>
    <div class="full">
        <?php echo $form->checkBoxListRow($model, 'over_time', array('0' => 'Daily after 8h', '1' => 'Weekly after 40h', '2' => 'Monthly after 160')); ?>
    </div>
</div>

<script>
    function fixed(val) {
        if (val == '1') {
            $('#fixed').hide();
            $('#accrued').show();
        } else {
            $('#fixed').show();
            $('#accrued').hide();
        }
    }

    function fixedVacation(val) {
        if (val == '1') {
            $('#fixed_vacation').hide();
            $('#accrued_vacation').show();
        } else {
            $('#fixed_vacation').show();
            $('#accrued_vacation').hide();
        }
    }

    $(document).ready(function () {
        fixed(<?= $model->sick_fixed_accrued ?>);
        fixedVacation(<?= $model->vacation_fixed_accrued ?>);
    });
</script>

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
