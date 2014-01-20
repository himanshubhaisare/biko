
<?php echo $this->getContent(); ?>

<div class="login" align="center">

	<h2>Log In</h2>

	<?php echo $this->tag->form(array(array('for' => 'session-do-login'), 'autocomplete' => 'off')); ?>
		<?php echo $form->show(); ?>
		<p>
			<?php echo $this->tag->submitButton(array('Log In', 'class' => 'btn btn-success', 'onclick' => 'this.disabled=true; this.form.submit()')); ?>
		</p>
	</form>
</div>