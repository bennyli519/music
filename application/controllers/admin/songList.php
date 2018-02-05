
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 * @Author: jerryli519 
 * @Date: 2017-02-05 19:06:08 
 * @Last Modified by: jerryli519
 * @Last Modified time: 2017-02-05 19:06:08 
 */

class SongList extends CI_Controller {
    /**
	 * 构造函数
	 */
	public function __construct(){
		parent::__construct();
		$this->load->helper('form');
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
		$this->load->view("music-list/music-list-check.html");
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
		success('admin/type/show_all','添加成功');
    }
	/**
	 * 修改动作
	 */
	public function edit_type(){
		$tid = $_GET['id'];//ajax 获取当前id
		$data = array(
			'type_name' => $_GET['type']
		);
		$this->type->edit($tid,$data);
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