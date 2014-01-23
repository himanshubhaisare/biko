<h2>{{ category.name }}</h2>


	{% for product in page.items %}
		<div class="row product">
			<div class="col-md-1" align="center">
				<span class="product-icon glyphicon {{ product.icon }}"></span>
			</div>
			<div class="col-md-8">
				<b class="product-title">{{ product.name }}</b>
				<p>{{ product.description }}</p>
			</div>
			<div class="col-md-2" align="center">
				{%- if product.price > 0 -%}
					<b class="product-price">${{ product.price }}</b>
				{%- else -%}
					<b class="product-price">Free</b>
				{%- endif -%}
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
