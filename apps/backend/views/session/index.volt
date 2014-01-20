
{{ content() }}

<div class="login" align="center">

	<h2>Log In</h2>

	{{ form(['for': 'session-do-login'], 'autocomplete': 'off') }}
		{{ form.show() }}
		<p>
			{{ submit_button("Log In", 'class': 'btn btn-success', 'onclick': 'this.disabled=true; this.form.submit()') }}
		</p>
	</form>
</div>