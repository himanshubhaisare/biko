
<h2><?php echo $product->name; ?></h2>

<hr>

<div style="padding-left: 30px">

	<div class="row">

		<div class="col-md-7 col-offset-2">

			<b>Description</b>
			<p><?php echo $product->description; ?></p>

			<b>Unit Price</b>
			<p>$ <?php echo $product->price; ?></p>

		</div>

		<div class="col-md-5">

			<div class="well" xstyle="max-width: 40%; margin-left: 20px">
				<div class="form-group">
					<label for="inputPassword" class="col-lg-2 control-label">Quantity</label>
					<div class="col-lg-10">
						<input type="number" class="form-control" id="quantity" value="1" style="text-align: right; width: 240px">
						<div class="checkbox">
							<label>
								<input type="checkbox"> Include one-year warranty (+ $30.00)
							</label>
						</div>
					</div>
				</div>
				<div class="form-group">
					<div class="col-lg-10" align="right">
						<input type="submit" class="btn btn-success" value="Add to Cart">
					</div>
				</div>
			</div>

		</div>

	</div>

</div>