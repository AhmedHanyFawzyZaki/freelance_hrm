<script>
    function changePeriod(val) {
        var arr = val.split('*_*');
        var period = arr[0];
        var to = arr[1];
        window.location = '<?= Yii::app()->request->getBaseUrl(true) ?>/activityLog/timeCards?id=<?= $user->id ?>&from=<?= $from ?>&to=' + to + '&period=' + period;
    }
</script>
<div class="row-fluid" id="main-div">
    <h5 class="text text-center width99">
        <?php
        if ($company->pay_period) {
            echo '<span class="span12 text-left"><select onchange="changePeriod(this.value)" class="pr-hide">';
            foreach ($company->pay_period as $p_id) {
                $pp = PayPeriod::model()->findByPk($p_id);
                $selected = isset($_GET['period']) && $_GET['period'] == $pp->period_in_days ? 'selected' : '';
                $new_to = date('Y-m-d', strtotime('+ ' . ($pp->period_in_days - 1) . ' day', strtotime($from)));
                echo '<option value="' . $pp->period_in_days . '*_*' . $new_to . '" ' . $selected . '>' . $pp->name . '</option>';
            }
            echo '</select></span>';
        }
        ?>
        <strong class="text-error"><?= $user->username ?>'s</strong> time cards for the period from<br>
        <label class="pr-hide">
            <a href="<?= Yii::app()->request->getBaseUrl(true) ?>/activityLog/timeCards?id=<?= $user->id ?>&from=<?= $previous_period_from ?>&to=<?= $previous_period_to ?>&period=<?= $period ?>">
                <i class="icon icon-arrow-left"></i>
            </a>&nbsp;&nbsp;
            (<?= date('d F Y', strtotime($from)) ?>) to (<?= date('d F Y', strtotime($to)) ?>) 
            &nbsp;&nbsp;
            <a href="<?= Yii::app()->request->getBaseUrl(true) ?>/activityLog/timeCards?id=<?= $user->id ?>&from=<?= $next_period_from ?>&to=<?= $next_period_to ?>&period=<?= $period ?>">
                <i class="icon icon-arrow-right"></i>
            </a>
        </label>
    </h5>
    <div class="autoscroll width100perc">
        <table class="table middle-table">
            <tr>
                <td></td>
                <?php
                $dateRange = Helper::DateRangeArray($from, $to);
                $total_paid_hours = 0;
                $total_paid_regular = 0;
                $total_paid_ot = 0;
                foreach ($dateRange as $dr) {
                    $day = date('D', strtotime($dr));
                    $dayNo = date('d', strtotime($dr));
                    echo '<th><div class="row-fluid">' . $day . '</div><hr class="margin10"><div class="row-fluid">' . $dayNo . '</div></th>';
                }
                ?>
                <td>Total Paid</td>
            </tr>
            <tr>
                <td>In <i class="icon icon-arrow-right"></i> Out</td>
                <?php
                foreach ($dateRange as $dr) {
                    $totalHours[$dr] = 0.00;
                    $ins = ActivityLog::model()->findAll(array('condition' => 'user_id="' . $user->id . '" and (DATE_FORMAT(time_in,"%Y-%m-%d")="' . $dr . '" OR DATE_FORMAT(time_out,"%Y-%m-%d")="' . $dr . '")'));
                    echo '<td>';
                    if ($ins) {
                        foreach ($ins as $in) {
                            if ($in->time_in && $in->time_in != '0000-00-00 00:00:00' && $in->time_out && $in->time_out != '0000-00-00 00:00:00') {
                                $totalHours[$dr]+=((strtotime($in->time_out) - strtotime($in->time_in)) / (60 * 60));
                            }
                            $time_in = '<a href="' . Yii::app()->request->getBaseUrl(true) . '/activityLog/update/' . $in->id . '?frame=1" class="s_frame">-Edit-</a>';
                            $time_out = '<a href="' . Yii::app()->request->getBaseUrl(true) . '/activityLog/update/' . $in->id . '?frame=1" class="s_frame">-Edit-</a>';
                            if ($in->time_in && $in->time_in != '0000-00-00 00:00:00')
                                $time_in = date('H:i', strtotime($in->time_in));
                            if ($in->time_out && $in->time_out != '0000-00-00 00:00:00')
                                $time_out = date('H:i', strtotime($in->time_out));
                            echo '<div>' . $time_in . ' <i class="icon icon-arrow-right"></i> ' . $time_out . '</div>';
                        }
                    }
                    echo '</td>';
                }
                ?>
                <td></td>
            </tr>
            <tr>
                <td>Regular Hours</td>
                <?php
                foreach ($dateRange as $dr) {
                    $wkd = $totalHours[$dr] >= 8 ? 8 : $totalHours[$dr];
                    $total_paid_regular+=$wkd;
                    echo '<td>' . number_format($wkd, 2) . '</td>';
                }
                ?>
                <td><?= number_format($total_paid_regular, 2) ?></td>
            </tr>
            <tr>
                <td>Overtime Hours</td>
                <?php
                foreach ($dateRange as $dr) {
                    $wkd_ot = $totalHours[$dr] >= 8 ? ($totalHours[$dr] - 8) : 0;
                    $total_paid_ot+=$wkd_ot;
                    echo '<td>' . number_format($wkd_ot, 2) . '</td>';
                }
                ?>
                <td><?= number_format($total_paid_ot, 2) ?></td>
            </tr>
            <tr>
                <td>Total Hours</td>
                <?php
                foreach ($dateRange as $dr) {
                    echo '<td>' . number_format($totalHours[$dr], 2) . '</td>';
                    $total_paid_hours+=$totalHours[$dr];
                }
                ?>
                <td><?= number_format($total_paid_hours, 2) ?></td>
            </tr>
        </table>
    </div>
</div>

<br>
<a href="<?=Yii::app()->request->urlReferrer?>" class="btn btn-info pull-left">Back</a>
<button onclick="printDiv()" class="btn btn-success pull-right">Print</button>

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
        }, 2);
    }
</script>

<!--<p class="margintop20 text-center">
    <i class="icon-circle" style="color:green;font-size:16px;"></i> Clocked in
    <i class="icon-circle" style="color:red;font-size:16px;"></i> Clocked out
</p>-->