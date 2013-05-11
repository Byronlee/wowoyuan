<?php 
class UserSetModel extends Model{
    
    //获取部门列表
    function getDepartment(){
       return $this->table(C('DB_PREFIX').'user_department')->findall();
    }
    
    function getFieldList(){
        return $this->table(C('DB_PREFIX').'user_set')->findall();
    }
    
    //添加字段
    function addfield(){
        $data['fieldkey']     =  t($_POST['fieldkey']);
        if( $this->table(C('DB_PREFIX').'user_set')->where($data)->count()==0 ){
            $data['fieldname']    =  t($_POST['fieldname']);
            $data['status']       =  intval($_POST['status']);
            $data['spaceshow']    =  intval($_POST['spaceshow']);
            $data['module']         =  t($_POST['module']);
            if( $this->table(C('DB_PREFIX').'user_set')->add( $data )){
                return true;
            }else{
                $this->error = '添加失败';
            }
        }else{
            $this->error = '字段名已存在';
        }
    }
    
    function deleteField($ids) {
    	$ids = is_array($ids) ? $ids : explode(',', $ids);
    	if ( !empty($ids) ) {
    		$map['id'] = array('in', $ids);
    		return $this->where($map)->delete();
    	}else {
    		return false;
    	}
    }
}
?>