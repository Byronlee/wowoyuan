/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


// center_top 菜单条特效的 js

var previousdiv = '';
var previouscenter_div='';
function showdetaildiv(divid ,idd,obj){
    highlightdiv(idd,obj);
    if(idd=='sc1'){
        if(previousdiv!=""){
            document.getElementById(previousdiv).style.display="none";
            document.getElementById(divid).style.display="block";
            previousdiv=divid;

        }
    }
    if(idd=='sc2'){
        if(previouscenter_div!=""){
            document.getElementById(previouscenter_div).style.display="none";
            document.getElementById(divid).style.display="block";
            previouscenter_div=divid;
    }
    }
}
function init(){
    document.getElementById('at1').style.display="block";
    previousdiv='at1';
    document.getElementById('first').className="on";
    document.getElementById('first_shancun').className="on";
     document.getElementById('at5').style.display="block";
    previouscenter_div='at5';
}

function highlightdiv(idd,obj)
{
    var getdiv= document.getElementById(idd);
    var getdiva = new Array();
    getdiva=getdiv.getElementsByTagName("A");
    for (i = 0; i < getdiva.length; i++)
    {
        getdiva[i].className = "";
    }
    obj.className = 'on';
}





/*----------------------------------------中间底部 滚动条的    滚动图片效果 的 js 代码,  这是向左移动！-------------------------*/
var dom;
var dom1;
var dom2;
var speed;//  滚动速度！
var MyMar;
function bodyload(){

	 init();   //这句代码是  上面的 菜单条的 初始化 的  俭省代码
     bodyload1();
    dom = document.getElementById('scrollbody');
    dom1 = document.getElementById('scroll1');
    dom2 = document.getElementById('scroll2');
    dom2.innerHTML = dom1.innerHTML;
    toLeft();

}
function toLeft(){
    MarqueeLeft();
}
function MarqueeLeft(){
    if(dom2.offsetWidth-dom.scrollLeft <= 0){
        dom.scrollLeft -= dom1.offsetWidth;
    }else{
        dom.scrollLeft ++;
    }
    if(!MyMar){
        MyMar = setInterval(MarqueeLeft,100);
    }
    dom.onmouseover = function() {
        clearLeft();
    }
    dom.onmouseout = function() {
        if(!MyMar)
            MyMar=setInterval(MarqueeLeft,100);
    }
}
function clearLeft(){
    clearInterval(MyMar);
    MyMar = null;
}



/* 个人信息中二级联动菜单    */
// 定义专业数组
professionArray      = new Array();
// new Array 大写
professionArray[0]   = new Array("信息科学与技术学院","计算机科学与技术,软件工程,网络工程,数字媒体技术,信息与计算科学");
professionArray[1]   = new Array("美术学院","艺术设计,动画,绘画");
professionArray[2]   = new Array("文学与新闻传播学院","汉语言文学,广播电视新闻学,对外汉语,新闻采编与制作,公共事务管理");
professionArray[3]   = new Array("电子信息工程学院","自动化,电气工程及其自动化,电子信息工程,通信工程,电气自动化技术");
professionArray[4]   = new Array("生物产业学院","生物工程,制药工程,食品科学与工程,药学,食品质量与安全,生物技术及应用,商检技术");
professionArray[5]   = new Array("工业制造学院","机械设计制造及其自动化,材料成型及控制工程,测控技术与仪器,车辆工程");
professionArray[6]   = new Array("城乡建设学院","土木工程,工程管理,环境工程,测绘工程,工程造价,建筑装饰工程技术");
professionArray[7]   = new Array("旅游文化产业学院","旅游管理,森林资源保护与游憩,园林,旅游管理,酒店管理");
professionArray[8]   = new Array("师范学院","小学教育,应用心理学,美术教育,音乐教育,商务英语,数学教育,语文教育");
professionArray[9]   = new Array("艺术学院","音乐表演,广播电视编导,影视表演,主持与播音,舞蹈表演");
professionArray[10]  = new Array("医护学院","护理学,药学,中药,口腔医学技术");
//外国语学院专业信息不确定,有待检查!
professionArray[11]  = new Array("外国语学院","英语,日语,法语,泰语");
//管理学院专业信息不确定,有待检查!
professionArray[12]  = new Array("管理学院","工商管理,会计,市场营销,电子商务,社区管理与服务");

