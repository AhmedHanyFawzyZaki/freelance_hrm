<?php
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id' => 'user-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('enctype' => 'multipart/form-data'),
        ));
?>

        <!--<p class="help-block">Fields with <span class="required">*</span> are required.</p>-->
<div class="well dis_tab" style="width: 96%;" id="required-div">
    <?php echo $form->errorSummary($model); ?>

    <?php //echo $form->textFieldRow($model, 'username', array('class' => 'span9', 'maxlength' => 255)); ?>
    <?php echo $form->textFieldRow($model, 'first_name', array('class' => 'span9', 'maxlength' => 255)); ?>

    <?php echo $form->textFieldRow($model, 'last_name', array('class' => 'span9', 'maxlength' => 255)); ?>

    <?php
    if ($model->user_type != Yii::app()->params['Admin']) {
        ?>
        <div class="control-group">
            <?php echo $form->labelEx($model, 'department_id', array('class' => 'control-label')) ?>
            <?php
            $this->widget('Select2', array(
                'model' => $model,
                'attribute' => 'department_id',
                'data' => Helper::ListDepartment(),
                'htmlOptions' => array('class' => "span7", 'empty' => ' '),
            ));
            ?>
        </div>
        <?php
    }
    ?>

    <div class="control-group ">
        <?php echo $form->labelEx($model, 'hire_date', array('class' => 'control-label')) ?>
        <div class="controls">
            <?php
            $this->widget('application.extensions.CJuiDateTimePicker.CJuiDateTimePicker', array(
                'model' => $model, //Model object
                'attribute' => 'hire_date', //attribute name
                'language' => '',
                'mode' => 'date', //use "time","date" or "datetime" (default)
                'options' => array(
                    "dateFormat" => Yii::app()->params['dateFormatJS'],
                    'changeMonth' => 'true',
                    'changeYear' => 'true',
                    'showOtherMonths' => true, // Show Other month in jquery
                    'yearRange' => "-50",
                    'showButtonPanel' => true,
                    'showOn' => 'both',
                    'buttonText' => '<i class="icon-calendar" style="display: table; padding: 5.6px 0;"></i>'
                ), // jquery plugin options
                'htmlOptions' => array(
                    'class' => 'span8',
                    'style' => 'border-radius: 5px 0 0 5px;border-right: 0 none;'
                ),
            ));
            ?>
        </div>
    </div>

    <?php
    echo '<div class="control-group">';
    echo $form->labelEx($model, 'image', array('class' => 'control-label'));
    echo '<div class="controls">';
    echo $form->fileField($model, 'image', array('class' => 'span8', 'maxlength' => 255));
    if (!$model->isNewRecord) {
        $this->widget('ext.SAImageDisplayer', array(
            'image' => $model->image,
            'title' => $model->username,
            'alt' => $model->username,
            'defaultImage' => 'defaultUser.jpg',
            'class' => 'pull-right',
            'group' => 'users',
            'size' => 'tiny',
        ));
    }
    echo '</div></div>';
    ?>

    <?php
    /* if (Yii::app()->user->getState('usertype') == Yii::app()->params['Admin']) {
      ?>
      <div class="control-group">
      <?php echo $form->labelEx($model, 'user_type', array('class' => 'control-label')) ?>
      <?php
      $this->widget('Select2', array(
      'model' => $model,
      'attribute' => 'user_type',
      'data' => CHtml::listData(UserType::model()->findAll(), 'id', 'title'),
      'htmlOptions' => array('class' => "span7"),
      ));
      ?>
      </div>
      <?php
      echo $form->checkBoxRow($model, 'active');
      } */
    ?>

</div>

