<?php

class Blog extends CI_Controller{

  public function __construct(){
    parent::__construct();
    $this->load->model('Blog_model');
    $this->load->model('Calender_model');
    $this->load->library("pagination");
    $this->load->library('breadcrumbs');
    //development の場合 プロファイラを有効に
    // if (ENVIRONMENT === 'development') {
    //     $this->output->enable_profiler();
    // }
  }
/*************************************************
 投稿
 ・トップページ(取得5件制限)
 ・記事一覧
 ・記事詳細
 ・月別記事
**************************************************/
  //トップページ(取得5件制限)
  public function index($year = null, $month = null, $day = null){
    $data['posts']         = $this->Blog_model->get_post_list_limit();
    $data['posts_archive'] = $this->Blog_model->get_post_archive_sidebar();
    $data['category']      = $this->Blog_model->get_category();
    $data['check_cat']     = $this->Blog_model->get_show_check_category();
    $data['calender']      = $this->Calender_model->generates($year,$month);
    $data['calender_post'] = $this->Calender_model->get_post_calender($year,$month,$day);
    $this->breadcrumbs->unshift('Home', '/');

    $this->load->view("tpl/header_meta");
    $this->load->view("tpl/header", $data);
    $this->load->view("blog/index",$data);
    $this->load->view("tpl/sidebar",$data);
    $this->load->view("tpl/footer");
  }

  //記事一覧
  public function post_list($year = null, $month = null, $day = null){
    $data['posts']         = $this->Blog_model->get_post_list();
    $data['posts_archive'] = $this->Blog_model->get_post_archive_sidebar();
    $data['category']      = $this->Blog_model->get_category();
    $data['check_cat']     = $this->Blog_model->get_show_check_category();
    $data['calender']      = $this->Calender_model->generates($year,$month);
    $data['calender_post'] = $this->Calender_model->get_post_calender($year,$month,$day);
    $this->breadcrumbs->push('Home', 'blog');
    $this->breadcrumbs->push('記事一覧', '/blog/post_list');
    //ページャー設定
    $config["base_url"] = base_url()."/blog/post_list";
    $config["total_rows"] = $this->db->get("post")->num_rows();//DB内の全記事数
    $config["per_page"] = 10;//表示件数、Model側と合わせる
    $config["num_links"] = 3;//現在ページ番号の前後に表示するリンク数
    $config['page_query_string'] = TRUE;// ページ番号をクエリストリングに変更
    $this->pagination->initialize($config);

    $this->load->view("tpl/header_meta");
    $this->load->view("tpl/header", $data);
    $this->load->view("blog/post_list",$data);
    $this->load->view("tpl/sidebar",$data);
    $this->load->view("tpl/footer");
  }

  //記事詳細
  public function post_detail($post_id, $year = null, $month = null, $day = null){
    $data['post']          = $this->Blog_model->get_post_detail($post_id);
    $data['posts_archive'] = $this->Blog_model->get_post_archive_sidebar();
    $data['category']      = $this->Blog_model->get_category();
    $data['check_cat']     = $this->Blog_model->get_show_check_category();
    $data['calender']      = $this->Calender_model->generates($year,$month);
    $data['calender_post'] = $this->Calender_model->get_post_calender($year,$month,$day);
    $this->breadcrumbs->push('Home', 'blog');
    $this->breadcrumbs->push('記事詳細', '/blog/post_detail');

    $this->load->view("tpl/header_meta");
    $this->load->view("tpl/header");
    $this->load->view("blog/post_detail",$data);
    $this->load->view("tpl/sidebar",$data);
    $this->load->view("tpl/footer");
  }

  //月別記事
  public function post_archive($year = null, $month = null, $day = null){
    $data['records']   = $this->Blog_model->get_post_archive();
    $data['posts_archive'] = $this->Blog_model->get_post_archive_sidebar();
    $data['category']      = $this->Blog_model->get_category();
    $data['check_cat']     = $this->Blog_model->get_show_check_category();
    $data['calender']      = $this->Calender_model->generates($year,$month);
    $data['calender_post'] = $this->Calender_model->get_post_calender($year,$month,$day);
    $this->breadcrumbs->push('Home', 'blog');
    $this->breadcrumbs->push('過去記事', '/blog/post_archive');
    //ページャー設定
    $post_date = $this->input->get('post_date');//x年x月を$_GET
    $config["base_url"] = base_url()."/blog/post_archive/?post_date={$_GET['post_date']}";
    $config["total_rows"] = $this->db
      ->where("date_format(post_date,'%Y-%m')='".$post_date."'")
      ->get("post")->num_rows();//該当する月の全記事数
    $config["per_page"] = 2;//表示件数、Model側と合わせる
    $config["num_links"] = 3;//現在ページ番号の前後に表示するリンク数
    $config['page_query_string'] = TRUE;// ページ番号をクエリストリングに変更
    $this->pagination->initialize($config);

    $this->load->view("tpl/header_meta");
    $this->load->view("tpl/header");
    $this->load->view("blog/post_archive",$data);
    $this->load->view("tpl/sidebar",$data);
    $this->load->view("tpl/footer");
  }
/*************************************************
 カテゴリ
 ・カテゴリに紐づいた記事を取得
 ・作成済みカテゴリ取得
**************************************************/
  //カテゴリに紐づいた記事を取得
  public function post_category($year = null, $month = null, $day = null){
    $data['posts']         = $this->Blog_model->get_post_category();
    $data['posts_archive'] = $this->Blog_model->get_post_archive_sidebar();
    $data['category']      = $this->Blog_model->get_category();
    $data['check_cat']     = $this->Blog_model->get_show_check_category();
    $data['calender']      = $this->Calender_model->generates($year,$month);
    $data['calender_post'] = $this->Calender_model->get_post_calender($year,$month,$day);
    $this->breadcrumbs->push('Home', 'blog');
    $this->breadcrumbs->push('カテゴリ記事一覧', '/blog/post_category');
    //ページャー設定
    $cat_slug = $this->input->get("cat_slug");
    $config["base_url"] = base_url()."/blog/post_category?cat_slug={$_GET['cat_slug']}";
    $config["total_rows"] = $this->db
      ->select("*,date_format(post_date,'%Y年%m月%d日') AS post_date")
      ->join('category', 'post_category.cat_id=category.cat_id')
      ->join('post', 'post.post_id=post_category.post_id')
      ->where("cat_slug='".$cat_slug."'")
      ->get("post_category")->num_rows();//該当する月の全記事数
    $config["per_page"] = 2;//表示件数、Model側と合わせる
    $config["num_links"] = 3;//現在ページ番号の前後に表示するリンク数
    $config['page_query_string'] = TRUE;// ページ番号をクエリストリングに変更
    $this->pagination->initialize($config);

    $this->load->view("tpl/header_meta");
    $this->load->view("tpl/header");
    $this->load->view("blog/post_category",$data);
    $this->load->view("tpl/sidebar",$data);
    $this->load->view("tpl/footer");
  }
  //作成済みカテゴリ取得
  public function get_category(){
    $data['category'] = $this->Blog_model->get_category();

    $this->load->view("tpl/header_meta");
    $this->load->view("tpl/header");
    $this->load->view("tpl/sidebar",$data);
    $this->load->view("tpl/footer");
  }



}