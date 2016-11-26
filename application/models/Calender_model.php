<?php
class Calender_model extends CI_Model{

  var $pref;

  function __construct(){
    parent::__construct();

    $this->pref = array(
      "show_next_prev" => TRUE,
      "next_prev_url" => base_url() . "calender/index"
    );

    // $this->pref = array(
    //   'table_open'             => '<table class="calender">',

    //   'heading_previous_cell'  => '<th><a href="{previous_url}">&lt;</a></th>',
    //   'heading_title_cell'     => '<th colspan="{colspan}">{heading}</th>',
    //   'heading_next_cell'      => '<th><a href="{next_url}">&gt;</a></th>',

    //   'week_day_cell'          => '<th>{week_day}</th>',

    //   'cal_cell_start'         => '<td class="day">',
    //   'cal_cell_start_today'   => '<td class="today">',

    //   'cal_cell_start_other'   => '<td class="other-month">',

    //   'cal_cell_content'       => '<a href="{content}">{day}</a>',
    //   'cal_cell_content_today' => '<div class="highlight"><a href="{content}">{day}</a></div>',

    //   'cal_cell_blank'         => '&nbsp;'
    // );
  }

  function generates ($year, $month){
    $this->load->library('calendar', $this->pref);

    $cal_data = $this->get_calendar_data($year, $month);

    return $this->calendar->generate($year, $month, $cal_data);
  }

  function get_calendar_data($year, $month){
    // 生成されるSQL : post_date LIKE "2016-11%"
    $query = $this->db->query("
      SELECT *,
      date_format(post_date,'%Y-%m-%d') AS post_date
      FROM post
      WHERE post_date
      LIKE '".$year."-".$month."%'
      ");
    $cal_data = array();

    foreach($query->result() as $row){
      //2016
      //00-00を00/00にしてやりたい
      //formatエラーが出ている
      $cal_data[substr($row->post_date, 8,2)] = site_url('calender/index/'.$year."/".$month."/".str_replace("-", "/",substr($row->post_date, 8,2)));
      //$cal_data[substr($row->post_date, 8,2)] = substr($row->post_date, 5,5);
    }
    return $cal_data;
}
  //これで各月の記事を取得
  //localhost/code_blog/calender/index/2016/10-24
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