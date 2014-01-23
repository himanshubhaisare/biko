
{% set currentOrder = request.getQuery("order", "alphanum") %}

{{ content() }}

<div class="row">
	<div class="col-md-6">
		<h2>{{ category.name }}</h2>
	</div>
	<div class="col-md-5" align="right">
		<div class="btn-group" align="left">
			<button type="button" class="btn btn-default dropdown-toggle btn-sm" data-toggle="dropdown">
				{% if currentOrder %}
					Order By | {{ currentOrder|capitalize }} <span class="caret"></span>
				{% else %}
					Order By <span class="caret"></span>
				{% endif %}
			</button>
			<ul class="dropdown-menu">
				{%- for order in ['newest', 'name', 'price', 'rating'] -%}
					{%- if order == currentOrder %}
						<li class="active">{{ link_to("category/" ~ category.shortName ~ "?page=" ~ page.current ~ "&order=" ~ order, order|capitalize) }}</li>
					{%- else -%}
						<li>{{ link_to("category/" ~ category.shortName ~ "?page=" ~ page.current ~ "&order=" ~ order, order|capitalize) }}</li>
					{%- endif -%}
				{%- endfor -%}
			</ul>
		</div>
	</div>
</div>

{%- for product in page.items -%}
	<div class="row product">
		<div class="col-md-1" align="center">
			<span class="product-icon glyphicon {{ product.icon }}"></span>
		</div>
		<div class="col-md-9">
			<b class="product-title">{{ product.name }}</b>
			<p>{{ product.description }}</p>
			{%- if product.stock < 5 -%}
				{%- if product.stock > 0 -%}
					<span class="low-stock">Less than 5 units left</span>
				{%- endif -%}
			{%- endif -%}
		</div>
		<div class="col-md-2" align="center">
			<p>
				{%- if product.price > 0 -%}
					<b class="product-price">${{ product.price }}</b>
				{%- else -%}
					<b class="product-price">Free</b>
				{%- endif -%}
			</p>
			{%- if product.stock > 0 -%}
				{{ link_to('cart/add/' ~ product.id , 'Add to Cart', 'class': 'btn btn-default btn-xs') }}
			{%- else -%}
				<span class="out-of-stock">Out of stock</span>
			{%- endif -%}
		</div>
	</div>
{%- endfor -%}

<div align="center">
	<ul class="pagination">
		<li>{{ link_to("category/" ~ category.shortName ~ "?page=" ~ page.before ~ "&order=" ~ currentOrder,   "« Previous", "class": "btn btn-default") }}</li>
		<li>{{ link_to("category/" ~ category.shortName ~ "?page=" ~ page.next   ~ "&order=" ~ currentOrder,   "Next »", "class": "btn btn-default") }}</li>
	</ul>
</div>
