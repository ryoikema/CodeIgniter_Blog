<?php

class Blog extends CI_Controller{

  public function __construct(){
    parent::__construct();
    $this->load->model('Blog_model');
    $this->load->model('Calender_model');
    //development の場合 プロファイラを有効に
    if (ENVIRONMENT === 'development') {
        $this->output->enable_profiler();
    }
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

    $this->load->view("tpl/header_meta");
    $this->load->view("tpl/header");
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

    $this->load->view("tpl/header_meta");
    $this->load->view("tpl/header");
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

    $this->load->view("tpl/header_meta");
    $this->load->view("tpl/header");
    $this->load->view("blog/post_detail",$data);
    $this->load->view("tpl/sidebar",$data);
    $this->load->view("tpl/footer");
  }

  //月別記事
  public function post_archive($year = null, $month = null, $day = null){
    $data['posts_month']   = $this->Blog_model->get_post_archive();
    $data['posts_archive'] = $this->Blog_model->get_post_archive_sidebar();
    $data['category']      = $this->Blog_model->get_category();
    $data['check_cat']     = $this->Blog_model->get_show_check_category();
    $data['calender']      = $this->Calender_model->generates($year,$month);
    $data['calender_post'] = $this->Calender_model->get_post_calender($year,$month,$day);

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