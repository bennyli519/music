
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
		$data = $this->db->get('type')->result_array();
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
	public function edit($uid, $data){
		$this->db->update('type', $data, array('type_id'=>$uid));
	}
	/**
	 * 删除
	 */
	public function del($tid){
		$data = $this->db->delete('type',array('type_id'=>$tid));
		return $data;
	}
	
}