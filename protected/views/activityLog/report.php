<?php $this->pageTitlecrumbs = Yii::t('translate', 'Print Time Cards'); ?>
<?php
if (isset($_GET['isPayroll']) && $_GET['isPayroll'] == 1) {
    $_POST['Time']['date_from'] = $_GET['from'];
    $_POST['Time']['date_to'] = $_GET['to'];
    $_POST['Time']['user_id'] = explode(',', $_GET['users']);
    ?>
    <h5 class="text text-center width99">
        <?php
        if (isset($_POST['Time'])) {
            echo '<button class="btn-small btn-danger pull-right" onclick="printDiv();return 0;">Print</button>';
            echo '<a href="' . Yii::app()->request->urlReferrer . '" class="btn-small btn pull-left marginTop5 marginRight10">Back</a>';
        }
        ?>
    </h5>
    <?php
} else {
    ?>
    <form method="post" action="?" class="form-horizontal isPayroll">
        <div class="control-group">
            <label class="control-label">Employees:</label>
            <div class="controls">
                <?php
                $this->widget('Select2', array(
                    'name' => 'Time[user_id]',
                    'data' => Helper::ListEmployee(),
                    'htmlOptions' => array('class' => "span9", 'multiple' => 'multiple', 'required' => 'required'),
                ));
                ?>
                <span class="span2 btn btn-all" onclick="selectAll()">Select All</span>
            </div>
        </div>

        <div class="control-group">
            <label class="control-label">Pay Period:</label>
            <div class="controls">
                <?php
                $this->widget('Select2', array(
                    'name' => 'Time[period]',
                    'data' => Helper::ListPayPeriods(), //CHtml::listData(PayPeriod::model()->findAll(array('condition' => 'company_id=' . $company->id)), 'period_in_days', 'name'),
                    'htmlOptions' => array('class' => "span10", 'empty' => 'Default Pay period', 'onchange' => 'ChangeDateRange(this.value)'),
                ));
                ?>
            </div>
        </div>

        <div class="clear">
            <div class="control-group">
                <label class="control-label">Date From:</label>
                <div class="controls">
                    <?php
                    $this->widget('application.extensions.CJuiDateTimePicker.CJuiDateTimePicker', array(
                        'name' => 'Time[date_from]', //attribute name
                        'language' => '',
                        'mode' => 'date', //use "time","date" or "datetime" (default)
                        'value' => $time_from,
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
                            'required' => 'required'
                        ),
                    ));
                    ?>
                    <div class="span2 pull-right">
                        <a href="javascript:void(0)" onclick="previous()">
                            <i class="icon icon-arrow-left"></i>
                        </a>
                        &nbsp;&nbsp;
                        <a href="javascript:void(0)" onclick="next()">
                            <i class="icon icon-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label">Date To:</label>
                <div class="controls">
                    <?php
                    $this->widget('application.extensions.CJuiDateTimePicker.CJuiDateTimePicker', array(
                        'name' => 'Time[date_to]', //attribute name
                        'language' => '',
                        'mode' => 'date', //use "time","date" or "datetime" (default)
                        'value' => $time_to,
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
                            'class' => 'span9',
                            'style' => 'border-radius: 5px 0 0 5px;border-right: 0 none;',
                            'required' => 'required',
                        ),
                    ));
                    ?>
                </div>
            </div>
        </div>

        <h5 class="text text-center width99">
            <input type="submit" value="Generate" class="btn btn-info">
            <?php
            if (isset($_POST['Time'])) {
                echo '<button class="btn-small btn-danger pull-right" onclick="printDiv();return 0;">Print</button>';
                //echo '<a href="'. Yii::app()->request->urlReferrer .'" class="btn-small btn pull-left marginTop5 marginRight10">Back</a>';
            }
            ?>
        </h5>
    </form>
<?php } ?>

