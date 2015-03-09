<?php
$maximgsize = 50000;
$arimage = array('png'=>'png','gif'=>'gif','jpeg'=>'jpeg','jpg'=>'jpg','jpe'=>'jpe','bmp'=>'bmp','tiff'=>'tiff','tif'=>'tif',
'swf'=>'swf','psd'=>'psd','iff'=>'iff','wbmp'=>'wbmp','wbm'=>'wbm','xbm'=>'xbm');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head><body>
<?php 
$code = isset($_GET['code']) ? $_GET['code'] : 0;
define('PUN_ROOT', dirname(__FILE__).'/../');
require PUN_ROOT.'include/common.php';
$result = $db->query('SELECT username,last_visit FROM '.$db->prefix.'users');
$num_user = $db->num_rows($result);
for ($i = 0; $i < $num_user; ++$i)
{ $cur_user = $db->fetch_assoc($result);
  if(($cur_user['username']!='Guest')&&($code==md5($cur_user['username']).md5($cur_user['last_visit'])))break;
}
if($i==$num_user){
echo '<h1>Not Found</h1>
<p>The requested URL '.$_SERVER['PHP_SELF'].' was not found on this server.</p>
</body></html';
$db->close();
exit;
}
if($pun_user['is_guest']){
echo '<h1>Re login, Pleace !</h1>
</body></html';
$db->close();
exit;
}
//echo 'code = '.$code."\n"; echo 'md5 = '.md5($cur_user['username']).md5($cur_user['last_visit']);
?>
<style type="text/css">
#imageview{width:98%;min-height:320px;display: compact;margin:8px;color:#660033;background:#f8f8f8 url(image-view.png) no-repeat center center}
#imageview img{display:inline-block;}
#fileview{width:23%;display:block;float:left;margin:4px;cursor:pointer; overflow:hidden;color:#0000FF;}
#fileview div{display:block;float:left;margin-right:4px}
</style>
</head><body>
<?php $dir = $cur_user['username'].'/';
$filnya = scandir($dir);$filenya = array();
foreach($filnya as $vra => $vrb)array_push($filenya,strtolower($vrb));

if(!$filenya) mkdir($dir);
if((isset($_FILES['imgfile']))&&($_FILES['imgfile']["error"]==0))
{ $filetype=explode('/',$_FILES['imgfile']['type']);
  if(!array_search(strtolower($filetype[1]),$arimage))$Err_upload='The file you tried to upload is not of an allowed type.';
  if((!$Err_upload)&&($_FILES['imgfile']["size"] > $maximgsize))$Err_upload='The file you tried to upload is larger than the maximum allowed';
  $file_upload = basename($_FILES['imgfile']['name']);
  if((!$Err_upload)&&(file_exists($dir.$file_upload)))$Err_upload='Already contains a file named "'.$_FILES['imgfile']['name'].'"';
  if((!$Err_upload)&&(!move_uploaded_file($_FILES['imgfile']['tmp_name'], $dir.$file_upload)))$Err_upload='The server was unable to save the uploaded file. Please contact the forum administrator at';
} else $Err_upload='No upload : You did not select a file for upload.';
if(isset($_POST['hidden']))
{ if(!$Err_upload)
  { array_push($filenya,basename($_FILES['imgfile']['name']));
	$Err_upload = 'Upload Succes';
  } else
  { if($_POST['hidden']!='hidden')
	{ $Err_upload = 'Delete file :';
	  $deletfile=str_replace(' ','',$_POST['hidden']);
	  $deletfile=explode(',',$deletfile);
	  foreach($deletfile as $vra=> $vrb)
	  {  if(file_exists($dir.$vrb))
		{ if(unlink($dir.$vrb))
		  { $Err_upload.= '<br>'.$vrb.' --> '.'Sucses Delete';
			foreach($filenya as $vrc => $vrd){if($vrd==$vrb){unset($filenya[$vrc]);break;}}
		  }else $Err_upload.= '<br>'.$vrb.' --> '.'Error Delete';
		}else $Err_upload.= '<br>'.$vrb.' --> '.'Error Delete "File not found"';
	  }
	}
  }
} else $Err_upload='&nbsp';/* */
foreach($filenya as $vrx => $vry)
{ if($vrx > 1){$pilihfile .='<div id="fileview"><div class="id'.$vrx.'" title="Delete '.$vry.'" onclick="deletfile(this)">[x]</div>
  <div class="idne'.$vrx.'" onclick="imageview(this)">'.$vry.'</div></div>';
  if(!$filleimgne){$filleimgne = $vry;}else $filleimgne .= ','.$vry;}
}
if($file_upload){$imgeview = 'style="background:#f8f8f8 url('.$dir.$file_upload.') no-repeat center center"';}else $imgeview='';
echo '<div id="imageview" '.$imgeview.'>'.$Err_upload.'</div>
<form method="post" action="../insertimg.php?code='.$code.'" enctype="multipart/form-data">
  <div style="display:block;padding:4px 8px;background:#bbbbbb">
    <input type="submit" value="Submit" />
    <input type="file" name="imgfile" />
    <input type="hidden" name="hidden" value="hidden" />
    <input type="button" name="undo" value="Undo selected delete" style="float:right" onclick="undodelete()" />
  </div>
</form>';
echo '<div id="listfile">'.$pilihfile.'</div>';
?>
<script type="text/javascript">
var dirnya = "<?php echo '../'.$dir ?>";
if (document.all||document.getElementById){
var imege=document.all? document.all["imageview"] : document.getElementById? document.getElementById("imageview") : "";
var filenya=document.all? document.all["listfile"] : document.getElementById? document.getElementById("listfile") : "";
var file2nya=filenya.innerHTML;
e=document.getElementsByTagName('input');for(var i=0;i<e.length;i+=1)
{ if(e[i].name=='hidden'){var e_postfile = e[i];var l_postfile = e[i].value;break;}}
var stateObj = { foo: "<?php echo $dir.$file_upload ?>" };
history.pushState(stateObj, "", "<?php echo $dir.$file_upload ?>");
}else document.write();
function imageview(var1)
{ imege.style.background="#f8f8f8 url("+dirnya+var1.innerHTML+") no-repeat center center";
  var stateObj = { foo: ""+dirnya+var1.innerHTML+"" };
  history.pushState(stateObj, "", ""+dirnya+var1.innerHTML+"");
}
function deletfile(var1){parent=var1.parentNode;var vr1=var1.className.replace('id','idne');
  var e=parent.childNodes;for(var i=0;i<e.length;i+=1)
  { if(e[i].className == vr1){e[i].style.color = '#aaaaaa';break;}}
  var vr1= var1.title.replace('Delete ','');
  if(e_postfile.value=='hidden'){e_postfile.value = vr1}else e_postfile.value += ', '+vr1;
}
function undodelete(){filenya.innerHTML=file2nya;e_postfile.value = 'hidden';}
</script>
</body>
</html>
