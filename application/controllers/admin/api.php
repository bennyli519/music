

<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 * @Author: jerryLi 
 * @Date: 2017-12-17 12:27:21 
 * @Last Modified by: jerryLi
 * @Last Modified time: 2017-12-17 12:27:51
 */

class Api extends CI_Controller {
    /**
	 * 构造函数
	 */
	public function __construct(){
		parent::__construct();
        $this->load->model('admin_model','admin');
        $this->load->model('api_model','api');
        $this->load->model('singer_model','singer');
        header('Access-Control-Allow-Origin: *');
		header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
		header('Access-Control-Allow-Methods: GET, POST, PUT,DELETE');
	}
	
	//接口 发送歌手数据
	public function sendSingersMes(){
		$singerList = $this->api->checkSingers();
		$s= json_encode($singerList);
		p($s);
	}
	
	/*
	 * 接受歌手mid 并返回对应歌手的歌曲
	 */
	public function Songs(){
		header('Access-Control-Allow-Origin: *');
		header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
		header('Access-Control-Allow-Methods: GET, POST, PUT,DELETE');
		$mid = $_POST['mid'];
//		$mid = "0020PeOh4ZaCw1";
		$songList = $this->api->checkSongs($mid);
		$a = json_encode($songList);
		p($a);
	}
}  