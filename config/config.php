<?php

//默认密码 "root" 使用MD5 32位小写加密 加密网址 http://tool.chinaz.com/tools/md5.aspx
//outputFolder为下载文件夹，末尾没有“/”
//security安全默认 true

return array(
	"security" => true,
	"password" => "63a9f0ea7bb98050796b649e85481845",
	"outputFolder" => "/volume1/Downloads",
	"extracter" => "ffmpeg",
	"max_dl" => 3);

?>
