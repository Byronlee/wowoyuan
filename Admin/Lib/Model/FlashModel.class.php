<?php
class FlashModel extends Model{
	/**
      *闪存模块统计
      *@param int $id
      *@return int 
	  */
	public function queryNumber($id){
		// $id = 1 查询全部闪存记录
		$queryStr = 'SELECT count(*) FROM wo_flash';
		if($id==1){
			$data = $this->query($queryStr);
			
		}
		
		return $data[0]['count(*)'];
		
		
		
	}
	
	
}
?>