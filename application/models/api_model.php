
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
	
	/**
	 * 通过歌曲Id查询排行榜前三歌曲
	 *
	 * @param [type] $mid
	 * @return void
	 */
	public function getOnlySong($mid){
		$this->db->where('song_mid',$mid);
		$data = $this->db->select('song_name,singers.singer_name')->from('songs')
		->join('singers', 'songs.singer_mid=singers.singer_mid')
		->get()->row_array();
		return $data;
		
	}
	
	/**
	 * 分类 (歌曲类型)
	 */
	public function checkType(){
		$typeList = $this->db->get('type')->result_array();
		return $typeList;
	}

	/**
	 *  歌曲类型详情(传类型id)
	 *
	 * @param [type] $type_id
	 * @return void
	 */
	public function checkTypeSongList($type_id){
		$this->db->limit(30);
		$this->db->where('type_id',$type_id);
		$typeSongList = $this->db->select('song_listencount,type_id,song_id,song_mid,song_name,song_duration,singers.singer_name,singer_area,songs.album_mid,albums.album_name')
		->from('songs')
		->join('singers', 'songs.singer_mid=singers.singer_mid')
		->join('albums','songs.album_mid=albums.album_mid')
		->order_by('song_listencount','desc')
		->get()->result_array();
		return $typeSongList;
	}

	/**
	 * 歌手类别详情查询（0 港台 1大陆 3 欧美） 按发行时间排序
	 *
	 * @param [type] $areaIndex
	 * @return void
	 */
	public function checkSingerTypeList($areaIndex){
		$this->db->where('singer_area',$areaIndex);
		$this->db->limit(100);
		$singers = $this->db->select('song_listencount,song_id,song_mid,song_name,song_duration,singers.singer_name,singer_area,songs.album_mid,albums.album_name')
		->from('songs')
		->join('singers', 'songs.singer_mid=singers.singer_mid')
		->join('albums','songs.album_mid=albums.album_mid')
		->order_by('song_listencount','desc')
		->get()->result_array();
		return $singers;
	}

	/**
	 * 分类 (年代详情查询)ist
	 */
	public function checkDateTimeList($date){
		$this->db->like('song_publish', $date);
		$this->db->limit(100);
		$songList =  $this->db->select('song_publish,song_listencount,song_id,song_mid,song_name,song_duration,singers.singer_name,songs.album_mid,albums.album_name')
		->from('songs')
		->join('singers', 'songs.singer_mid=singers.singer_mid')
		->join('albums','songs.album_mid=albums.album_mid')
		->order_by('song_publish','asc')
		->get()->result_array();
		return $songList;
	}
	/**
	 *  歌单查询
	 */
	public function checkSonglist(){
		$songList = $this->db->select('list_id,list_name,list_total,list_intro,list_thumb,list_author,list_songs')
		->from('lists')
		->order_by('list_total','desc')
		->get()->result_array();
		return $songList;
	}
	/**
	 *  歌单详情查询
	 */
	public function checkDetailSonglist($list_id){
		$this->db->where('list_id',$list_id);
		$songList = $this->db->select('list_songs')
		->from('lists')
		->order_by('list_total','desc')
		->get()->result_array();
		return $songList;
	}
		/**
	 * 通过歌单Id查询歌曲
	 *
	 * @param [type] $mid
	 * @return void
	 */
	public function getListSong($mid){
		$this->db->where('song_mid',$mid);
		$data = $this->db->select('song_id,song_mid,song_name,song_duration,singers.singer_name,songs.album_mid,albums.album_name')->from('songs')
		->join('singers', 'songs.singer_mid=singers.singer_mid')
		->join('albums','songs.album_mid=albums.album_mid')
		->get()->row_array();
		return $data;
		
	}
	/**
	 * 新歌速递
	 *
	 * @param [type] $mid
	 * @return void
	 */
	public function getNewSong(){
		$this->db->limit(10);
		$data = $this->db->select('song_publish,song_id,song_mid,song_name,song_duration,singers.singer_name,songs.album_mid,albums.album_name')->from('songs')
		->join('singers', 'songs.singer_mid=singers.singer_mid')
		->join('albums','songs.album_mid=albums.album_mid')
		->order_by('song_publish','desc')
		->get()->result_array();
		return $data;
	}
		
	/**
	 *  电台查询
	 */
	public function checkCastlist(){
		$castList = $this->db->select('broadcast_id,broadcast_name,broadcast_author,broadcast_intro,broadcast_list,broadcast_thumb,broadcast_count')
		->from('broadcast')
		->order_by('broadcast_type','asc')
		->get()->result_array();
		return $castList;
	}
	/**
	 *  电台详情查询
	 */
	public function checkDetailCastList($cast_id){
		$this->db->where('broadcast_id',$cast_id);
		$songList = $this->db->select('broadcast_list')
		->from('broadcast')
		->get()->result_array();
		return $songList;
	}
}