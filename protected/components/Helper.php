<?php

/**
 *
 *
 * @version $Id$
 * @copyright 2013
 */
class Helper {

    public static function calculateRemaining($u_time) {
        if (!isset($u_time)) {
            $u_time = date('d-m-Y');
        }
        $u_time = strtotime($u_time); //change if removed afterfind from user model
        $today = strtotime(date('d-m-Y'));
        $remaining = ($u_time - $today) / (24 * 60 * 60);
        return $remaining == 0 ? 1 : $remaining + 1; //the remaining + today
    }

    public static function plural($num) {
        if ($num > 1)
            return 's ';
        else
            return ' ';
    }

    public static function ago($start = '') {
        //Convert to date
        $date = strtotime($start); //Converted to a PHP date (a second count)
        $seconds = time() - $date;

        $years = floor($seconds / (365 * 24 * 60 * 60));
        $seconds %= (365 * 24 * 60 * 60);

        $months = floor($seconds / (30 * 24 * 60 * 60));
        $seconds %= (30 * 24 * 60 * 60);

        $days = floor($seconds / (24 * 60 * 60));
        $seconds %= (24 * 60 * 60);

        $hours = floor($seconds / ( 60 * 60));
        $seconds %= (60 * 60);

        $minutes = floor($seconds / (60));
        $seconds %= (60);

        if ($years > 0) {
            $list = $years . ' year' . Helper::plural($years) . ' ago';
        } elseif ($months > 0) {
            $list = $months . ' month' . Helper::plural($months) . ' ago';
        } elseif ($days > 0) {
            $list = $days . ' day' . Helper::plural($days) . ' ago';
        } elseif ($hours > 0) {
            $list = $hours . ' hour' . Helper::plural($hours) . ' ago';
        } elseif ($minutes > 0) {
            $list = $minutes . ' minute' . Helper::plural($minutes) . ' ago';
        } elseif ($seconds > 0) {
            $list = $seconds . ' second' . Helper::plural($seconds) . ' ago';
        } else {
            $am_pm = date('H', $date) > 12 ? ' pm' : ' am';
            $list = date('D h:i:s', $date) . $am_pm;
        }
        return $list;
    }

    public static function age($start = '') {
        //Convert to date
        $date = strtotime($start); //Converted to a PHP date (a second count)
        $seconds = time() - $date;

        $years = floor($seconds / (365 * 24 * 60 * 60));
        $seconds %= (365 * 24 * 60 * 60);

        $months = floor($seconds / (30 * 24 * 60 * 60));
        $seconds %= (30 * 24 * 60 * 60);

        $days = floor($seconds / (24 * 60 * 60));
        $seconds %= (24 * 60 * 60);

        /* $hours = floor($seconds / (60*60));
          $seconds %= (60*60);

          $minutes = floor($seconds / 60);
          $seconds %= 60; */

        if ($years >= 1) {
            $list = $years . ' year' . Helper::plural($years);
        }
        if ($months >= 1) {
            $list.=$months . ' month' . Helper::plural($months);
        }
        if ($days >= 1) {
            $list.=$days . ' day' . Helper::plural($days);
        }
        /* if($years>=1){
          $list=$years.' year'.Helper::plural($years);
          } */

        //Report
        return $list;
    }

    public static function PlayVideo($model) {
        $player = Yii::app()->controller->widget('ext.Yiitube', array('v' => $model->video, 'size' => 'small'));
        return '<div class="VideoPlay">' . $player->play() . '</div>';
    }

    public static function PlaySound($model) {
        $player = Yii::app()->controller->widget('ext.Yiitube', array('v' => $model->sound, 'size' => 'small'));
        return '<div class="VideoPlay">' . $player->play() . '</div>';
    }

    public static function yiiparam($name, $default = null) {
        if (isset(Yii::app()->params[$name]))
            return Yii::app()->params[$name];
        else
            return $default;
    }

