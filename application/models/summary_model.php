<?php
	class Summary_model extends CI_Model
	{
		public $table_name = 'summary';
		
		//初始化模型
		public function __construct()
		{
			$this->load->database();
		}
		
		public function select($summary_id = FALSE)
		{
			$this->db->select($this->table_name.'.*, stuff.lastname as stuff_lastname, stuff.firstname as stuff_firstname, user.lastname as user_lastname, user.firstname as user_firstname');
			$this->db->join('stuff', $this->table_name.'.stuff_id = stuff.stuff_id', 'left');
			$this->db->join('user', $this->table_name.'.user_id = user.user_id', 'left');
			$this->db->order_by('status asc, time_create desc');
			$data = array();
			
			//系统管理员以上级别可查看所有公司、品牌、门店的消费记录
			if($this->session->userdata('level') < 8):
				$data[$this->table_name.'.biz_id'] = $this->session->userdata('biz_id');
			endif;
			//公司管理员上级别才可查看本公司所有消费记录
			if($this->session->userdata('level') < 7):
				$data[$this->table_name.'.brand_id'] = $this->session->userdata('brand_id');
			endif;
			//品牌管理员上级别才可查看本品牌所有消费记录
			if($this->session->userdata('level') < 6):
				$data[$this->table_name.'.branch_id'] = $this->session->userdata('branch_id');
			endif;
			
			if ($summary_id === FALSE):
				$query = $this->db->get_where($this->table_name, $data);
				return $query->result_array();
				
			else:
				$data['summary_id'] = $summary_id;
				$query = $this->db->get_where($this->table_name, $data);
				return $query->row_array();
				
			endif;
		}
		
		//新增公司，并返回插入后的行ID
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
		
		//删除公司（标记为已删除状态）
		public function delete($summary_id)
		{
			$data = array(
				'status' => '4',
				'time_delete' => date('Y-m-d H:i:s'),
				'operator_id' => $this->session->userdata('manager_id')
			);
			
			$this->db->where('summary_id', $summary_id);
			return $this->db->update($this->table_name, $data);
		}
		
		//编辑消费记录
		public function edit($summary_id)
		{
		    $data = array(
				'' => '',
				'' => $this->input->post(''),
				'' => $this->session->userdata(''),
				'operator_id' => $this->session->userdata('manager_id')
		    );
			
			$this->db->where('summary_id', $summary_id);
			return $this->db->update($this->table_name, $data);
		}
		
		//确认消费记录
		public function confirm($summary_id)
		{
			$data = array(
                'status' => '3',
				'time_confirm' => date('Y-m-d H:i:s'),
				'operator_id' => $this->session->userdata('manager_id')
			);
			
			$this->db->where('summary_id', $summary_id);
			return $this->db->update($this->table_name, $data);
		}
		
		//取消消费记录（标记为已取消状态）
		public function cancel($summary_id)
		{
			$data = array(
                'status' => '3',
				'time_cancel' => date('Y-m-d H:i:s'),
				'operator_id' => $this->session->userdata('manager_id')
			);
			
			$this->db->where('summary_id', $summary_id);
			return $this->db->update($this->table_name, $data);
		}
		
		//检查特定会员是否有大于等于、小于，或等于一定数额的消费记录
		public function check_record($user_id, $amount, $symbol = '>=')
		{
			$data = array(
				'user_id' => $user_id,
				'amount'.$symbol => $amount
			);
			/*
			$query = $this->db->get_where('summary', $data);
			return $query->row_array();
			*/
			$query = $this->db->get_where($this->table_name, $data);
			return $this->db->count_all_results();
		}
	}