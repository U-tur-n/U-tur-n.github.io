<?php
//==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>
//
// Ajaxいいねボタン v2.23 [ GPL ]
// Copyright (c) phpkobo.com ( http://jpn.phpkobo.com/ )
// Email : admin@phpkobo.com
// ID : LKBNX-223J
//
//==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<
	$cfg = CEnv::config("install/page.dbsetup");
	$lca = CEnv::locale("install/page.dbsetup");
	$req = _req();

	$rs["db-hostname"] = $cfg["def-db-hostname"];
	$rs["db-database"] = "";
	$rs["db-username"] = "";
	$rs["db-password"] = "";
	$rs["db-tbl-prefix"] = $cfg["def-db-tbl-prefix"];
?>
<div class="psect">
<input type="hidden" name="page-key" value="dbsetup"/>

	<div class="psect-body">
		<div class="ctar-form">

			<div class="task-title">
			<span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
			<?php echo $lca["page:title"]; ?>
			</div>

			<p class="task-inst text-info">
				<?php echo $lca["text:inst"]; ?>
			</p>

			<div class="ctar-falert"></div>

			<div class="row">
				<div class="col-sm-6">
					<div class="form-group">
						<label><?php echo $lca["label:db-hostname"]; ?>
							<?php echo $req; ?></label>
						<input type="text"
							class="form-control _ffe_"
							name="db-hostname"
							value="<?php echo _hsc( $rs["db-hostname"] ); ?>"
							placeholder="<?php echo $lca["plh:db-hostname"]; ?>"
						/>
					</div>
				</div>

				<div class="col-sm-6">
					<div class="form-group">
						<label><?php echo $lca["label:db-database"]; ?>
							<?php echo $req; ?></label>
						<input type="text"
							class="form-control _ffe_"
							name="db-database"
							value="<?php echo _hsc( $rs["db-database"] ); ?>"
							placeholder="<?php echo $lca["plh:db-database"]; ?>"
						/>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-sm-6">
					<div class="form-group">
						<label><?php echo $lca["label:db-username"]; ?>
							<?php echo $req; ?></label>
						<input type="text"
							class="form-control _ffe_"
							name="db-username"
							value="<?php echo _hsc( $rs["db-username"] ); ?>"
							placeholder="<?php echo $lca["plh:db-username"]; ?>"
						/>
					</div>
				</div>

				<div class="col-sm-6">
					<div class="form-group">
						<label><?php echo $lca["label:db-password"]; ?>
							<?php echo $req; ?></label>
						<input type="text"
							class="form-control _ffe_"
							name="db-password"
							value="<?php echo _hsc( $rs["db-password"] ); ?>"
							placeholder="<?php echo $lca["plh:db-password"]; ?>"
						/>
					</div>
				</div>
			</div>

			<div style="margin:0 0 15px 20px;font-size:80%;">
			<a href="#" class="toggle-advanced-options"><?php echo $lca["label:advanced-options"]; ?></a>
			</div>
			<div class="row area-advanced-options" style="display:none;">
				<div class="col-sm-6">
					<div class="form-group">
						<label><?php echo $lca["label:db-tbl-prefix"]; ?>
							<?php echo $req; ?></label>
						<input type="text"
							class="form-control _ffe_"
							name="db-tbl-prefix"
							value="<?php echo _hsc( $rs["db-tbl-prefix"] ); ?>"
							placeholder="<?php echo $lca["plh:db-tbl-prefix"]; ?>"
						/>
					</div>
				</div>

				<div class="col-sm-6">
					&nbsp;
				</div>
			</div>
		</div>
	</div>

	<?php include("tpl.navi.inc.php"); ?>
</div>

<script>
$(document).ready(function(){
	$(".toggle-advanced-options")
		.click(function(e){
			e.preventDefault();
			$(".area-advanced-options").toggle();
		})
		.keypress(function(e) {
			if (( e.which == 13 ) || ( e.which == 32 )) {
				e.preventDefault();
				$(this).click();
			}
		});

	$(".ctar-form")
		.find("input[name='db-hostname']")
		.select();
});
</script>
<?php // ?>