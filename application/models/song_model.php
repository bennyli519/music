
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 * @Author: jerryLi 
 * @Date: 2017-12-23 16:53:01 
 * @Last Modified by: jerryLi
 * @Last Modified time: 2017-12-24 00:25:52
 * 歌曲模型
 */

class Song_model extends CI_Model{
	/**
	 * 查询
	 */
	
	public function check(){
		$data = $this->db->select('song_id,song_name,singer_name,type_name')->from('songs')
		->join('singers', 'songs.singer_mid=singers.singer_mid')
		->join('type','songs.type_id=type.type_id')
		->order_by('song_id', 'asc')->get()->result_array();
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
		$this->db->update('songs', $data, array('song_mid'=>$sid));
	}
	/**
	 * 删除
	 */
	public function del($sid){
		$data = $this->db->delete('songs',array('song_id'=>$sid));
		return $data;
	}
	
}