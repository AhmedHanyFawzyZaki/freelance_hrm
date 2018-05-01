<?php

class ActivityLogController extends AdminController {

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
        $model = new ActivityLog;
        $model->time_in = date('Y-m-d H:i');
        $model->time_out = date('Y-m-d H:i', strtotime('+4 hour'));

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['ActivityLog'])) {
            $model->attributes = $_POST['ActivityLog'];
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

        if (isset($_POST['ActivityLog'])) {
            $model->attributes = $_POST['ActivityLog'];
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
        }
        else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        $model = new ActivityLog('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['ActivityLog']))
            $model->attributes = $_GET['ActivityLog'];

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
        $model = ActivityLog::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'activity-log-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionPunch() {
        $in_time = ActivityLog::model()->find(array('condition' => 'user_id=' . Yii::app()->user->id . ' and DATE_FORMAT(time_in,"%Y-%m-%d") = "' . date('Y-m-d') . '" and (time_out is null or time_out="")'));
        $user = User::model()->findByPk(Yii::app()->user->id);
        $message = '';
        $to = $user->checkinout_email;
        if ($in_time) {
            $in_time->time_out = date('Y-m-d H:i:00');
            $msg = json_encode(array('status' => '2', 'msg' => 'You have successfully punched out at (' . Timeoff::getTime($in_time->time_out) . ').'));
            if ($user->checkout_notification && $user->checkinout_notification && $user->checkinout_email) {
                $message = '(' . $user->title . ') ' . $user->username . ' has checked out at "' . Timeoff::getTime($in_time->time_out) . '"';
            }
        } else {
            $in_time = new ActivityLog;
            $in_time->time_in = date('Y-m-d H:i:00');
            $in_time->user_id = Yii::app()->user->id;
            $msg = json_encode(array('status' => '1', 'msg' => 'You have successfully punched in at (' . Timeoff::getTime($in_time->time_in) . ').'));
            if ($user->checkin_notification && $user->checkinout_notification && $user->checkinout_email) {
                $message = '(' . $user->title . ') ' . $user->username . ' has checked in at "' . Timeoff::getTime($in_time->time_out) . '"';
            }
            $depTime=date('Y-m-d').' '.$user->department->in_time;
            if(strtotime($in_time->time_in) > strtotime($depTime)  && $user->checkin_late_notification && $user->checkin_late_email){
                $message = '(' . $user->title . ') ' . $user->username . ' has checked in late at "' . Timeoff::getTime($in_time->time_out) . '"';
                $to = $user->checkin_late_email;
            }
        }
        $in_time->status = 0;

        if ($in_time->save()) {
            /*             * ********** */
            if ($user->company_id && $message) {

                $subject = Yii::app()->name . ' Notification';
                $fromEmail = $user->company->email;
                $fromName = $user->company->name;
                $from = $fromName . ' <' . $fromEmail . '>';
                Helper::SendMail($from, $to, $subject, $message);
            }
            /*             * ********** */
            echo $msg;
        } else {
            echo json_encode(array('status' => '0', 'msg' => 'Something went wrong!'));
        }
    }

    public function actionTimeCards() {
        $id = $_GET['id'];
        $from = $_GET['from'];
        $to = $_GET['to'];
        $user = User::model()->findByPk($id);
        $company = Company::model()->findByPk($user->company_id);
        $period = 14;
        if (isset($_GET['period']))
            $period = $_GET['period'];
        /* $next_period_from = date('Y-m-d', strtotime($from) + (($period + 1) * 24 * 60 * 60));
          $next_period_to = date('Y-m-d', strtotime($to) + ($period * 24 * 60 * 60));
          $previous_period_from = date('Y-m-d', strtotime($from) - ($period * 24 * 60 * 60));
          $previous_period_to = date('Y-m-d', strtotime($to) - ($period * 24 * 60 * 60)); */
        $next_period_from = date('Y-m-d', strtotime('+' . $period . ' day', strtotime($from)));
        $next_period_to = date('Y-m-d', strtotime('+' . $period . ' day', strtotime($to)));
        $previous_period_from = date('Y-m-d', strtotime('-' . $period . ' day', strtotime($from)));
        $previous_period_to = date('Y-m-d', strtotime('-' . $period . ' day', strtotime($to)));

        $cards = ActivityLog::model()->findAll(array('condition' => 'user_id="' . $_GET['id'] . '" and DATE_FORMAT(time_in,"%Y-%m-%d")>="' . $_GET['from'] . '" and DATE_FORMAT(time_out,"%Y-%m-%d")<="' . $_GET['to'] . '"'));

        $this->render('time-cards', array(
            'user' => $user,
            'from' => $from,
            'to' => $to,
            'next_period_from' => $next_period_from,
            'next_period_to' => $next_period_to,
            'previous_period_from' => $previous_period_from,
            'previous_period_to' => $previous_period_to,
            'period' => $period,
            'company' => $company
        ));
    }

    public function actionReport() {
        $company = Company::model()->findByPk(Yii::app()->user->getState('company'));
        $time_from = date('m/d/Y', strtotime(Company::PayrollStart($company->id)));
        $time_to = date('m/d/Y', strtotime(Company::PayrollLast($company->id, $time_from)));

        $this->render('report', array(
            'company' => $company,
            'time_from' => $time_from,
            'time_to' => $time_to,
        ));
    }

    public function actionGetDateRange() {
        $company = Company::model()->findByPk(Yii::app()->user->getState('company'));
        $period = $_GET['period'];
        $time_from = date('m/d/Y', strtotime(Company::PayrollStart($company->id, $period)));
        $time_to = date('m/d/Y', strtotime(Company::PayrollLast($company->id, $time_from, $period)));

        $arr['from'] = $time_from;
        $arr['to'] = $time_to;
        echo json_encode($arr);
    }

    public function actionChangeStatus() {
        $id = $_GET['id'];
        $status = $_GET['status'];
        ActivityLog::model()->updateAll(array('status' => $status), 'id=' . $id);
        $this->redirect(array('view', 'id' => $id));
    }

}
