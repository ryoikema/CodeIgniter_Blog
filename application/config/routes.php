<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*お問い合わせ*/
$route['contact/confirm'] = 'contact/confirm';
$route['contact']         = 'contact';

/*カレンダー*/
$route['calender(:any)']     = 'calender/$1';

/*管理画面*/
  //ログイン/ログアウト/会員機能
  $route['member/members']          = 'member/members';
  $route['member/login_validation'] = 'member/login_validation';
  $route['member/login']            = 'member/login';
  $route['member']                  = 'member';
  //category
  $route['admin/post_category/(:any)']         = 'admin/post_category/$1';
  $route['admin/category/admin_category_edit'] = "admin/category/admin_category_edit";
  $route['admin/category']                     = "admin/category";
  //post
  $route['admin/admin_post_delete'] = 'admin/admin_post_delete';
  $route['admin/admin_post_edit']   = 'admin/admin_post_edit';
  $route['admin/admin_post_create'] = 'admin/admin_post_create';
  $route['admin/post_detail']       = 'admin/post_detail';
  $route['admin']                   = "admin";

/*一般画面*/
  //ギャラリー
  $route['gallery']     = 'gallery';

  //category
  $route['blog/post_category/(:any)'] = 'blog/post_category/$1';
  $route['blog/post_category']        = 'blog/post_category';

  //post
$route['blog/post_archive/(:any)'] = 'blog/post_archive/$1';
$route['blog/post_archive']        = 'blog/post_archive';
$route['blog/post_detail']         = 'blog/post_detail';
$route['blog/post_list']           = 'blog/post_list';
$route['default_controller']       = 'blog';

$route['404_override']         = '';
$route['translate_uri_dashes'] = FALSE;
