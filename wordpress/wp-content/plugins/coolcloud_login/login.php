<?php
/*
Plugin Name: Coolcloud Login
Plugin URI: http://liuronghuan.com/
Description: 高仿酷云登录界面
Version: 1.0
Author: 刘荣焕
Author URI: http://liuronghuan.com/
License: A "Slug" license name e.g. GPL2
*/


//在顶部添加内容
function liuronghuan_login_header() {
    //自定义登录页面的LOGO图片，请大家注意修改图片哦
    echo '<style type="text/css">
        h1 a { background-image:url('.plugin_dir_url(__FILE__ ).'images/logo.png) !important;width: 150px !important;height:80px !important;-webkit-background-size:150px 80px !important; }
        .forgetmenot { display:none; }
    </style>';
    //添加自定义CSS
    echo '<link rel="stylesheet" type="text/css" href="'.plugin_dir_url(__FILE__ ).'css/coolcloud.css" />';
    remove_action('login_head', 'wp_shake_js', 12);
}
add_action('login_head', 'liuronghuan_login_header');


//在登陆页面添加粒子元素
function liuronghuan_sky() {
    echo '<div id="sky"></div>';
}
add_action('login_body_class', 'liuronghuan_sky');


//在底部添加内容
function liuronghuan_login_footer(){
    echo '<div id="cloud"></div>';
}
add_filter( 'login_footer', 'liuronghuan_login_footer' );



function liuronghuan_failed_login() {
    return '密码错误!';
}
add_filter('login_errors', 'liuronghuan_failed_login');



add_filter('logout_url', 'liuronghuan_logout_redirect_home', 10, 2);
function liuronghuan_logout_redirect_home($logouturl, $redir){
    $redir = home_url();
    return $logouturl . '&redirect_to=' . urlencode($redir);
}



add_filter( 'login_footer', 'liuronghuan_checked_rememberme' );
function liuronghuan_checked_rememberme() {
	echo "<script>document.getElementById('rememberme').checked = true;</script>";
}
//自定义登录页面的LOGO链接为首页链接
add_filter('login_headerurl', create_function(false,"return get_bloginfo('url');"));
//自定义登录页面的LOGO提示为网站名称
add_filter('login_headertitle', create_function(false,"return get_bloginfo('name');"));
?>