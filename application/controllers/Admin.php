<?php
class Admin extends CI_Controller{

  public function __construct(){
    parent::__construct();
    $this->load->model('Admin_model');
    $this->load->model('Users_model');
    $this->load->library("pagination");
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
    //ページャー設定
    $config["base_url"] = base_url()."/admin/index";
    $config["total_rows"] = $this->db->get("post")->num_rows();//DB内の全記事数
    $config["per_page"] = 20;//表示件数、Model側と合わせる
    $config["num_links"] = 3;//現在ページ番号の前後に表示するリンク数
    $config['page_query_string'] = TRUE;// ページ番号をクエリストリングに変更
    $this->pagination->initialize($config);

    if($this->session->userdata('is_logged_in')){
      $this->load->view("tpl_admin/header_meta");
      $this->load->view("tpl_admin/header");
      $this->load->view("admin/index",$data);
      $this->load->view("tpl_admin/sidebar");
      $this->load->view("tpl_admin/footer");
    }else{
      redirect('member/restricted');
    }
  }

  //記事詳細
  public function post_detail($post_id){
    $data['post'] = $this->Admin_model->admin_get_post($post_id);
    $data['category']  = $this->Admin_model->admin_get_category();
    $data['check_cat'] = $this->Admin_model->admin_get_show_category();

    if($this->session->userdata('is_logged_in')){
      $this->load->view("tpl_admin/header_meta");
      $this->load->view("tpl_admin/header");
      $this->load->view("admin/post_detail",$data);
      $this->load->view("tpl_admin/sidebar");
      $this->load->view("tpl_admin/footer");
    }else{
      redirect('member/restricted');
    }
  }

  //新規投稿(複数カテゴリの紐付け)
  public function admin_post_create(){
    $data['category'] = $this->Admin_model->admin_get_category();

    $this->form_validation->set_rules('post_title', 'タイトル', 'trim|xss_clean');
    $this->form_validation->set_rules('post_content', '本文', 'trim|xss_clean');
    $this->form_validation->set_rules('cat_id[]', 'カテゴリ', 'trim');

    if($this->session->userdata('is_logged_in')){
      if($this->form_validation->run() === FALSE){
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
    }else{
      redirect('member/restricted');
    }
  }

  //投稿編集(紐づいたカテゴリも更新)
  public function admin_post_edit($post_id){
    //編集ページに来たら、DB内の投稿内容をフォームに表示
    if($this->session->userdata('is_logged_in')){
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
        $this->form_validation->set_rules('post_title', 'タイトル', 'trim|xss_clean');
        $this->form_validation->set_rules('post_content', '本文', 'trim|xss_clean');
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
    }else{
      redirect('member/restricted');
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
    //ページャー設定
    $cat_slug = $this->input->get("cat_slug");
    $config["base_url"] = base_url()."/admin/post_category?cat_slug={$_GET['cat_slug']}";
    $config["total_rows"] = $this->db
      ->select("*,date_format(post_date,'%Y年%m月%d日') AS post_date")
      ->join('category', 'post_category.cat_id=category.cat_id')
      ->join('post', 'post.post_id=post_category.post_id')
      ->where("cat_slug='".$cat_slug."'")
      ->get("post_category")->num_rows();//該当する月の全記事数
    $config["per_page"] = 20;//表示件数、Model側と合わせる
    $config["num_links"] = 3;//現在ページ番号の前後に表示するリンク数
    $config['page_query_string'] = TRUE;// ページ番号をクエリストリングに変更
    $this->pagination->initialize($config);

    if($this->session->userdata('is_logged_in')){
      $this->load->view("tpl_admin/header_meta");
      $this->load->view("tpl_admin/header");
      $this->load->view("admin/post_category",$data);
      $this->load->view("tpl_admin/sidebar");
      $this->load->view("tpl_admin/footer");
    }else{
      redirect('member/restricted');
    }
  }

  //カテゴリ作成
  public function category(){
    if($this->session->userdata('is_logged_in')){
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
        $this->form_validation->set_rules('cat_name', 'カテゴリ名', 'trim|required|min_length[1]|max_length[12]|xss_clean');
        $this->form_validation->set_rules('cat_slug', 'スラッグ', 'trim|required|min_length[1]|max_length[12]|xss_clean');

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
    }else{
      redirect('member/restricted');
    }
  }

  //カテゴリ編集
  public function admin_category_edit($cat_id){
    if($this->session->userdata('is_logged_in')){
      if(empty($this->input->post('submit'))){
        $data['cat']      = $this->Admin_model->admin_get_edit_category($cat_id);
        $data['category'] = $this->Admin_model->admin_get_category();
        $this->load->view("tpl_admin/header_meta");
        $this->load->view("tpl_admin/header");
        $this->load->view("admin/admin_category_edit",$data);
        $this->load->view("tpl_admin/sidebar");
        $this->load->view("tpl_admin/footer");
      }else{
        $this->form_validation->set_rules('cat_name', 'カテゴリ名', 'trim|required|min_length[1]|max_length[12]|xss_clean');
        $this->form_validation->set_rules('cat_slug', 'スラッグ', 'trim|required|min_length[1]|max_length[12]|xss_clean');

        if($this->form_validation->run() === FALSE){
          $this->load->view("tpl_admin/header_meta");
          $this->load->view("tpl_admin/header");
          $this->load->view("admin/admin_category_edit",$data);
          $this->load->view("tpl_admin/sidebar");
          $this->load->view("tpl_admin/footer");
        }else{
          $this->Admin_model->admin_edit_category($cat_id);
          redirect('admin/category','refresh');
        }
      }
    }else{
      redirect('member/restricted');
    }
  }

  //カテゴリ削除
  public function admin_category_delete($cat_id){
    $this->Admin_model->admin_delete_category($cat_id);
    redirect('admin/category','refresh');
  }
/*************************************************
 メディア
 ・画像アップロード
 ・サムネイル作成
 ・アップロード画像の表示
**************************************************/
  public function upload($year = null, $month = null, $day = null){
    $this->gallery_path = realpath(APPPATH."../images");
    $this->gallery_path_url = base_url()."images/";

    if($this->session->userdata('is_logged_in')){
      if($this->input->post("upload")){//投稿ボタンが押されたら
        //投稿
        $config = array(
          "upload_path" => $this->gallery_path,
          "allowed_types" => "jpg|gif|png",
          "encrypt_name" => true
          );
        $this->load->library("upload",$config);
        $this->upload->do_upload();
        //サムネイルを作る
        $image_data = $this->upload->data();
        $config = array(
          "source_image" => $image_data["full_path"],
          "new_image" => $this->gallery_path."./thumbs",
          "maintain_ratio" => false,
          "width" => 150,
          "height" => 100,
          );
        $this->load->library("image_lib", $config);
        $this->image_lib->resize();

        redirect("admin/upload");
      }

      //表示用にアップロードされた各画像毎に絶対パスを生成
      $files = scandir($this->gallery_path);
      $files = array_diff($files, array(".","..","thumbs"));

      $images = array();
      foreach($files as $file){
        $images[] = array(
          "url" => $this->gallery_path_url.$file,//元ファイル
          "thumb_url" => $this->gallery_path_url."thumbs/".$file//サムネイル
          );
      }
      $data["images"] = $images;

      $this->load->view("tpl_admin/header_meta");
      $this->load->view("tpl_admin/header");
      $this->load->view('admin/gallery',$data);
      $this->load->view("tpl_admin/sidebar");
      $this->load->view("tpl_admin/footer");
    }
  }


}