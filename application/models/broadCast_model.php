
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 * @Author: jerryLi 
 * @Date: 2018-02-07 22:26:31 
 * @Last Modified by: jerryLi
 * @Last Modified time: 2018-02-05
 * 音乐类型管理模型
 */
class BroadCast_model extends CI_Model{
		/**
		 * 查询
		 */
		public function check(){
			$data = $this->db->get('broadcast')->result_array();
			return $data;
		}
		
		/**
		 * 编辑
		 */
		public function checkList($list_id){
			$this->db->where('broadcast_id',$list_id);
			$query = $this->db->select('broadcast_type,broadcast_list')
			->from('broadcast')->get()->result_array();
			return $query;
		}
		
		/**
		 * 添加
		 */
	
		public function add($data){
			$this->db->insert('broadcast',$data);
		}
		
		public function del($id){
			$data = $this->db->delete('broadcast',array('broadcast_id'=>$id));
			return $data;
		}
		
		/**
		 * 收入歌曲到电台
		 */
		public function addToBroadcast($broadcast_id, $data){
			$this->db->update('broadcast', $data, array('broadcast_id'=>$broadcast_id));
		}
	
		/**
		 * 热门  热度 (按收听量排行)
		 */
		public function hotSongs(){
			$this->db->limit(30);
			$songsList = $this->db->select('song_listencount,song_mid,song_name')
			->from('songs')
			->order_by('song_listencount','desc')
			->get()->result_array();
			return $songsList;
			
		}
	
		/**
		 * 18年最新
		 *
		 * @param [type] $mid
		 * @return void
		 */
		public function getNewSong(){
			$this->db->like('song_publish','2018');
			$this->db->limit(30);
			$data = $this->db->select('song_mid,song_name,song_publish')
			->from('songs')
			->order_by('song_listencount','desc')
			->get()->result_array();
			return $data;
		}
	
		/**
		 * 随心听 
		 */
		public function SongRadom(){
			$this->db->order_by('song_id', 'RANDOM');
			$this->db->limit(30);
			$songsList = $this->db->select('song_mid,song_name')
			->from('songs')
			->get()->result_array();
			return $songsList;
			
		}
		
		
		/**
		 * 精选
		 */
		public function SongSelect(){
			$this->db->order_by('song_listencount', 'RANDOM');
			$this->db->limit(30);
			$songsList = $this->db->select('song_mid,song_name')
			->from('songs')
			->get()->result_array();
			return $songsList;
			
		}
	
}