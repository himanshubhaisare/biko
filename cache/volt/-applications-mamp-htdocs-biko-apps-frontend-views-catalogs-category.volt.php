
<?php $currentOrder = $this->request->getQuery('order', 'alphanum'); ?>

<?php echo $this->getContent(); ?>

<div class="row">
	<div class="col-md-6">
		<h2><?php echo $category->name; ?></h2>
	</div>
	<div class="col-md-5" align="right">
		<div class="btn-group" align="left">
			<button type="button" class="btn btn-default dropdown-toggle btn-sm" data-toggle="dropdown">
				<?php if ($currentOrder) { ?>
					Order By | <?php echo ucwords($currentOrder); ?> <span class="caret"></span>
				<?php } else { ?>
					Order By <span class="caret"></span>
				<?php } ?>
			</button>
			<ul class="dropdown-menu"><?php foreach (array('newest', 'name', 'price', 'rating') as $order) { ?><?php if ($order == $currentOrder) { ?>
						<li class="active"><?php echo $this->tag->linkTo(array('category/' . $category->shortName . '?page=' . $page->current . '&order=' . $order, ucwords($order))); ?></li><?php } else { ?><li><?php echo $this->tag->linkTo(array('category/' . $category->shortName . '?page=' . $page->current . '&order=' . $order, ucwords($order))); ?></li><?php } ?><?php } ?></ul>
		</div>
	</div>
</div><?php foreach ($page->items as $product) { ?><div class="row product">
		<div class="col-md-1" align="center">
			<span class="product-icon glyphicon <?php echo $product->icon; ?>"></span>
		</div>
		<div class="col-md-9">
			<b class="product-title"><?php echo $product->name; ?></b>
			<p><?php echo $product->description; ?></p><?php if ($product->stock < 5) { ?><?php if ($product->stock > 0) { ?><span class="low-stock">Less than 5 units left</span><?php } ?><?php } ?></div>
		<div class="col-md-2" align="center">
			<p><?php if ($product->price > 0) { ?><b class="product-price">$<?php echo $product->price; ?></b><?php } else { ?><b class="product-price">Free</b><?php } ?></p><?php if ($product->stock > 0) { ?><?php echo $this->tag->linkTo(array('cart/add/' . $product->id, 'Add to Cart', 'class' => 'btn btn-default btn-xs')); ?><?php } else { ?><span class="out-of-stock">Out of stock</span><?php } ?></div>
	</div><?php } ?><div align="center">
	<ul class="pagination">
		<li><?php echo $this->tag->linkTo(array('category/' . $category->shortName . '?page=' . $page->before . '&order=' . $currentOrder, '« Previous', 'class' => 'btn btn-default')); ?></li>
		<li><?php echo $this->tag->linkTo(array('category/' . $category->shortName . '?page=' . $page->next . '&order=' . $currentOrder, 'Next »', 'class' => 'btn btn-default')); ?></li>
	</ul>
</div>
