
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 * @Author: jerryli519 
 * @Date: 2017-02-05 19:06:08 
 * @Last Modified by: jerryli519
 * @Last Modified time: 2017-02-05 19:06:08 
 */

class Broadcast extends CI_Controller {
    /**
	 * 构造函数
	 */
	public function __construct(){
		parent::__construct();
		$this->load->helper('form');
		$this->load->model('broadCast_model','broad');
    }

    /**
     * 创建歌单视图加载
     */
    public function show_uplist(){
        $this->load->view("music-broadcast/music-broadcast-upload.html");
    }
	/**
	 * 查看歌单视图加载
	 */
	
	public function show_all(){
		$broadcast['broadcast'] = $this->broad->check();
		$this->load->view("music-broadcast/music-broadcast-check.html",$broadcast);
	}
    /**
     * 添加信息到电台动作
     */
    public function add_list(){
        $borad_name = $this->input->post('borad_name');
        $borad_type = $this->input->post('borad_type');
	    $borad_author = $this->input->post('borad_author');
        $borad_intro = $this->input->post('borad_intro');
        $borad_date = $this->input->post('borad_date');
 		              
		$data = array(
			'broadcast_name' => $borad_name,
			'broadcast_type' => $borad_type,
			'broadcast_author' => $borad_author,
			'broadcast_intro' => $borad_intro,
			'broadcast_publish' => $borad_date
		);
		$this->broad->add($data);
		success('admin/broadcast/show_all','添加成功');
	}
	/**
	 * 处理歌曲id 并且添加到电台表中
	 */
	public function getMidList($arr,$cast_id){
		$midList = "";
		foreach($arr as $value){
			$midList = $midList.$value['song_mid'].'/';
		}
		$midData = array(
			'broadcast_list' => rtrim($midList, "/")
		);
		p($midData);
		$this->broad->addToBroadcast($cast_id,$midData);
		success("admin/broadcast/show_all","收录成功");
	}

	/**
	 * 添加歌曲到对应电台
	 */
	public function update_broadcast(){
		//broadcast类型 1个性 2精选 3热门 4最新 5随心听
		$cast_id = $this->uri->segment(4);
		$data = $this->broad->checkList($cast_id);
	
		switch($data[0]['broadcast_type'])
		{
			case 1:
				//个性电台
			break;
			case 2:
				//精选
				$songSelect = $this->broad->SongSelect();
				$this->getMidList($songSelect,$cast_id);
				break;
			case 3:
				//热门
				$hotSong = $this->broad->hotSongs();
				$this->getMidList($hotSong,$cast_id);
				break;
			case 4:
				//最新
				$newSongList = $this->broad->getNewSong();
				$this->getMidList($newSongList,$cast_id);
				break;
			default:
				//随心听
				$randomList = $this->broad->SongRadom();
				$this->getMidList($randomList,$cast_id);
	
		};

	}
	

	/**
	 * 删除动作
	 */
	public function del_type(){
		$tid = $this->uri->segment(4);
		$this->type->del($tid);
		success('admin/type/show_all','删除成功');
	}
	
}