
<div class="navbar navbar-default navbar-backend">
	<div class="navbar-header">
		<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-responsive-collapse">
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
		</button>
		<li>{{ link_to('index', 'BIKØ', "class": "navbar-brand") }}</li>
	</div>
	<div class="navbar-collapse collapse navbar-responsive-collapse">
		<ul class="nav navbar-nav navbar-right">
			<li>{{ link_to('help', 'Help') }}</li>
			<li>{{ link_to(['for': 'session-do-logout'], 'Logout') }}</li>
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
