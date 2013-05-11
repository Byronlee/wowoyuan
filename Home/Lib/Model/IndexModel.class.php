<?php
class IndexModel extends Model{
	var $uid;
	
	//获得图片的存储路径
	function getSavePath(){
		$savePath = 'Public/images/uploads/avatar/'.$this->uid;
		if (!file_exists($savePath)){
			mk_dir($savePath);
			
		}
		return $savePath;
		
	}
	
	// 上传头像
	function upload(){
		// 不要缓存
	    @header("Pragma: no-cache");
		$pic_path = $this->getSavePath().'/initial.jpg';
		//return $pic_path;
		if(empty($_FILES['uping'])){
			$return['message'] = '上传失败,请稍后在试';
			$return['code']    = 0;
		}
		else{
			if(@copy($_FILES['uping']['tmp_name'],$pic_path)||@move_uploaded_file($_FILES['uping']['tmp_name'],$pic_path)){
				import("ORG.Util.Image");
				Image::thumb($pic_path,$pic_path,'',300,300);
				list($src_w,$src_h,$src_type,$src_attr) = @getimagesize($pic_path);
				@unlink($_FILES['uping']['tmp_name']);
				$return['data']['pic_w']   = $src_w;
				$return['data']['pic_h']   = $src_h;
				$return['data']['pic_url'] = $pic_path;
				$return['code'] = 1;
			}
		    else{
		    	@unlink($_FILES['uping']['tmp_name']);
	        	$return['message'] = '对不起, 图片未上传成功';
	        	$return['code']    = '0';
		    }
			
		}
		return json_encode($return);
		
		
	}
	
	function doSave(){
		$x1 = $_POST['x1'];
		$y1 = $_POST['y1'];
		$w  = $_POST['w'];
		$h  = $_POST['h'];
		$src = $_POST['pic_url'];
	    //return $x1;
	    
		// 获取源图的扩展名宽高
		list($sr_w, $sr_h, $sr_type, $sr_attr) = @getimagesize($src);
		if($sr_type){
			//获取后缀名
			$ext = image_type_to_extension($sr_type,false);
		} else {
			echo 0;
			exit;
		}
		
		$big_w = '120';
		$big_h = '120';
		
		$middle_w = '50';
		$middle_h = '50';
		
		$small_w  = '30';
		$small_h  = '30';
		$face_path = $this->getSavePath();
			//return $face_path;
	    $big_name = $face_path.'/big.jpg';
	    $middle_name = $face_path.'/middle.jpg';
	    $small_name = $face_path.'/small.jpg';
			
	    $func	=	($ext != 'jpg')?'imagecreatefrom'.$ext:'imagecreatefromjpeg';
		$img_r	=	call_user_func($func,$src);
		// 生成大图
		$dest_r = ImageCreateTrueColor($big_h,$big_w);
		$back   = ImageColorAllocate($dest_r,255,255,255);
		ImageFilledRectangle( $dest_r, 0, 0, $big_w, $big_h, $back );
		ImageCopyResampled( $dest_r, $img_r, 0, 0, $x1, $y1, $big_w, $big_h, $w, $h );
		ImagePNG($dest_r,$big_name);  // 生成大图
		//生成中图
		$sdst_r	=	ImageCreateTrueColor( $middle_w, $middle_h );
		ImageCopyResampled( $sdst_r, $dest_r, 0, 0, 0, 0, $middle_w, $middle_h, $big_w, $big_w );
		ImagePNG($sdst_r,$middle_name);  // 生成中图
		// 生成小图
		$sdst_s	=	ImageCreateTrueColor( $small_w, $small_h );
		ImageCopyResampled( $sdst_s, $dest_r, 0, 0, 0, 0, $small_w, $small_h, $big_w, $big_w );
		ImagePNG($sdst_s,$small_name);  // 生成小图
		
		ImageDestroy($dest_r);
		ImageDestroy($sdst_r);
		ImageDestroy($sdst_s);
		ImageDestroy($img_r);
		
	     $flag = D()->execute('UPDATE wo_user SET is_set_avatar = 1 WHERE user_id = '.$this->uid);
			Session::set('register_id','');
			echo 1;
		
	}
	/**
	 *  添加建议    
	 * @param string $text
	 * @param int $uid
	 * @return int
	 */
	public function upAdvise($text,$uid){
		$data = D()->execute("INSERT INTO wo_advise(advise,user_id,posttime) VALUES('".$text."',$uid,".time().")");
		return $data;
		
	}
}
?>