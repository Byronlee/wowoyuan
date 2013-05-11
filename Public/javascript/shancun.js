/**
 * 
 */
/*   Î¢Çø     */
var name_10='two';
var cursel_10=1;
var array_len;
onload=function(){
	var links_array = document.getElementById('about2').getElementsByTagName('div');
	array_len=links_array.length;
	setTab1(name_10,cursel_10);
}
function setTab1(name,cursel){
//  links_len=4;
	cursel_10=cursel;
	for(var i=1; i<=array_len; i++){
		var menu_1 = document.getElementById(name+i);
		var menudiv_1 = document.getElementById("con_"+name+"_"+i);
		if(i==cursel){
			menu_1.className="off";
			menudiv_1.style.display="block";
		}
		else{
			menu_1.className="";
			menudiv_1.style.display="none";
		}
	}
	
}