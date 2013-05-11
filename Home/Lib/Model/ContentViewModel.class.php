<?php
//  ViewModelΪthinkphp�е���ͼģ�� 
class ContentViewModel extends ViewModel {
	// viewFields ΪViewModel���е�����
    public $viewFields = array(
        'Flash'=>array('flash_id','user_id','flash_body','_type'=>'LEFT'),
        'User'=>array('user_id','username','_on'=>'Flash.user_id=User.user_id'),
    );
}