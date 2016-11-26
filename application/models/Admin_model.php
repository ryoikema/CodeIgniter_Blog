<?php
class Admin_model extends CI_Model{
/*************************************************
 投稿
 ・トップページ用
 ・記事詳細用
 ・新規投稿
 ・新規投稿に紐づいたカテゴリを挿入
 ・投稿編集
 ・投稿に紐づいたカテゴリを編集
 ・投稿削除
 ・投稿に紐づいたカテゴリー削除
**************************************************/
  //トップページ用
  public function admin_get_post_list($post_id = FALSE){
    $query = $this->db->query("
      SELECT *
      ,date_format(post_date,'%Y年%m月%d日') AS post_date
      FROM post
      ORDER BY post_id
      DESC");
    return $query->result_array();
  }


  //記事詳細用
  public function admin_get_post($post_id = FALSE){
    $query = $this->db->query("
      SELECT *
      , date_format(post_date,'%Y年%m月%d日') AS post_date
      FROM post
      WHERE post_id=$post_id");
    return $query->row_array();
  }

  //新規投稿
  public function admin_set_post(){
    $data = array(
      'post_title'   => $this->input->post('post_title'),
      'post_content' => $this->input->post('post_content')
      );
     return $this->db->insert('post', $data);
  }
  //新規投稿に紐づいたカテゴリを挿入
  public function admin_set_post_category(){
    //post_category
    $post_id = $this->db->insert_id();
    $cat_id  = $this->input->post('cat_id');
    for($i=0; $i < count($cat_id); $i++){
      $this->db->query("
        INSERT INTO post_category(post_id, cat_id)
        VALUES($post_id, $cat_id[$i]) ");
    }
  }

  //投稿編集
  public function admin_set_edit($post_id){
    $data = array(
      'post_title'   => $this->input->post('post_title'),
      'post_content' => $this->input->post('post_content')
      );
    return $this->db->update('post', $data, array('post_id'=>$post_id));
  }
  //投稿に紐づいたカテゴリを編集
  public function admin_set_edit_post_category(){
    $post_id = $this->input->post('post_id');
    $cat_id  = $this->input->post('cat_id');
    $this->db->delete('post_category', array('post_id'=>$post_id));
    for($i=0; $i < count($cat_id); $i++){
      $this->db->query("
        INSERT INTO post_category(post_id, cat_id)
        VALUES($post_id, $cat_id[$i]) ");
    }
  }

  //投稿削除
  public function admin_delete_post($post_id){
    $this->db->delete('post',array('post_id'=>$post_id));
  }
  //投稿に紐づいたカテゴリーも削除
  public function admin_delete_post_category($post_id){
    $this->db->delete('post_category',array('post_id'=>$post_id));
  }

/*************************************************
 カテゴリ
 ・カテゴリ取得
 ・投稿に紐づいたカテゴリの取得 （記事編集用）
 ・カテゴリ取得 （カテゴリ編集用）
 ・カテゴリ新規
 ・カテゴリ編集
 ・カテゴリ削除 post_category.post_id post_category.cat_id:category.cat_id cat_name cat_slug
**************************************************/
  //カテゴリ取得
  public function admin_get_category(){
   $query =  $this->db->get('category');
   return $query->result_array();
  }

  //投稿に紐づいたカテゴリの取得 (記事表示用)
  public function admin_get_show_category(){
    $query = $this->db->query("
      SELECT *
      FROM category
      inner join post_category ON(category.cat_id=post_category.cat_id)
      ");
    return $query->result_array();
   }

  //投稿に紐づいたカテゴリの取得 (記事編集用)
  public function admin_get_post_category($post_id){
    $query =  $this->db->query("
      SELECT *
      FROM category left join
      (SELECT * FROM post_category WHERE post_id=$post_id) AS post_category
      ON category.cat_id=post_category.cat_id
      ORDER BY category.cat_id ASC");
    return $query->result_array();
  }

  //カテゴリに紐づいた記事を取得 (記事表示用)
  public function get_post_category(){
    $cat_slug = $this->input->get("cat_slug");
    $query = $this->db->query("
      SELECT *, date_format(post_date,'%Y年%m月%d日') AS post_date
      FROM post_category
      inner join category on(post_category.cat_id=category.cat_id)
      inner join post on(post.post_id=post_category.post_id)
      WHERE cat_slug='".$cat_slug."'");

     return $query->result_array();
   }

  //カテゴリ取得 （カテゴリ編集用）
  public function admin_get_edit_category($cat_id){
    $query =  $this->db->get_where('category', array('cat_id'=> $cat_id));
    return $query->row_array();
  }

  //カテゴリ新規
  public function admin_set_category(){
    $data = array(
      'cat_name' => $this->input->post('cat_name'),
      'cat_slug' => $this->input->post('cat_slug')
      );
    return $this->db->insert('category', $data);
    $this->load->view('admin/thanks');
  }

  //カテゴリ編集
  public function admin_edit_category($cat_id){
    $data = array(
      'cat_name' => $this->input->post('cat_name'),
      'cat_slug' => $this->input->post('cat_slug')
      );
    return $this->db->update('category', $data, array('cat_id'=>$cat_id));
    redirect('admin/category');
  }

  //カテゴリ削除
  public function admin_delete_category($cat_id){
    $this->db->delete('category',array('cat_id'=>$cat_id));
    redirect('admin/category');
  }

}