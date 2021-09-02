<?php
//==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>
//
// Ajaxいいねボタン v2.23 [ GPL ]
// Copyright (c) phpkobo.com ( http://jpn.phpkobo.com/ )
// Email : admin@phpkobo.com
// ID : LKBNX-223J
//
//==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<

$flist = array();

//-- [BEGIN] flist
$flist[] = array(
	"type"=>"file",
	"path"=>CEnv::pathConfig() . "config.db.inc.php",
	"access"=>"rw",
);
//-- [END] flist

CPermCheck::setupAccessFileList($flist);
$lca = CEnv::locale("install/page.permcheck");

$b_print_idx = false;

?>
<div class="psect" data-reload="1">
<input type="hidden" name="page-key" value="permcheck"/>

	<div class="psect-body">
		<div class="ctar-form">

			<div class="task-title">
			<span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
			<?php echo $lca["page:title"]; ?>
			</div>

			<p class="task-inst">
				<?php echo $lca["text:inst"]; ?>
			</p>

			<?php foreach( $flist as $rs ): ?>
			<div class="panel panel-default">
				<div class="panel-heading">
					<div class="pentry">
						<div class="pentry-row">
							<?php if ( $b_print_idx ): ?>
							<div class="pentry-cell pentry-cell-idx">
								<?php CPermCheck::printIdxLabel(); ?>
							</div>
							<?php endif; ?>
							<div class="pentry-cell pentry-cell-type">
								<?php CPermCheck::printTypeLabel( $lca, $rs ); ?>
							</div>
							<div class="pentry-cell pentry-cell-path">
								<?php echo $rs["path"]; ?>
							</div>
						</div>
					</div>
				</div>
				<div class="panel-body" style="text-align:center;">
				<?php CPermCheck::printRWLabels( $lca, $rs ); ?>
				</div>
			</div>
			<?php endforeach; ?>

				<div class="result-ctar-frame">
					<div class="result-ctar">
						<?php if ( CPermCheck::getErrCnt() > 0 ): ?>
						<div class="error-ctar">
							<div class="error-msg"><?php echo CPermCheck::getErrCnt(); ?> <?php
								echo str_replace("%s%",(CPermCheck::getErrCnt() != 1 ) ? "s" : "",
									$lca["text:error"]); ?></div>
							<div class="error-inst">
								<?php echo $lca["text:error-inst"]; ?>
							</div>
						</div>
						<div style="text-align:center;">
							<button class="btn btn-info btn-reload">
								<span class="glyphicon glyphicon-repeat"></span>
								<?php echo $lca["label:reload"]; ?>
							</button>
						</div>
						<?php else: ?>
						<div class="success-ctar">
							<div class="success-msg">
								<span class="glyphicon glyphicon-thumbs-up" aria-hidden="true"
									style="position:relative;top:2px;"
								></span>
								<?php echo $lca["text:success"]; ?>
							</div>
							<div class="success-inst"><?php echo $lca["text:success-inst"]; ?></div>
						</div>
						<?php endif; ?>
					</div>
				</div>
			<div class="row">
				<div class="col-sm-12">
				</div>
			</div>
		</div>
	</div>

	<?php $btn_next_disabled = ( CPermCheck::getErrCnt() > 0 ); ?>
	<?php include("tpl.navi.inc.php"); ?>
</div>
<?php // ?>