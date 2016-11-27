<?php
class Calender_model extends CI_Model{

  var $pref;

  function __construct(){
    parent::__construct();
    $this->pref = array(
      "show_next_prev" => TRUE,
      "next_prev_url" => base_url() . "calender/index"
    );
  }

  //カレンダー生成関数
  function generates ($year, $month){
    $this->load->library('calendar', $this->pref);
    $cal_data = $this->get_calendar_data($year, $month);

    return $this->calendar->generate($year, $month, $cal_data);
  }

  //月毎の記事取得関数
  function get_calendar_data($year, $month){
    //生成されるSQL : post_date LIKE "2016-11%"
    $y = date('Y');
    $m = date('m');

    if(is_null($year)){
      //ページに訪れた時点での日付リンク取得SQL
      $query = $this->db->query("
        SELECT *,
        date_format(post_date,'%Y-%m-%d') AS post_date
        FROM post
        WHERE post_date
        LIKE '".$y."-".$m."%'
      ");

      $cal_data = array();
      foreach($query->result() as $row){
        //2016/00/00
        //日付に ルート/calender/index/年/月/日←絶対パスを格納
        $cal_data[substr($row->post_date, 8,2)] = site_url('calender/index/'.$y."/".$m."/".str_replace("-", "/",substr($row->post_date, 8,2)));
      }
      return $cal_data;
    }else{
      //月リンクがクリックされたら、前、次の月リンク取得
      $query = $this->db->query("
        SELECT *,
        date_format(post_date,'%Y-%m-%d') AS post_date
        FROM post
        WHERE post_date
        LIKE '".$year."-".$month."%'
        ");

      $cal_data = array();
      foreach($query->result() as $row){
        //2016/00/00
        $cal_data[substr($row->post_date, 8,2)] = site_url('calender/index/'.$year."/".$month."/".str_replace("-", "/",substr($row->post_date, 8,2)));
      }
      return $cal_data;
     }
  }

  //日付毎の記事取得関数
  //localhost/code_blog/calender/index/2016/10/24
  public function get_post_calender($year, $month, $day){
    $post_date = $this->input->get('post_date');

    $query = $this->db->query("
      SELECT *,
      date_format(post_date,'%Y-%m-%d') AS post_date
      FROM post
      WHERE post_date
      LIKE '".$year."-".$month."-".$day."%'
    ");
    return $query->result_array();
  }

}