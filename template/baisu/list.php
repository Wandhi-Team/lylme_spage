<?php
// +----------------------------------------------------------+
// | LyLme Spage BaiSu Theme                                  |
// +----------------------------------------------------------+
// | Copyright (c) 2022 LyLme                                 |
// +----------------------------------------------------------+
// | File: list.php                                           |
// +----------------------------------------------------------+
// | Authors: LyLme <admin@lylme.com>                         |
// | date: 2022-05-01                                         |
// +----------------------------------------------------------+
// 获取网站
$groups = $DB->query("SELECT * FROM `lylme_groups` ORDER BY `group_order` ASC");
// 获取分类
$i = 0;
while ($group = $DB->fetch($groups)) {
	//循环所有分组
	$sql = "SELECT * FROM `lylme_links` WHERE `group_id` = " . $group['group_id']." ORDER BY `link_order` ASC;";
	$group_links = $DB->query($sql);
	$link_num = $DB->num_rows($group_links);
	// 获取返回字段条目数量
	echo '<div class="site-name" id="category-'.$group["group_id"] .'">' . $group["group_icon"]  . $group["group_name"] . '</div>
				<div class="site-list">';
	//输出分组图标和标题
	if ($link_num == 0) {
		echo '      	<div class="list kongs"></div>
						<div class="list kongs"></div>
						<div class="list kongs"></div>
						<div class="list kongs"></div>' . "</div>";
		$i = 0;
		continue;
	}
	while ($link = $DB->fetch($group_links)) {
		// 循环每个链接
		// 返回指定分组下的所有字段
		if ($link_num > $i) {
			$i = $i + 1;
			if($link["link_status"]!="0"){
			echo "\n" . '
            <div class="list urllist" id="id_' . $link["id"] . '" data-id="' . $link["id"] . '" data-url="' . $link["url"] . '">
			<a rel="nofollow" href="' . $link["url"] . '" target="_blank">';
			if ($link["icon"] == '') {
				echo '<img src="/assets/img/default-icon.png" alt="默认' . $link["name"] . '" />';
			} else if (!preg_match("/^<svg*/", $link["icon"])) {
				echo '<img src="' . $link["icon"] . '" alt="' . $link["name"] . '" />';
			} else {
				echo $link["icon"];
			}
			echo	'<p class="name">'. $link["name"] . '</p><p class="desc"></p></a></div>';
			}
		}
		if ($link_num == $i) {
			//判断当前分组链接循环完毕
			echo '  <div class="list kongs"></div>
				    <div class="list kongs"></div>
					<div class="list kongs"></div>
					<div class="list kongs"></div>' . "\n</div>";
			//输出分类结束标签
			$i = 0;
			break;
			//重置$i为0跳出当前循环
		}
	}
}
$DB->close();
?>