<div class="well dis_tab" style="width: 96%;" id="optional-div">
    <h4 class="text-center">Optional</h4><hr>

    <?php echo $form->textFieldRow($model, 'employee_id', array('class' => 'span9', 'maxlength' => 255)); ?>

    <?php echo $form->textFieldRow($model, 'title', array('class' => 'span9', 'maxlength' => 255)); ?>

    <?php echo $form->textFieldRow($model, 'pay_rate', array('class' => 'span9', 'maxlength' => 255, 'append' => '$')); ?>

    <div class="control-group">
        <?php echo $form->labelEx($model, 'pay_rate_period', array('class' => 'control-label')) ?>
        <?php
        $this->widget('Select2', array(
            'model' => $model,
            'attribute' => 'pay_rate_period',
            'data' => CHtml::listData(PayPeriod::model()->findAll(), 'id', 'name'),
            'htmlOptions' => array('class' => "span7", 'empty' => ' '),
        ));
        ?>
    </div>
</div>

<div class="well dis_tab" style="width: 96%;" id="notif-div">
    <h4 class="text-center">Instant Notification</h4><hr>

    <?php echo $form->checkBoxRow($model, 'checkinout_notification', array('onclick' => 'inout()')); ?>
    <div id="inout" class="clear offset1">
        <?php echo $form->textFieldRow($model, 'checkinout_email', array('class' => 'span12', 'maxlength' => 255)); ?>
        <label class="checkbox dis_tab" style="padding-left: 40px;padding-top: 5px;">
            <input type="checkbox" id="in" onclick="addEmail('User_checkinout_email', 'in')" <?= in_array(Yii::app()->user->useremail, explode(',', $model->checkinout_email)) ? 'checked' : '' ?>>
            Add my email.
        </label>
        <div class="clear offset1">
            <p class="small-text">Notifications will be sent to this Email address.</p>
            <p class="small-text">Multiple Email addresses must be comma-separated.</p>
        </div>
        <div class="clear"><br></div>
        <?php echo $form->checkBoxRow($model, 'checkin_notification'); ?>
        <?php echo $form->checkBoxRow($model, 'checkout_notification'); ?>
    </div>
    <div class="clear"></div>
    <?php echo $form->checkBoxRow($model, 'checkin_late_notification', array('onclick' => 'inlate()')); ?>
    <div id="inlate" class="clear offset1">
        <?php echo $form->textFieldRow($model, 'checkin_late_email', array('class' => 'span12', 'maxlength' => 255)); ?>
        <label class="checkbox dis_tab" style="padding-left: 40px;padding-top: 5px;">
            <input type="checkbox" id="in_late" onclick="addEmail('User_checkin_late_email', 'in_late')" <?= in_array(Yii::app()->user->useremail, explode(',', $model->checkin_late_email)) ? 'checked' : '' ?>>
            Add my email.
        </label>
        <div class="clear offset1">
            <p class="small-text">Notifications will be sent to this Email address.</p>
            <p class="small-text">Multiple Email addresses must be comma-separated.</p>
        </div>
    </div>

</div>

