<?php
class Calender extends CI_Controller{

  public function __construct(){
    parent::__construct();
    $this->load->model('Blog_model');
    $this->load->model('Calender_model');
    $this->load->library("pagination");
    $this->load->library('breadcrumbs');
    //development の場合 プロファイラを有効に
    // if(ENVIRONMENT === 'development'){
    //   $this->output->enable_profiler();
    // }
  }
/*************************************************
 カレンダー
 ・月記事一覧表示
 ・日付リンク(カレンダー出力)
**************************************************/
  //月記事一覧表示
  function index($year = null, $month = null, $day = null){
    $data['posts_archive'] = $this->Blog_model->get_post_archive_sidebar();
    $data['category']      = $this->Blog_model->get_category();
    $data['check_cat']     = $this->Blog_model->get_show_check_category();
    $data['calender']      = $this->Calender_model->generates($year,$month,$day);
    $data['calender_post'] = $this->Calender_model->get_post_calender($year,$month,$day);
    $this->breadcrumbs->push('Home', 'blog');
    $this->breadcrumbs->push('月別記事', '/calender/index');
    //ページャー設定
    $config["base_url"] = base_url()."/calender/index/".$year."/".$month;
    $config["total_rows"] = $this->db
      ->where("date_format(post_date,'%Y-%m')='".$year."-".$month."'")
      ->get("post")->num_rows();//DB内の全記事数
    $config["per_page"] = 2;//表示件数、Model側と合わせる
    $config["num_links"] = 3;//現在ページ番号の前後に表示するリンク数
    $config['page_query_string'] = TRUE;// ページ番号をクエリストリングに変更
    $this->pagination->initialize($config);

    $this->load->view("tpl/header_meta");
    $this->load->view("tpl/header");
    $this->load->view("calender/index",$data);
    $this->load->view("tpl/sidebar",$data);
    $this->load->view("tpl/footer");
  }

  //日付リンク(カレンダー出力)
  function date($year = null, $month = null, $day = null){
    $data['posts_archive'] = $this->Blog_model->get_post_archive_sidebar();
    $data['category']      = $this->Blog_model->get_category();
    $data['check_cat']     = $this->Blog_model->get_show_check_category();
    $data['calender']      = $this->Calender_model->generates($year,$month,$day);
    $data['calender_post_date'] = $this->Calender_model->get_post_calender_date($year,$month,$day);
    $this->breadcrumbs->push('Home', 'blog');
    $this->breadcrumbs->push('日付記事', '/calender/date');
    //ページャー設定
    $config["base_url"] = base_url()."/calender/date/".$year."/".$month."/".$day."";
    $config["total_rows"] = $this->db
      ->where("date_format(post_date,'%Y-%m-%d')='".$year."-".$month."-".$day."'")
      ->get("post")->num_rows();//DB内の全記事数
    $config["per_page"] = 2;//表示件数、Model側と合わせる
    $config["num_links"] = 3;//現在ページ番号の前後に表示するリンク数
    $config['page_query_string'] = TRUE;// ページ番号をクエリストリングに変更
    $this->pagination->initialize($config);

    $this->load->view("tpl/header_meta");
    $this->load->view("tpl/header");
    $this->load->view("calender/date",$data);
    $this->load->view("tpl/sidebar",$data);
    $this->load->view("tpl/footer");
  }



}