
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 * @Author: jerryli519 
 * @Date: 2017-12-15 18:56:11 
 * @Last Modified by: jerryLi
 * @Last Modified time: 2017-12-17 20:33:22
 */

class Login extends CI_Controller {
    /**
     * 登陆默认方法
     */
    public function index(){
        $this->load->view('login.html');
    }

    /**
     * 登录动作
     */
    public function login_in(){
        // 检查是否开启session
        if(!isset($_SESSION)){
            session_start();
        }
        $this->load->model('admin_model','admin');//加载admin数据模型并且设admin简称

        $username = $this->input->post('username');//获取表单用户名
        $password = $this->input->post('password');//获取表单密码
        $userData = $this->admin->check($username);//查询
        if(!$userData || $userData[0]['user_pwd'] != md5($password)) error('用户名或者密码不正确');
 
        $sessionData = array(
			'username'	=> $username,
            'uid'		=> $userData[0]['user_id'],
            'avtar'     => $userData[0]['user_avtar'],//图片路径
			'logintime' => time()
			);
        //存储登录信息到session
        $this->session->set_userdata($sessionData);
        success('admin/admin/index', '登陆成功');  
    }

    /**
	 * 退出登陆
	 */
	public function login_out(){
		$this->session->sess_destroy();
		success('admin/login/index','退出成功');
	}

}