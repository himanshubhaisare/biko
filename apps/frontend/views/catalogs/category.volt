<h2>{{ category.name }}</h2>


	{% for product in page.items %}
		<div class="row product">
			<div class="col-md-10">
				<b class="product-title">{{ product.name }}</b>
				<p>{{ product.description }}</p>
			</div>
			<div class="col-md-2" align="center">
				<b class="product-price">${{ product.price }}</b>
				{{ link_to('cart/add', 'Add to Cart', 'class': 'btn btn-info btn-sm') }}
			</div>
		</div>
	{% endfor %}

<div align="center">
	<ul class="pagination">
		<li>{{ link_to("category/" ~ category.shortName ~ "?page=" ~ page.before, "« Previous") }}</li>
		<li>{{ link_to("category/" ~ category.shortName ~ "?page=" ~ page.next, "Next »") }}</li>
	</ul>
</div>