<div class="well dis_tab" style="width: 96%;" id="access-div">
    <h4 class="text-center"><?= Yii::app()->name ?> Access</h4><hr>
    <?php echo $form->textFieldRow($model, 'email', array('class' => 'span9', 'maxlength' => 255)); ?>

    <?php
    if ($model->password) {
        echo '<div class="control-group" id="pass_res">
            <label for="User_password" class="control-label">Password</label>
            <div class="controls">
                <a class="btn btn-info" onclick="$(\'#pass\').show();$(\'#pass_res\').hide();" href="javascript:void(0);">Reset Password</a>
            </div>
        </div>';
        echo '<div id="pass" style="display:none;">' . $form->passwordFieldRow($model, 'password', array('class' => 'span9', 'maxlength' => 255)) . '</div>';
    } else {
        echo $form->passwordFieldRow($model, 'password', array('class' => 'span9', 'maxlength' => 255));
    }
    ?>

    <?php echo $form->checkBoxRow($model, 'active', array('onclick' => 'permissions()')); ?>
    <p class="small-text clear offset1 rel">Employee can login with their Email and Password to the TimeSnob website.</p>

    <div id="permissions">
        <div class="offset1">
            <?php echo $form->checkBoxRow($model_permission, 'punch_other', array('onclick' => 'defaultPermissions()')); ?>
            <!--<p class="small-text clear offset1 rel">Other employees can Punch In & Out from this employee's TimeSnob Account.</p>-->
        </div>
        <div class="clear"></div>
        <div class="offset1">
            <?php echo $form->checkBoxRow($model_permission, 'activity_log_create'); ?>
            <?php echo $form->checkBoxRow($model_permission, 'activity_log_update'); ?>
            <?php echo $form->checkBoxRow($model_permission, 'punch'); ?>
            <?php echo $form->checkBoxRow($model_permission, 'report'); ?>
            <?php //echo $form->checkBoxRow($model_permission, 'gps'); ?>
            <?php echo $form->checkBoxRow($model_permission, 'pay_info'); ?>
            <?php echo $form->checkBoxRow($model_permission, 'time_off'); ?>
        </div>
        <div class="offset1">
            <?php echo $form->checkBoxRow($model_permission, 'admin', array('onclick' => 'admin()')); ?>
        </div>
        <div class="clear"></div>
        <div id="admin">
            <div class="offset2 well dis_tab">
                <h5 class="text text-center">Choose Admin Permissions</h5>
                <?php echo $form->checkBoxRow($model_permission, 'company_user'); ?>
                <?php echo $form->checkBoxRow($model_permission, 'company_department'); ?>
                <?php echo $form->checkBoxRow($model_permission, 'company_reports'); ?>
                <?php echo $form->checkBoxRow($model_permission, 'company_pay_info'); ?>
                <?php echo $form->checkBoxRow($model_permission, 'company_timeoff'); ?>
                <?php echo $form->checkBoxRow($model_permission, 'company_activity'); ?>
                <?php echo $form->checkBoxRow($model_permission, 'company_dashboard'); ?>
                <?php echo $form->checkBoxRow($model_permission, 'company_admin'); ?>
                <?php echo $form->checkBoxRow($model_permission, 'company_settings'); ?>
            </div>
        </div>
    </div>
</div>

<div class="well dis_tab" style="width: 96%;" id="overtime-div">
    <h4 class="text-center">Overtime Rules</h4><hr>
    <?php echo $form->checkBoxRow($model, 'overtime', array('onclick' => 'overtime()')); ?>
    <div class="clear offset2" id="overtime">
        <?php
        echo $form->radioButtonList($model, 'overtime_period', Helper::RulesPeriod());
        ?>
    </div>
</div>

<div class="well dis_tab" style="width: 96%;" id="holiday-div">
    <h4 class="text-center">Holiday Pay Rules</h4><hr>
    <?php echo $form->checkBoxRow($model, 'holiday_pay', array('onclick' => 'holiday_pay()')); ?>
    <div class="clear offset2" id="holiday_pay">
        <div class="span6">
            <?php
            echo $form->radioButtonList($model, 'holiday_pay_period', Helper::RulesPeriod());
            ?>
        </div>
        <div class="span6 row-fluid">
            <?php
            if (Yii::app()->user->hasState('company')) {
                $hds = PaidHoliday::model()->findAllByAttributes(array('company_id' => Yii::app()->user->getState('company')));
            } elseif ($model->company_id) {
                $hds = PaidHoliday::model()->findAllByAttributes(array('company_id' => $model->company_id));
            }
            if ($hds) {
                foreach ($hds as $hd) {
                    $arr_hd[] = $hd->name;
                }
                echo '<p class="text text-small">' . implode(', ', $arr_hd) . '</p>';
            }
            ?>
        </div>
    </div>
</div>

