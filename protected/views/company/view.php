<?php

$this->breadcrumbs = array(
    'Companies' => array('index'),
    $model->name,
);

$this->menu = array(
    array('label' => Yii::t('translate', 'List Company'), 'url' => array('index')),
    array('label' => Yii::t('translate', 'Create Company'), 'url' => array('create')),
    array('label' => Yii::t('translate', 'Update Company'), 'url' => array('update', 'id' => $model->id)),
    array('label' => Yii::t('translate', 'Delete Company'), 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->id), 'confirm' => 'Are you sure you want to delete this item?')),
);
?>

<?php $this->pageTitlecrumbs = Yii::t('translate', 'View Company') . ' "' . $model->name . '"'; ?>
<?php

/* 'vacation_fixed_accrued',
  'vacation_fixed_pay',
  'vacation_fixed_rollover',
  'vacation_fixed_rollover_pay',
  'vacation_fixed_max_hours',
  'vacation_accrue_hour',
  'vacation_accrue_per_hour',
  'vacation_accrue_rollover',
  'vacation_accrue_rollover_pay',
  'vacation_accrue_max_hours',
 * 
 */

$primary = array(
    'name',
    'email',
    'pay_period' => array(
        'name' => 'pay_period',
        'value' => PayPeriod::listPeriods($model->pay_period)
    ),
    'start_on' => array(
        'name' => 'start_on',
        'value' => date('d F Y', strtotime($model->start_on)),
    ),
);

if ($model->sick_fixed_accrued) {
    $sick = array(
        'sick_fixed_accrued' => array(
            'name' => 'sick_fixed_accrued',
            'value' => $model->sick_fixed_accrued ? 'Accrued' : 'Fixed amount per year'
        ),
        'sick_accrue_hour',
        'sick_accrue_per_hour',
        'sick_accrue_rollover'=>array(
            'name'=>'sick_accrue_rollover',
            'value'=>$model->sick_accrue_rollover?'Yes':'No'
        ),
        'sick_accrue_rollover_pay',
        'sick_accrue_max_hours',
    );
} else {
    $sick = array(
        'sick_fixed_accrued' => array(
            'name' => 'sick_fixed_accrued',
            'value' => $model->sick_fixed_accrued ? 'Accrued' : 'Fixed amount per year'
        ),
        'sick_fixed_pay',
        'sick_fixed_rollover'=>array(
            'name'=>'sick_fixed_rollover',
            'value'=>$model->sick_fixed_rollover?'Yes':'No'
        ),
        'sick_fixed_rollover_pay',
        'sick_fixed_max_hours',
    );
}

if ($model->vacation_fixed_accrued) {
    $vacation = array(
        'vacation_fixed_accrued' => array(
            'name' => 'vacation_fixed_accrued',
            'value' => $model->vacation_fixed_accrued ? 'Accrued' : 'Fixed amount per year'
        ),
        'vacation_accrue_hour',
        'vacation_accrue_per_hour',
        'vacation_accrue_rollover'=>array(
            'name'=>'vacation_accrue_rollover',
            'value'=>$model->vacation_accrue_rollover?'Yes':'No'
        ),
        'vacation_accrue_rollover_pay',
        'vacation_accrue_max_hours',
    );
} else {
    $vacation = array(
        'vacation_fixed_accrued' => array(
            'name' => 'vacation_fixed_accrued',
            'value' => $model->vacation_fixed_accrued ? 'Accrued' : 'Fixed amount per year'
        ),
        'vacation_fixed_pay',
        'vacation_fixed_rollover'=>array(
            'name'=>'vacation_fixed_rollover',
            'value'=>$model->vacation_fixed_rollover?'Yes':'No'
        ),
        'vacation_fixed_rollover_pay',
        'vacation_fixed_max_hours',
    );
}

$this->widget('bootstrap.widgets.TbDetailView', array(
    'data' => $model,
    'attributes' => array_merge($primary, $sick, $vacation),
));
?>
