
<div class="navbar navbar-default">
	<div class="navbar-header">
		<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-responsive-collapse">
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
		</button>
		<li>{{ link_to('index', 'BIKØ', "class": "navbar-brand") }}</li>
	</div>
	<div class="navbar-collapse collapse navbar-responsive-collapse">
		<ul class="nav navbar-nav">
			{% set options = [
					'category/software'        : ['Software', 'icon-home'],
					'category/hardware'        : ['Hardware', 'icon-home'],
					'category/network'         : ['Network', 'icon-wrench']
				] %}
			{% set controller = dispatcher.getControllerName() %}
			{% for option, label in options %}
				{% if controller == option %}
					<li class="active">{{ link_to(option, '<span class="' ~ label[1] ~ ' icon-black"></span> ' ~ label[0]) }}</li>
				{% else %}
					<li>{{ link_to(option, '<span class="' ~ label[1] ~ '"></span> ' ~ label[0]) }}</li>
				{% endif %}
			{% endfor %}
		</ul>
		<ul class="nav navbar-nav navbar-right">
			<li>{{ link_to('help', 'Help') }}</li>
			<li><form class="navbar-form navbar-left">
				<input type="text" class="form-control col-lg-8" placeholder="Search">
			</form></li>
		</ul>
	</div>
</div>

<div class="cart-nav navbar">
	<div class="navbar-header">
		<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-responsive-collapse">
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
		</button>
	</div>
	<div class="navbar-collapse collapse navbar-responsive-collapse">
		<ul class="nav navbar-nav pull-right">
			{% set items = session.get("cartItems") %}
			{%- if !items -%}
				You don't have items added to the shopping cart
			{%- else -%}
				<table>
					<tr>
						<td>You have <b>{{ items }}</b> in the shopping cart</td>
						<td></td>
						<td>{{ link_to('cart/checkout', 'Check-Out', 'class': 'btn btn-success btn-xs') }}</td>
					</tr>
				</table>
			{%- endif -%}
		</ul>
	</div>
</div>

<div class="main-container container">
	{{ content() }}
</div>

<footer>
	<div align="center">
		<a target="_blank" href="http://phalconphp.com/">Phalcon Framework</a> - 2011 - {{ date('Y') }}
	</div>
</footer>
