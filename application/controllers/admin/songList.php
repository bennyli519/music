
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 * @Author: jerryli519 
 * @Date: 2017-02-05 19:06:08 
 * @Last Modified by: jerryLi
 * @Last Modified time: 2018-03-01 03:01:02
 */

class SongList extends CI_Controller {
    /**
	 * 构造函数
	 */
	public function __construct(){
		parent::__construct();
		$this->load->helper('form');
		$this->load->model('api_model','api');
		$this->load->model('songList_model','list');
    }

    /**
     * 创建歌单视图加载
     */
    public function show_uplist(){
        $this->load->view("music-list/music-list-upload.html");
    }
	/**
	 * 查看歌单视图加载
	 */
	
	public function show_all(){
		$songlist['songlist'] = $this->list->check();
		$this->load->view("music-list/music-list-check.html",$songlist);
	}
    /**
     * 添加歌单动作
     */
    public function add_list(){
        $list_name = $this->input->post('list_name');
        $list_type = $this->input->post('list_type');
	    $list_author = $this->input->post('list_author');
        $list_intro = $this->input->post('list_intro');
        $list_date = $this->input->post('list_date');
 		
                
		$data = array(
			'list_name' => $list_name,
			'list_type' => $list_type,
			'list_author' => $list_author,
			'list_intro' => $list_intro,
			'list_publish' => $list_date
		);
		
		$this->list->add($data);
		success('admin/songlist/show_all','添加成功');
    }
	/**
	 * 修改视图
	 */
	public function edit_list(){
		$id = $this->uri->segment(4);//歌单id
		$data['list'] = $this->list->checkList($id);
		$a= $data['list'][0]['list_songs'];
		$arr = explode("/",$a);		//切割mid
		foreach($arr as $key => $item){
			$songList[] = $this->api->getListSong($item);//查询
		}	
		$data['list'][0]['list_songs'] = $songList;
		$this->load->view("music-list/music-list-edit.html",$data);
	}	
	/**
	 * 修改动作
	 *
	 * @return void
	 */
	public function update_list(){
		$songList = array();
		$listSize = $_POST['list'];//歌单歌曲条数
		echo 'aaa'.$listSize;
		for($i=0;$i<sizeof($listSize);$i++){
			$id = 'mid'.$i;
			echo 'bbb'.$id;
			//echo $_REQUEST[$id];
		}
		//p($songList);
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