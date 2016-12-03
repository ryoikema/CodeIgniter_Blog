<?php
class Gallery extends CI_Controller {

	var $gallery_path;
	var $gallery_path_url;

	public function __construct(){
		parent::__construct();
    $this->load->model('Blog_model');
    $this->load->model('Calender_model');
    $this->load->library('breadcrumbs');
		$this->gallery_path = realpath(APPPATH."../images");
		$this->gallery_path_url = base_url()."images/";
    //development の場合 プロファイラを有効に
    // if(ENVIRONMENT === 'development'){
    //   $this->output->enable_profiler();
    // }
	}

	public function index($year = null, $month = null, $day = null){
    $data['posts_archive'] = $this->Blog_model->get_post_archive_sidebar();
    $data['category']      = $this->Blog_model->get_category();
    $data['check_cat']     = $this->Blog_model->get_show_check_category();
    $data['calender']      = $this->Calender_model->generates($year,$month,$day);
    $data['calender_post'] = $this->Calender_model->get_post_calender($year,$month,$day);
    $this->breadcrumbs->push('Home', 'blog');
    $this->breadcrumbs->push('ギャラリー', 'gallery');

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

		$this->load->view("tpl/header_meta");
		$this->load->view("tpl/header");
		$this->load->view('gallery',$data);
		$this->load->view("tpl/sidebar");
		$this->load->view("tpl/footer");
	}
}