professionArray[13]  = new Array("国际教育学院","工商管理,商务英语");
professionArray[14]  = new Array("学前教育学院","学前教育,特殊教育");
//体育学院专业信息不确定,有待检查!
professionArray[15]  = new Array("体育学院","体育教育,社区体育");
professionArray[16]  = new Array("经济政法学院","法学,法律事务");


function getProfession(academy){
	//alert(professionArray);
	//alert(professionArray.length);
	//清空 城市 下拉选单 
	document.all.profession.length = 0 ; 
	for(var m=0;m<professionArray.length;m++){
		//alert(22);
		if(professionArray[m][0]==academy){
			parray = professionArray[m][1].split(',');
			for(var n=0;n<parray.length;n++){
				document.all.profession.options[document.all.profession.length] = new Option(parray[n],parray[n]);
			}
		}
	}
	
}

/*  初始化二级菜单的选项  */
function initOption(object,value){
	var optionsLen = $(object+" option").length;
	 //$("#grade").get(0).selectedIndex = 3;

	 for(var i=0;i<optionsLen;i++){
		 if($(object).get(0).options[i].value==value){
			
			 $(object).get(0).options[i].selected = true;
		 }
	 }
}



/*滚动图片效果 的 js 代码,  这是向右移动！*/
var div;
var div1;
var div2;
var speed1;//  滚动速度！
var Mydiv;
function bodyload1(){
    div = document.getElementById('scrollbody1');
    div1 = document.getElementById('scroll3');
    div2 = document.getElementById('scroll4');
    div2.innerHTML = div1.innerHTML;
    toLeft1();
}
function toLeft1(){
    MarqueeLeft1();
}
function MarqueeLeft1(){
    if(div.scrollLeft <= 0){
        div.scrollLeft += div1.offsetWidth;
    }else{
        div.scrollLeft --;
    }
    if(!Mydiv){
        Mydiv = setInterval(MarqueeLeft1,100);
    }
    div.onmouseover = function() {
        clearLeft1();
    }
    div.onmouseout = function() {
        if(!Mydiv)
            Mydiv=setInterval(MarqueeLeft1,100);
    }
}
function clearLeft1(){
    clearInterval(Mydiv);
    Mydiv = null;
}