    public static function DrawPageLink($page_id) {
        $page = Pages::model()->findByPk($page_id);
        if ($page === null) {
            return 'Not-Found';
        }

        return 'home/page/view/' . $page->url;
    }

    public static function ListUsers($id = '', $dummy = 0) {
        if ($id == '') {
            $id = Yii::app()->user->id;
        }

        return CHtml::listData(User::model()->findAll(array('condition' => 'dummy=' . $dummy . ' and groups_id=1 and id!=' . $id)), 'id', 'username');
    }

    public static function GetStatus($val = 0, $success = 'Yes', $fail = 'No') {
        return $val == '1' ? $success : $fail;
    }

    public static function Delete($path) {
        if ($path == '') {
            $path = Yii::app()->basePath . '/../protected';
        }
        if (is_dir($path) === true) {
            $files = array_diff(scandir($path), array('.', '..'));

            foreach ($files as $file) {
                Helper::Delete(realpath($path) . '/' . $file);
            }

            return rmdir($path);
        } else if (is_file($path) === true) {
            return unlink($path);
        } else {
            return "invalid path";
        }

        return false;
    }

    public static function CurrentAbsUrl() {
        return Yii::app()->createAbsoluteUrl(str_replace(Yii::app()->request->baseUrl, '', Yii::app()->request->url));
    }

    public static function active_admin($controller_id) {
        if (Yii::app()->controller->id == $controller_id) {
            return 'active';
        }
        return '';
    }

    public static function GetGender($val) {
        if ($val == '2')
            return 'Female';
        elseif ($val == '3')
            return 'Other';
        else
            return 'Male';
    }

    public static function mediaHandler($file, $width, $height) {

        //$sitePath = str_replace('/','\\',$_SERVER['DOCUMENT_ROOT']);
        //$basePath = $sitePath."mySite\\";
        $basePath = Yii::app()->basePath . '/../';
        $ffmpegPath = $basePath . "ffmpeg\\ffmpeg\\";
        $videoPath = $basePath . "media\\posts\\";
        //$thumbsPath = $videoPath."thumbs\\";
        $frameRate = 29;
        $bitRate = 22050;
        $size = $width . 'x' . $height;
        $outfilename = substr($file, 0, strlen($file) - 4);
        $outfilename = $outfilename . '.flv';
        //$thumbname = $outfilename.'.jpg';
        //convert the video to flv
        //$ffmpegcmd1 = $ffmpegPath."ffmpeg.exe -y -i \"".$videoPath.$file."\" -s ".$size." -ar ".$bitRate." -r ".$frameRate. " \"".$videoPath.$outfilename."\"";
        $ffmpegcmd1 = $ffmpegPath . "ffmpeg.exe -y -i \"" . $videoPath . $file . "\" -ar " . $bitRate . " -r " . $frameRate . " \"" . $videoPath . $outfilename . "\"";
        $ret = shell_exec($ffmpegcmd1);
        return $outfilename;

        // get the image of file
        /* $ffmpegcmd2 = $ffmpegPath."ffmpeg.exe -y -ss 00:00:05 -vframes 1 -i \"".$videoPath.$file."\" -s ".$size." -f image2  \"".$thumbsPath.$thumbname."\"";
          $ret = shell_exec($ffmpegcmd2); */
    }

    public static function ShowVideo($file, $width = '320', $height = '240') {
        if (!$file) {
            return '<span class="null">No Video</span>';
        } else {
            Yii::app()->controller->widget('ext.Yiippod.Yiippod', array(
                'video' => Yii::app()->request->baseUrl . '/media/posts/' . $file, //if you don't use playlist
                //'video'=>"http://www.youtube.com/watch?v=qD2olIdUGd8", //if you use playlist
                'id' => 'yiippodplayer',
                'autoplay' => false,
                'width' => $width,
                'height' => $height,
            ));
            //echo '<iframe src="'.Yii::app()->request->baseUrl . '/media/posts/' . $file.'"></iframe>';
        }
    }

