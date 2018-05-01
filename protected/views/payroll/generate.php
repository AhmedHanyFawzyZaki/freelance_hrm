<?php $this->pageTitlecrumbs = Yii::t('translate', 'Payroll') . ' (' . $model->time_from . ' => ' . $model->time_to . ')'; ?>
<div id="main-div">
    <table class="table middle-table" >
        <tr>
            <th>Emp. ID</th>
            <th>Name</th>
            <th>Department</th>
            <th>
        <div class="row-fluid">Regular</div>
        <div class="row-fluid">
            <div class="span4">Rate</div>
            <div class="span4">Hours</div>
            <div class="span4">Amount</div>
        </div>
        </th>
        <th>
        <div class="row-fluid">Overtime</div>
        <div class="row-fluid">
            <div class="span6">Hours</div>
            <div class="span6">Amount</div>
        </div>
        </th>
        <th>
        <div class="row-fluid">Deduction</div>
        <div class="row-fluid">
            <div class="span6">Hours</div>
            <div class="span6">Amount</div>
        </div>
        </th>
        <th>Total</th>
        <th class="pr-hide">Time Cards</th>
        </tr>

        <?php
        if ($employees) {
            $users=array();
            foreach ($employees as $emp) {
                $users[]=$emp->id;
                if ($emp->pay_rate && $emp->payRatePeriod->period) {
                    $r_rate = '$' . round($emp->pay_rate, 1) . ' / ' . $emp->payRatePeriod->period . 'h'; //regular rate
                    $r_h_rate = round($emp->pay_rate / $emp->payRatePeriod->period, 1); //regular hourly rate
                    $hours_worked = Payroll::hoursWorked($emp->id, $model->id); //total hours worked during the payroll period
                    $ded_hours = Payroll::hoursDeducted($emp->id, $model->id); //total hours deducted during the payroll period
                    $ot_hours = $hours_worked - $emp->payRatePeriod->period; //overtime during this period
                    $ot_hours = $ot_hours > 0 ? $ot_hours : 0;

                    $r_amount = $hours_worked * $r_h_rate;
                    $ot_amount = $ot_hours * $r_h_rate;
                    $ded_amount = $ded_hours * $r_h_rate;

                    $total = $r_amount + $ot_amount - $ded_amount;
                    $total = $total > 0 ? $total : 0;
                    $period = (int) ((strtotime($model->time_to) - strtotime($model->time_from)) / (60 * 60 * 24));
                    echo '<tr>
            <td>' . $emp->employee_id . '</td>
            <td>' . $emp->username . '</td>
            <td>' . $emp->department->name . '</td>
            <td>
                <div class="row-fluid">
                    <div class="span4">' . $r_rate . '</div>
                    <div class="span4">' . round($hours_worked, 2) . 'h</div>
                    <div class="span4">$' . round($r_amount, 2) . '</div>
                </div>
            </td>
            <td>
                <div class="row-fluid">
                    <div class="span6">' . round($ot_hours, 2) . 'h</div>
                    <div class="span6">$' . round($ot_amount, 2) . '</div>
                </div>
            </td>
            <td>
                <div class="row-fluid">
                    <div class="span6">' . round($ded_hours, 2) . 'h</div>
                    <div class="span6">$' . round($ded_amount, 2) . '</div>
                </div>
            </td>
            <td>$' . round($total, 2) . '</td>
            <td class="pr-hide"><a href="' . Yii::app()->request->getBaseUrl(true) . '/activityLog/timeCards?id=' . $emp->id . '&from=' . $model->time_from . '&to=' . $model->time_to . '&period=' . $period . '">Details</a></td>
        </tr>';
                }
            }
        }
        ?>
    </table>
</div>

<br>
<button onclick="printDiv()" class="btn btn-success pull-right marginLeft30">Print Summary</button>
<a href="<?=Yii::app()->request->getBaseUrl(true)?>/activityLog/report?isPayroll=1&from=<?=$model->time_from?>&to=<?=$model->time_to?>&users=<?=implode(',',$users)?>" class="btn btn-info pull-right">Print TimeCards</a>

<script>
    function printDiv() {
        var html = $('#main-div').html();
        var printWindow = window.open('', '', 'height=400,width=800');
        printWindow.document.write(html);
        printWindow.document.write('<style>.pr-hide{display:none;}</style><link type="text/css" href="<?= Yii::app()->theme->baseUrl ?>/css/style.css" rel="stylesheet">');
        printWindow.document.write('<link type="text/css" href="<?= Yii::app()->request->getBaseUrl(true) ?>/css/bootstrap.css" rel="stylesheet">');
        printWindow.document.close();
        setTimeout(function () {
            printWindow.print();
        }, 1);
    }
</script>