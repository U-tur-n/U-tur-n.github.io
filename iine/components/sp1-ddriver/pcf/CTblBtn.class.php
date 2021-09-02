<?php
//==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>
//
// Ajaxいいねボタンv2.23用サービスパック１ [ GPL ]
// Copyright (c) phpkobo.com ( http://jpn.phpkobo.com/ )
// Email : admin@phpkobo.com
// ID : LKBSP-100J
//
//==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<

class CTblBtn extends CTblBase {

	const TBL_NAME = "btn";
	const ID_NAME = "btn_id";

	public function __construct( $prt ) {
		parent::__construct( $prt );
		$this->b_read_all = true;
	}

	public function loadVcntsx( $data ) {

		$rx = array();
		$pmap = $data->pmap;

		if ( count($pmap) ) {

			//-- build clauses
			$clx = array();

			//-- select clause
			$clx[] = CSql::clSelect(array(
				"poll_id",
				"bid",
				"vcnt",
			));

			//-- from
			$clx[] = CSql::clFrom(self::TBL_NAME);

			//-- cond
			$cond = array();

			$cond2 = array();
			foreach( $pmap as $poll_id=>$pid ) {
				$cond2[] = CSql::clCond( "poll_id", "=", $poll_id );
			}
			$cond[] = CSql::clCondOp( "OR", $cond2 );

			//-- where clause
			if ( !empty($cond)  ) {
				$clx[] = CSql::clWhere("AND",$cond);
			}

			//-- run query
			$result = CSql::query($clx);
			while ( $rs = CDb::getRowA( $result ) ) {
				$pid = $pmap[$rs["poll_id"]];
				if ( !isset($rx[$pid]) ) {
					$rx[$pid] = array();
				}
				$rx[$pid][$rs["bid"]] = intval($rs["vcnt"]);
			}

			//-- free result
			CDb::freeResult($result);
		}

		//-- assing
		$data->resp["vcntsx"] = $rx;
	}

	public function update( $data ) {
		foreach( $data->update_btn as $update ) {
			$this->updateOne($data,$update);
		}
	}

	private function updateOne( $data, $update ) {

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
		$cond[] = CSql::clCond( "poll_id", "=", $data->poll_id );
		$cond[] = CSql::clCond( "bid", "=", $update["bid"] );

		//-- where clause
		if ( !empty($cond)  ) {
			$clx[] = CSql::clWhere("AND",$cond);
		}

		//-- limite clause
		$clx[] = "LIMIT 1";

		//-- run query
		$btn_id = 0;
		$result = CSql::query($clx);
		if ( $rs = CDb::getRowA( $result ) ) {
			$btn_id = $rs[self::ID_NAME];
		}

		//-- free result
		CDb::freeResult( $result );

		$vx = array();
		if ( $btn_id ) {
			$vx[] = "vcnt=GREATEST(0,vcnt+(".$update["change"]."))";
			CTable::updateByID( self::TBL_NAME, self::ID_NAME, $btn_id, $vx );
		} else {
			$vx["poll_id"] = $data->poll_id;
			$vx["bid"] = $update["bid"];
			$vx["vcnt"] = max(0,$update["change"]);
			CTable::insertRec( self::TBL_NAME, $vx );
		}
	}

	public function loadVcnts( $data ) {

		$vcnts = array();

		//-- build clauses
		$clx = array();

		//-- select clause
		$clx[] = CSql::clSelect(array(
			self::ID_NAME,
			"bid",
			"vcnt",
		));

		//-- from
		$clx[] = CSql::clFrom(self::TBL_NAME);

		//-- cond
		$cond = array();
		$cond[] = CSql::clCond( "poll_id", "=", $data->poll_id );

		$cond2 = array();
		foreach( $data->update_vcnt as $bid=>$sel ) {
			$cond2[] = CSql::clCond( "bid", "=", $bid );
		}
		$cond[] = CSql::clCondOp( "OR", $cond2 );

		//-- where clause
		if ( !empty($cond)  ) {
			$clx[] = CSql::clWhere("AND",$cond);
		}

		//-- run query
		$result = CSql::query($clx);
		while ( $rs = CDb::getRowA( $result ) ) {
			$vcnts[$rs["bid"]] = intval($rs["vcnt"]);
		}

		//-- free result
		CDb::freeResult( $result );

		//-- set resp
		$data->resp["vcnts"] = $vcnts;
	}

	private function findRec( $data, &$vcnt ) {

		//-- build clauses
		$clx = array();

		//-- select clause
		$clx[] = CSql::clSelect(array(
			self::ID_NAME,
			"vcnt",
		));

		//-- from
		$clx[] = CSql::clFrom(self::TBL_NAME);

		//-- cond
		$cond = array();
		$cond[] = CSql::clCond( "poll_id", "=", $data->poll_id );
		$cond[] = CSql::clCond( "bid", "=", $data->requ["bid"] );

		//-- where clause
		if ( !empty($cond)  ) {
			$clx[] = CSql::clWhere("AND",$cond);
		}

		//-- limite clause
		$clx[] = "LIMIT 1";

		//-- run query
		$btn_id = null;
		$vcnt = null;
		$result = CSql::query($clx);
		if ( $rs = CDb::getRowA( $result ) ) {
			$btn_id = $rs[self::ID_NAME];
			$vcnt = intval($rs["vcnt"]);
		}

		//-- free result
		CDb::freeResult( $result );

		return $btn_id;
	}

	public function edit( $data ) {
		$vx = array();
		$vx["vcnt"] = $data->requ["vcnt"];
		if ( $btn_id = $this->findRec( $data, $vcnt ) ) {
			CTable::updateByID( self::TBL_NAME, self::ID_NAME, $btn_id, $vx );
		} else {
			$vx["poll_id"] = $data->poll_id;
			$vx["bid"] = $data->requ["bid"];
			CTable::insertRec( self::TBL_NAME, $vx );
		}

		$data->resp["vcnts"] = array();
		if ( $this->findRec( $data, $vcnt ) ) {
			$data->resp["vcnts"][$data->requ["bid"]]  = $vcnt;
		}
	}
}

?>