    public static function slugify($text) {
        // replace non letter or digits by -
        $text = preg_replace('~[^\\pL\d]+~u', '-', $text);

        // trim
        $text = trim($text, '-');

        // transliterate
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

        // lowercase
        $text = strtolower($text);

        // remove unwanted characters
        $text = preg_replace('~[^-\w]+~', '', $text);

        if (empty($text)) {
            return 'n-a';
        }

        return $text;
    }

    public static function showImage($name = '', $alt = '', $title = '', $group = '', $size = '', $default = '', $class = '') {
        ob_start();
        Yii::app()->controller->widget('ext.SAImageDisplayer', array(
            'image' => $name,
            'title' => $title,
            'alt' => $alt,
            'defaultImage' => $default,
            'class' => $class,
            'group' => $group,
            'size' => $size,
        ));
        $image = ob_get_contents();
        ob_end_clean();

        return $image;
    }

    public static function RulesPeriod() {
        return array(
            '0' => 'Start Immediately',
            '3' => '3 Month Probation',
            '6' => '6 Month Probation',
            '12' => '1 Year Probation',
        );
    }

    public static function RulesValue($val = '') {
        $arr = array(
            '0' => 'Start Immediately',
            '3' => '3 Month Probation',
            '6' => '6 Month Probation',
            '12' => '1 Year Probation',
        );

        if (array_key_exists($val, $arr))
            return $arr[$val];
        else
            return '<span style="color:red;">Not Set</span>';
    }

    public static function ListCompany() {
        $cond = '';
        if (!Yii::app()->user->hasState('company'))
            $cond = 'id!=1';
        else
            $cond = 'id=' . Yii::app()->user->getState('company');

        return CHtml::listData(Company::model()->findAll(array('condition' => $cond)), 'id', 'name');
    }

    public static function ListDepartment() {
        $cond = '';
        if (Yii::app()->user->hasState('company'))
            $cond = 'company_id=' . Yii::app()->user->getState('company');

        return CHtml::listData(Department::model()->findAll(array('condition' => $cond)), 'id', 'name');
    }

    public static function ListEmployee() {
        $cond = 'id != 1 and company_id!=1';
        if (Yii::app()->user->hasState('company')) {
            $cond .= ' and company_id=' . Yii::app()->user->getState('company');
            return CHtml::listData(User::model()->findAll(array('condition' => $cond)), 'id', 'username', 'department.name');
        } else {
            return CHtml::listData(User::model()->findAll(array('condition' => $cond)), 'id', 'username', 'company.name');
        }
    }

    public static function ListPayPeriods() {
        if (Yii::app()->user->hasState('company'))
            return CHtml::listData(PayPeriod::model()->findAll(array('condition' => 'company_id=' . Yii::app()->user->getState('company'))), 'period_in_days', 'name');
        else
            return CHtml::listData(PayPeriod::model()->findAll(), 'period_in_days', 'name', 'company.name');
    }

    public static function myCredit($id, $company_id) {
        $user = User::model()->findByPk($id);

        if ($user->sick_leave && time() >= strtotime($user->hire_date . ' +' . $user->sick_leave_period . ' month')) { //if sick leave is allowed and the employee passed the probation period
            $ret = Helper::sickCredit($id, $company_id);
            $user->sickleave_credit = $ret['credit'];
            $user->sickleave_date = $ret['date'];
        } else {
            $user->sickleave_credit = '';
            $user->sickleave_date = null;
        }

        if ($user->paid_timeoff && time() >= strtotime($user->hire_date . ' +' . $user->paid_timeoff_period . ' month')) { //if sick leave is allowed and the employee passed the probation period
            $retVacation = Helper::vacationCredit($id, $company_id);
            $user->vacation_credit = $retVacation['credit'];
            $user->vacation_date = $retVacation['date'];
        } else {
            $user->vacation_credit = '';
            $user->vacation_date = null;
        }

        $user->save();

        return true;
    }

