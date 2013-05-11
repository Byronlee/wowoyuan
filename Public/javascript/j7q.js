/** 
* jQuery插件开发方法二：第一步：插件定义 
*/ 
jQuery.myPlugin = { 
//获得浏览器的内核与外壳的类型和版本 
Client: function (){ 
	//浏览器内核类型(只有五种) 
	var engine = { ie:0, webkit:0, gecko:0, opera:0, khtml:0 }; 
	//浏览器外壳类型（国内常见的浏览器有：360浏览器、傲游、腾讯QQ\TT浏览器、世界之窗、彗星浏览器、绿色浏览器、传统IE、谷歌Chrome、网景netscape、火狐、Opera、苹果Safari等等） 
	var shell = { se360:0, se:0, maxthon:0, qq:0, tt:0, theworld:0, cometbrowser:0, greenbrowser:0, ie:0, chrome:0, netscape:0, firefox:0, opera:0, safari:0, konq:0 }; 
	//获得客户端浏览器的信息 
	var ua = navigator.userAgent.toLowerCase(); 
	for (var type in engine) { 
		if (typeof type === 'string') { 
			var regexp = 'gecko' === type ? /rv:([\w.]+)/ : RegExp(type + '[ \\/]([\\w.]+)'); 
			if (regexp.test(ua)){ 
				engine.version = window.opera ? window.opera.version() : RegExp.$1;//浏览器内核版本 
				engine[type] = parseFloat(engine.version); 
				engine.type = type;//浏览器内核类型 
				break; 
			} 
		} 
	} 
	for (var type in shell) { 
		if (typeof type === 'string') { 
			var regexp = null; 
			switch(type) { 
				case "se360": regexp = /360se(?:[ \/]([\w.]+))?/; break; 
				case "se": regexp = /se ([\w.]+)/; break; 
				case "qq": regexp = /qqbrowser\/([\w.]+)/; break; 
				case "tt": regexp = /tencenttraveler ([\w.]+)/; break; 
				case "safari": regexp = /version\/([\w.]+)/; break; 
				case "konq": regexp = /konqueror\/([\w.]+)/; break; 
				case "netscape": regexp = /navigator\/([\w.]+)/; break; 
				default: regexp = RegExp(type + '(?:[ \\/]([\\w.]+))?'); 
			} 
			if (regexp.test(ua)) { 
				shell.version = window.opera ? window.opera.version() : RegExp.$1 ? RegExp.$1 : 'unknown';//浏览器外壳版本 
				shell[type] = parseFloat(shell.version); 
				shell.type = type;//浏览器外壳类型 
				break; 
			} 
		} 
	} 
	//返回浏览器内核与外壳的类型和版本：engine为内核，shell为外壳 
	return { engine: engine, shell: shell }; 
} 
}; 
/** 
* jQuery插件开发方法二：第二步：执行插件 
* jQuery.myBrowser插件：获得浏览器的内核与外壳的类型和版本 
* 使用示例： 
* (1)浏览器内核：alert("您的浏览器信息如下：\n内核类型："+jQuery.myBrowser.engine.type+"，内核版本："+jQuery.myBrowser.engine.version); 
* (2)浏览器外壳：alert("您的浏览器信息如下：\n外壳类型："+jQuery.myBrowser.shell.type+"，外壳版本："+jQuery.myBrowser.shell.version); 
*/ 
jQuery.myBrowser = jQuery.myPlugin.Client(); 
//判断
if(jQuery.myBrowser.engine.type!="webkit"||jQuery.myBrowser.shell.type!="chrome"){
	window.location.href=SITE_URL+"sorry";
}
