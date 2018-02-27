
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
        $this->load->model('album_model','album');
        $this->load->model('songList_model','list');
    }

    /**
     * 上传歌曲视图加载
     */
    public function song_view(){
        $data['type'] = $this->type->check(); //调取音乐类型
        $data['singer'] = $this->singer->check();//调取歌手
        $this->load->view("music-song/music-song-upload.html",$data);
    }
	
		
	/**
	 * 查看歌曲视图加载（分页）
	 */
	
	public function song_list_view(){
		//后台设置后缀为空，否则分页出错
		$this->config->set_item('url_suffix', '');
		//载入分页类
		$this->load->library('pagination');
		$perPage = 10;

		//配置项设置
		$config['base_url'] = site_url('admin/song/song_list_view');
		$config['total_rows'] = 2340;
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
		
		$data['song'] = $this->song->check();
		$data['songlist'] = $this->list->check();
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
        $singer_mid = $this->input->post('singer_mid');
       //专辑名(暂时用爬来来的专辑,如果自己添加歌曲，插入专辑名+自己制作mid作为主键)
        $ablum_name = $this->input->post('album_name');
        $song_source = $info['song'];//上传MP3文件
        $song_lyics = $info['lyics'];//上传歌词文件
        $song_date = $this->input->post('song_date');
        
        $data = array(
			'song_name'   => $song_name,
            'song_publish'   => $song_date,
            'song_source' => $song_source['file_name'],
			'song_lyics'  => $song_lyics['file_name'],
			'type_id'     => $song_type,
			'singer_mid'   => $singer_mid
		);
		$this->song->add($data);
		success('admin/song/song_list_view','添加成功');

    }
    /**
     * 添加到歌单
     */
    public function add_to_List(){
    	$song_mid = $this->uri->segment(4);
    	$list_id = $this->uri->segment(5);
    	$data = array(
    		'list_songs' => $song_mid
    	);
    	//$data['list_songs'];
    	$listsong = $this->list->checkList($list_id);//先查歌单里头有没有歌曲
    //	p($listsong['list_songs']);
    	if($listsong[0]['list_songs'] == ""){
    		$data['list_songs'] = $listsong[0]['list_songs'].$data['list_songs'];
    	}else{
    		$data['list_songs'] = $listsong[0]['list_songs'].'/'.$data['list_songs'];
    	}
    
    	$this->list->edit($list_id,$data);
    	success('admin/song/song_list_view','添加成功');
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

	public function readSong(){
		set_time_limit(0);
		$path = base_url()."songs.txt";		
		$file = fopen($path, "r");
		$songsList = array();
		$i = 0;
		while(!feof($file))
		{
		 $songsList[$i]= fgets($file);//fgets()函数从文件指针中读取一行
		 $i++;
		}
		fclose($file);
		$songsList=array_filter($songsList);
		for($i=0;$i< sizeof($songsList);$i++){
			$mid = substr($songsList[$i],36,14);
			echo $mid.'<br>';
			$data = array(
				'song_source'  => $songsList[$i],
			);
		}	
		
	}
	public function getSongsMes(){
		header('Access-Control-Allow-Origin: *');
		header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
		header('Access-Control-Allow-Methods: GET, POST, PUT,DELETE');
     	$songs = $_POST['songs'];
     	for( $i=0; $i < sizeof($songs); $i++){

     			$song_mid = $songs[$i][1];
     			$song_name = $songs[$i][3];
				$song_duration = $songs[$i][6];
     			$song_listencount = $songs[$i][9];
     			$song_uploadtime = $songs[$i][8];
     			$singer_mid = $songs[$i][2];
     			$ablum_mid = $songs[$i][5];
     			$ablum_name = $songs[$i][4];
     			$type_id = rand(1,10);
//				$data = array(
//						'song_mid'  => $song_mid,
//			     		'song_name' => $song_name,
//			     		'song_duration' => $song_duration,
//			     		'song_listencount' => $song_listencount,
//						'song_publish'=> $song_uploadtime,
//						'singer_mid' => $singer_mid,
//						'album_mid' => $ablum_mid,
//						'type_id' => $type_id
//				);
				$data = array(
						'album_name' => $ablum_name,
						'album_mid' => $ablum_mid
				);

			
     	}

	}
	
}
 