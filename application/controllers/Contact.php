<?php
class Contact extends CI_Controller{

  public function __construct(){
    parent::__construct();
    $this->load->model('Blog_model');
    $this->load->model('Calender_model');
    $this->load->model('Contact_model');

    //development の場合 プロファイラを有効に
    if(ENVIRONMENT === 'development'){
      $this->output->enable_profiler();
    }

  }

  public function index($year = null, $month = null){
    // $this->contact_model->
    $data['posts']         = $this->Blog_model->get_post_list_limit();
    $data['posts_archive'] = $this->Blog_model->get_post_archive_sidebar();
    $data['category']      = $this->Blog_model->get_category();
    $data['check_cat']     = $this->Blog_model->get_show_check_category();
    $data['calender']      = $this->Calender_model->generates($year,$month);
    $data['calender_post'] = $this->Calender_model->get_post_calender($year,$month);

    $this->form_validation->set_rules('name', 'お名前', 'trim|required|xss_clean');
    $this->form_validation->set_rules('email', 'メールアドレス', 'trim|required|valid_email|xss_clean');
    $this->form_validation->set_rules('text', 'お問い合わせ内容', 'trim|required|xss_clean');

    if($this->form_validation->run() === FALSE){
      $this->load->view('tpl/header_meta');
      $this->load->view('tpl/header');
      $this->load->view('contact/index',$data);
      $this->load->view('tpl/sidebar',$data);
      $this->load->view('tpl/footer');
    }else{
      $this->load->view('tpl/header_meta');
      $this->load->view('tpl/header');
      $this->load->view('contact/confirm',$data);
      $this->load->view('tpl/sidebar',$data);
      $this->load->view('tpl/footer');
    }
  }

  public function confirm($year = null, $month = null){
    // $this->contact_model->
    $data['posts']         = $this->Blog_model->get_post_list_limit();
    $data['posts_archive'] = $this->Blog_model->get_post_archive_sidebar();
    $data['category']      = $this->Blog_model->get_category();
    $data['check_cat']     = $this->Blog_model->get_show_check_category();
    $data['calender']      = $this->Calender_model->generates($year,$month);
    $data['calender_post'] = $this->Calender_model->get_post_calender($year,$month);

    $this->form_validation->set_rules('name', 'お名前', 'trim|required');
    $this->form_validation->set_rules('email', 'メールアドレス', 'trim|required');
    $this->form_validation->set_rules('text', 'お問い合わせ内容', 'trim|required');

  if($this->input->post('return_edit')){
      $this->load->view('tpl/header_meta');
      $this->load->view('tpl/header');
      $this->load->view('contact/index',$data);
      $this->load->view('tpl/sidebar',$data);
      $this->load->view('tpl/footer');
  }else{
    if($this->form_validation->run() === FALSE){
      $this->load->view('tpl/header_meta');
      $this->load->view('tpl/header');
      $this->load->view('contact/index',$data);
      $this->load->view('tpl/sidebar',$data);
      $this->load->view('tpl/footer');
    }else{
      $this->load->view('tpl/header_meta');
      $this->load->view('tpl/header');
      $this->load->view('contact/confirm',$data);
      $this->load->view('tpl/sidebar',$data);
      $this->load->view('tpl/footer');
    }
  }
  }


  public function thank($year = null, $month = null){
    // $this->contact_model->
    $data['posts']         = $this->Blog_model->get_post_list_limit();
    $data['posts_archive'] = $this->Blog_model->get_post_archive_sidebar();
    $data['category']      = $this->Blog_model->get_category();
    $data['check_cat']     = $this->Blog_model->get_show_check_category();
    $data['calender']      = $this->Calender_model->generates($year,$month);
    $data['calender_post'] = $this->Calender_model->get_post_calender($year,$month);

    $this->load->view('tpl/header_meta');
    $this->load->view('tpl/header');
    $this->load->view('contact/thank',$data);
    $this->load->view('tpl/sidebar',$data);
    $this->load->view('tpl/footer');
  }



}