/* 帐号设置中的JS   */
$(document).ready(function(){
	// 初始密码
	$("#original-pas").live('blur',function(){
		var ori = $("#original-pas").val();
		//alert(ori);
		//alert(SITE_URL+"/Index/doSetAccount");
		$.post(SITE_URL+"Index/doSetAccount",{pas:ori},function(txt){
			if(txt==1){
				$(".or-err").html('<img src="/Public/images/button/right.png" />');
			}
			else {	
				$(".or-err").html('密码错误,请重新输入');
			}
		})	
	});
	// 修改密码

	$("#modify-pas").live('blur',function(){
		$(".pas-err").html('');
		var mopas   = $("#modify-pas").val();
		if(mopas==''){
			$(".pas-err").html('密码不能空!');
			//alert('密码不能为空!');
		}
		else if(mopas==$("#original-pas").val()){
			$(".pas-err").html('修改的密码不能和原密码相同!');
		}
		else if(mopas.length<6||mopas.length>16){
			$(".pas-err").html('密码长度应该在6到16位之间!');
		}
		
		else{
			$(".pas-err").html('<img src="/Public/images/button/right.png" />');
		}
		
	});
	$("#modify-repas").live('blur',function(){
		$(".repas-err").html('');
		var mopas   = $("#modify-pas").val();
		var morepas = $("#modify-repas").val();
		if(mopas!=morepas || morepas==''){
			$(".repas-err").html('两次输入的密码不一致!');
		}
		else{
			$(".repas-err").html('<img src="/Public/images/button/right.png" />');
		}
		
		
	});
	$("#submit-input-1").live('click',function(){
		
		
		var mopas   = $("#modify-pas").val();
		var morepas = $("#modify-repas").val();
		if(mopas!=morepas || morepas==''){
			$(".repas-err").html('两次输入的密码不一致!');
			alert('两次密码输入不一致！');
		}
		else{
			
		var mopas   = $("#modify-pas").val();
		if($('.tb_setAcc  img').length==3){
			$.post(SITE_URL+"Index/doSetAccount",{mopas:mopas},function(txt){
				if(txt==1){
					alert('修改密码成功!');
					location.href=SITE_URL+"Index/setAccount";
				}
				else{
					alert('修改密码失败!');
					
				}
			})
		}else{
			alert('请填写正确信息!');
		}
		
		
		}
	});
	
	
	
});
/* 修改个人信息中JS   */
$(document).ready(function(){
	// 验证数字正则表达式
	 var validatePriceNum =  /^\d+$/;
	 // 验证用户名正则表达式
	 var pattern2 = /^[\u0391-\uFFE5\w]+$/;
	$("#set-nickName").live('blur',function(){
		var nickName = $("#set-nickName").val();
		if(nickName==''){
			$("#info-error").html('用户名不能为空哟!');
			
		}
		else if(nickName.length<2||nickName.length>12){
			$("#info-error").html('用户名长度必须在2-12位之间');
			
			
		}
		else if(!(nickName.match(pattern2))){
			$("#info-error").html('昵称格式应该由中文,英文,数字,下划线组成!');
			
		}
		else {
		$.post(SITE_URL+"Public/validateRegister",{name:nickName},function(txt){
				if(txt==1){
					$("#info-error").html('用户名已存在！');
			}
				else{
			 //用户名格式没有错误!
			    
				//$("#info-error").html('');
				}
			})
		}
		
	});
	// 验证QQ
	$(".selectQQ").live('blur',function(){
		var qq  = $(".selectQQ").val();
		if(this.value==''){
			$(".qq-error").html('');
		}
		else if(qq.length>15){
			$(".qq-error").html('qq长度应该小于15位哟!');
			
		}
		else if(!validatePriceNum.test(this.value)){
			$(".qq-error").html('qq只能为数字');
			
		}
		else {
			
			$(".qq-error").html('');
		}
	});
	// 验证日期
	$(".fill-birthday input").live('blur',function(){
		if($(this).is(".year")){
			if(this.value.length>4||!validatePriceNum.test(this.value)){
				$(".bir-error").html('年份格式不正确!');
			
			}
			else{
				
				$(".bir-error").html('');
			}
		}
		if($(this).is(".month")){
			if(this.value.length>2||!validatePriceNum.test(this.value)){
				$(".bir-error").html('月份格式不正确!');
				returnValidateInfo = 1;
			}
			else{
				
				$(".bir-error").html('');
			}
		}
		if($(this).is(".day")){
			if(this.value.length>2||!validatePriceNum.test(this.value)){
				$(".bir-error").html('日期格式不正确!');
				returnValidateInfo = 1;
			}
			else{
				
				$(".bir-error").html('');
			}
		}
		
	});
	
	// 提交
	$('#info-form').live('submit',function(){
	  var options = { 
			success:function(txt){	
				txt = eval('('+txt+')');
				   if(txt==1){
					 alert('保存成功!');
					   location.href=SITE_URL+"Index/Information";
				   }
				   else if(txt==0){
					     alert('保存失败!');
				   }
			}
	};
	  
	if($(".tb-setInfo .error").text()==''){
	$(this).ajaxSubmit(options);
	return false;
	}
	else {
		alert('请完善信息!');
		return false;
	}
	});

});




