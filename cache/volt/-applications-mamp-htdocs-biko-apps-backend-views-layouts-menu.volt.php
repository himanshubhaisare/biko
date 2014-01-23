<div class="row">
	<div class="col-md-3">
		<div class="list-group">
			<?php $options = array('dashboard' => 'Dashboard', 'products' => 'Products', 'categories' => 'Categories'); ?>
			<?php foreach ($options as $controller => $label) { ?>
				<?php if (Phalcon\Text::lower($this->dispatcher->getControllerName()) == $controller) { ?>
					<?php echo $this->tag->linkTo(array('admin/' . $controller, $label, 'class' => 'list-group-item active')); ?>
				<?php } else { ?>
					<?php echo $this->tag->linkTo(array('admin/' . $controller, $label, 'class' => 'list-group-item')); ?>
				<?php } ?>
			<?php } ?>
		</div>
	</div>
	<div class="col-md-9">
		<?php echo $this->getContent(); ?>
	</div>
</div>