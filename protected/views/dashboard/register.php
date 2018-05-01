<div class="white-bg">
    <div class="row-fluid">
        <div class="span10">
            <h3 class="head-title">Sign up</h3>
            <p>Fill in the form below to setup your company.</p>
        </div>
        <div class="span2"><i class="fa fa-pencil big-icon"></i></div>
    </div>
    <hr>
    <div class="row-fluid">
        <?php
        $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
            'id' => 'company-form',
            'enableClientValidation' => true,
            'clientOptions' => array(
                'validateOnSubmit' => true,
            ),
        ));
        ?>

        <h4 class="head-title text-center">Your info</h4>
        <div class="inputwrapper animate1 bounceIn">
            <?php echo $form->textFieldRow($user, 'first_name', array('class' => 'txtfield', 'placeholder' => 'First Name')); ?>
        </div>
        
        <div class="inputwrapper animate2 bounceIn">
            <?php echo $form->textFieldRow($user, 'last_name', array('class' => 'txtfield', 'placeholder' => 'Last Name')); ?>
        </div>

        <div class="inputwrapper animate3 bounceIn">
            <?php echo $form->textFieldRow($user, 'email', array('class' => 'txtfield', 'placeholder' => 'Email')); ?>
        </div>

        <div class="inputwrapper animate4 bounceIn">
            <?php echo $form->passwordFieldRow($user, 'password', array('class' => 'txtfield', 'placeholder' => 'Password')); ?>
        </div>

        <div class="inputwrapper animate5 bounceIn">
            <?php echo $form->passwordFieldRow($user, 'password_repeat', array('class' => 'txtfield', 'placeholder' => 'Repeat Password')); ?>
        </div>

        <hr>

        <h4 class="head-title text-center">Your company</h4>
        <div class="inputwrapper animate6 bounceIn">
            <?php echo $form->textFieldRow($model, 'name', array('class' => 'txtfield', 'placeholder' => 'Name')); ?>
        </div>

        <div class="inputwrapper animate7 bounceIn">
            <?php echo $form->textFieldRow($model, 'email', array('class' => 'txtfield', 'placeholder' => 'Email')); ?>
        </div>

        <div class="inputwrapper animate8 bounceIn">
            <?php echo $form->textFieldRow($model, 'address', array('class' => 'txtfield', 'placeholder' => 'Address')); ?>
        </div>

        <div class="inputwrapper animate9 bounceIn">
            <?php echo $form->textFieldRow($model, 'phone', array('class' => 'txtfield', 'placeholder' => 'Phone')); ?>
        </div>

        <div class="inputwrapper animate10 bounceIn">
            <?php $this->widget('bootstrap.widgets.TbButton', array('buttonType' => 'submit', 'label' => 'Sign up')); ?>
        </div>

        <div class="animate9 bounceIn">
            <label class="checkbox">
                <input type="checkbox" required="required"> 
                <a href="<?=Yii::app()->request->baseUrl?>/_<?=Page::model()->findByPk(1)->slug?>" class="s_frame">You agree to all terms and conditions</a>
            </label>
        </div>

        <?php $this->endWidget(); ?>

    </div>
</div>