

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
		//$mid = "0020PeOh4ZaCw1";
		$songList = $this->api->checkSongs($mid);
		$a = json_encode($songList);
		p($a);
	}
	/**
	 * 排行榜页
	 */
	public function getTopList(){
		$data = $this->api->TopList();
		for($i=0;$i<5;$i++){
			$a= $data[$i]['rank_songList'];
			$arr = explode("/",$a);		//切割mid
			foreach($arr as $key => $item){
				$songList[] = $this->api->getOnlySong($item);//查询
			}	
			$data[$i]['rank_songList'] = $songList;
			$songList = "";
		}
		$json_data = json_encode($data);
		p($json_data);
		
	}
	
	/**
	 * 排行榜详情页  前三十(singer_area:0港台 1内地 2日韩 3欧美 4热门)
	 */
	public function getAreaSong(){

		/**
		 * 	$area_hk = 0  $area_dl = 1 $area_jk = 2 $area_ea = 3
		 */
		$area_type = $_POST['area_type'];//获取类型
		if(	$area_type == 4){
			$data = $this->api->hotSongs();
		}else{
			$data = $this->api->hotAreaSongs($area_type);
		}	
		
		$s= json_encode($data);
		p($s);
	}
	/**
	 * 排行榜详情页  前三十(4 热度)
	 */
	public function getHotSong(){
		$data['hot'] = $this->api->hotSongs();
//		p($data);
		 $s= json_encode($data);
		 p($s);
	}

}  