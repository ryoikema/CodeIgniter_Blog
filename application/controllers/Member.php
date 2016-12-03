<?php
class Member extends CI_Controller{
/*------------------------
| ログイン/ログアウト機能
-------------------------*/
  public function __construct(){
    parent::__construct();
    $this->load->model('Blog_model');
    $this->load->model('Calender_model');
    $this->load->library('breadcrumbs');
    //development の場合 プロファイラを有効に
    // if(ENVIRONMENT === 'development'){
    //   $this->output->enable_profiler();
    // }
  }

  public function index($year = null, $month = null, $day = null){
    $this->login();
  }

  public function members($year = null, $month = null, $day = null){
    $data['posts']         = $this->Blog_model->get_post_list_limit();
    $data['posts_archive'] = $this->Blog_model->get_post_archive_sidebar();
    $data['category']      = $this->Blog_model->get_category();
    $data['check_cat']     = $this->Blog_model->get_show_check_category();
    $data['calender']      = $this->Calender_model->generates($year,$month);
    $data['calender_post'] = $this->Calender_model->get_post_calender($year,$month,$day);

    if($this->session->userdata('is_logged_in')){
      $this->load->view("tpl/header_meta");
      $this->load->view("tpl/header");
      $this->load->view("admin/index");
      $this->load->view("tpl/sidebar", $data);
      $this->load->view("tpl/footer");
    }else{
      redirect('member/restricted');
    }
  }

  public function logout(){
    $this->session->sess_destroy();
    redirect('member/login');
  }

  public function login($year = null, $month = null, $day = null){
    $data['posts']         = $this->Blog_model->get_post_list_limit();
    $data['posts_archive'] = $this->Blog_model->get_post_archive_sidebar();
    $data['category']      = $this->Blog_model->get_category();
    $data['check_cat']     = $this->Blog_model->get_show_check_category();
    $data['calender']      = $this->Calender_model->generates($year,$month);
    $data['calender_post'] = $this->Calender_model->get_post_calender($year,$month,$day);
    $this->breadcrumbs->push('Home', 'blog');
    $this->breadcrumbs->push('会員ログインフォーム', '/blog/member');

    $this->load->view("tpl/header_meta");
    $this->load->view("tpl/header");
    $this->load->view("member/login");
    $this->load->view("tpl/sidebar", $data);
    $this->load->view("tpl/footer");
  }

  public function login_validation($year = null, $month = null, $day = null){
    $data['posts']         = $this->Blog_model->get_post_list_limit();
    $data['posts_archive'] = $this->Blog_model->get_post_archive_sidebar();
    $data['category']      = $this->Blog_model->get_category();
    $data['check_cat']     = $this->Blog_model->get_show_check_category();
    $data['calender']      = $this->Calender_model->generates($year,$month);
    $data['calender_post'] = $this->Calender_model->get_post_calender($year,$month,$day);

    $this->form_validation->set_rules('email', 'メールアドレス', 'trim|valid_email|required|min_length[4]|xss_clean|callback_validation_credentials');
    $this->form_validation->set_rules('password', 'パスワード', 'trim|required|xss_clean|md5');

    if($this->form_validation->run()){
      $data = array(
        'email' => $this->input->post('email'),
        'is_logged_in' => 1
        );
      $this->session->set_userdata($data);

      redirect("admin/index");
    }else{
      $this->load->view("tpl/header_meta");
      $this->load->view("tpl/header");
      $this->load->view("member/login");
      $this->load->view("tpl/sidebar", $data);
      $this->load->view("tpl/footer");
    }
  }

  public function restricted($year = null, $month = null, $day = null){
    $data['posts']         = $this->Blog_model->get_post_list_limit();
    $data['posts_archive'] = $this->Blog_model->get_post_archive_sidebar();
    $data['category']      = $this->Blog_model->get_category();
    $data['check_cat']     = $this->Blog_model->get_show_check_category();
    $data['calender']      = $this->Calender_model->generates($year,$month);
    $data['calender_post'] = $this->Calender_model->get_post_calender($year,$month,$day);

    $this->load->view("tpl/header_meta");
    $this->load->view("tpl/header");
    $this->load->view("member/restricted");
    $this->load->view("tpl/sidebar", $data);
    $this->load->view("tpl/footer");
  }

