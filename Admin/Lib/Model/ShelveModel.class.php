<?php
class ShelveModel extends Model{
	/**
	 * 商品数量统计
	 * @param int $id
	 * @return int
	 */
	public function queryNumber($id){
		$queryStr = 'SELECT count(*) FROM wo_shelve';
		if($id == 4){
			$number = $this->query($queryStr);
		}
		else{
	 $number = $this->query($queryStr.' WHERE is_Sale = '.$id);
	 //dump($this);
		}
	 return $number[0]['count(*)'];
	}
	
	
	
	
}





?>