<div id="main-div">
    <?php
    if (isset($_POST['Time'])) {
        foreach ($_POST['Time']['user_id'] as $emp) {
            $user = User::model()->findByPk($emp);
            echo '<div class="well clear" style="page-break-before:always"><h6 class="alert alert-info marginTop20">Name: ' . $user->username . '<span class="marginLeft50">ID: ' . $user->employee_id . '</span><span class="marginLeft50">Department: ' . $user->department->name . '</span></h6>';
            $this->renderPartial('report-time-card', array('user' => $user, 'from' => $_POST['Time']['date_from'], 'to' => $_POST['Time']['date_to']));
            echo '</div>';
        }
    }
    ?>
</div>

<script>
    function printDiv() {
        var html = $('#main-div').html();
        var printWindow = window.open('', '', 'height=400,width=800');
        printWindow.document.write(html);
        printWindow.document.write('<link type="text/css" href="<?= Yii::app()->request->getBaseUrl(true) ?>/css/bootstrap.css" rel="stylesheet">');
        printWindow.document.write('<style>.pr-hide{display:none;}</style><link type="text/css" href="<?= Yii::app()->theme->baseUrl ?>/css/style.css" rel="stylesheet">');
        printWindow.document.close();
        setTimeout(function () {
            printWindow.print();
        }, 2);
    }
</script>

<script>
    function ChangeDateRange(val) {
        $.ajax({
            url: '<?= Yii::app()->request->getBaseUrl(true) ?>/activityLog/getDateRange?period=' + val,
            success: function (data) {
                var arr = jQuery.parseJSON(data);
                $('#Time_date_from').val(arr['from']);
                $('#Time_date_to').val(arr['to']);
            }
        });
    }
    function selectAll() {
        var arr = [];
        $('#Time_user_id option').each(function (i, x) {
            arr.push(x.value);
        });
        $('#Time_user_id').val(arr).trigger("change");
    }
    $(document).ready(function () {
        //set the form on submit here
<?php
if (isset($_POST['Time'])) {
    ?>
            var users_arr =<?php echo json_encode($_POST['Time']['user_id']); ?>;
            $('#Time_user_id').val(users_arr).trigger("change");
            $('#Time_date_from').val("<?= $_POST['Time']['date_from'] ?>");
            $('#Time_date_to').val("<?= $_POST['Time']['date_to'] ?>");
            $('#Time_period').val("<?= $_POST['Time']['period'] ?>");
    <?php
}
?>
    });
</script>
<script>
    function next() {
        var from = $('#Time_date_from').val();
        var to = $('#Time_date_to').val();
        if (!from) {
            $('#Time_date_from').focus();
        } else if (!to) {
            $('#Time_date_to').focus();
        } else {
            var dFrom = new Date(from);
            var dTo = new Date(to);
            var diff = (dTo.getTime() - dFrom.getTime()) + 86400000;//difference + 1 more day

            var nFrom = new Date(dFrom.getTime() + diff);
            $('#Time_date_from').val($.datepicker.formatDate('<?= Yii::app()->params['dateFormatJS'] ?>', nFrom));

            var nTo = new Date(dTo.getTime() + diff);
            $('#Time_date_to').val($.datepicker.formatDate('<?= Yii::app()->params['dateFormatJS'] ?>', nTo));
        }
    }
    function previous() {
        var from = $('#Time_date_from').val();
        var to = $('#Time_date_to').val();
        if (!from) {
            $('#Time_date_from').focus();
        } else if (!to) {
            $('#Time_date_to').focus();
        } else {
            var dFrom = new Date(from);
            var dTo = new Date(to);
            var diff = (dTo.getTime() - dFrom.getTime()) + 86400000;//difference + 1 more day

            var nFrom = new Date(dFrom.getTime() - diff);
            $('#Time_date_from').val($.datepicker.formatDate('<?= Yii::app()->params['dateFormatJS'] ?>', nFrom));

            var nTo = new Date(dTo.getTime() - diff);
            $('#Time_date_to').val($.datepicker.formatDate('<?= Yii::app()->params['dateFormatJS'] ?>', nTo));
        }
    }
</script>