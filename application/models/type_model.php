
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 * @Author: jerryLi 
 * @Date: 2017-12-18 22:26:31 
 * @Last Modified by: jerryLi
 * @Last Modified time: 2017-12-18 22:26:31
 * 音乐类型管理模型
 */
class Type_model extends CI_Model{
	/**
	 * 查询
	 */
	public function check(){
		$data = $this->db->get('type')->result_array();
		return $data;
	}
	/**
	 * 添加
	 */

	public function add($data){
		$this->db->insert('type',$data);
	}

	/**
	 * 编辑
	 */
	public function reset($uid, $data){
		$this->db->update('type', $data, array('user_id'=>$uid));
	}

	
}