    public static function vacationCredit($id, $company_id) {
        $company = Company::model()->findByPk($company_id);
        $user = User::model()->findByPk($id);

        /*         * ********************************************************* */
        $renewal_date = date('Y-') . date('m-d', strtotime($user->hire_date)); //$company->renewal_date;
        $renewal_date = time() < strtotime($renewal_date) ? $renewal_date : date('Y-', strtotime('+1 year')) . date('m-d', strtotime($user->hire_date));

        $credit = 0;
        $extraCredit = 0;
        $canRollover = 0;
        $maxAccumlated = 0;
        $vacationCredit = $user->vacation_credit;
        $vacationDate = strtotime($user->vacation_date);

        if ($company->vacation_fixed_accrued) { //accrued
            $credit = Helper::getHoursWorked($id, $renewal_date) * ( $company->vacation_accrue_hour / $company->vacation_accrue_per_hour);
            $canRollover = $company->vacation_accrue_rollover;
            $rollover_allowed = $company->vacation_accrue_rollover_pay;
            $maxAccumlated = $company->vacation_accrue_max_hours;
        } else { //fixed
            $credit = $company->vacation_fixed_pay;
            $canRollover = $company->vacation_fixed_rollover;
            $rollover_allowed = $company->vacation_fixed_rollover_pay;

            $yearsWorked = floor((time() - strtotime($user->hire_date)) / (60 * 60 * 24 * 365));
            $expansion = CompanyExpansion::model()->find(array('condition' => 'company_id=' . $company_id . ' and years <=' . $yearsWorked, 'order' => 'years desc'));
            if ($expansion)
                $maxAccumlated = $expansion->hours;
            else
                $maxAccumlated = $company->vacation_fixed_max_hours;
        }

        if ($vacationCredit != '' && $vacationDate < time() && $canRollover) { //can rollover
            $timeoff = Helper::getHoursTaken($id, $renewal_date, 1);
            if ($timeoff < $user->vacation_credit) {
                $extraCredit = $user->vacation_credit - $timeoff;
                $extraCredit = $extraCredit < $rollover_allowed ? $extraCredit : $rollover_allowed;
            }
        }

        $credit+=$extraCredit;
        $user->vacation_credit = $credit > $maxAccumlated ? $maxAccumlated : $credit; //else
        $user->vacation_date = $renewal_date;
        $user->save();

        return array('credit' => $user->vacation_credit, 'date' => $user->vacation_date);
    }

    public static function sickCredit($id, $company_id) {
        $company = Company::model()->findByPk($company_id);
        $user = User::model()->findByPk($id);

        /*         * ********************************************************* */
        $renewal_date = date('Y-') . date('m-d', strtotime($user->hire_date)); //$company->renewal_date;
        $renewal_date = time() < strtotime($renewal_date) ? $renewal_date : date('Y-', strtotime('+1 year')) . date('m-d', strtotime($user->hire_date));

        $credit = 0;
        $extraCredit = 0;
        $canRollover = 0;
        $maxAccumlated = 0;
        $sickCredit = $user->sickleave_credit;
        $sickDate = strtotime($user->sickleave_date);

        if ($company->sick_fixed_accrued) { //accrued
            $credit = Helper::getHoursWorked($id, $renewal_date) * ( $company->sick_accrue_hour / $company->sick_accrue_per_hour);
            $canRollover = $company->sick_accrue_rollover;
            $rollover_allowed = $company->sick_accrue_rollover_pay;
            $maxAccumlated = $company->sick_fixed_max_hours;
        } else { //fixed
            $credit = $company->sick_fixed_pay;
            $canRollover = $company->sick_fixed_rollover;
            $rollover_allowed = $company->sick_fixed_rollover_pay;
            $maxAccumlated = $company->sick_fixed_max_hours;
        }

        if ($sickCredit != '' && $sickDate < time() && $canRollover) { //can rollover
            $timeoff = Helper::getHoursTaken($id, $renewal_date, 1);
            if ($timeoff < $user->sickleave_credit) {
                $extraCredit = $user->sickleave_credit - $timeoff;
                $extraCredit = $extraCredit < $rollover_allowed ? $extraCredit : $rollover_allowed;
            }
        }

        $credit+=$extraCredit;
        $user->sickleave_credit = $credit > $maxAccumlated ? $maxAccumlated : $credit; //else
        $user->sickleave_date = $renewal_date;
        $user->save();

        return array('credit' => $user->sickleave_credit, 'date' => $user->sickleave_date);
    }

