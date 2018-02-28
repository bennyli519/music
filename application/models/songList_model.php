
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 * @Author: jerryLi 
 * @Date: 2018-02-05 22:26:31 
 * @Last Modified by: jerryLi
 * @Last Modified time: 2018-03-01 02:09:04
 * 音乐类型管理模型
 */
class SongList_model extends CI_Model{
	/**
	 * 查询
	 */
	public function check(){
		$data = $this->db->get('lists')->result_array();
		return $data;
	}
	
	/**
	 * 编辑
	 */
	public function checkList($list_id){
		$this->db->where('list_id',$list_id);
		$query = $this->db->select('list_name,list_type,list_intro,list_author,list_songs')
		->from('lists')->get()->result_array();
		return $query;
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
	public function edit($list_id, $data){
		$this->db->update('lists', $data, array('list_id'=>$list_id));
	}
	/**
	 * 删除
	 */
	public function del($tid){
		$data = $this->db->delete('type',array('type_id'=>$tid));
		return $data;
	}
	
}