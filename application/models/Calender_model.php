<?php
class Calender_model extends CI_Model{

  var $pref;

  function __construct(){
    parent::__construct();
    $this->pref = array(
      "show_next_prev" => TRUE,
      "next_prev_url" => base_url() . "calender/index"
    );

    $this->pref["template"] = array(
      'table_open'             => '<table class="calender">',

      'heading_previous_cell'  => '<th class="prev"><a href="{previous_url}">&lt;</a></th>',
      'heading_title_cell'     => '<th colspan="{colspan}">{heading}</th>',
      'heading_next_cell'      => '<th class="next"><a href="{next_url}">&gt;</a></th>',

      'week_day_cell'          => '<th>{week_day}</th>',

      'cal_cell_start'         => '<td class="day">',
      'cal_cell_start_today'   => '<td class="today">',

      'cal_cell_start_other'   => '<td class="other-month">',

      'cal_cell_content'       => '<a href="{content}">{day}</a>',
      'cal_cell_content_today' => '<div class="highlight"><a href="{content}">{day}</a></div>',

      'cal_cell_blank'         => '&nbsp;'
    );
  }

  //カレンダー生成関数
  function generates ($year, $month){
    $this->load->library('calendar', $this->pref);

    $cal_data = $this->get_calendar_data($year, $month);

    return $this->calendar->generate($year, $month, $cal_data);
  }

  //月毎、日毎の記事リンク作成
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
        //日付に ルート/calender/index/年/月/日を格納
        $cal_data[date('j',strtotime($row->post_date))] = site_url('calender/date/'.$y."/".$m."/".str_replace("-", "/", substr($row->post_date, 8,2)));
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
        $cal_data[date('j',strtotime($row->post_date))] = site_url('calender/date/'.$year."/".$month."/".str_replace("-", "/", substr($row->post_date, 8,2)));
      }
      return $cal_data;
     }
  }

  //月毎リンクの記事取得
  //localhost/code_blog/calender/index/2016/10?
  public function get_post_calender($year, $month, $day){
    $post_date = $this->input->get('post_date');

    if(empty($_GET['per_page'])){
      $_GET['per_page'] = 0;
    }

    $query=
      $this->db
      ->select("*,date_format(post_date,'%Y年%m月%d日') AS post_date")
      ->where("date_format(post_date,'%Y-%m')='".$year."-".$month."'")
      ->order_by("post_date DESC")
      ->get("post", 2, $_GET['per_page']);//表示件数はControllerと合わせる
     return $query->result_array();
  }

  //日付リンク毎クリック後の各日付記事一覧
  //localhost/code_blog/calender/index/2016/10/24?
  public function get_post_calender_date($year, $month, $day){
    $post_date = $this->input->get('post_date');

    if(empty($_GET['per_page'])){
      $_GET['per_page'] = 0;
    }

    $query=
      $this->db
      ->select("*,date_format(post_date,'%Y年%m月%d日') AS post_date")
      ->where("date_format(post_date,'%Y-%m-%d')='".$year."-".$month."-".$day."'")
      ->order_by("post_date DESC")
      ->get("post", 2, $_GET['per_page']);//表示件数はControllerと合わせる
     return $query->result_array();
  }

}