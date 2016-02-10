<?php
	class Referral_model extends CI_Model
	{
		public $table_name = 'referral';
		
		//初始化模型
		public function __construct()
		{
			$this->load->database();
		}
		
		/* 以下是referral分析函数 */
		//获取所有推广，或根据activity_id、ad_id、poster_id、spreader_type、spreader_id等字段内容获取相应数据
		public function select($index_type, $index_content)
		{
			$data = array();
			$this->db->order_by('time_visit', 'desc');
			
			$this->db->select($this->table_name.'.*, stuff.lastname AS spreader_lastname, stuff.firstname AS spreader_firstname,  user.lastname AS user_lastname, user.firstname AS user_firstname');
			$this->db->join('stuff', $this->table_name.'.spreader_id = stuff.stuff_id', 'left');
			$this->db->join('user', $this->table_name.'.user_id = user.user_id', 'left');
			
			$data[$index_type] = $index_content;
			$query = $this->db->get_where($this->table_name, $data);
			return $query->result_array();
		}
		
		//统计某营销活动个人推广情况
		public function analyse($activity_id = FALSE , $spreader_type = FALSE)
		{
			$data = array();

			$this->db->group_by('spreader_id');
			$this->db->order_by('count(spreader_id)', 'desc');

			if($activity_id != FALSE):
				$data['activity_id'] = $activity_id;
			endif;
			if($spreader_type != FALSE):
				$data['spreader_type'] = $spreader_type;
			endif;
			
			$this->db->select($this->table_name.'.spreader_id , count('.$this->table_name.'.spreader_id) AS spreader_sum, stuff.lastname AS spreader_lastname, stuff.firstname AS spreader_firstname');
			$this->db->join('stuff', $this->table_name.'.spreader_id = stuff.stuff_id', 'left');
			
			$query = $this->db->get_where($this->table_name, $data);
			return $query->result_array();
		}

		
		//统计某营销活动总流量
		public function sum_activity($activity_id = FALSE)
		{
			$data = array();

			if ($activity_id != FALSE):
				$data['activity_id'] = $activity_id;
			endif;
			
			$this->db->where($data);
			$this->db->from($this->table_name);
			return $this->db->count_all_results();
		}
		
		//统计某广告总流量
		public function sum_ad($ad_id = FALSE)
		{
		
		}
		
		//统计某广告位总流量
		public function sum_poster($poster_id = FALSE)
		{
		
		}

		/* 以下是referral操作函数 */
		//根据给定的参数查找相应的记录是否存在
		public function find($user_ip = NULL, $activity_id = NULL, $ad_id = NULL, $poster_id = NULL, $spreader_type = NULL, $spreader_id = NULL)
		{
			$data = array(
				'user_ip' => $user_ip,
				'activity_id' => $activity_id,
				'ad_id' => $ad_id,
				'poster_id' => $poster_id,
				'spreader_type' => $spreader_type,
				'spreader_id' => $spreader_id
			);
			
			$query = $this->db->get_where($this->table_name, $data);
			$result = $query->row_array();
			
			if(empty($result)):
				return false;
			elseif((time()-$result['timestamp_visit']) < 43200): // 若符合条件的记录产生于12小时之内则返回该记录referral_id
				return $result['referral_id'];
			else:
				return false;
			endif;
		}

		//根据给定的referral_id将对应的time_visit和timestamp_visit更改为现在时间
		public function update_time($referral_id)
		{
			$data = array(
				'time_visit' => date('Y-m-d H:i:s'),
				'timestamp_visit' => time()
			);
			$this->db->where('referral_id', $referral_id);
			return $this->db->update($this->table_name, $data);
		}

		//根据activity_id查询activity表中是否存在该活动
		public function search_activity($activity_id)
		{
			$data['activity_id'] = $activity_id;
			$query = $this->db->get_where('activity', $data);
			return $query->row_array();
		}

		//新增访问流水
		public function create($user_agent, $user_ip, $activity_id, $ad_id, $poster_id, $spreader_type, $spreader_id)
		{
			$data = array(
				'user_agent' => $user_agent,
				'user_ip' => $user_ip,
				'activity_id' => $activity_id,
				'ad_id' => $ad_id,
				'poster_id' => $poster_id,
				'spreader_type' => $spreader_type,
				'spreader_id' => $spreader_id,
				'timestamp_visit' => time()
			);

			if($this->input->cookie('qdd_user_id')):
				$data['user_id'] = $this->input->cookie('qdd_user_id');
			endif;
			if($this->input->server('HTTP_REFERER')):
				$data['user_referer'] = $this->input->server('HTTP_REFERER');
			endif;
		
			//若成功添加访问流水，则返回该流水ID
			if(!$this->db->insert($this->table_name, $data)):
				return FALSE;
			else:
				return $this->db->insert_id();
			endif;
		}
		
		//根据activity_id获取对应的url（网址）
		public function getUrl($activity_id)
		{
			$data['activity_id'] = $activity_id;
			$this->db->select('url');
			
			$query = $this->db->get_where('activity' , $data);
			$result = $query->row_array();
			return $result['url'];
		}
	}