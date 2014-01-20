
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
		<ul class="nav navbar-nav">
			<?php $options = array('category/software' => array('Software', 'icon-home'), 'category/hardware' => array('Hardware', 'icon-home'), 'category/network' => array('Network', 'icon-wrench')); ?>
			<?php $controller = $this->dispatcher->getControllerName(); ?>
			<?php foreach ($options as $option => $label) { ?>
				<?php if ($controller == $option) { ?>
					<li class="active"><?php echo $this->tag->linkTo(array($option, '<span class="' . $label[1] . ' icon-black"></span> ' . $label[0])); ?></li>
				<?php } else { ?>
					<li><?php echo $this->tag->linkTo(array($option, '<span class="' . $label[1] . '"></span> ' . $label[0])); ?></li>
				<?php } ?>
			<?php } ?>
		</ul>
		<ul class="nav navbar-nav navbar-right">
			<li><?php echo $this->tag->linkTo(array('help', 'Help')); ?></li>
			<li><form class="navbar-form navbar-left">
				<input type="text" class="form-control col-lg-8" placeholder="Search">
			</form></li>
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
