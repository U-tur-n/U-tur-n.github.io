<div class="psect">
	<div class="psect-heading">
		<div class="cell-step">
			<span class="label-step"><?php echo $step++; ?></span>
		</div>
		<div class="cell-title">
			<?php echo $lca_form["title:enter-key"]; ?>
		</div>
	</div>
	<div class="psect-body">

		<div class="row">
			<div class="col-sm-12">
				<p><?php echo $lca_form["text:enter-key"]; ?></p>

				<div class="form-group">
					<label><?php echo $lca_form["label:key"]; ?>:</label>
					<input type="text" class="form-control _ffe_" name="pid"
						value="" placeholder="<?php echo $lca_form["ph:key"]; ?>" maxlength="300" />
					<div style="text-align:right;">
						<button class="btn btn-sm btn-info btn-gen-pid">
						<?php echo $lca_form["label:random-key"]; ?></button>
					</div>
				</div>

				<p><?php echo $lca_form["text:enter-key:inst1"]; ?></p>
				<p><?php echo $lca_form["text:remainder"]; ?></p>
				<p><button class="btn btn-default btn-enter-memo">
					<?php echo $lca_form["label:remainder"]; ?></button></p>
			</div>
		</div>
	</div>
</div>
<?php // ?>