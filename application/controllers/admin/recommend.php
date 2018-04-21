

<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 * @Author: jerryLi 
 * @Date: 2018-3-9 12:27:21 
 * @Last Modified by: jerryLi
 * @Last Modified time:  2018-3-9 15:27:21 
 */

class recommend extends CI_Controller {
    /**
	 * 构造函数
	 */
	public function __construct(){
        parent::__construct();
        $this->load->model('api_model','api');
	}
    
    	/**
	 * 协同算法
	 */
	public function recom(){
	    //ItemCF  
		error_reporting(E_ALL&&~E_NOTICE);  
		$train = $this->api->get_collect();    //array(userid,itemid)  
		// e($train); //初始数据
		$W = $this->itemSimilarity($train);    //物品相似度
        echo "计算物品相似度<br>";
        e($W);
        $username = "benny";//推荐的用户名
        $a = $this->recommend($train,$username,$W,5);   //推荐歌曲
        echo '推荐给Benny的歌曲列表';
        e($a);
        
	}
    
	//计算相似度  
	function itemSimilarity($train){  
		$user_item=array(); //存放歌曲列表  
		for($i=0;$i<count($train);$i++){  
			$user=$train[$i]['user_name'];  //用户
            $item=$train[$i]['song_name'];  //歌曲名字
            $user_item[$user][]=$item;  
		}    
		echo "用户物品倒排表<br>";
		e($user_item);
		$N=array(); //$N[i]表示喜欢物品i的用户数   
		$C=array();  //C[i][j]=|N(i)∩N(j)|
		foreach($user_item as $item){  
            for($i=0;$i<count($item);$i++){  
				$N[$item[$i]]+=1;  
				// p($N);
                for($j=0;$j<count($item);$j++){  
                    if($item[$i]!=$item[$j]){  
                        $C[$item[$i]][$item[$j]]+=1;  
                    }  
                }  
            }  
		}  
        echo "计算共现矩阵C<br>";
        e($C);
		$W=array(); //$W[i][j]表示物品i和物品j的相似度  
        foreach($C as $key=>$value){  
            $i=$key;    //物品i  
            foreach($value as $j=>$cij){  
                $W[$i][$j]=$cij/sqrt($N[$i]*$N[$j]); //余弦相似度
            }  
        }              	
		return $W;
	}  
	
	//推荐算法  
	function recommend($train,$user_id,$W,$K){  
        $rank=array();  //用户对物品的感兴趣程度  
        //用户到物品倒排表,和itemSimilarity的重复，以后可以考虑合并或更换训练集的数据结构  
        $user_item=array();  
        for($i=0;$i<count($train);$i++){  
            $item=$train[$i]['song_name'];  
            $user=$train[$i]['user_name'];  
            $user_item[$user][]=$item;  
        }  
		$ru=$user_item[$user_id];   //用户喜欢的物品集合  
        foreach($ru as $i){  
			//$W[$i]表示和物品i相似的其他物品集合  
			//p($W[$i]);
            arsort($W[$i]);
            $count=0;   //计数器  
            foreach($W[$i] as $j=>$wij){  
            
                if(!in_array($j, $ru)){  
                    $rank[$j]+=$wij;  
				} 
				// echo $count;
				// $count++;  
				// if($count==$K) break;  			
            }  
        }  
		arsort($rank);
        return $rank;  
	}  
}