<?php
class Calender extends CI_Controller{

  public function __construct(){
    parent::__construct();
    $this->load->model('Blog_model');
    $this->load->model('Calender_model');
    //development の場合 プロファイラを有効に
    if(ENVIRONMENT === 'development'){
      $this->output->enable_profiler();
    }
  }
/*************************************************
 カレンダー
 ・日付リンク(カレンダー出力)
**************************************************/
  function index($year = null, $month = null, $day = null){
    $data['posts_archive'] = $this->Blog_model->get_post_archive_sidebar();
    $data['category']      = $this->Blog_model->get_category();
    $data['check_cat']     = $this->Blog_model->get_show_check_category();

    $data['calender']      = $this->Calender_model->generates($year,$month,$day);
    $data['calender_post'] = $this->Calender_model->get_post_calender($year,$month,$day);

    $this->load->view("tpl/header_meta");
    $this->load->view("tpl/header");
    $this->load->view("calender/index",$data);
    $this->load->view("tpl/sidebar",$data);
    $this->load->view("tpl/footer");
  }

}