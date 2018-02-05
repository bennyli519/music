
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 * @Author: jerryLi 
 * @Date: 2018-02-05 22:26:31 
 * @Last Modified by: jerryLi
 * @Last Modified time: 2018-02-05
 * 音乐类型管理模型
 */
class SongList_model extends CI_Model{
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
		$this->db->insert('lists',$data);
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