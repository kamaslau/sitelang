<?php
	class Credit_model extends CI_Model
	{
		public $table_name = 'credit';
		
		//初始化模型
		public function __construct()
		{
			$this->load->database();
		}
	
		//获取所有积分记录，或根据id获取单独积分流水
		public function select($credit_id = FALSE, $type = FALSE)
		{
			$data = array();
			$this->db->order_by('action desc, type desc, time_create desc');
			/*
			if ($type === FALSE):
				$this->db->where('action !=', 1);
				$types = array('1' , '2' );
				$this->db->where_not_in('type', $types);
			endif;
			*/
				
			//系统管理员以上级别可查看所有公司、品牌、门店的积分
			if($this->session->userdata('level') < 8):
				$data['biz_id'] = $this->session->userdata('biz_id');
			endif;
			//公司管理员上级别才可查看本公司所有积分
			if($this->session->userdata('level') < 7):
				$data['brand_id'] = $this->session->userdata('brand_id');
			endif;
			//品牌管理员上级别才可查看本品牌所有积分
			if($this->session->userdata('level') < 6):
				$data['branch_id'] = $this->session->userdata('branch_id');
			endif;
			
			if ($credit_id === FALSE):
				$query = $this->db->get_where($this->table_name, $data);
				return $query->result_array();
				
			else:
				$data['$credit_id'] = $credit_id;
				$query = $this->db->get_where($this->table_name, $data);
				return $query->row_array();
			
			endif;
		}
		
		//新增积分，并返回插入后的行ID
		public function create()
		{
			/* 以下为备用语句，以供参考 */
			$data = array(
				'' => '',
				'' => $this->input->post(''),
				'' => $this->session->userdata(''),
				'operator_id' => $this->session->userdata('manager_id')
			);
			if(TRUE){$data[''] = $this->input->post('');}

			return $this->db->insert($this->table_name, $data);
			if($this->db->insert($this->table_name, $data)):
				return $this->db->insert_id();
			endif;
		}
		
		//删除积分（标记为已删除状态）
		public function delete($credit_id)
		{
			$data = array(
				'' => '0',
				'operator_id' => $this->session->userdata('manager_id')
			);
			
			$this->db->where('credit_id', $credit_id);
			return $this->db->update($this->table_name, $data);
		}
		
		//编辑积分
		public function edit($credit_id)
		{
		    $data = array(
				'' => '',
				'' => $this->input->post(''),
				'' => $this->session->userdata(''),
				'operator_id' => $this->session->userdata('manager_id')
		    );
			
			$this->db->where('credit_id', $credit_id);
			return $this->db->update($this->table_name, $data);
		}
	}