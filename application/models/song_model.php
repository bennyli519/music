
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 * @Author: jerryLi 
 * @Date: 2017-12-23 16:53:01 
 * @Last Modified by: jerryLi
 * @Last Modified time: 2017-12-23 17:32:52
 * 歌曲模型
 */

class Song_model extends CI_Model{
	/**
	 * 查询
	 */
	public function check(){
		$data = $this->db->get('songs')->result_array();
		return $data;
	}
	/**
	 * 添加
	 */

	public function add($data){
		$this->db->insert('songs',$data);
	}

	/**
	 * 编辑
	 */
	public function edit($sid, $data){
		$this->db->update('songs', $data, array('song_id'=>$sid));
	}
	/**
	 * 删除
	 */
	public function del($sid){
		$data = $this->db->delete('songs',array('song_id'=>$sid));
		return $data;
	}
	
}