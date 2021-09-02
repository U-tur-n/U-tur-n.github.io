<?php
//==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>
//
// Ajaxいいねボタンv2.23用サービスパック１ [ GPL ]
// Copyright (c) phpkobo.com ( http://jpn.phpkobo.com/ )
// Email : admin@phpkobo.com
// ID : LKBSP-100J
//
//==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<

class CTblPoll extends CTblBase {

	const TBL_NAME = "poll";
	const ID_NAME = "poll_id";

	public function __construct( $prt ) {
		parent::__construct( $prt );
	}

	public function makePidMap( $data ) {

		$pidx = $data->pidx;
		$pmap = array();

		//-- build clauses
		$clx = array();

		//-- select clause
		$clx[] = CSql::clSelect(array(
			self::ID_NAME,
			"pid",
		));

		//-- from
		$clx[] = CSql::clFrom(self::TBL_NAME);

		//-- cond
		$cond = array();

		$cond2 = array();
		foreach( $pidx as $pid ) {
			$cond2[] = CSql::clCond( "pid", "=", $pid );
		}
		$cond[] = CSql::clCondOp( "OR", $cond2 );

		//-- where clause
		if ( !empty($cond)  ) {
			$clx[] = CSql::clWhere("AND",$cond);
		}

		//-- run query
		$result = CSql::query($clx);
		while ( $rs = CDb::getRowA( $result ) ) {
			$pmap[$rs[self::ID_NAME]] = $rs["pid"];
		}

		//-- free result
		CDb::freeResult($result);

		$data->pmap = $pmap;
	}

	public function getPollInfo( $data ) {
		$this->findPollID($data);
		if ( !$data->poll_id ) {
			$data->poll_id = $this->makeRecord($data->requ["pid"]);
		}
	}

	private function findPollID( $data ) {

		$data->poll_id = 0;

		//-- build clauses
		$clx = array();

		//-- select clause
		$clx[] = CSql::clSelect(array(
			self::ID_NAME,
		));

		//-- from
		$clx[] = CSql::clFrom(self::TBL_NAME);

		//-- cond
		$cond = array();
		$cond[] = CSql::clCond( "pid", "=", $data->requ["pid"] );

		//-- where clause
		if ( !empty($cond)  ) {
			$clx[] = CSql::clWhere("AND",$cond);
		}

		//-- limite clause
		$clx[] = "LIMIT 1";

		//-- run query
		$result = CSql::query($clx);
		if ( $rs = CDb::getRowA( $result ) ) {
			$data->poll_id = $rs[self::ID_NAME];
		}

		//-- free result
		CDb::freeResult( $result );
	}

	private function makeRecord( $pid ) {
		$vx = array();
		$vx["dt_create"] = $this->prt->getDateTimeStr();
		$vx["pid"] = $pid;
		return CTable::insertRec( self::TBL_NAME, $vx );
	}

}

?>