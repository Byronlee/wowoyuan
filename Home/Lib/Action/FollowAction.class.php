<?php
class FollowAction extends CommonAction{

    //关注人
    function follow(){      //特别注释：$this->uid  表示，当前登录用户；$_POST['uid']表示当前登录用户要该用户的操作；
    	if($_POST['type']=='dofollow'){   		
    	  echo D('Follow')->dofollow($this->uid,intval($_POST['uid']) );
    	}else{
    		echo D('Follow')->unfollow($this->uid,intval($_POST['uid']) );
    	}
    }
}