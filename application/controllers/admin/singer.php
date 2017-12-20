<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 * @Author: jerryli519 
 * @Date: 2017-12-20 14:16:18 
 * @Last Modified by: jerryli519
 * @Last Modified time: 2017-12-20 15:44:08
 */

class Singer extends CI_Controller {
    /**
	 * 构造函数
	 */
	public function __construct(){
		parent::__construct();
		$this->load->helper('form');
        $this->load->model('singer_model','singer');
    }

    /**
     * 查看歌手视图加载
     */
    public function singer_view(){
        $this->load->view("music-singer/music-singer-upload.html");
    }
	/**
	 * 查看歌手视图加载
	 */
	
	public function singer_list_view(){
		$this->load->view("music-singer/music-singer-check.html");
	}
	
    /**
     * 添加歌手信息动作
     */
    public function add_type(){
    	//文件上传------------------------
		//配置
		$config['upload_path'] = './uploads/singers';
		$config['allowed_types'] = 'gif|jpg|png|jpeg';
		$config['max_size'] = '10000';
		$config['file_name'] = time() . mt_rand(1000,9999);

		//载入上传类
		$this->load->library('upload', $config);
		//执行上传
		$status = $this->upload->do_upload('image');
	
		$wrong = $this->upload->display_errors();

		if($wrong){
			error($wrong);
		}
		//返回信息
		$info = $this->upload->data();
		// p($info);die;

		//缩略图-----------------
		//配置
		$arr['source_image'] = $info['full_path'];
		$arr['create_thumb'] =TRUE;
		$arr['maintain_ratio'] = TRUE;
		$arr['max_width'] = 200;
		$arr['max_height'] = 200;	

		//载入缩略图类
		$this->load->library('image_lib', $arr);
		//执行动作
		$status = $this->image_lib->resize();

		if(!$status){
			error('缩略图动作失败');
		}
		
		
        $singer_name = $this->input->post('singer_name');
        $singer_type = $this->input->post('singer_type');
        $area = $this->input->post('area');
        $image = $info['file_name'];//上传图片路径
        $singer_birth = $this->input->post('singer_birth');
        $singer_intro = $this->input->post('singer_intro');
        $data = array(
			'singer_name' => $singer_name,
			'singer_type' => $singer_type,
			'singer_avtar'=> $image,
			'singer_area' => $area,
			'singer_birth'=> $singer_birth,
			'singer_intro'=> $singer_intro
		);
		
		$this->singer->add($data);
		success('admin/singer/singer_list_view','添加成功');

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
