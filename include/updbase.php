<?php
if(empty(constant("VERSION")))return 0;
function get_vernum($version){
   $vn = explode('.',str_replace('v','',$version)); 
   $vernum =  $vn[0].sprintf("%02d",$vn[1]).sprintf("%02d",$vn[2]);
   return $vernum;
}
$sqlvn = get_vernum($conf['version']);  //数据库版本
$filevn = get_vernum(constant("VERSION"));  // 文件版本
if($sqlvn < $filevn){
    //文件版本大于数据库版本执行更新
$sql= '';
if($sqlvn < 10101) {
    $version = 'v1.1.1';
	$sql = $sql.file_get_contents(ROOT.'install/update.sql');
}
if($sqlvn < 10103) {
    $version = 'v1.1.3';
	@unlink(ROOT.'include/head.php');
	@unlink(ROOT.'include/home.php');
	@unlink(ROOT.'include/apply.php');
	@unlink(ROOT.'include/footer.php');
	$sql = $sql.file_get_contents(ROOT.'install/update1.sql');
} 
if($sqlvn < 10104) {
	$version = 'v1.1.4';
}
if($sqlvn < 10105) {
	$version = 'v1.1.5';
	$sql = $sql.file_get_contents(ROOT.'install/update2.sql');
}
if($sqlvn < 10106) {
	$version = 'v1.1.6';
	$sql = $sql.file_get_contents(ROOT.'install/update3.sql');
}
$sql=explode(';',$sql);
for ($i=0;$i<count($sql);$i++) {
	if (trim($sql[$i])=='')continue;
	if($DB->query($sql[$i])) {
	}
}
saveSetting('version',$version);
}