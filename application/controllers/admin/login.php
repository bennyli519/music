
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 * @Author: jerryli519 
 * @Date: 2017-12-15 18:56:11 
 * @Last Modified by: jerryli519
 * @Last Modified time: 2017-12-15 19:17:21
 */

class Login extends CI_Controller {
    /**
     * 登陆默认方法
     */
    public function index(){
        $this->load->helper('url');
        $this->load->view('login.html');
    }
}