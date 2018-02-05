

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
	 * 获取歌曲分类类型
	 */
	public function getTypeList(){
		$typeList['songType'] = $this->api->checkType();
		$typeList['singerType'] = array(
			array(
				"picUrl"=> "http://y.gtimg.cn/music/photo/radio/track_radio_202_10_6.jpg",
				"title" => "内地",
				"type_id" => "1"
			),
			array(
				"picUrl"=> "http://y.gtimg.cn/music/photo/radio/track_radio_119_10_6.jpg",
				"title" => "港台",
				"type_id" => "0"
			),
			array(
				"picUrl"=> "http://y.gtimg.cn/music/photo/radio/track_radio_120_10_6.jpg",
				"title" => "欧美",
				"type_id" => "3"
			)
		);
		$typeList['dateType'] = array(
			array(
				"picUrl"=> "http://y.gtimg.cn/music/photo/radio/track_radio_122_10_5.jpg",
				"title" => "70精选",
				"type_id" => "2005"
			),
			array(
				"picUrl"=> "http://y.gtimg.cn/music/photo/radio/track_radio_123_10_4.jpg",
				"title" => "80精选",
				"type_id" => "2010"
			),
			array(
				"picUrl"=> "http://y.gtimg.cn/music/photo/radio/track_radio_124_10_4.jpg ",
				"title" => "90精选",
				"type_id" => "2015"
			)

		);
		$json_type = json_encode($typeList);
		p($json_type);
	}
	/**
	 * 曲风类型 歌曲详情列表
	 *
	 * @return void
	 */
	public function getTypeSongList(){
		$type_kind = $_POST["type_kind"];//类别
		$type_id = $_POST["type_id"];
		switch($type_kind){
			case 0:
				$songList = $this->api->checkTypeSongList($type_id);
				break;
			case 1:
				$songList = $this->api->checkSingerTypeList($type_id);
				break;
			case 2:
				$songList = $this->api->checkDateTimeList($type_id);
				break;
		}
                  
		$json_type = json_encode($songList);
		p($json_type);
	}

	/**
	 * 歌手类别 歌曲详情列表
	 *
	 * @return void
	 */
	public function getTypeSingerList(){
		$songList = $this->api->checkSingerTypeList(3);
		$json_type = json_encode($songList);
		p($json_type);
	}

	
	/**
	 * 年代分类 年代精选详情列表
	 *
	 * @return void
	 */
	public function getTypeDateList(){
		$songList = $this->api->checkDateTimeList();
		$json_type = json_encode($songList);
		p($json_type);
	}

}  