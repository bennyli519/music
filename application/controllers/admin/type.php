
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 * @Author: jerryli519 
 * @Date: 2017-12-18 19:06:08 
 * @Last Modified by: jerryli519
 * @Last Modified time: 2017-12-18 19:16:55
 */

class Type extends CI_Controller {
    /**
	 * 构造函数
	 */
	public function __construct(){
		parent::__construct();
        $this->load->model('type_model','type');
    }

    /**
     * 音乐类型视图加载
     */
    public function show_type(){
        $this->load->view("music-type/music-type-add.html");
    }
    /**
     * 添加音乐类型动作
     */
    public function add_type(){
        $muisc_type_name = $this->input->post('music_type_name');
    }
}