  public function validation_credentials(){
    $this->load->model('Users_model');

    if($this->Users_model->can_log_in()){
      return true;
    }else{
      $this->form_validation->set_message('validation_credentials','ユーザー名かパスワードが違います');
      return false;
    }
  }
/* ------------------------
| 会員登録機能
-------------------------*/
  public function signup($year = null, $month = null, $day = null){
    $data['posts']         = $this->Blog_model->get_post_list_limit();
    $data['posts_archive'] = $this->Blog_model->get_post_archive_sidebar();
    $data['category']      = $this->Blog_model->get_category();
    $data['check_cat']     = $this->Blog_model->get_show_check_category();
    $data['calender']      = $this->Calender_model->generates($year,$month);
    $data['calender_post'] = $this->Calender_model->get_post_calender($year,$month,$day);

    $this->load->view("tpl/header_meta");
    $this->load->view("tpl/header");
    $this->load->view("member/signup", $data);
    $this->load->view("tpl/sidebar");
    $this->load->view("tpl/footer");
  }

  public function signup_validation($year = null, $month = null, $day = null){
    $data['posts']         = $this->Blog_model->get_post_list_limit();
    $data['posts_archive'] = $this->Blog_model->get_post_archive_sidebar();
    $data['category']      = $this->Blog_model->get_category();
    $data['check_cat']     = $this->Blog_model->get_show_check_category();
    $data['calender']      = $this->Calender_model->generates($year,$month);
    $data['calender_post'] = $this->Calender_model->get_post_calender($year,$month,$day);

    $this->form_validation->set_rules('email', 'Email', 'trim|required|min_length[4]|xss_clean|valid_email|is_unique[user.user_email]');
    $this->form_validation->set_rules('password', 'パスワード', 'trim|required|min_length[5]|max_length[12]|xss_clean');
    $this->form_validation->set_rules('cpassword', 'パスワード確認用', 'trim|required|matches[password]|xss_clean');
    $this->form_validation->set_message('is_unique','入力したメールアドレスは既に登録されています');

    if($this->form_validation->run()){
      //ランダムキーの作成
      $key = md5(uniqid());

      //仮登録ユーザへ確認メールの送信
      $this->load->model("Users_model");

      $this->load->library('email', array("mailtype" => "html"));
      $this->email->from('メールアドレス@gmail.com','私からあなたへ');
      $this->email->to($this->input->post('email'));
      $this->email->subject("仮の会員登録が完了しました。");
      $message = "<p>会員登録ありがとうございます。</p>";
      $message .= "<p><a href=' ".base_url(). "member/resister_user/$key'>こちらをクリックして、会員登録を完了してください。</a></p>";
      $this->email->message($message);

      //temp_userにデータを挿入できたら、仮登録メールを送信する
      if($this->Users_model->add_temp_users($key)){
        if($this->email->send()){
          $this->load->view("tpl/header_meta");
          $this->load->view("tpl/header");
          $this->load->view("member/signup_validation");
          $this->load->view("tpl/sidebar", $data);
          $this->load->view("tpl/footer");
        }else{
          echo "メール送信に失敗しました";
        }
      }else{
        echo "データベースへ登録できませんでした";
      }
    }else{
      $this->load->view("tpl/header_meta");
      $this->load->view("tpl/header");
      $this->load->view("member/signup");
      $this->load->view("tpl/sidebar", $data);
      $this->load->view("tpl/footer");
    }
  }

  public function resister_user($key, $year = null, $month = null, $day = null){
    $this->load->model('Users_model');

    $data['posts']         = $this->Blog_model->get_post_list_limit();
    $data['posts_archive'] = $this->Blog_model->get_post_archive_sidebar();
    $data['category']      = $this->Blog_model->get_category();
    $data['check_cat']     = $this->Blog_model->get_show_check_category();
    $data['calender']      = $this->Calender_model->generates($year,$month);
    $data['calender_post'] = $this->Calender_model->get_post_calender($year,$month,$day);

    if($newemail = $this->Users_model->is_valid_key($key)){
      if($this->Users_model->add_user($key)){
        $data = array(
          'email' => $newemail,
          'is_logged_in' => 1
          );

        $this->session->set_userdata($data);
        redirect('member/resister_user_move');
      }else{
        echo "ユーザー登録に失敗しました";
      }
    }else{
      $this->load->view("tpl/header_meta");
      $this->load->view("tpl/header");
      $this->load->view("member/resister_user");
      $this->load->view("tpl/sidebar", $data);
      $this->load->view("tpl/footer");
    }
  }

  public function resister_user_move($year = null, $month = null, $day = null){
    $data['posts']         = $this->Blog_model->get_post_list_limit();
    $data['posts_archive'] = $this->Blog_model->get_post_archive_sidebar();
    $data['category']      = $this->Blog_model->get_category();
    $data['check_cat']     = $this->Blog_model->get_show_check_category();
    $data['calender']      = $this->Calender_model->generates($year,$month);
    $data['calender_post'] = $this->Calender_model->get_post_calender($year,$month,$day);

    $this->load->view("tpl/header_meta");
    $this->load->view("tpl/header");
    $this->load->view("member/resister_user_move");
    $this->load->view("tpl/sidebar", $data);
    $this->load->view("tpl/footer");
  }


}