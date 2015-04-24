<html>
<head>

<STYLE>
#ie5menu {
	BACKGROUND-COLOR: #1e90ff; BORDER-BOTTOM: #000000 0px solid; BORDER-LEFT: #000000 0px solid; BORDER-RIGHT: #000000 0px solid; BORDER-TOP: #000000 0px solid; FONT-FAMILY: Verdana, Arial, Helvetica, sans-serif; FONT-SIZE: 7.8pt; FONT-WEIGHT:bold; COLOR: #FFFFFF; LINE-HEIGHT: 13px; POSITION: absolute; VISIBILITY: hidden; WIDTH: 114px
}
.menuitems {
	PADDING-LEFT: 15px; PADDING-RIGHT: 15px
}
</STYLE>
 
<SCRIPT language=JavaScript1.2>
var display_url=0
function showmenuie5(){
var rightedge=document.body.clientWidth-event.clientX
var bottomedge=document.body.clientHeight-event.clientY
if (rightedge<ie5menu.offsetWidth)
ie5menu.style.left=document.body.scrollLeft+event.clientX-ie5menu.offsetWidth
else
ie5menu.style.left=document.body.scrollLeft+event.clientX
if (bottomedge<ie5menu.offsetHeight)
ie5menu.style.top=document.body.scrollTop+event.clientY-ie5menu.offsetHeight
else
ie5menu.style.top=document.body.scrollTop+event.clientY
ie5menu.style.visibility="visible"
return false
}
function hidemenuie5(){
ie5menu.style.visibility="hidden"
}
function highlightie5(){
if (event.srcElement.className=="menuitems"){
event.srcElement.style.backgroundColor=""
 
// cor ao passar o mouse
 
event.srcElement.style.color="#000000"
if (display_url==1)
window.status=event.srcElement.url
}
}
function lowlightie5(){
if (event.srcElement.className=="menuitems"){
event.srcElement.style.backgroundColor=""
event.srcElement.style.color="#FFFFFF"
window.status=''
}
}
function jumptoie5(){
if (event.srcElement.className=="menuitems")
window.location=event.srcElement.url
}
</SCRIPT>
<script language=JavaScript1.2>
document.oncontextmenu=showmenuie5
if (document.all&&window.print)
document.body.onclick=hidemenuie5
</script>
 
<script>
 
function abremenu(x){
	if (IE) {
	document.all.divinfos[x-1].style.visibility="hidden";
	document.all.divinfos[x-1].style.display='';
	document.all.divinfos[x-1].style.filter="blendTrans(duration=.5)";
	document.all.divinfos[x-1].filters.blendTrans.Apply();
	document.all.divinfos[x-1].style.visibility="visible";
	document.all.divinfos[x-1].filters.blendTrans.Play();
	}
}
 
function fechamenu(x){
	if (IE) {
	document.all.divinfos[x-1].style.visibility="hidden";
	document.all.divinfos[x-1].style.display='none';
	}
}
 
</script>

</head>
 
<body>    
<div id=ie5menu onClick=jumptoie5() onMouseOut=lowlightie5() 
onMouseOver=highlightie5()> 
      
<div> <font align=center>&nbsp;&nbsp;&nbsp;&nbsp;Fabio Poletto</font></div>
      
<hr color=#f8f8f8 width="99%" size="1">
      
<div class=menuitems style="CURSOR: hand" 
url="sua página" align="left">sua página</div>
 
<div class=menuitems style="CURSOR: hand" 
url="sua página" align="left">sua página</div>
 
<div class=menuitems style="CURSOR: hand" 
url="sua página" align="left">sua página</div>
 
<div class=menuitems style="CURSOR: hand" 
url="sua página" align="left">sua página</div>
 
<div class=menuitems style="CURSOR: hand" 
url="sua página" align="left">sua página</div>
 
<hr color=#f8f8f8 width="90%" size="1">
      <center>
&nbsp;&nbsp;Fabio Poletto
      </center>
    </div>
</body>
</html>