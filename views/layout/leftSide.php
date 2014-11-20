<?php $this->startContent('main'); ?>
<!-- 这里放要附加到main中的代码,mian在最外层，里面是本页面，在里面是要渲染的页面 -->
<?php echo 'b'; ?>
<?php echo $content; ?>

<?php $this->endContent(); ?>