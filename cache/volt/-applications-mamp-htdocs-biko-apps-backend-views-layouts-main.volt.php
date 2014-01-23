
<div class="navbar navbar-default">
	<div class="navbar-header">
		<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-responsive-collapse">
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
		</button>
		<li><?php echo $this->tag->linkTo(array('index', 'BIKØ', 'class' => 'navbar-brand')); ?></li>
	</div>
	<div class="navbar-collapse collapse navbar-responsive-collapse">
		<ul class="nav navbar-nav navbar-right">
			<li><?php echo $this->tag->linkTo(array('help', 'Help')); ?></li>
			<li><?php echo $this->tag->linkTo(array('admin/session/logout', 'Logout')); ?></li>
		</ul>
	</div>
</div>

<div class="main-container container">
	<?php echo $this->getContent(); ?>
</div>

<footer>
	<div align="center">
		<a target="_blank" href="http://phalconphp.com/">Phalcon Framework</a> - 2011 - <?php echo date('Y'); ?>
	</div>
</footer>
