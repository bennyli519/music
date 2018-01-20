
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 * @Author: jerryLi 
 * @Date: 2017-12-18 22:26:31 
 * @Last Modified by: jerryLi
 * @Last Modified time: 2017-12-18 22:26:31
 * 音乐专辑管理模型
 */
class Album_model extends CI_Model{
	/**
	 * 查询
	 */
	public function check(){
		$data = $this->db->select('song_id,song_name,album_name')->from('songs')
		->join('albums', 'songs.album_mid=albums.album_mid')
		->order_by('song_id', 'asc')->get()->result_array();
		return $data;
	}
	/**
	 * 添加
	 */

	public function add($data){
		$this->db->insert('albums',$data);
	}

	/**
	 * 编辑
	 */
	public function edit($uid, $data){
		$this->db->update('albums', $data, array('type_id'=>$uid));
	}
	/**
	 * 删除
	 */
	public function del($tid){
		$data = $this->db->delete('albums',array('type_id'=>$tid));
		return $data;
	}
	
}