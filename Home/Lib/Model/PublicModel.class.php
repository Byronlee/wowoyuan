<?php
class PublicModel extends Model{


	public function getUserInfo($uid,$mid){
		$data = D()->query('SELECT * FROM wo_user WHERE user_id = '.$uid);	
	     foreach ($data  as $k=>$v){				
			$data[$k]['following'] = M('user_follow')->where('uid='.$uid)->count();		
			$data[$k]['follower']  = M('user_follow')->where('fid='.$uid)->count();
			$data[$k]['grade_class']=D('Shelve')->sure_grade($data[$k]['grade'],$data[$k]['class']);
			$data[$k]['flashs']=M('flash')->where('user_id='.$uid)->count();
			$data[$k]['weities']=M('weitie')->where('user_id='.$uid)->count();
			$data[$k]['followState']  = D('Follow')->getState( $mid , $uid);				
		}
		if (empty($data)) return 0;
		else return $data;
	}
	
	
}
?>