<div class="well dis_tab" style="width: 96%;" id="timeoff-div">
    <h4 class="text-center">Time Off Permissions</h4><hr>
    <?php echo $form->checkBoxRow($model, 'sick_leave', array('onclick' => 'sick_leave()')); ?>
    <div class="clear offset2" id="sick_leave">
        <?php
        echo $form->radioButtonList($model, 'sick_leave_period', Helper::RulesPeriod());
        ?>
    </div>
    <div class="clear"></div>
    <?php echo $form->checkBoxRow($model, 'paid_timeoff', array('onclick' => 'paid_timeoff()')); ?>
    <div class="clear offset2" id="paid_timeoff">
        <?php
        echo $form->radioButtonList($model, 'paid_timeoff_period', Helper::RulesPeriod());
        ?>
    </div>
</div>

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
        inout();
        inlate();
        overtime();
        holiday_pay();
        sick_leave();
        paid_timeoff();
        permissions();
        admin();
<?php
if (isset($_GET['field'])) {
    ?>
            var top = ($("#<?= $_GET['div'] ?>").offset().top) - 480;
            $('html,body').animate({
                scrollTop: top,
            },
                    'slow');
            $('#<?= $_GET['div'] ?>').css('border', '1px solid red');
            setTimeout(
                    function () {
                        $('#<?= $_GET['div'] ?>').css('border', '1px solid #e3e3e3');
                        /*$('#<?= $_GET['field'] ?>').focus();*/
                    }, 5000);

    <?php
}
?>
    });

    function inout() {
        if (document.getElementById('User_checkinout_notification').checked) {
            $('#inout').show();
        } else {
            $('#inout').hide();
        }
    }
    function inlate() {
        if (document.getElementById('User_checkin_late_notification').checked) {
            $('#inlate').show();
        } else {
            $('#inlate').hide();
        }
    }
    function overtime() {
        if (document.getElementById('User_overtime').checked) {
            $('#overtime').show();
        } else {
            $('#overtime').hide();
        }
    }
    function holiday_pay() {
        if (document.getElementById('User_holiday_pay').checked) {
            $('#holiday_pay').show();
        } else {
            $('#holiday_pay').hide();
        }
    }
    function sick_leave() {
        if (document.getElementById('User_sick_leave').checked) {
            $('#sick_leave').show();
        } else {
            $('#sick_leave').hide();
        }
    }
    function paid_timeoff() {
        if (document.getElementById('User_paid_timeoff').checked) {
            $('#paid_timeoff').show();
        } else {
            $('#paid_timeoff').hide();
        }
    }
    function permissions() {
        if (document.getElementById('User_active').checked) {
            $('#permissions').show();
        } else {
            $('#permissions').hide();
        }
    }
    function admin() {
        if (document.getElementById('UserPermission_admin').checked) {
            $('#admin').show();
        } else {
            $('#admin').hide();
        }
    }
    function defaultPermissions() {
        if (document.getElementById('UserPermission_punch_other').checked) {
            document.getElementById('UserPermission_punch').checked = true;
            document.getElementById('UserPermission_report').checked = true;
            document.getElementById('UserPermission_pay_info').checked = true;
            document.getElementById('UserPermission_time_off').checked = true;
        } else {
            document.getElementById('UserPermission_punch').checked = false;
            document.getElementById('UserPermission_report').checked = false;
            document.getElementById('UserPermission_pay_info').checked = false;
            document.getElementById('UserPermission_time_off').checked = false;
        }
    }

    function addEmail(field_id, id) {
        var email = "<?= Yii::app()->user->useremail ?>";
        var val = $('#' + field_id).val();
        var newVal = val ? val + ', ' + email : email;
        if (document.getElementById(id).checked) {
            $('#' + field_id).val(newVal.trim().replace(/^,|,$/g, ''));
        } else {
            var oldVal = val.replace(email, '');
            $('#' + field_id).val(oldVal.trim().replace(/^,|,$/g, ''));
        }
    }
</script>
