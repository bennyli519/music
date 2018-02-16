

<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 * @Author: jerryLi 
 * @Date: 2017-12-17 12:27:21 
 * @Last Modified by: jerryLi
 * @Last Modified time: 2018-2-14 12:27:51
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
	
	//用户验证
	public function checkUser(){
		$name = $_POST['user']; //用户名
	    $password = $_POST['pwd'];//密码
		//$name = "benny";
		$userData = $this->api->checkUser($name);
		$arr[] = array(
			'Rstatus' =>'false',
			'user_id' =>$userData[0]['user_id'],
			'user_name'=>$userData[0]['user_name'],
			'user_avtar'=>$userData[0]['user_avtar']
		);
		

		if(!$userData || $userData[0]['user_pwd'] != md5($password)){
			echo 'failed';
		}else{
			$arr[0]['Rstatus'] = true;
			$a = json_encode($arr);
			p($a);
		}
		
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
	 * type 歌曲详情列表
	 *
	 * @return void
	 */
	public function getTypeSongList(){
		$type_kind = $_POST["type_kind"];//类别
		$type_id = $_POST["type_id"];
		switch($type_kind){
			case 0:
				//曲风类型 歌曲详情列表
				$songList = $this->api->checkTypeSongList($type_id);
				break;
			case 1:
				// 歌手类别 歌曲详情列表
				$songList = $this->api->checkSingerTypeList($type_id);
				break;
			case 2:
				//年代分类 年代精选详情列表
				$songList = $this->api->checkDateTimeList($type_id);
				break;
		}
                  
		$json_type = json_encode($songList);
		p($json_type);
	}
	/**
	 * 获取歌单
	 */
	public function getDiscList(){
		$data = $this->api->checkSonglist();
		$json_type = json_encode($data);
		p($json_type);
	}
	public function getDiscDetail(){
		$list_id = $_POST['list_id'];
		$data = $this->api->checkDetailSonglist($list_id);
		$a= $data[0]['list_songs'];
		$arr = explode("/",$a);		//切割mid
		foreach($arr as $key => $item){
			$songList[] = $this->api->getListSong($item);//查询
		}	
		$data[0]['list_songs'] = $songList;
		$json_type = json_encode($data);
		p($json_type);
		
	}
	/**
	 * 新歌速递
	 */
	public function getNewSong(){
		$data = $this->api->getNewSong();
		$json_type = json_encode($data);
		p($json_type);
	}
	/**
	 * 获取电台页面
	 */
	public function getBroadCast(){
		$data = $this->api->checkCastlist();
		$json_type = json_encode($data);
		p($json_type);
	}  

	/**
	 * 电台详情
	 *
	 * @return void
	 */
	public function getCastSongList(){
		$cast_id = $_POST['cast_id'];
		$data = $this->api->checkDetailCastList($cast_id);
		$a= $data[0]['broadcast_list'];
		$arr = explode("/",$a);		//切割mid
		foreach($arr as $key => $item){
			$song = $this->api->getListSong($item);
			if($song == null){
				continue;
			}else{
				$songList[] = $this->api->getListSong($item);//查询
			}
		}	
		$data[0]['broadcast_list'] = $songList;
		$json_type = json_encode($data);
		p($json_type);
	}
	/**
	 * 发表评论
	 *
	 * @return void
	 */
	public function addComment(){
		$mid = $_POST['mid'];//歌曲mid
		$user_id = $_POST['user_id'];//用户id
		$comment = $_POST['comment'];//评论内容
		$dt = new DateTime();
		$date = $dt->format('Y-m-d H:i:s');
		$data = array(
			'comment_content' => $comment,
			'song_mid' => $mid,
			'from_uid' => $user_id,
			'comment_time' => $date
		);
		$this->api->addComment($data);
		$content = $this->api->check_comment($mid);
		$json_type = json_encode($content);
		p($json_type);
		//p("发表成功");
	}
	/**
	 * 查看评论
	 *
	 * @return void
	 */
	public function checkComment(){
		$mid = $_POST['mid'];//歌曲mid
		//$mid = "003tefnw2xS3QA";
		$content = $this->api->check_comment($mid);
		$json_type = json_encode($content);
		p($json_type);
		//p("发表成功");
	}
	/**
	 * 协同算法
	 */
	public function test(){
		$train=array(  
			array(1,11),        //array(userid,itemid)  
			array(1,12),  
			array(1,14),  
			array(2,11),  
			array(2,13),  
			array(3,12),  
			array(3,15),  
			array(4,13),  
			array(4,14),  
			array(4,15),  
		);  
		$item_user=array(); //存放物品列表  
		for($i=0;$i<count($train);$i++){  
			$item=$train[$i][1];  
			$user=$train[$i][0];  
			$item_user[$item][]=$user;  
		}    
		$N=array(); //$N[u]表示用户u使用过的物品总数  
		$C=array(); //C[u][v]=|N(u)∩N(u)|  
		foreach($item_user as $user){  
			for($i=0;$i<count($user);$i++){  
				$N[$user[$i]]+=1;  
				for($j=0;$j<count($user);$j++){  
					if($user[$i]!=$user[$j]){  
						$C[$user[$i]][$user[$j]]+=1;  
					}  
				}  
			}  
		}  
		p($c);
		
	}
}  