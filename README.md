# fluxbb
Modification of FluxBB 1.5.8  <strong>modul Simple Image Upload</strong>

<h2>How to install</h2>

I. CREATE FOLDER <strong>upload</strong>

Copy file <strong>insertimg.php</strong> in this folder


II. OPEN FILE <strong>include/template/main.tpl</strong>

Add <strong>&lt;pun_upload&gt;</strong>

before <i><strong>&lt;/body&gt;</strong></i>


III. OPEN FILE <strong>footer.php</strong>

Add

<strong>if(!isset($pun_upload))$pun_upload='';</strong>

<strong>$tpl_main = str_replace('&lt;pun_upload&gt;',$pun_upload, $tpl_main);</strong>

before <i><strong>// Close the db connection (and free up any result data)</strong></i>
