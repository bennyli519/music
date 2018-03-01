

<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 * @Author: jerryLi 
 * @Date: 2017-12-17 12:27:21 
 * @Last Modified by: jerryLi
 * @Last Modified time: 2017-12-17 12:27:51
 */

class Admin extends CI_Controller {
    /**
	 * 构造函数
	 */
	public function __construct(){
		parent::__construct();
        $this->load->model('admin_model','admin');
	}
    /**
     * 登陆默认方法
     */
    public function index(){
        $this->load->helper('url');
        $this->load->view('index.html');
    }
    public function welcome(){
        $this->load->view('index_welcome.html');
    }
    /**
     * 添加管理员用户
     */
    public function add(){
        $this->load->helper('form');
        $this->load->view("music_user_add.html");
    }
    /**
     * 添加用户动作
     */
    public function add_user(){
        $username = $this->input->post("username");
        $usertype = $this->input->post("userType");//权限类型
        $newPwd  = $this->input->post('newPwd');//新密码
        $newPwd1 = $this->input->post('confirmPwd');//确认密码
        if($newPwd != $newPwd1) error('您所输入的新密码与确认密码不一致,请重新输入');

        $data = array(
            'user_name' => $username,
            'user_pwd'  => md5($newPwd),
            'user_type' => $usertype,
            'user_avtar'=>'http://thirdqq.qlogo.cn/g?b=sdk&k=7mqicicib2s1aJgvnEOpMQibiaQ&s=100&t=519'
        );

        $this->admin->add($data);
        success('admin/admin/add','添加成功');
    }
    /**
     * 修改后台管理员密码
     */
    public function reset(){
        $this->load->view('music_user_pwd_reset.html');
    }
    /**
     * 修改密码动作
     */
    public function reset_pwd(){

        // 查询用户名
        $username = $this->session->userdata('username');
		$userData = $this->admin->check($username);

        $pwd = $this->input->post('pwd');//获取原登陆密码
        if(md5($pwd) != $userData[0]['user_pwd']) error('原密码错误');

        $newPwd  = $this->input->post('newPwd');//新密码
        $newPwd1 = $this->input->post('confirmPwd');//确认密码
 
        if($newPwd != $newPwd1) error('您所输入的新密码与确认密码不一致,请重新输入');

        $uid = $this->session->userdata('uid');
        $data = array(
            'user_pwd' => md5($newPwd)
        );
        $this->admin->reset($uid,$data);
        success('admin/admin/reset', '修改成功');

    }
    /**
     * 查询前台用户
     */
    public function checkUser(){
        $data['user'] = $this->admin->checkUser();
        $this->load->view("music_user_check.html",$data);
    }
     /**
     *删除前台用户
     */
    public function delUser(){
        $id = $this->uri->segment(4);
		$this->admin->del($id);
		success('admin/admin/checkUser','删除成功');
    }
}