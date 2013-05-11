
/*      ----------- aboutÒ页面的   js
                                ----------------     */
var name_0='one';
var cursel_0=1;
var links_len;

  function onabout(){
	var links = document.getElementById('aboutl').getElementsByTagName('div');
	links_len=links.length;
	setTab(name_0,cursel_0);
}
//    name="one"
function setTab(name,cursel){
//  links_len=4;
	cursel_0=cursel;
	for(var i=1; i<=links_len; i++){
		var menu = document.getElementById(name+i);
		var menudiv = document.getElementById("con_"+name+"_"+i);
		if(i==cursel){
		//   HTMLÖÐÃ»ÓÐ³öÏÖ  class="off";
			menu.className="off";
			//  ¶ÔÓ¦µÄÑ¡Ïî¿¨
			menudiv.style.display="block";
		}
		else{
			menu.className="";
			menudiv.style.display="none";
		}
	}
}

   //  shelve 页面的js



function error(message){
	if(message=="数据插入数据库时出错!"){
		alert(message);
    	$('#out-btn').parent().html('<input type="button" id="gg_T" class="failed_img" value="图片插入出错！" />');
    	}else{
    		alert(message);
        	$('#out-btn').parent().html('<input type="button" id="gg_T" class="failed_img" value="图片上传失败！" />');               
	}
} 

function subSubmit(){
	var subForm = document.getElementById('subForm');
	subForm.submit();	
	$('#gg_T').parent().html(' <input type="submit" class="button" id="out-btn" name="submit" value="开始拍卖吧" onclick="psubmit()" />');
	
}    

   // 判断正确的图片显示
   var rightImgPath     ="<img src='/Public/images/button/right.png' />";
  
$(document).ready(function(){
	

	
	//对trade_way 动态的默认设置初始化值
    var selects = document.getElementsByName("trade_way"); 
    var T_way=$('.T_way').val();
    if(T_way==""){
   	 selects[2].checked= true; 
     }
    else{
    for (var i=0; i<selects.length; i++){  
        if (selects[i].value==T_way) {  
            selects[i].checked= true;  
            break;  
        }         
    }  
   }
	
	

	
	
	// 验证数字正则表达式
	 var validatePriceNum =  /^\d+$/;
	  //文本框失去焦点后
    $('#shelve :input').blur(function(){
    	// 有提示信息是清楚提示信息
         var $parent = $(this).parent();
         $parent.find(".formtips").remove();
         //验证用户名
         if( $(this).is('#goods_name') ){
                if( this.value=="" ){
                  
                eval(putOutError('输入商品名称!'));
                }else if(this.value.length > 20 ){
                	eval(putOutError('小于20字符!'));
                }
                else{
                    eval(putOutSuccess());
                }
         }
       //验证用户名
         if( $(this).is('#goods_detail') ){
                if( this.value==""){
                  
                  eval(putOutError("<div class='tips'>&nbsp;&nbsp;请对商品的品牌,大小,新旧程度等大概描述，以便对方更好的了解。</div>"));
                }
                else if(this.value.length < 20){
                	 eval(putOutError("<div class='tips_t'>长度不小于20位！</div>"));
                }else{
                  
                	 eval(putOutError("<div class='tips_t'>&nbsp;&nbsp;<span class='formtips onSuccess'>"+rightImgPath+"</spans></div>"));
                }
         }
         //验证价格
         if( $(this).is('.pritable input') ){
        	
                if( this.value==""){
                 
                    eval(putOutError('请输入你出售的价格!'));
                }else if(!validatePriceNum.test(this.value)){              	
                	 eval(putOutError('价格必须是数字!'));
                }
                	else{
                   
                		 eval(putOutSuccess());
                }
         }
       
         // 验证QQ
      
         if( $(this).is('#qq') ){
        	
                if( this.value=="" ){
                   
                    eval(putOutError('请输入你的QQ号码'));
                }else if(!validatePriceNum.test(this.value)){
                	//alert(2);
                	
                	eval(putOutError('QQ必须是数字!'));
                }
                	else{
                   
                		 eval(putOutSuccess());
                }
         }
         // 验证手机号
      
         if( $(this).is('#tel') ){
        	
                if( this.value=="" || this.value.length != 11 ){
                    
                    eval(putOutError('请输入11位手机号码!'));
                }else if(!validatePriceNum.test(this.value)){
                	//alert(2);
                
                	eval(putOutError('电话号码必须是数字!'));
                }
                	else{
                  
                		 eval(putOutSuccess());
                }
         }   
         
    }).keyup(function(){
       $(this).triggerHandler("blur");
    }).focus(function(){
         $(this).triggerHandler("blur");
    });

    
	 $("#shelve").live('submit',function(){
		 	
		 	var options = {
		 			success:function(txt){
		 				 txt = eval('('+txt+')');
                     if(txt.code==1){
                    	 alert(txt.message);                  	
                    	 location.href = txt.jumpUrl;
                     }

		 	}
		 	}
		 	$("form").trigger('blur');
		 	var numError = $('*.onSuccess img').length;
		 	
		 	if(numError==6){
		 		// 判断是否有图片
		 		if($('#preview img').length<=0){
		 			alert('请选择图片!');
		 			return false;
		 		}	
		 		else {
		 			//alert(22);
		 			$("#shelve").ajaxSubmit(options);
		 		    return false;
		 	}
		 	}
		 	 else{
		 		alert('请填写完整的信息');
		 		return false;
		 	 }
		 });
	
   
});
function psubmit(){		
		$("#shelve").submit();		
}

