
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
		song_publish,song_listencount,singers.singer_name')->from('songs')
		->join('singers', 'songs.singer_mid=singers.singer_mid')
		->join('albums','songs.album_mid=albums.album_mid')
		->order_by('song_id', 'asc')->get()->result_array();
		return $data;
	}
	
	/**
	 * 港台  大陆 日韩 欧美 热度 (按收听量排行)
	 */
	public function hotAreaSongs($areaIndex){
		$this->db->where('singer_area',$areaIndex);
		$this->db->limit(30);
		$singers = $this->db->select('song_listencount,song_id,song_mid,song_name,song_duration,singers.singer_name,singer_area,songs.album_mid,albums.album_name')
		->from('songs')
		->join('singers', 'songs.singer_mid=singers.singer_mid')
		->join('albums','songs.album_mid=albums.album_mid')
		->order_by('song_listencount','desc')
		->get()->result_array();
		return $singers;
		
	}
	
	/**
	 * 热门  热度 (按收听量排行)
	 */
	public function hotSongs(){
		$this->db->limit(30);
		$singers = $this->db->select('song_listencount,song_id,song_mid,song_name,song_duration,singers.singer_name,singer_area,songs.album_mid,albums.album_name')
		->from('songs')
		->join('singers', 'songs.singer_mid=singers.singer_mid')
		->join('albums','songs.album_mid=albums.album_mid')
		->order_by('song_listencount','desc')
		->get()->result_array();
		return $singers;
		
	}
	
	/**
	 * 排行榜页
	 */
	public function TopList(){
		$topList = $this->db->select('listenCount,rank_picUrl,rank_topTitle,rank_songList,rank_type')
		->from('rank')
	//	->join('songs', 'songs.song_mid=r.singer_mid')
//		->join('albums','songs.album_mid=albums.album_mid')
		->order_by('listencount','desc')
		->get()->result_array();
		return $topList;
		
	}
	
	public function getOnlySong($mid){
		$this->db->where('song_mid',$mid);
		$data = $this->db->select('song_name,singers.singer_name')->from('songs')
		->join('singers', 'songs.singer_mid=singers.singer_mid')
		->get()->row_array();
		return $data;
		
	}

}