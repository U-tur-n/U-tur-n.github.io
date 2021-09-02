<?php
//==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>
//
// Ajaxいいねボタン v2.23 [ GPL ]
// Copyright (c) phpkobo.com ( http://jpn.phpkobo.com/ )
// Email : admin@phpkobo.com
// ID : LKBNX-223J
//
//==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<

class CDBSetup {

	private static function validate( $data ) {

		//-- locale
		$lca = CEnv::locale( "install/validate" );

		//-- vali macro
		CValiMacro::setup($data, $lca);
		CValiMacro::vStr("db-hostname");
		CValiMacro::vStr("db-database");
		CValiMacro::vStr("db-username");
		CValiMacro::vStr("db-password");
		CValiMacro::vStr("db-tbl-prefix");
	}

	private static function setup( $data ) {

		//-- locale
		$lca = CEnv::locale( "install/validate" );

		if ( !CConfigDbFile::checkPermission() ) {
			CFRes::addEA( $lca["err:can-not-write-config-db-file"] );
			return false;
		}

		//if ( !CConfigDbFile::load($px) ) {
		//	CFRes::addEA( $lca["err:invalid-config-db-file"] );
		//	return false;
		//}

		$px = array();
		$px["db-hostname"] = $data->vx["db-hostname"];
		$px["db-database"] = $data->vx["db-database"];
		$px["db-username"] = $data->vx["db-username"];
		$px["db-password"] = $data->vx["db-password"];
		$px["db-tbl-prefix"] = $data->vx["db-tbl-prefix"];

		$path_sql = $data->path_sql;
		if ( !CDBInstaller::run( $px, $path_sql, $errmsg ) ) {
			CFRes::addEA( $errmsg );
			return false;
		}

		//-- save config file
		CConfigDbFile::save($px);

		return true;
	}

	public static function process( $data ) {
		$data->vx = array();
		$data->fm = $data->requ["form"];

		//-- validate
		self::validate( $data );
		if ( !CFRes::isValidated() ) {
			return false;
		}

		//-- setup
		if ( !self::setup( $data ) ) {
			return false;
		}

		return true;
	}

}

?>