// 返回正确的信息
function putOutSuccess(){
	   return "$parent.append(\"<span class='formtips onSuccess'>"+rightImgPath+"</spans>\");";
   }
// 返回错误的信息
function putOutError(errorMsg){
	return  "$parent.append(\"<span class='formtips onError'>"+errorMsg+"</span>\");";

}








/*--------------------------------------------------------------以上是张强写的 js，一下放 李江华写的js----------------------*/












/*---------------------------------------------js分区---------------------------*/

//日志和微贴发表专区的   分类菜单连动 的js

// 微区种类的  类



function provinceList()
{

    this.length=5;
    this[0] = new Option("校园生活","0")
    this[1] = new Option("热门闲聊","1");
    this[2] = new Option("校内学习","2");
    this[3] = new Option("最新活动","3");
    this[4] = new Option("爆料百汇","4");
    return this;
}
function citylist()
{
    this.length=5;
    this[0]=new Array(4);
    this[0][0]=new Option("恋爱单身","0");
    this[0][1]=new Option("食堂饮食","1");
    this[0][2]=new Option("寝室生活","2");
    this[0][3]=new Option("心理情绪","3");

    this[1]=new Array(2);
    this[1][0]=new Option("校内热门","100");
    this[1][1]=new Option("社会百态","101");

    this[2]=new Array(4);
    this[2][0]=new Option("专业技术","200");
    this[2][1]=new Option("学习笔迹","201");
    this[2][2]=new Option("竞赛关注","202");
    this[2][3]=new Option("答案分享","203");

    this[3]=new Array(5);
    this[3][0]=new Option("协会活动","300");
    this[3][1]=new Option("团队活动","301");
    this[3][2]=new Option("校级院级活动","3022");
    this[3][3]=new Option("心理情绪","303");
    this[3][4]=new Option("学生会活动","304");

    this[4]=new Array(1);
    this[4][0]=new Option("我来爆料","500");
    return this;
}

//创建provincelist、citylist类实例
var provinceOb=new provinceList();
var cityOb=new citylist();

//定义province、city变量，用于select元素
var province;
var city;


function addCitys(province,city)
{
    var index=province.selectedIndex;
    for(var i=0;i<cityOb[index].length;i++)
    {
        try
        {
            city.add(cityOb[index][i]);
        }
        catch(e)
        {
            city.add(cityOb[index][i],null);
        }
    }
}

function delCitys(city)
{
    for(var i=0;i<city.length;i++)
    {
        city.remove(i);
    }
}



function initialize(privinceId,cityId)
{
    //获取select元素
    province=document.getElementById("province");
    city=document.getElementById("city");

    //循环添加省份到province
    for(var i=0;i<provinceOb.length;i++)
    {
        try
        {
            province.add(provinceOb[i]);
        }
        catch(e)
        {
            province.add(provinceOb[i],null);
        }
    }

    //初始化privinceId
    if(privinceId==undefined)
    {
        privinceId=0;
    }
    //设置province默认选项
    province.options[privinceId].selected=true;

    //添加城市到city
    addCitys(province,city);
    //设置city的默认选项
    if(cityId!=undefined)
    {
        city.options[cityId].selected=true;
    }
    else
    {
        city.options[0].selected=true;
    }
}

//下拉列表改变事件
function selectchange(province,city)
{
    delCitys(city);
    addCitys(province,city);
}

$(document).ready(function(){
	$("#upadvise").live('click',function(){
		var text = $("#adviseText").val();
       if(text==''){
    	   alert('建议不能为空!');
       }		
       else{
    	   $.post(SITE_URL+"Index/upAdvice",{text:text},function(txt){
    		   if(txt==1){
    			   alert('提交成功!');
    			   location.reload();
    		   }
    		   else{
    			   alert('提交失败!');
    		   }
    	   });
       }
		
	})
	
	
	
})