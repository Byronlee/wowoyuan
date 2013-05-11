/**
 * 
 */


/* 重置设置中的JS   */

$(document).ready(function(){
	
	// 修改密码

	$("#modify-pas").live('blur',function(){
		$(".pas-err").html('');
		var mopas   = $("#modify-pas").val();
		if(mopas==''){
			$(".pas-err").html('密码不能空!');
			//alert('密码不能为空!');
		}
		else if(mopas.length<6||mopas.length>16){
			$(".pas-err").html('长度应在6到16位之间!');
		}
		else{
			$(".pas-err").html('<img src="/Public/images/button/right.png" />');
		}
		$("#modify-repas").live('blur',function(){
			$(".repas-err").html('');
			var mopas   = $("#modify-pas").val();
			var morepas = $("#modify-repas").val();
			if(mopas!=morepas || morepas==''){
				$(".repas-err").html('密码不一致!');
			}
			else{
			
					$(".repas-err").html('<img src="/Public/images/button/right.png" />');
				
			}
		});
	});
	
	
});