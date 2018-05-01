<?php

/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class AdminController extends CController {

    /**
     * @var string the default layout for the controller view. Defaults to '//layouts/column1',
     * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
     */
    public $layout = '//layouts/main';
    public $pageTitlecrumbs;

    /**
     * @var array context menu items. This property will be assigned to {@link CMenu::items}.
     */
    public $menu = array();

    /**
     * @var array the breadcrumbs of the current page. The value of this property will
     * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
     * for more details on how to specify this property.
     */
    public $breadcrumbs = array();

    public function init() {
        // set the default theme for any other controller that inherit the admin controller
        Yii::app()->theme = 'bootstrap';
    }

    protected function beforeAction($action) {

        if ((isset($_GET['frame']) && $_GET['frame'] == 1) || (strpos($_SERVER['HTTP_REFERER'], 'frame=1'))) {
            $this->layout = '//layouts/frame';
        }

        //if the user is not admin redirect to the home page

        if (Yii::app()->user->isGuest) {
            $this->redirect(Yii::app()->request->baseUrl . '/dashboard');
        }

        /*         * **********************check for controller permission for the company admins************************************* */
        if (Yii::app()->user->getState('usertype') != Yii::app()->params['Admin']) {
            $permissions = Yii::app()->user->getState('userpermissions');
            //var_dump($permissions);die;
            $controller = strtolower(Yii::app()->controller->id);
            $access = 0;

            if (Yii::app()->user->getState('usertype') == Yii::app()->params['subAdmin']) {
                if ($controller == 'department' && $permissions['admin'] == 1 && $permissions['company_department'] == 1)
                    $access = 1;
                elseif ($controller == 'user' && $permissions['admin'] == 1 && $permissions['company_user'] == 1)
                    $access = 1;
                elseif ($controller == 'requesttype' && $permissions['admin'] == 1 && $permissions['company_settings'] == 1)
                    $access = 1;
                elseif ($controller == 'company' && $permissions['admin'] == 1 && $permissions['company_settings'] == 1)
                    $access = 1;
                elseif ($controller == 'paidHoliday' && $permissions['admin'] == 1 && $permissions['company_settings'] == 1)
                    $access = 1;
                elseif ($controller == 'timeoff' && $permissions['admin'] == 1 && $permissions['company_timeoff'] == 1)
                    $access = 1;
                elseif ($controller == 'activitylog' && $permissions['admin'] == 1 && $permissions['company_activity'] == 1)
                    $access = 1;
                elseif ($controller == 'payroll' && $permissions['admin'] == 1 && $permissions['company_reports'] == 1)
                    $access = 1;
                elseif ($controller == 'paidholiday' && $permissions['admin'] == 1 && $permissions['company_pay_info'] == 1)
                    $access = 1;
                elseif ($controller == 'payperiod' && $permissions['admin'] == 1 && $permissions['company_pay_info'] == 1)
                    $access = 1;
            }else {
                $action = strtolower(Yii::app()->controller->action->id);
                if ($controller == 'activitylog' && $action != 'update' && $permissions['activity_log_create'] == 1)
                    $access = 1;
                elseif ($controller == 'activitylog' && $action != 'create' && $permissions['activity_log_update'] == 1)
                    $access = 1;
                elseif ($controller == 'activitylog' && $action != 'update' && $permissions['punch'] == 1)
                    $access = 1;
                elseif ($controller == 'payroll' && $action == 'slip' && $permissions['pay_info'] == 1)
                    $access = 1;
                elseif ($controller == 'timeoff' && $action != 'update' && $permissions['time_off'] == 1)
                    $access = 1;
                elseif ($controller == 'user' && $action == 'view') //&& $permissions['report'] == 1
                    $access = 1;
            }

            if ($controller == 'faq' || $controller == 'systemlog')
                $access = 1;

            if (!$access)
                $this->redirect(Yii::app()->request->getBaseUrl(true) . '/dashboard/invalidPermission');
        }
        return parent::beforeAction($action);
    }

}
