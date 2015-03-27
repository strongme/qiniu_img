<?php  
/*
Plugin Name: 七牛图片服务
Plugin URI: http://URI_Of_Page_Describing_Plugin_and_Updates
Description: 向七牛存储服务中上传，列出带前缀的图片文件，并加以展示
Version: 1.0
Author: Strongme
Author URI: http://strongme.cn
License: GPLv2
*/

/*

This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
*/

function qiniuimg_load_sdk() {
	require_once('sdk/conf.php');
	require_once('sdk/rs.php');
	require_once('sdk/rsf.php');	
}
add_action( 'init', 'qiniuimg_load_sdk' );


/*定义添加菜单选项的函数*/
function qiniuimg_plugin_menu() {
	// add_options_page( "七牛空间配置", "七牛空间配置", "manage_options", "qiniu_config_id", "qiniu_config_options" );
	add_menu_page( "七牛图片", "七牛图片服务", "manage_options", __FILE__, "qiniuimg_index" );
	// add_submenu_page( __FILE__, '七牛空间配置', '七牛空间配置', 'manage_options', __FILE__.'_config', 'qiniuimg_config' );
}

/*将函数注册到钩子中*/
add_action( "admin_menu", "qiniuimg_plugin_menu");

function qiniuimg_option_init() {
	register_setting( 'qiniuimg_options', 'qiniuimg_bucket');
	register_setting( 'qiniuimg_options', 'qiniuimg_domain');
	register_setting( 'qiniuimg_options', 'qiniuimg_accesskey');
	register_setting( 'qiniuimg_options', 'qiniuimg_secretkey');
}

add_action('admin_init', 'qiniuimg_option_init');

/*定义选项被打开时显示的页面*/
function qiniuimg_index() {
	if(!current_user_can('manage_options')) {
		wp_die(_('你没有权限访问这个页面。'));
	}
	$data = array();
	$data[qiniuimg_theme] = 'flatly';
	// qiniuimg_load_img();
    qiniuimg_display($data);
}


function qiniuimg_config() {
	if(!current_user_can('manage_options')) {
		wp_die(_('你没有权限访问这个页面。'));
	}
	echo "配置页面";
}

function qiniuimg_display($data) {
	require_once('_head.php');
	if(!empty($data['msg_title'])&&!empty($data['msg_body'])) {
		require_once('_alert.php');
	}
	require_once('_index.php');
	require_once('_foot.php');
}

function qiniuimg_load_img($bucket, $accessKey, $secretKey, $prefix, $size, $markerout) {
	Qiniu_SetKeys($accessKey, $secretKey);
	$client = new Qiniu_MacHttpClient(null);
	list($items, $markerOut, $err) = Qiniu_RSF_ListPrefix($client, $bucket, $prefix, $markerout, $size);
	return array(
		'items'=> $items,
		'markerout'=> $markerOut
	);	
}

function qiniuimg_shortcode_loadimg($atts, $content=null, $code="") {
	$domain = get_option('qiniuimg_domain');
	$bucket = get_option('qiniuimg_bucket');
	$accessKey = get_option('qiniuimg_accesskey');
	$secretKey = get_option('qiniuimg_secretkey');
	//判断是否已经设置过相关属性
	$result = '
	<div class="container" style="width:100%;">
	';
	if(empty($domain) || empty($bucket) || empty($accessKey) || empty($secretKey)) {
		$result .= '
			<div class="alert alert-danger alert-dismissible" role="alert">
			  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			  <strong>不太好!</strong> &nbsp;客官，您的七牛图片服务参数还未设置完整吧，所以不给你用。
			</div>
		';
	}else if(empty($atts['prefix'])) {
		$result .= '
			<div class="alert alert-danger alert-dismissible" role="alert">
			  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			  <strong>不太好!</strong> &nbsp;客官，您的短代码中未设置prefix属性，所以没法儿加载图片。
			</div>
		';
	}else {
		$size = $atts['size'];
		if(empty($size)) $size = 0;
		$result_data = qiniuimg_load_img($bucket, $accessKey, $secretKey, $atts['prefix'], $size, '');
		$groupsize = $atts['groupsize'];
		if(empty($groupsize))$groupsize = 4;
		if(12%$groupsize!=0)$groupsize = 4;
		$result .= qiniuimg_render_result($domain, $result_data['items'], $result_data['markerout'],$groupsize);
	}
	$result .= '</div>';
	return $result;
}

add_shortcode( 'qiniu_img', 'qiniuimg_shortcode_loadimg' );


function qiniuimg_render_result($domain, $items, $markerout, $groupsize) {

	$result = "";
	$pageCount = 1;
	$pageHtml = '<nav><ul class="pagination">';
	foreach ($items as $key => $value) {
		if($key == 0) {
			$result .= "<div class='row img-row' id='qiniu_page_".$pageCount."'>";
		}else if($key%$groupsize==0) {
			$pageHtml .= '<li ><a href="####" onclick="show('.($pageCount).')">'.($pageCount).'</a></li>';
			$pageCount++;
			if($pageCount<2) {
				$result .= "</div><div class='row  img-row' id='qiniu_page_".$pageCount."'>";
			}else {
				$result .= "</div><div class='row img-row' style='' id='qiniu_page_".$pageCount."'>";
			}
		}
		$result .= "<div class='col-md-".(12/$groupsize)." thumbnail'>
		<a href='".$domain."/".$value['key']."'><img src='".$domain."/".$value['key']."'></a>
		<div class='caption'>
		<h4 class='text-center'>".$value['key']."</h4>
		</div>
		</div>";
	}
	$result .= '</div>';
	$pageHtml .= '</ul></nav>
	<script>
	function show(pagenum) {
		var allrow = document.getElementsByClassName("img-row");
		for(var i=0;i<allrow.length;i++) {
			allrow[i].style.display = "none";
		}
		document.getElementById("qiniu_page_"+pagenum).style.display = "block";
	}
	</script>
	';
	// $result .= $pageHtml;
	return $result;
}

?>

