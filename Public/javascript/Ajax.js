
//  用于储存XMLHttpRequest对象
   var xmlHttp = null;
 //  创建XMLHttpResquest对象
   function createXmlHTTP(){
	   
	   if(window.ActiveXObject){
		   // 将各个版本的ActiveXObject放在一个数组
		   var arrActiveX = ['Microsoft.XMLHTTP','MSXML2.XMLHTTP.6.0','MSXML2.XMLHTTP.5.0','MSXMLHTTP.4.0','MSXML2.XMLHTTP.3.0','MSXML2.XMLHTTP'];
		   // 通过循环创建XMLHttpRequest对象
		   for(var i=0;i<arrActiveX.length;i++){
			   try{
				   xmlHttp = new ActiveXObject(arrActiveXp[i]);
				   break;
			   }
			   catch(ex){}
		   }
	   }
	   else if(window.XMLHttpRequest){
		   //  创建XMLHttpRequest对象
		   xmlHttp = new XMLHttpRequest();
	   }
	}

   
   // 用于检验用户名的函数   
   function checkUserName(){
	   var uname = myForm.username.value;
	   var file  = myForm.file;
	   // 创建XMLHttpRequest对象  
	   createXmlHTTP();
	   // 判断对象是否创建成功  
	   if(xmlHttp!=null){
		   // 定义用于响应XML   HttpRequest对象状态改变变化的函数  
		    xmlHttp.onreadystatechange = checkData;
		    //  创建HTTP请求 
		    xmlHttp.open("POST","__URL__/check",true);
		  //定义传输的文件HTTP头信息 
		    　      xmlHttp.setRequestHeader("Content-Type","application/x-www-form-urlencoded"); 
		    // 发送HTTP请求
		    xmlHttp.send('uname='+uname);
	   }
	   else alert('你的浏览器不支持XMLHTTP!');
   }
   
   // 初始化第一级菜单
   function initFirst(){
	 
	   document.getElementById('doublecombo').options[0].selected = 'selected';
   }
    
   
   //  发送HTTP请求 
   function sendHttp(number){
	  
	   number++;
	   createXmlHTTP();
	   if(xmlHttp!=null){
		   xmlHttp.onreadystatechange = getData;
		   // URL用__URL__/getClassByAjax不对
		   xmlHttp.open("GET",SITE_URL+"/Trade/getClassByAjax/id/"+number,true);
		   xmlHttp.send();
	   }
	   else alert('你的浏览器不支持XMLHTTP!');
	   
	   
   }
   // 处理结果
   function getData(){
	   // 二级分类的属性
	   var j=1;
	   var temp=document.getElementById('stage');
	   if(xmlHttp.readyState == 4&&xmlHttp.status ==200){
		   var gettedData    = xmlHttp.responseText;
		   //alert(gettedData);
		   var gettedDataArr = gettedData.split(',');		   
		   for(i=0;i<temp.length;i++){				  
			   temp.remove(i); 
			   }	   
		   for(i=0;i<gettedDataArr.length;i++){
			  if(gettedDataArr[i]!=''){
			   temp.options[i] = new Option(gettedDataArr[i],j++);
			  }	   
		   }	   
	   }   
   }
   
