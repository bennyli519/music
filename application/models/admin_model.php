
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 * @Author: jerryLi 
 * @Date: 2017-12-17 19:26:37 
 * @Last Modified by: jerryLi
 * @Last Modified time: 2017-12-17 20:04:31
 * 后台用户管理模型
 */
class Admin_model extends CI_Model{
	/**
	 * 查询后台用户数据
	 */
	public function check($username){
		// $this->db->where(array('username'=>$username))->get('admin')->result_array();
		$data = $this->db->get_where('users', array('user_name'=>$username,'user_type'=>'0'))->result_array();
		return $data;
	}

	/**
	 * 修改密码
	 */
	public function reset($uid, $data){
		$this->db->update('admin', $data, array('aid'=>$uid));
	}

	
}