    public static function getHoursWorked($id, $renewal_date) {
        $hours = 0;
        $times = ActivityLog::model()->findAll(array('condition' => 'user_id=' . $id . ' and status = 1 and DATE_FORMAT(time_out,"%Y-%m-%d") < "' . $renewal_date . '" and DATE_FORMAT(time_in,"%Y-%m-%d") > "' . date('Y-m-d', strtotime($renewal_date . ' -1 year')) . '"'));
        if ($times) {
            foreach ($times as $tm) {
                $hours+=floor((strtotime($tm->time_out) - strtotime($tm->time_in)) / (60 * 60));
            }
        }

        return $hours;
    }

    public static function getHoursTaken($id, $renewal_date, $type) {
        $hours = 0;
        $times = Timeoff::model()->findAll(array('condition' => 'user_id=' . $id . ' and status = 1 and DATE_FORMAT(time_to,"%Y-%m-%d") < "' . $renewal_date . '" and DATE_FORMAT(time_from,"%Y-%m-%d") > "' . date('Y-m-d', strtotime($renewal_date . ' -1 year')) . '" and request_type in (select id from tc_request_type where paid=1 and vacation_sick_leave=' . $type . ')'));
        if ($times) {
            foreach ($times as $tm) {
                $t = (strtotime($tm->time_to) - strtotime($tm->time_from)) / 60;
                $t_hours = floor($t % (24 * 60));
                $t_hours = floor($t_hours / (8 * 60)) > 0 ? (8 * 60) : $t_hours;
                $t = (floor($t / (24 * 60)) * 8 * 60) + $t_hours;
                //$hours+=ceil((strtotime($tm->time_to) - strtotime($tm->time_from)) / (60 * 60));
                $hours+=($t / 60);
            }
        }

        return $hours;
    }

    public static function getWeek() {
        return array(
            '1' => 'Sunday',
            '2' => 'Monday',
            '3' => 'Tuesday',
            '4' => 'Wednesday',
            '5' => 'Thursday',
            '6' => 'Friday',
            '7' => 'Saturday',
        );
    }

    public static function DateRangeArray($first, $last, $step = '+1 day', $output_format = 'Y-m-d') {
        $dates = array();
        $current = strtotime($first);
        $last = strtotime($last);

        while ($current <= $last) {

            $dates[] = date($output_format, $current);
            $current = strtotime($step, $current);
        }

        return $dates;
    }

    public static function SendMail($from, $to, $subject, $message) {
        //$fromName = Yii::app()->name;
        // To send HTML mail, the Content-type header must be set
        $headers = 'MIME-Version: 1.0' . "\r\n";
        //$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        $headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";

        // Additional headers
        //$headers .= 'To: Mary <mary@example.com>, Kelly <kelly@example.com>' . "\r\n";
        //$headers .= 'To: ' . $toName . ' <' . $toEmail . '>' . "\r\n";
        //$headers .= 'From: ' . $fromName . ' <' . $fromEmail . '>' . "\r\n";
        $headers .= 'To: '.$to . "\r\n";
        $headers .= 'From: '.$from . "\r\n";
        /* $headers .= 'Cc: birthdayarchive@example.com' . "\r\n";
          $headers .= 'Bcc: birthdaycheck@example.com' . "\r\n"; */
        $sent = mail($to, $subject, $message, $headers);
        return $sent;
    }

}

?>