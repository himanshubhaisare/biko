<div class="row">
	<div class="col-md-3">
		<div class="list-group">
			{% set options = [
				'dashboard'  : 'Dashboard',
				'products'   : 'Products',
				'categories' : 'Categories'
			] %}
			{% for controller,label in options %}
				{% if dispatcher.getControllerName()|lower == controller %}
					{{ link_to('admin/' ~ controller, label, 'class': 'list-group-item active') }}
				{% else %}
					{{ link_to('admin/' ~ controller, label, 'class': 'list-group-item') }}
				{% endif %}
			{% endfor %}
		</div>
	</div>
	<div class="col-md-9">
		{{ content() }}
	</div>
</div>