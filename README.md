# fluxbb
Modification of FluxBB 1.5.8  <strong>modul Simple Image Upload</strong>

<h2>How to install</h2>

I. CREATE FOLDER <strong>upload</strong>

Copy file <strong>insertimg.php</strong> in this folder



II. OPEN FILE <strong>include/template/main.tpl</strong>

Add <strong>&lt;pun_upload&gt;</strong>

before <i><strong>&lt;/body&gt;</strong></i>



III. OPEN FILE <strong>footer.php</strong>

Add  <strong>if(!isset($pun_upload))$pun_upload='';</strong>

<strong>$tpl_main = str_replace('&lt;pun_upload&gt;',$pun_upload, $tpl_main);</strong>

before <i><strong>// Close the db connection (and free up any result data)</strong></i>



III. OPEN FILE <strong>header.php</strong>



after <i><strong>// Output JavaScript to validate form (make sure required fields are filled out)</strong></i>

add 

$usere=md5($pun_user['username']).md5($pun_user['last_visit']);<br>
$pun_upload = '

&lt;script type="text/javascript"&gt;

if (document.all||document.getElementById){

var ule=document.getElementsByTagName("ul");

for(i=0;i<ule.length;i+=1){if(ule[i].className=="bblinks")

{ ule[i].innerHTML+=\'&lt;li&gt;&lt;span&gt;&lt;a href="upload/insertimg.php?code='.$usere.'" onclick="return 

winupload(this.href,\\\'gest\\\',\\\'resizable=yes,location=no,menubar=no,status=no,scrollbars=yes\\\');"&gt;
&lt;strong&gt;Image&lt;/strong&gt;&lt;/a&gt;&lt;/span&gt;&lt;/li&gt;\';

  break;

}}}else document.write();

function winupload(vr1,vr2,vr3)

{ window.open(vr1,vr2,"top=120,left=100,width=800,height=440,vr3");

  return false};

&lt;/script&gt;

';
