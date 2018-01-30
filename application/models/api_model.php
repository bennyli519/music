
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 * @Author: jerryLi 
 * @Date: 2017-12-20 15:41:31 
 * @Last Modified by: jerryLi
 * @Last Modified time: 2017-12-20 15:50:31
 * 音乐类型管理模型
 */
class Api_model extends CI_Model{
	/**
	 * 查询歌手信息
	 */
	public function checkSingers(){
		$this->db->select('singer_name, singer_mid, singer_avtar,singer_findex');
		$data = $this->db->get('singers')->result_array();
		return $data;
	}
	/*
	 *查询歌手对应的歌曲信息 
	 */
	public function checkSongs($mid){
		$this->db->like('songs.singer_mid', $mid);
		$data = $this->db->select('song_id, song_mid, song_name,songs.album_mid,albums.album_name,song_duration,
		song_publish,song_listencount,song_source,singers.singer_name')->from('songs')
		->join('singers', 'songs.singer_mid=singers.singer_mid')
		->join('albums','songs.album_mid=albums.album_mid')
		->order_by('song_id', 'asc')->get()->result_array();
//		$data = $this->db->get('songs')->result_array();
		return $data;
	}
	/**
	 * 0 港台 热度 (按收听量排行)
	 */
	public function hotHkSongs(){
//		$query = $this->db->get_where('songs', array('id' => $id), $limit, $offset);
//		$this->db->select('song_mid,song_name,songs.album_mid,singers.singer_name,singer_type')
//		->from('songs')
//		->join('singers', 'songs.singer_mid=singers.singer_mid')
//		->order_by('song_listencount','asc')
//		->get()->result_array();
////		
//		$singers = $this->db->get_where('singers',array('singer_area' => '0'),10)->result_array();
//		return $singers;
		$this->db->where('singer_area', '0');
		$this->db->limit(30);
		$singers = $this->db->select('song_listencount,song_mid,song_name,singers.singer_name,singer_area')
		->from('songs')
		->join('singers', 'songs.singer_mid=singers.singer_mid')
		->order_by('song_listencount','desc')
		->get()->result_array();
		return $singers;
		
	}

}