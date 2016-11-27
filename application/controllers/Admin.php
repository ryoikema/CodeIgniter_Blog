<?php
class Admin extends CI_Controller{

  public function __construct(){
    parent::__construct();
    $this->load->model('Admin_model');

    //development の場合 プロファイラを有効に
    // if (ENVIRONMENT === 'development') {
    //     $this->output->enable_profiler();
    // }

  }
/*************************************************
 投稿
 ・管理画面トップ用
 ・記事詳細用
 ・新規投稿(複数カテゴリの紐付け)
 ・投稿編集(紐づいたカテゴリも更新)
 ・投稿と紐づいたカテゴリの削除
**************************************************/
  //管理画面トップ
  public function index($post_id = NULL){
    $data['posts'] = $this->Admin_model->admin_get_post_list();
    $data['check_cat'] = $this->Admin_model->admin_get_show_category();
    $this->load->view("tpl_admin/header_meta");
    $this->load->view("tpl_admin/header");
    $this->load->view("admin/index",$data);
    $this->load->view("tpl_admin/sidebar");
    $this->load->view("tpl_admin/footer");
  }

  //記事詳細
  public function post_detail($post_id){
    $data['post'] = $this->Admin_model->admin_get_post($post_id);

    $this->load->view("tpl_admin/header_meta");
    $this->load->view("tpl_admin/header");
    $this->load->view("admin/post_detail",$data);
    $this->load->view("tpl_admin/sidebar");
    $this->load->view("tpl_admin/footer");
  }

  //新規投稿(複数カテゴリの紐付け)
  public function admin_post_create(){
    $data['category'] = $this->Admin_model->admin_get_category();

    $this->form_validation->set_rules('post_title', 'タイトル', 'trim');
    $this->form_validation->set_rules('post_content', '本文', 'trim');
    $this->form_validation->set_rules('cat_id[]', 'カテゴリ', 'trim');

    if ($this->form_validation->run() === FALSE) {
      $this->load->view("tpl_admin/header_meta");
      $this->load->view("tpl_admin/header");
      $this->load->view("admin/admin_post_create",$data);
      $this->load->view("tpl_admin/sidebar");
      $this->load->view("tpl_admin/footer");
    } else {
      $this->Admin_model->admin_set_post();
      $this->Admin_model->admin_set_post_category();
      $this->load->view('admin/thanks');
    }
  }

  //投稿編集(紐づいたカテゴリも更新)
  public function admin_post_edit($post_id){
    //編集ページに来たら、DB内の投稿内容をフォームに表示
    if(empty($this->input->post('submit'))){
      $data['post']       = $this->Admin_model->admin_get_post($post_id);
      $data['regist_cat'] = $this->Admin_model->admin_get_category();
      $data['check_cat']  = $this->Admin_model->admin_get_post_category($post_id);

      $this->load->view("tpl_admin/header_meta");
      $this->load->view("tpl_admin/header");
      $this->load->view("admin/admin_post_edit",$data);
      $this->load->view("tpl_admin/sidebar");
      $this->load->view("tpl_admin/footer");
    }else{
      $this->form_validation->set_rules('post_title', 'タイトル', 'trim');
      $this->form_validation->set_rules('post_content', '本文', 'trim');
      $this->form_validation->set_rules('cat_id[]', 'カテゴリ', 'trim');

      if($this->form_validation->run() === FALSE){
        $this->load->view("tpl_admin/header_meta");
        $this->load->view("tpl_admin/header");
        $this->load->view("admin/admin_post_edit",$data);
        $this->load->view("tpl_admin/sidebar");
        $this->load->view("tpl_admin/footer");
      }else{
        $this->db->trans_start();
          $this->Admin_model->admin_set_edit($post_id);
          $this->Admin_model->admin_set_edit_post_category($post_id);
        $this->db->trans_complete();
        $this->load->view('admin/thanks');
      }
    }
  }

  //投稿と紐づいたカテゴリの削除
  public function admin_post_delete($post_id){
    $this->db->trans_start();
      $this->Admin_model->admin_delete_post($post_id);
      $this->Admin_model->admin_delete_post_category($post_id);
    $this->db->trans_complete();
    $this->load->view('admin/thanks');
  }
/*************************************************
 カテゴリ
 ・カテゴリに紐づいた記事を取得
 ・カテゴリ作成（カテゴリ表示/カテゴリ作成）
 ・カテゴリ編集
 ・カテゴリ削除
**************************************************/
  //カテゴリに紐づいた記事を取得
  public function post_category(){
    $data['posts']     = $this->Admin_model->get_post_category();
    $data['category']  = $this->Admin_model->admin_get_category();
    $data['check_cat'] = $this->Admin_model->admin_get_show_category();

    $this->load->view("tpl_admin/header_meta");
    $this->load->view("tpl_admin/header");
    $this->load->view("admin/post_category",$data);
    $this->load->view("tpl_admin/sidebar");
    $this->load->view("tpl_admin/footer");
  }

  //カテゴリ作成
  public function category(){

    if(empty($this->input->post('submit'))){
      //カテゴリ表示
      $data['categorys'] = $this->Admin_model->admin_get_category();
      $this->load->view("tpl_admin/header_meta");
      $this->load->view("tpl_admin/header");
      $this->load->view("admin/category",$data);
      $this->load->view("tpl_admin/sidebar");
      $this->load->view("tpl_admin/footer");
    }else{
      //カテゴリ作成
      $this->form_validation->set_rules('cat_name', 'カテゴリ名', 'trim|required|min_length[1]|max_length[12]');
      $this->form_validation->set_rules('cat_slug', 'スラッグ', 'trim|required|min_length[1]|max_length[12]');

      if($this->form_validation->run() === FALSE){
        $this->load->view("tpl_admin/header_meta");
        $this->load->view("tpl_admin/header");
        $this->load->view("admin/category");
        $this->load->view("tpl_admin/sidebar");
        $this->load->view("tpl_admin/footer");
      }else{
        $this->Admin_model->admin_set_category();
        redirect('admin/category','refresh');
      }
    }
  }

  //カテゴリ編集
  public function admin_category_edit($cat_id){
    if(empty($this->input->post('submit'))){
      $data['cat']      = $this->Admin_model->admin_get_edit_category($cat_id);
      $data['category'] = $this->Admin_model->admin_get_category();
      $this->load->view("tpl_admin/header_meta");
      $this->load->view("tpl_admin/header");
      $this->load->view("admin/admin_category_edit",$data);
      $this->load->view("tpl_admin/sidebar");
      $this->load->view("tpl_admin/footer");
    }else{
      $this->form_validation->set_rules('cat_name', 'カテゴリ名', 'trim|required|min_length[1]|max_length[12]');
      $this->form_validation->set_rules('cat_slug', 'スラッグ', 'trim|required|min_length[1]|max_length[12]');

      if($this->form_validation->run() === FALSE){
        $this->load->view("tpl_admin/header_meta");
        $this->load->view("tpl_admin/header");
        $this->load->view("admin/admin_category_edit",$data);
        $this->load->view("tpl_admin/sidebar");
        $this->load->view("tpl_admin/footer");
      } else {
        $this->Admin_model->admin_edit_category($cat_id);
        redirect('admin/category','refresh');
      }
    }
  }

  //カテゴリ削除
  public function admin_category_delete($cat_id){
    $this->Admin_model->admin_delete_category($cat_id);
    redirect('admin/category','refresh');
  }

}