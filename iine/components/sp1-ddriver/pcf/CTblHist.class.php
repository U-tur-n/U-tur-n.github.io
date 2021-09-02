<?php
//==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>
//
// Ajaxいいねボタンv2.23用サービスパック１ [ GPL ]
// Copyright (c) phpkobo.com ( http://jpn.phpkobo.com/ )
// Email : admin@phpkobo.com
// ID : LKBSP-100J
//
//==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<

class CTblHist extends CTblBase {

	const TBL_NAME = "hist";
	const ID_NAME = "hist_id";

	public function __construct( $prt ) {
		parent::__construct( $prt );
	}

	public function loadSelsx( $data ) {

		//-- build clauses
		$clx = array();

		//-- select clause
		$clx[] = CSql::clSelect(array(
			"voter_id",
			"poll_id",
			"bid",
		));

		//-- from
		$clx[] = CSql::clFrom(self::TBL_NAME);

		//-- cond
		$cond = array();
		$cond[] = CSql::clCond( "voter_id", "=", $data->voter_id );

		//-- expiration threshold
		$threshold = $this->prt->getSigExpireThreshold();
		if ( !is_null($threshold) ) {
			$cond[] = CSql::clCond("dt_create",">=",$threshold);
		}

		//-- pmap
		$cond2 = array();
		foreach( $data->pmap as $poll_id=>$pid ) {
			$cond2[] = CSql::clCond( "poll_id", "=", $poll_id );
		}
		$cond[] = CSql::clCondOp( "OR", $cond2 );

		//-- where clause
		if ( !empty($cond)  ) {
			$clx[] = CSql::clWhere("AND",$cond);
		}

		//-- run query
		$selsx = array();
		$result = CSql::query($clx);
		while ( $rs = CDb::getRowA( $result ) ) {
			$pid = $data->pmap[$rs["poll_id"]];
			if ( !isset($selsx[$pid]) ) {
				$selsx[$pid] = array();
			}
			$selsx[$pid][$rs["bid"]] = 1;
		}

		//-- free result
		CDb::freeResult($result);

		//-- assign
		$data->resp["selsx"] = $selsx;
	}

	public function loadSels( $data ) {

		//-- build clauses
		$clx = array();

		//-- select clause
		$clx[] = CSql::clSelect(array(
			"bid",
		));

		//-- from
		$clx[] = CSql::clFrom(self::TBL_NAME);

		//-- cond
		$cond = array();
		$cond[] = CSql::clCond( "voter_id", "=", $data->voter_id );
		$cond[] = CSql::clCond( "poll_id", "=", $data->poll_id );

		//-- expiration threshold
		$threshold = $this->prt->getSigExpireThreshold();
		if ( !is_null($threshold) ) {
			$cond[] = CSql::clCond("dt_create",">=",$threshold);
		}

		//-- where clause
		if ( !empty($cond)  ) {
			$clx[] = CSql::clWhere("AND",$cond);
		}

		//-- run query
		$sels = array();
		$result = CSql::query($clx);
		while ( $rs = CDb::getRowA( $result ) ) {
			$sels[$rs["bid"]] = 1;
		}

		//-- free result
		CDb::freeResult($result);

		//-- assign
		$data->resp["sels"] = $sels;
	}

	public function getBtnType( $data ) {
		$data->hist_id = 0;
		$data->bid = "";

		//-- build clauses
		$clx = array();

		//-- select clause
		$clx[] = CSql::clSelect(array(
			self::ID_NAME,
			"bid",
		));

		//-- from
		$clx[] = CSql::clFrom(self::TBL_NAME);

		//-- cond
		$cond = array();
		$cond[] = CSql::clCond( "poll_id", "=", $data->poll_id );
		$cond[] = CSql::clCond( "voter_id", "=", $data->voter_id );

		//-- where clause
		if ( !empty($cond)  ) {
			$clx[] = CSql::clWhere("AND",$cond);
		}

		//-- order by
		$clx[] = "ORDER BY hist_id ASC";

		//-- limit clause
		$clx[] = "LIMIT 1";

		//-- run query
		$result = CSql::query($clx);
		if ( $rs = CDb::getRowA( $result ) ) {
			$data->hist_id = $rs[self::ID_NAME];
			$data->bid = $rs["bid"];
		}

		//-- free result
		CDb::freeResult( $result );
	}

	public function update( $data ) {
		foreach( $data->update_hist as $update ) {
			$this->updateOne($data,$update);
		}
	}

	private function updateOne( $data, $update ) {
		switch( $update["cmd"] ) {
		case "delete":
			CTable::deleteByID( self::TBL_NAME, "hist_id", $update["hist_id"] );
			break;
		case "insert":
			if ( $data->voter_id ) {
				$vx["dt_create"] = $this->prt->getDateTimeStr();
				$vx["voter_id"] = $data->voter_id;
				$vx["poll_id"] = $data->poll_id;
				$vx["bid"] = $update["bid"];
				CTable::insertRec( self::TBL_NAME, $vx );
			}
			break;
		}
	}

	public function expire( $data, $threshold ) {
		$clx = array();
		$clx[] = CSql::clDelete(self::TBL_NAME);
		$cond = array();
		$cond[] = CSql::clCond("dt_create","<",$threshold);
		$clx[] = CSql::clWhere("AND",$cond);
		CSql::query($clx);
	}

}

?>