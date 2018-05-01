<div class="white-bg">
    <div class="row-fluid">
        <div class="span10">
            <h3 class="head-title">Login</h3>
            <p>Enter your username and password to log on.</p>
        </div>
        <div class="span2"><i class="fa fa-key big-icon"></i></div>
    </div>
    <hr>
    <div class="row-fluid">
        <?php
        /** @var BootActiveForm $form */
        $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
            'id' => 'login',
            'enableClientValidation' => true,
            'clientOptions' => array(
                'validateOnSubmit' => true,
            ),
        ));
        ?>

        <div class="inputwrapper animate1 bounceIn">
            <?php echo $form->textFieldRow($model, 'username', array('class' => 'txtfield', 'placeholder' => 'email')); ?>
        </div>

        <div class="inputwrapper animate2 bounceIn">
            <?php echo $form->passwordFieldRow($model, 'password', array('class' => 'inputwrapper animate2 bounceIn', 'placeholder' => 'password')); ?>
        </div>

        <div class="animate4 bounceIn">
            <?php echo $form->checkboxRow($model, 'rememberMe'); ?>
        </div>

        <div class="inputwrapper animate3 bounceIn">
            <?php $this->widget('bootstrap.widgets.TbButton', array('buttonType' => 'submit', 'label' => 'Login')); ?>
        </div>

        <?php $this->endWidget(); ?>
    </div>
</div>