<?php

class TimeoffController extends AdminController {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column2';

    /**
     * @return array action filters
     */
    public function filters() {
        return array(
                /* 'accessControl', // perform access control for CRUD operations */
        );
    }

    public function actions() {
        return array(
            'order' => array(
                'class' => 'ext.yiisortablemodel.actions.AjaxSortingAction',
            ),
        );
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules() {
        return array(
            array('allow', // allow all users to perform 'index' and 'view' actions
                'actions' => array('index', 'view'),
                'users' => array('*'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('create', 'update'),
                'users' => array('@'),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('admin', 'delete'),
                'users' => array('admin'),
            ),
            array('allow', 'actions' => array('order'), 'users' => array('@')),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id) {
        $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $model = new Timeoff;
        $model->time_from = date('m/d/Y H:i');
        $model->time_to = date('m/d/Y H:i', strtotime('+4 hour'));

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Timeoff'])) {
            $model->attributes = $_POST['Timeoff'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->id));
        }

        $this->render('create', array(
            'model' => $model,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $model = $this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Timeoff'])) {
            $model->attributes = $_POST['Timeoff'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->id));
        }

        $this->render('update', array(
            'model' => $model,
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {
        if (Yii::app()->request->isPostRequest) {
            // we only allow deletion via POST request
            $this->loadModel($id)->delete();

            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
        } else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        $model = new Timeoff('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Timeoff']))
            $model->attributes = $_GET['Timeoff'];

        $this->render('index', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id) {
        $model = Timeoff::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'timeoff-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionCalculate() {
        $from = date('Y-m-d H:i',strtotime($_POST['from']));
        $to = date('Y-m-d H:i',strtotime($_POST['to']));
        $user = $_POST['user'];
        $request = $_POST['request'];
        
        $period = (strtotime($to) - strtotime($from)) / 60; //minutes
        $period_hours = floor($period % (24 * 60));
        $period_hours = floor($period_hours / (8 * 60)) > 0 ? (8 * 60) : $period_hours;
        $period = (floor($period / (24 * 60)) * 8 * 60) + $period_hours;

        $employee = User::model()->findByPk($user);
        Helper::myCredit($user, $employee->company_id); //update user timeoff fields
        $employee = User::model()->findByPk($user); //reselect employee to get the updated values
        $company = Company::model()->findByPk($employee->company_id);
        $paid_request = RequestType::model()->findByPk($request)->paid;
        $vacation_sick_leave = RequestType::model()->findByPk($request)->vacation_sick_leave;

        $time_available = $vacation_sick_leave ? $employee->sickleave_credit : $employee->vacation_credit; //$company->paid_time_available;
        $time_available *= 60; //convert it to minutes
        /*         * ********************************************************* */
        $renewal_date = date('Y-') . date('m-d', strtotime($employee->hire_date)); //$company->renewal_date;
        $renewal_date = $to < $renewal_date ? $renewal_date : date('Y-', strtotime('+1 year')) . date('m-d', strtotime($employee->hire_date));

        $times = Timeoff::model()->findAll(array('condition' => 'user_id=' . $user . ' and status = 1 and DATE_FORMAT(time_to,"%Y-%m-%d") < "' . $to . '" and DATE_FORMAT(time_to,"%Y-%m-%d") < "' . $renewal_date . '" and DATE_FORMAT(time_from,"%Y-%m-%d") > "' . date('Y-m-d', strtotime($renewal_date . ' -1 year')) . '" and request_type in (select id from tc_request_type where paid=1 and vacation_sick_leave=' . $vacation_sick_leave . ')'));
        $used_time = 0;
        if ($times) {
            foreach ($times as $tm) {
                $t = (strtotime($tm->time_to) - strtotime($tm->time_from)) / 60;
                $t_hours = floor($t % (24 * 60));
                $t_hours = floor($t_hours / (8 * 60)) > 0 ? (8 * 60) : $t_hours;
                $t = (floor($t / (24 * 60)) * 8 * 60) + $t_hours;
                $used_time += $t;
            }
        }

        $class = $time_available >= $used_time + $period ? 'alert-success' : 'alert-danger';
        if ($paid_request && Timeoff::canRequest($user, $vacation_sick_leave)) {
            if ($time_available >= $used_time + $period) {
                $paid_time = $period;
                $unpaid_time = 0;
            } else {
                $unpaid_time = abs($time_available - ($used_time + $period));
                $paid_time = abs($period - $unpaid_time);
            }
        } else {
            $unpaid_time = $period;
            $paid_time = 0;
            $class = 'alert-danger';
        }
        $time_str = floor($time_available / 60) . ' hour(s) ';
        $time_str.=$time_available % 60 ? ($time_available % 60) . ' minute(s)' : '';

        $used_str = floor($used_time / 60) . ' hour(s) ';
        $used_str.=$used_time % 60 ? ($used_time % 60) . ' minute(s)' : '';

        $period_str = floor($period / 60) . ' hour(s) ';
        $period_str.=$period % 60 ? ($period % 60) . ' minute(s)' : '';

        $paid_str = floor($paid_time / 60) . ' hour(s) ';
        $paid_str.=$paid_time % 60 ? ($paid_time % 60) . ' minute(s)' : '';
        
        if($unpaid_time>$period)
            $unpaid_time=$period;

        $unpaid_str = floor($unpaid_time / 60) . ' hour(s) ';
        $unpaid_str.=$unpaid_time % 60 ? ($unpaid_time % 60) . ' minute(s)' : '';
        echo '<table class="items table table-condensed table-striped alert ' . $class . '"><tr><td>Total Paid Time Available</td><td>Total Time off taken</td><td>Requested Time off</td><td>Requested Time off (Paid)</td><td>Requested Time off(Unpaid)</td></tr>
        <tr><td>' . $time_str . '</td><td>' . $used_str . '</td><td>' . $period_str . '</td><td>' . $paid_str . '</td><td>' . $unpaid_str . '</td></tr></table>';
    }
    
    public function actionChangeStatus() {
        $id=$_GET['id'];
        $status=$_GET['status'];
        Timeoff::model()->updateAll(array('status'=>$status),'id='.$id);
        $this->redirect(array('view', 'id' => $id));
    }

}
