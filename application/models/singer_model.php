
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 * @Author: jerryLi 
 * @Date: 2017-12-20 15:41:31 
 * @Last Modified by: jerryLi
 * @Last Modified time: 2017-12-20 15:50:31
 * 音乐类型管理模型
 */
class Singer_model extends CI_Model{
	/**
	 * 查询
	 */
	public function check(){
		$this->db->select('singer_name, singer_mid, singer_avtar,singer_findex');
		$data = $this->db->get('singers')->result_array();
		return $data;
	}
	/**
	 * 添加
	 */

	public function add($data){
		$this->db->insert('singers',$data);
	}

	/**
	 * 编辑
	 */
	public function edit($sid, $data){
		$this->db->update('singers', $data, array('singer_id'=>$sid));
	}
	/**
	 * 删除
	 */
	public function del($sid){
		$data = $this->db->delete('singers',array('singer_id'=>$sid));
		return $data;
	}
	
}