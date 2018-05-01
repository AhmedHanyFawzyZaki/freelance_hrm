<form method="post" action="?">
    <div class="control-group">
        <?php //echo $form->labelEx($model, 'user_id', array('class' => 'control-label')) ?>
        <?php
        $this->widget('Select2', array(
            'name' => 'Payroll[user_id]',
            'data' => Helper::ListEmployee(),
            'htmlOptions' => array('class' => "span7", 'empty' => 'All Employees'),
        ));
        ?>
    </div>

    <div class="control-group50">
        <label class="control-label50">Date:</label>
        <div class="controls">
            <?php
            $this->widget('application.extensions.CJuiDateTimePicker.CJuiDateTimePicker', array(
                'name' => 'Payroll[date_from]', //attribute name
                'language' => '',
                'mode' => 'date', //use "time","date" or "datetime" (default)
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
                    'class' => 'width40',
                    'style' => 'border-radius: 5px 0 0 5px;border-right: 0 none;',
                    'required' => 'required'
                ),
            ));
            ?>
        </div>
    </div>

    <div class="control-group50">
        <label class="control-label50">To:</label>
        <div class="controls">
            <?php
            $this->widget('application.extensions.CJuiDateTimePicker.CJuiDateTimePicker', array(
                'name' => 'Payroll[date_to]', //attribute name
                'language' => '',
                'mode' => 'date', //use "time","date" or "datetime" (default)
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
                    'class' => 'width40',
                    'style' => 'border-radius: 5px 0 0 5px;border-right: 0 none;',
                    'required' => 'required'
                ),
            ));
            ?>
        </div>
    </div>

    <div class="form-actions clear">
        <button class="btn btn-primary" type="submit">Submit</button>
        <a class="btn cancel-btn" onclick="$('#collapseThree').height('0');
                $('#collapseThree').removeClass('in');" href="javascript:void(0);">Cancel</a>
    </div>
    <div class="row-fluid text-center">
        <strong><?= date('m/d/Y', strtotime($payroll->time_from)) . ' to ' . date('m/d/Y', strtotime($payroll->time_to)) ?></strong>
        <br>
        <a href="?print=all" class="btn btn-warning">Print Latest Payroll Timesheets</a>
    </div>
</form>