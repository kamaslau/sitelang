<?php
	class User_model extends CI_Model
	{
		public $table_name = 'user';
		
		//初始化模型
		public function __construct()
		{
			$this->load->database();
		}
		
		//获取所有会员，或根据id获取特定会员
		public function select($user_id = FLASE, $period)
		{
			$data = array();
			
			//系统管理员以上级别可查看所有公司、品牌、门店的会员
			if($this->session->userdata('level') < 8):
				$this->db->like('biz_visited', '|'.$this->session->userdata('biz_id').'|');
			endif;
			//公司管理员上级别才可查看本公司所有会员
			if($this->session->userdata('level') < 7):
				$this->db->like('brand_visited', '|'.$this->session->userdata('brand_id').'|');
			endif;
			//品牌管理员上级别才可查看本品牌所有会员
			if($this->session->userdata('level') < 6):
				$this->db->like('branch_visited', '|'.$this->session->userdata('branch_id').'|');
			endif;
			
			if ($user_id === FALSE):
				$this->db->order_by('group desc, time_create desc');
				$query = $this->db->get_where($this->table_name, $data);
				
			elseif($user_id == 'recent_dob'):
				$this->db->order_by('group desc, day(dob), time_create');
				if($period == 1)://列出当日生日会员
					$data['day(dob)'] = date('d');
					$data['month(dob)'] = date('m');
				endif;
				if($period == 2)://列出当月生日会员
					$data['month(dob)'] = date('m');
				endif;
				$query = $this->db->get_where($this->table_name, $data);
				
			else:
				$data['user_id'] = $user_id;
				$query = $this->db->get_where($this->table_name, $data);
				
			endif;
			
			return $query->result_array();
		}
		
		//新增会员，并返回插入后的行ID
		public function create()
		{
			/* 以下为备用语句，以供参考 */
			$data = array(
				'' => '',
				'' => $this->input->post(''),
				'' => $this->session->userdata(''),
				'time_create' => date('Y-m-d H:i:s'),
				'operator_id' => $this->session->userdata('manager_id')
			);
			if(TRUE){$data[''] = $this->input->post('');}

			return $this->db->insert($this->table_name, $data);
			if($this->db->insert($this->table_name, $data)):
				return $this->db->insert_id();
			endif;
		}
		
		//删除会员（标记为已删除状态）
		public function delete($user_id)
		{
			$data = array(
				'' => '0',
				'operator_id' => $this->session->userdata('manager_id')
			);
			
			$this->db->where('user_id', $user_id);
			return $this->db->update($this->table_name, $data);
		}
		
		//编辑会员
		public function edit($user_id)
		{
		    $data = array(
				'' => '',
				'' => $this->input->post(''),
				'' => $this->session->userdata(''),
				'operator_id' => $this->session->userdata('manager_id')
		    );
			
			$this->db->where('user_id', $user_id);
			return $this->db->update($this->table_name, $data);
		}
		
		//调整会员等级
		public function regroup($user_id, $group)
		{
			$data = array(
				'group' => $group,
				'operator_id' => $this->session->userdata('manager_id')
			);
			
			$this->db->where('user_id', $user_id);
			return $this->db->update($this->table_name, $data);
		}
		
		//获取全部会员总消费额
		public function total_summary()
		{
			$data = array();
			/*
			//系统管理员以上级别可查看所有公司、品牌、门店的会员
			if($this->session->userdata('level') < 8):
				$this->db->like('biz_visited', '|'.$this->session->userdata('biz_id').'|');
			endif;
			//公司管理员上级别才可查看本公司所有会员
			if($this->session->userdata('level') < 7):
				$this->db->like('brand_visited', '|'.$this->session->userdata('brand_id').'|');
			endif;
			//品牌管理员上级别才可查看本品牌所有会员
			if($this->session->userdata('level') < 6):
				$this->db->like('branch_visited', '|'.$this->session->userdata('branch_id').'|');
			endif;
			*/
			$this->db->select_sum('amount');
			$query = $this->db->get_where('summary', $data);
			return $query->result_array();
		}
		
		//获取会员积分额 1总获得积分额2总使用积分额，在controller中可用两者之差获取总积分余额
		public function total_credit($action = 1)
		{
			$data = array();
			$data['action'] = $action;
			/*
			//系统管理员以上级别可查看所有公司、品牌、门店的会员
			if($this->session->userdata('level') < 8):
				$this->db->like('biz_visited', '|'.$this->session->userdata('biz_id').'|');
			endif;
			//公司管理员上级别才可查看本公司所有会员
			if($this->session->userdata('level') < 7):
				$this->db->like('brand_visited', '|'.$this->session->userdata('brand_id').'|');
			endif;
			//品牌管理员上级别才可查看本品牌所有会员
			if($this->session->userdata('level') < 6):
				$this->db->like('branch_visited', '|'.$this->session->userdata('branch_id').'|');
			endif;
			*/
			$this->db->select_sum('amount');
			$query = $this->db->get_where('credit', $data);
			return $query->result_array();
		}
		
		//最近注册的会员，1今日2本月
		public function recent_join($period)
		{
			if($period == 1):
				$this->db->like('time_create', date('Y-m-d'), 'after');
			elseif($period == 2):
				$this->db->like('time_create', date('Y-m-'), 'after');
			endif;
			
			$query = $this->db->get($this->table_name);
			return $query->num_rows();
		}
		
		//最近过生日的会员，1今日2本月
		public function recent_dob($period)
		{
			if($period == 1):
				$this->db->where('day(dob)', date('d'));
				$this->db->where('month(dob)', date('m'));
			elseif($period == 2):
				$this->db->where('month(dob)', date('m'));
			endif;
			
			$query = $this->db->get($this->table_name);
			return $query->num_rows();
		}
	}