/* 注册页面      */
$(document).ready(function(){
	 // 验证邮箱正则表达式
	 var pattern1 = /^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+(\.[a-zA-Z0-9_-])+/;
	 // 验证用户名正则表达式
	 var pattern2 = /^[\u0391-\uFFE5\w]+$/;
	 // 文本失去焦点后
	 
	 $('input').focus(function(){		 
		 var parent  = $(this).parent();
		 parent.find(".error").remove();
		 if(parent.find(".right_right").html()==''){
     if( $(this).is("#email")){    	   
    	   parent.append('<div class="error">&nbsp;赶快输入你的邮箱吧</div>');   		  
   	   }
    	 
      if($(this).is("#password")){   	
    	   parent.append('<div class="error">&nbsp;输入6-18位的秘密</div>');    	 
      }
       if($(this).is("#repassword")){    	   
    	   parent.find(".error").remove();    	   
       }
       if($(this).is("#nickname")){    	   	   
    		   parent.append('<div class="error">&nbsp;请输入你的真实姓名吧</div>');    	   
      }
      if($(this).is("#validateVerify")){  	  
    	   parent.find(".error").remove();    	   
       }
		 }
 });	 	 		 	 
	 $('select').blur(function(){		//两级连动菜单 的选择情况判断 
	 });
	 
	 
	 $('input').blur(function(){
		 var parent  = $(this).parent();
		 parent.find(".error,.right_right").remove();
       if( $(this).is("#email")){
    	   if(this.value==''){
    		   parent.append('<div class="error">亲，邮箱不能为空呃!</div>');
    		  
    	   }
    	   else if(!pattern1.test(this.value)){
    		   parent.append('<div class="error">请输入正确的邮箱格式呃</div>');
    	   }
    	   else{
    		   $.post(SITE_URL+"Public/validateRegister",{email:this.value},function(txt){
    			   if(txt==1){
    			   parent.append('<div class="error">亲，邮箱已经存在了</div>');
    			   }
    			   else{
    				   parent.append('<div class="right_right"><img src="'+_PUBLIC_+'/images/button/right.png" /></div>')
    			   }
    		   });
    	   }
       }
       if($(this).is("#password")){
    	   if(this.value==''){
    		   parent.append('<div class="error">亲，密码不能为空哦</div>');
    	   }
    	   else if(this.value.toString().length<6||this.toString().value>18){
    		   parent.append('<div class="error">密码必须大于6位小于18位!</div>');
    	   }else{
			   parent.append('<div class="right_right"><img src="'+_PUBLIC_+'/images/button/right.png" /></div>')
		   }  
       }
       if($(this).is("#repassword")){
    	   if(this.value==''||this.value!=$("#password").val()){
    		   parent.append('<div class="error">亲，两次输入的密码不一样</div>');
    	   }else{
			   parent.append('<div class="right_right"><img src="'+_PUBLIC_+'/images/button/right.png" /></div>')
		   } 
       }
       if($(this).is("#nickname")){
    	   if(this.value==''){
    		   parent.append('<div class="error">亲，用户名不能为空!</div>');
    	   }
    	   else if(this.value.length<2||this.value.length>12){
    		   parent.append('<div class="error">用户名长度必须在2-12位之间</div>');
    	   }
    	   else if(!(this.value.match(pattern2))){
    		   parent.append('<div class="error">用户名格式不正确!</div>');
    	   }
    	   else{
    		   $.post(SITE_URL+"Public/validateRegister",{name:this.value},function(txt){
    			   if(txt==1){
        			   parent.append('<div class="error">;亲，用户名已经存在了</div>');
        			   }
        			   else{
        				   parent.append('<div class="right_right"><img src="'+_PUBLIC_+'/images/button/right.png" /></div>');
        			   }  			  
    		   });
    	   }   	   
       }
       if($(this).is("#validateVerify")){
    	   if(this.value==''){
    		   parent.append('<div class="error">亲,验证码不能为空</div>');
    	   }
    	   else{
    		   $.post(SITE_URL+"Public/validateVerify",{verify:this.value},function(txt){
    			   
    			   if(txt==0){
    				   parent.append('<div class="error">亲,验证码不正确</div>');
    			   }
    			   else
    				   {
    				   parent.append('<div class="right_right"><img src="'+_PUBLIC_+'/images/button/right.png" /></div>');
    				   }
    		   })
    	   }   	   
       }
  });
	 
	 
	
		 $("#form").live('submit',function(){
		 	      var options = {
		 			success:function(txt){
		 				txt = eval('('+txt+')');
		 				if(txt==1){
		 					alert('注册成功!');
		 					location.href=SITE_URL+"uphead";
		 				}
		 				else if(txt==2){
		 					alert('不能重复注册哟!!');
		 				}
		 				else if(txt==6){
							alert('两次密码不一致！');
		 				}
					}
		 	}
		 	$("form").trigger('blur');
		 	var numError = $('*.right_right').length;			
		 	 if(numError==5){	
				$("#form").ajaxSubmit(options);
				return false;		 	
		 	}
		 	 else{
				 
		 		 alert('请填写完整的信息');
		 		 return false;
		 	 }		 		 	 		 	 
		 });
  
     // 验证码
     $("#change").live('click',function(){	
	    changeVerify();	    
    });
 }); // 验证码
 function changeVerify(){
		var timenow = new Date().getTime();
		document.getElementById('verifyImg').src=SITE_URL+'Public/verify/'+timenow;  
	}