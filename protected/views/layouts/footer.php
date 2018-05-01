<!-- Start Footer-->
<footer class="row-fluid">
    <div class="row-fluid">
        <div class="span2"></div>
        <div class="span3 no-responsive">
            <h3 class="grey">Talk to us</h3>
            <p><?=Yii::app()->params['email']?></p>
            <p><?=Yii::app()->params['phone']?></p>
        </div>
        <div class="span3 no-responsive">
            <h3 class="grey">Write to us</h3>
            <?=Yii::app()->params['address']?>
        </div>
        <div class="span2 no-responsive text-right">
            <img src="<?= Yii::app()->request->getBaseUrl(true) ?>/img/logo-white.png" width="90">
        </div>
        <div class="span2"></div>
    </div>
    <div class="row-fluid foot">
        <div class="span2"></div>
        <div class="span4 no-responsive">
            <p class="copyrights">&copy; <?= date('Y') ?> Henley Wealth Management LTD.</p>
        </div>
        <div class="span4 no-responsive">
            <div class="footer-icons">
                <a href="<?=Yii::app()->params['twitter']?>" target="_blank"><i class="fa fa-twitter-square rotate"></i></a>
                <a href="<?=Yii::app()->params['facebook']?>" target="_blank"><i class="fa fa-facebook-square rotate"></i></a>
                <a href="<?=Yii::app()->params['linkedin']?>" target="_blank"><i class="fa fa-linkedin-square rotate"></i></a>
            </div>
        </div>
        <div class="span2"></div>
        <div class="row-fluid">
            <div class="span8 offset2 text-center">
                <p class="trade-mark"><?=Yii::app()->params['footer']?></p>
            </div>
        </div>
    </div>
</footer>

</body>
<!-- InstanceEnd --></html>
