<?php
class Contact extends CI_Controller{

  public function __construct(){
    parent::__construct();
    $this->load->model('Blog_model');
    $this->load->model('Calender_model');
    $this->load->model('Contact_model');
    $this->load->library('breadcrumbs');
    //development の場合 プロファイラを有効に
    // if(ENVIRONMENT === 'development'){
    //   $this->output->enable_profiler();
    // }
  }

  public function index($year = null, $month = null, $day = null){
    $data['posts']         = $this->Blog_model->get_post_list_limit();
    $data['posts_archive'] = $this->Blog_model->get_post_archive_sidebar();
    $data['category']      = $this->Blog_model->get_category();
    $data['check_cat']     = $this->Blog_model->get_show_check_category();
    $data['calender']      = $this->Calender_model->generates($year,$month);
    $data['calender_post'] = $this->Calender_model->get_post_calender($year,$month,$day);
    $this->breadcrumbs->push('Home', 'blog');
    $this->breadcrumbs->push('お問い合わせ', 'contact');

    $this->form_validation->set_rules('name', 'お名前', 'trim|required|xss_clean');
    $this->form_validation->set_rules('email', 'メールアドレス', 'trim|required|xss_clean');
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

  public function confirm($year = null, $month = null, $day = null){
    $data['posts']         = $this->Blog_model->get_post_list_limit();
    $data['posts_archive'] = $this->Blog_model->get_post_archive_sidebar();
    $data['category']      = $this->Blog_model->get_category();
    $data['check_cat']     = $this->Blog_model->get_show_check_category();
    $data['calender']      = $this->Calender_model->generates($year,$month);
    $data['calender_post'] = $this->Calender_model->get_post_calender($year,$month,$day);
    $this->breadcrumbs->push('Home', 'blog');
    $this->breadcrumbs->push('お問い合わせ', 'contact/confirm');

    if($this->input->post('return_edit')){
      $this->load->view('tpl/header_meta');
      $this->load->view('tpl/header');
      $this->load->view('contact/index',$data);
      $this->load->view('tpl/sidebar',$data);
      $this->load->view('tpl/footer');
    }else{
      $this->load->view('tpl/header_meta');
      $this->load->view('tpl/header');
      $this->load->view('contact/thank',$data);
      $this->load->view('tpl/sidebar',$data);
      $this->load->view('tpl/footer');

      $config = Array(
        'protocol'  => 'smtp',
        'smtp_host' => 'ssl://smtp.googlemail.com',
        'smtp_port' => 465,
        'smtp_user' => 'メールアドレス@gmail.com',
        'smtp_pass' => 'パスワードを入力',
        'mailtype'  => 'html',
        'charset'   => 'UTF-8'
      );

      $this->load->library('email', $config);
      $this->email->set_newline("\r\n");//エラー回避のおまじない

      $this->email->from('メールアドレス@gmail.com', 'ザク改造003');
      $this->email->to('メールアドレス@gmail.com');

      $this->email->subject('ご利用有難うございます');
      $this->email->message($this->input->post('name'));
      $this->email->message($this->input->post('email'));
      $this->email->message($this->input->post('text'));

      $result = $this->email->send();
    }
  }

  public function thank($year = null, $month = null, $day = null){
    $data['posts']         = $this->Blog_model->get_post_list_limit();
    $data['posts_archive'] = $this->Blog_model->get_post_archive_sidebar();
    $data['category']      = $this->Blog_model->get_category();
    $data['check_cat']     = $this->Blog_model->get_show_check_category();
    $data['calender']      = $this->Calender_model->generates($year,$month);
    $data['calender_post'] = $this->Calender_model->get_post_calender($year,$month,$day);
    $this->breadcrumbs->push('Home', 'blog');
    $this->breadcrumbs->push('お問い合わせ', 'contact/confirm');

    $this->load->view('tpl/header_meta');
    $this->load->view('tpl/header');
    $this->load->view('contact/thank',$data);
    $this->load->view('tpl/sidebar',$data);
    $this->load->view('tpl/footer');
  }



}