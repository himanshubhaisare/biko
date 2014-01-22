<h2><?php echo $category->name; ?></h2>


	<?php foreach ($page->items as $product) { ?>
		<div class="row product">
			<div class="col-md-10">
				<b class="product-title"><?php echo $product->name; ?></b>
				<p><?php echo $product->description; ?></p>
			</div>
			<div class="col-md-2" align="center">
				<b class="product-price">$<?php echo $product->price; ?></b>
				<?php echo $this->tag->linkTo(array('cart/add', 'Add to Cart', 'class' => 'btn btn-info btn-sm')); ?>
			</div>
		</div>
	<?php } ?>

<div align="center">
	<ul class="pagination">
		<li><?php echo $this->tag->linkTo(array('category/' . $category->shortName . '?page=' . $page->before, '« Previous')); ?></li>
		<li><?php echo $this->tag->linkTo(array('category/' . $category->shortName . '?page=' . $page->next, 'Next »')); ?></li>
	</ul>
</div>
