<?php
//==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>
//
// Ajaxいいねボタンv2.23用サービスパック１ [ GPL ]
// Copyright (c) phpkobo.com ( http://jpn.phpkobo.com/ )
// Email : admin@phpkobo.com
// ID : LKBSP-100J
//
//==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<

class CTblVoter extends CTblBase {

	const TBL_NAME = "voter";
	const ID_NAME = "voter_id";

	public function __construct( $prt ) {
		parent::__construct( $prt );

		$cfg = CEnv::config("poll/block");
		$this->b_ipsig = $cfg["b-ipsig"];
		$this->b_cksig = $cfg["b-cksig"];
		$this->v_ipsig = null;
		$this->v_cksig = null;

		$this->ipsig = new CIpSig();
		$this->cksig = new CCkSig();
	}

	private function findVoter( $fdname, $fdval ) {

		if ( empty($fdval) ) { return 0; }

		//-- build clauses
		$clx = array();

		//-- select clause
		$clx[] = CSql::clSelect(array(
			self::ID_NAME,
			"dt_create",
			$fdname,
		));

		//-- from
		$clx[] = CSql::clFrom(self::TBL_NAME);

		//-- cond
		$cond = array();
		$cond[] = CSql::clCond( $fdname, "=", $fdval );

		//-- expiration threshold
		$threshold = $this->prt->getSigExpireThreshold();
		if ( !is_null($threshold) ) {
			$cond[] = CSql::clCond("dt_create",">=",$threshold);
		}

		//-- where clause
		if ( !empty($cond)  ) {
			$clx[] = CSql::clWhere("AND",$cond);
		}

		//-- ordery by clause
		$clx[] = "ORDER BY voter_id ASC";

		//-- limite clause
		$clx[] = "LIMIT 1";

		//-- run query
		$voter_id = 0;
		$result = CSql::query($clx);
		if ( $rs = CDb::getRowA( $result ) ) {
			$voter_id = $rs[self::ID_NAME];
			if ( $fdname == "ipsig" ) {
				$this->v_ipsig = $rs["ipsig"];
			}
			if ( $fdname == "cksig" ) {
				$this->v_cksig = $rs["cksig"];
			}
		}

		//-- free result
		CDb::freeResult( $result );

		return $voter_id;
	}

	public function getVoterInfo( $data ) {

		$voter_id = 0;

		if ( $this->b_ipsig && !$voter_id ) {
			if ( $ipsig = $this->ipsig->getVal() ) {
				if ( $id = $this->findVoter("ipsig",$ipsig) ) {
					$voter_id = $id;
				}
			}
		}

		if ( $this->b_cksig && !$voter_id ) {
			if ( $cksig = $this->cksig->getVal() ) {
				if ( $id = $this->findVoter("cksig",$cksig) ) {
					$voter_id = $id;
				}
			}
		}

		$data->voter_id = $voter_id;
	}

	public function update( $data ) {

		if ( $this->b_ipsig || $this->b_cksig ) {
			if ( $data->voter_id ) {
				$vx = array();

				if ( $this->b_ipsig ) {
					if ( empty($this->v_ipsig) ) {
						$this->v_ipsig = $this->ipsig->getVal();
					}
					if ( !empty($this->v_ipsig) ) {
						$vx["ipsig"] = $this->v_ipsig;
					}
				}

				if ( $this->b_cksig ) {
					if ( empty($this->v_cksig) ) {
						$this->v_cksig = $this->cksig->getVal(true);
					}
					if ( !empty($this->v_cksig) ) {
						$vx["cksig"] = $this->v_cksig;
						$this->cksig->setVal($this->v_cksig);
					}
				}

				$vx["dt_create"] = $this->prt->getDateTimeStr();
				CTable::updateByID(self::TBL_NAME,self::ID_NAME,
					$data->voter_id,$vx);
			} else {
				$vx = array();

				if ( $this->b_ipsig ) {
					$this->v_ipsig = $this->ipsig->getVal();
					if ( !empty($this->v_ipsig) ) {
						$vx["ipsig"] = $this->v_ipsig;
					}
				}
				if ( $this->b_cksig ) {
					$this->v_cksig = $this->cksig->getVal(true);
					if ( !empty($this->v_cksig) ) {
						$vx["cksig"] = $this->v_cksig;
						$this->cksig->setVal($this->v_cksig);
					}
				}

				$vx["dt_create"] = $this->prt->getDateTimeStr();
				CTable::insertRec(self::TBL_NAME,$vx);
			}

			$this->getVoterInfo($data);
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