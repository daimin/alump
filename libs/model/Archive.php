<?php
/**
 * 文章归档
 * @author daimin
 *
 */
class ALump_Archive extends ALump_Model {
	public $year = 0;
	public $month = "";
	public $date = "";
	public $postid = "";

	function __construct($row){
		parent::__construct($row);
		$this->year = $this->get('year');
		$this->month = $this->get('month');
		$this->date = $this->get('date');
		$this->postid = $this->get('postid');
		
	}
	
	
}

?>