<?php
//==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>
//
// Ajaxいいねボタンv2.23用サービスパック１ [ GPL ]
// Copyright (c) phpkobo.com ( http://jpn.phpkobo.com/ )
// Email : admin@phpkobo.com
// ID : LKBSP-100J
//
//==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<

class CDDriver {

	public function __construct() {
		$this->tbl_btn = new CTblBtn($this);
		$this->tbl_poll = new CTblPoll($this);
		$this->tbl_voter = new CTblVoter($this);
		$this->tbl_hist = new CTblHist($this);
		CEnv::useLib("db");
		$this->open_status = CDb::open();
	}

	public function load( $data ) {
		$this->tbl_poll->makePidMap($data);
		$this->tbl_btn->loadVcntsx($data);
		$this->tbl_voter->getVoterInfo($data);
		$this->tbl_hist->loadSelsx($data);
	}

	public function hist( $data ) {
		$this->tbl_poll->getPollInfo($data);
		$this->tbl_voter->getVoterInfo($data);
		$this->tbl_hist->getBtnType($data);
	}

	public function update( $data ) {
		$this->tbl_voter->update($data);
		$this->tbl_btn->update($data);
		$this->tbl_hist->update($data);
		$this->tbl_btn->loadVcnts($data);
		$this->tbl_hist->loadSels($data);
	}

	public function expire( $data ) {
		$threshold = $this->getSigExpireThreshold();
		if ( is_null($threshold) ) { return; }
		$this->tbl_voter->expire($data,$threshold);
		$this->tbl_hist->expire($data,$threshold);
	}

	public function edit( $data ) {
		$this->tbl_poll->getPollInfo($data);
		$this->tbl_btn->edit($data);
	}

	public function getDateTime( $t = false ) {
		if ( $t === false ) {
			return gmdate("U");
		} else {
			return gmdate("U",$t);
		}
	}

	public function getDateTimeStr( $t = false ) {
		if ( $t === false ) {
			return gmdate("Y-m-d H:i:s");
		} else {
			return gmdate("Y-m-d H:i:s",$t);
		}
	}

	public function getSigExpireInterval() {
		$cfg = CEnv::config("poll/block");
		if ( empty($cfg["sig-expire"]) ) { return 0; }
		$days = $cfg["sig-expire"];
		return ( substr($days,-1) == "s" ) ?
			intval(substr($days,0,-1)) :
			intval($days)*(60*60*24);
	}

	public function getSigExpireThreshold() {
		$interval = $this->getSigExpireInterval();
		if ( $interval <= 0 ) { return null; }
		$now = $this->getDateTime();
		return $this->getDateTimeStr($now-$interval);
	}

}

?>