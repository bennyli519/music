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
     * 上传歌手视图加载
     */
    public function singer_view(){
        $this->load->view("music-singer/music-singer-upload.html");
    }
	/**
	 * 查看歌手视图加载（分页）
	 */
	
	public function singer_list_view(){
		//后台设置后缀为空，否则分页出错
		$this->config->set_item('url_suffix', '');
		//载入分页类
		$this->load->library('pagination');
		$perPage = 5;

		//配置项设置
		$config['base_url'] = site_url('admin/singer/singer_list_view');
		$config['total_rows'] = $this->db->count_all_results('singers');
		$config['per_page'] = $perPage;
		$config['uri_segment'] = 4;
		
		$config['full_tag_open'] = '<ul class="pagination">';  
        $config['full_tag_close'] = '</ul>';  
        $config['first_tag_open'] = '<li>';  
        $config['first_tag_close'] = '</li>';  
        $config['prev_tag_open'] = '<li>';  
        $config['prev_tag_close'] = '</li>';  
        $config['next_tag_open'] = '<li>';  
        $config['next_tag_close'] = '</li>';  
        $config['cur_tag_open'] = '<li class="active"><a>';  
        $config['cur_tag_close'] = '</a></li>';  
        $config['last_tag_open'] = '<li>';  
        $config['last_tag_close'] = '</li>';  
        $config['num_tag_open'] = '<li>';  
        $config['num_tag_close'] = '</li>';  

		$config['first_link']= '首页';  
        $config['next_link']= '>';  
        $config['prev_link']= '<';  
        $config['last_link']= '末页'; 
        
		$this->pagination->initialize($config);

		$data['links'] = $this->pagination->create_links();
		// p($data);die;
		$offset = $this->uri->segment(4);
		$this->db->limit($perPage, $offset);
		
		$data['singer'] = $this->singer->check();
		$this->load->view("music-singer/music-singer-check.html",$data);
	}
	
    /**
     * 添加歌手信息动作
     */
    public function add_singer(){
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
	 * 歌手信息修改动作
	 */
	public function edit_singer(){
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
	public function del_singer(){
		$sid = $this->uri->segment(4);
		$this->singer->del($sid);
		success('admin/singer/singer_list_view','删除成功');
	}
	
	public function getSingerMes(){
		header('Access-Control-Allow-Origin: *');
		header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
		header('Access-Control-Allow-Methods: GET, POST, PUT,DELETE');
     	$singer = $_POST['singer'];
     	echo($singer[0]['items'][0][1]);
     	for( $i=0; $i < sizeof($singer); $i++){
     		    		
     		for( $j=0;$j< sizeof($singer[$i]['items']);$j++){
     			$singer_mid = $singer[$i]['items'][$j][0];
     			$singer_name = $singer[$i]['items'][$j][1];
     			$singer_findex = $singer[$i]['items'][$j][2];
     			$singer_type =  $singer[$i]['items'][$j][3];
     			$singer_area = $singer[$i]['items'][$j][4];
//   			$singer_gender = $singer[$i]['items'][$j][5];
     			$image = $singer[$i]['items'][$j][6];
     			
				$data = array(
						'singer_mid'  => $singer_mid,
			     		'singer_name' => $singer_name,
			     		'singer_findex' => $singer_findex,
			     		'singer_type' => $singer_type,
						'singer_avtar'=> $image,
						'singer_area' => $singer_area,
						'singer_birth'=> "1980-02-12",
						'singer_intro'=> "大家好我是".$singer_name  	
				);
				p($data);
//				$this->singer->add($data);

     		}
     	}
         
	}
	
	
}
