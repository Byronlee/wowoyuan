<!--      获得焦点,删除文本   -->
function clearText(obj)
{
if(obj.value == obj.defaultValue)
obj.value = "";
}
<!--      失去焦点,获得文本   -->
function showText(obj)
{
if(obj.value == "")
obj.value = obj.defaultValue;
}