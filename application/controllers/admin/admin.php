

<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 * @Author: jerryLi 
 * @Date: 2017-12-17 12:27:21 
 * @Last Modified by: jerryLi
 * @Last Modified time: 2017-12-17 12:27:51
 */

class Admin extends CI_Controller {
    /**
     * 登陆默认方法
     */
    public function index(){
        $this->load->helper('url');
        $this->load->view('index.html');
    }
}