<div class="row-fluid">
    <div class="autoscroll width100perc">
        <table class="table middle-table table-striped small-table">
            <tr>
                <th class="span2">Date</th>
                <th class="span1">Day</th>
                <th class="span2">In</th>
                <th class="span2">Out</th>
                <th class="span2">Deductions</th>
                <th class="span2">Hours</th>
                <th class="span1">Pay Code</th>
            </tr>
            <?php
            $dateRange = Helper::DateRangeArray($from, $to);
            $grandTotalHours=0;
            $grandTotalDeductions=0;
            $grandTotalOver=0;
            $grandTotalOffs=0;
            foreach ($dateRange as $dr) {
                if (strtotime($user->hire_date) <= strtotime($dr)) {
                    //$paid_offs = Timeoff::model()->findAll(array('condition' => 'user_id="' . $user->id . '" and (DATE_FORMAT(time_from,"%Y-%m-%d")="' . $dr . '" OR DATE_FORMAT(time_to,"%Y-%m-%d")="' . $dr . '") and request_type in (select id from tc_request_type where paid=1)'));
                    $paid_offs = Timeoff::model()->findAll(array('condition' => 'user_id="' . $user->id . '" and "'.$dr.'" between time_from and time_to and request_type in (select id from tc_request_type where paid=1)'));
                    $ins = ActivityLog::model()->findAll(array('condition' => 'user_id="' . $user->id . '" and (DATE_FORMAT(time_in,"%Y-%m-%d")="' . $dr . '" OR DATE_FORMAT(time_out,"%Y-%m-%d")="' . $dr . '")'));
                    $day = date('D', strtotime($dr));
                    $dayNo = date('m/d/Y', strtotime($dr));
                    $time_in = '';
                    $time_out = '';
                    $hours = '';
                    $wkd_ot = 0;
                    $totalHours = 0; //total hours of the current day
                    $code = '';

                    if ($ins) {
                        foreach ($ins as $i => $in) {
                            //$totalHours+=((strtotime($in->time_out) - strtotime($in->time_in)) / (60 * 60));
                            $day = $i > 0 ? " " : $day;
                            if ($in->time_in && $in->time_in != '0000-00-00 00:00:00' && $in->time_out && $in->time_out != '0000-00-00 00:00:00') {
                                $hours = round((strtotime($in->time_out) - strtotime($in->time_in)) / (60 * 60), 2);
                                $totalHours+=$hours;
                                $grandTotalHours+=$hours;
                            }
                            $time_in = '<a href="' . Yii::app()->request->getBaseUrl(true) . '/activityLog/update/' . $in->id . '?frame=1" class="s_frame">-Edit-</a>';
                            $time_out = '<a href="' . Yii::app()->request->getBaseUrl(true) . '/activityLog/update/' . $in->id . '?frame=1" class="s_frame">-Edit-</a>';
                            if ($in->time_in && $in->time_in != '0000-00-00 00:00:00')
                                $time_in = date('H:i', strtotime($in->time_in));
                            if ($in->time_out && $in->time_out != '0000-00-00 00:00:00')
                                $time_out = date('H:i', strtotime($in->time_out));
                            echo '<tr><td>' . $dayNo . '</td><td>' . $day . '</td><td>' . $time_in . '</td><td>' . $time_out . '</td><td> </td><td>' . round($hours,2) . '</td><td>Wkd</td></tr>';
                        }
                        $wkd_ot = $totalHours >= 8 ? ($totalHours - 8) : 0;
                        if ($wkd_ot > 0) {
                            echo '<tr><td>' . $dayNo . '</td><td> </td><td> </td><td> </td><td> </td><td>' . round($wkd_ot,2) . '</td><td>Wkd > ot</td></tr>';
                        }
                    } else {
                        $paidHoliday = PaidHoliday::model()->find(array('condition' => 'company_id="' . $user->company_id . '" and day_month="' . date('d-m', strtotime($dr)) . '"'));
                        if ($paidHoliday || in_array(strtolower($day), $user->company->weekly_holiday)) {
                            $hours = 8;
                            $totalHours += 8;
                            $code = $paidHoliday ? 'Paid Holiday' : 'Weekly Holiday';
                        }
                        echo '<tr><td>' . $dayNo . '</td><td>' . $day . '</td><td>' . $time_in . '</td><td>' . $time_out . '</td><td> </td><td>' . $hours . '</td><td>' . $code . '</td></tr>';
                    }
                    
                    if ($paid_offs) {
                        foreach ($paid_offs as $d) {
                            $hours=((strtotime($d->time_to) - strtotime($d->time_from)) / (60 * 60));
                            $hours=$hours>8?8:$hours;
                            $grandTotalOffs+=$hours;
                            $code = 'Paid Time Off';
                            $time_in = date('H:i', strtotime($d->time_from));
                            $time_out = date('H:i', strtotime($d->time_to));
                            echo '<tr><td>' . $dayNo . '</td><td> </td><td>' . $time_in . '</td><td>' . $time_out . '</td><td> </td><td>' . $hours . '</td><td>' . $code . '</td></tr>';
                        }
                    }
                    
                    $deduction = $totalHours < 8 ? number_format(8 - $totalHours, 2) : ' ';
                    echo '<tr class="blue-bg"><td><strong>Daily Total</strong></td><td> </td><td> </td><td> </td><td>' . $deduction . '</td><td>' . number_format($totalHours, 2) . '</td><td> </td></tr>';
                    $grandTotalDeductions+=$deduction;
                    $grandTotalOffs+=0;
                    $grandTotalOver+=$wkd_ot;
                }else{
                    echo '<tr><td colspan="7">Hired on "'.date('m/d/Y', strtotime($user->hire_date)).'"</td></tr>';
                }
            }
            echo '<tr class="alert alert"><td><strong>Grand Total</strong></td><td>Worked: ' . number_format($grandTotalHours-$grandTotalOver, 2) . '</td><td>Overtime: ' . number_format($grandTotalOver, 2) . '</td><td>Time offs: ' . number_format($grandTotalOffs, 2) . '</td><td>Deduction: ' . number_format($grandTotalDeductions,2) . '</td></tr>';
            ?>
        </table>
    </div>
</div>

<div class="well" style="margin-top: 15px;width: 350px;">
    <h5><strong style="width: 150px;float: left;">Employee Signature:</strong> ............................................... </h5>
    <h5><strong style="width: 150px;float: left;">Employer Signature:</strong> ............................................... </h5>
</div>

<!--<p class="margintop20 text-center">
    <i class="icon-circle" style="color:green;font-size:16px;"></i> Clocked in
    <i class="icon-circle" style="color:red;font-size:16px;"></i> Clocked out
</p>-->