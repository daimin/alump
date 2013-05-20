<?php
class ALump_Array {
	
	/*
	 * 内部数据一个Array
	 */
	private $data = null;
	
	public $pageNav = null;
	
	
	
	/*
	 * 该类数据未分页的总条数
	 * @param $type 数组的类型
	 * @param  $itemcount
	 */
	public function __construct( $itemcount=0){
		$this->data = array();
		$this->pageNav = new ALump_PageNav($itemcount);
	}
	/*
	 * 内部计数器
	 */
	private $_index = 0;
	
	/*
	 * 添加元素的数组尾部
	 */
	public function add($item){
		array_push($this->data, $item);
	}
	/*
	 * 获取指定索引的元素
	 */
	public function  get($index){
		if(isset($this->data[$index])){
			return $this->data[$index];
		}
		
		return False;
	}
	/*
	 * 返回数组的大小
	 */
	public function size(){
		return count($this->data);
	}
	/**
	 * 把数组解析到指定的格式
	 * 参数1：解析格式化字符串
	 * 参赛2：可以是标签的名字，也可以是指定的值
	 */
	public function parse($fmt, $relVal=""){
		$fmt = strtolower($fmt);
		preg_match_all('/{([a-zA-Z0-9]+)}/i', $fmt, $matches);
		
		if(empty($matches) || count($matches) < 2){
			return "";
		}
		
		$parseAttr = $matches[1];
		// 得到渲染类别 1 是option,2是li
		$ftype = 0;
		if(strpos($fmt, '<option') !== False){
			$ftype = 1;
		}else if(strpos($fmt, '<li')!== False){
			$ftype = 2;
		}

 		$to = array();
 		
		foreach ($this->data as $key=>$val){
			$rep = $fmt;
			
			for($i =0,$len=count($matches[0]);$i < $len;$i++){
				$attr = $matches[1][$i];
				$rattr = $matches[0][$i];

				switch($ftype){
					case 1: // option
						
						$oval = $val->$attr;
						
						$compVal = ALump::$request->request($relVal);
						if(empty($relVal)){
							$compVal = $relVal;
						}
						
						if($oval == $compVal){
							$repss = explode(">", $rep);
							$rep = $repss[0].' selected="selected" >'.$repss[1];
						}
						break;
					case 2:
						$val->getPermalink();
						$oval = $val->$attr;
						//echo $oval;
					    
						break;
					default:
						break;
				}
			echo '|'.$rattr.'|';
				$rep = str_replace($rattr, $val->$attr, $rep);

			}
			//echo $rep;
			array_push($to, $rep);
		}
		
 		return implode("", $to);
	}
	
	/*
	 * 返回内部的数组数据
	 */
	public function items(){
		return $this->data;
	}
	/*
	 * 当前数组是否有元素
	 */
	public function have(){
		return !empty($this->data);
	}
	/*
	 * 下一个元素
	 */
	public function next(){
		$res = False;
		if(isset($this->data[$this->_index])){
			
			$res = $this->data[$this->_index];
		}
		$this->_index += 1;
		return $res;
	}
	
	public function index(){
		echo $this->_index;
		return $this->_index;
	}
	/*
	 * 轮换返回值，根据数组的当前序号
	 */
	public function alt($even, $add){
		if($this->_index % 2 == 0){
			echo $even;
			return $even;
		}
		echo $add;
		return $add;
	}
	/*
	 * 设置分页的链接参数
	 */
	public function setPageNavParams($params){
		$this->pageNav->params = $params;
	}
	/*
	 * 返回分页数据
	 */
	public function pageNav(){
		
		echo '<span class="pager" style="float:right;">共 '.$this->pageNav->itemcount.' 项&nbsp;&nbsp;
		<a class="link_button" href="?1=1'.$this->pageNav->params.'&page=1">&laquo;</a>
		<a class="link_button" href="?1=1'.$this->pageNav->params.'&page='.($this->pageNav->pageno - 1).'">&lsaquo;</a>
		第 <input type="text" value="'.$this->pageNav->pageno.'" id="page_input_2" class="page_input"/> 页,共 '.$this->pageNav->pagecount.' 页
				<a class="link_button" href="?1=1'.$this->pageNav->params.'&page='.($this->pageNav->pageno + 1).'">&rsaquo;</a>
				<a class="link_button" href="?1=1'.$this->pageNav->params.'&page='.($this->pageNav->pagecount).'">&raquo;</a>
  </span>';
	}
}

?>