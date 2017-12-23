
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 * @Author: jerryLi 
 * @Date: 2017-12-23 12:53:08 
 * @Last Modified by: jerryLi
 * @Last Modified time: 2017-12-24 00:29:46
 */

class Song extends CI_Controller {
    /**
	 * 构造函数
	 */
	public function __construct(){
		parent::__construct();
		$this->load->helper('form');
        $this->load->model('type_model','type');//加载音乐类型模型
        $this->load->model('singer_model','singer');//加载歌手音乐模型
        $this->load->model('song_model','song');
    }

    /**
     * 查看歌曲视图加载
     */
    public function song_view(){
        $data['type'] = $this->type->check(); //调取音乐类型
        $data['singer'] = $this->singer->check();//调取歌手
        $this->load->view("music-song/music-song-upload.html",$data);
    }
	/**
	 * 查看歌曲视图加载
	 */
	
	public function song_list_view(){
        $data['song'] = $this->song->check();
		$this->load->view("music-song/music-song-check.html",$data);
	}
	
    /**
     * 添加歌曲信息动作
     */
    public function add_song(){
    	//多文件上传------------------------
		//配置

        $upload_config = array(
            'upload_path' =>  './uploads/music_files',
            'allowed_types' => '*',
            'max_size' => '10000',
            'file_name'=> time() . mt_rand(1000,9999)
          );
        $this->load->library('upload');
        $this->upload->initialize($upload_config);
        //循环处理上传文件
        foreach ($_FILES as $key => $value) {
                if (!empty($key['name'])) {
                    $this->upload->do_upload($key);
                }
                if ($this->upload->do_upload($key)) {
                    //上传成功
                    $info[$key] = $this->upload->data();
                } else {
                    //上传失败
                    echo $this->upload->display_errors();
                }
            
        }
        $song_name = $this->input->post('song_name');
        $song_type = $this->input->post('type_id');
        $singer_id = $this->input->post('singer_id');
        $song_source = $info['song'];//上传MP3文件
        $song_lyics = $info['lyics'];//上传歌词文件
        $song_date = $this->input->post('song_date');
        
        $data = array(
			'song_name'   => $song_name,
            'song_publish'   => $song_date,
            'song_source' => $song_source['file_name'],
			'song_lyics'  => $song_lyics['file_name'],
			'type_id'     => $song_type,
			'singer_id'   => $singer_id
		);
		$this->song->add($data);
		success('admin/singer/singer_list_view','添加成功');

    }
    
	/**
	 * 歌曲信息修改动作
	 */
	public function edit_song(){
		$sid = $_GET['id'];//ajax 获取当前id
		$intro = $_GET['intro'];
		
		$data = array(
			'singer_intro' => $intro
		);
		$this->singer->edit($sid,$data);
	}
	
	/**
	 * 删除动作
	 */
	public function del_song(){
		$sid = $this->uri->segment(4);
		$this->song->del($sid);
		success('admin/song/song_list_view','删除成功');
	}
	
}
