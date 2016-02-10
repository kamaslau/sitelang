<?php
	class Activity_model extends CI_Model
	{
		public $table_name = 'activity';
		
		//初始化模型
		public function __construct()
		{
			$this->load->database();
		}

		//获取所有活动，或根据ID获取特定活动
		public function select($activity_id = FALSE)
		{
			$data = array();
			$this->db->order_by('status');
			
			//系统管理员以上级别可查看所有活动
			if($this->session->userdata('level') < 8):
				$data[$this->table_name.'.biz_id'] = $this->session->userdata('biz_id');
			endif;
			//公司管理员上级别才可查看本公司所有活动
			if($this->session->userdata('level') < 7):
				$data[$this->table_name.'.brand_id'] = $this->session->userdata('brand_id');
			endif;
			//品牌管理员上级别才可查看本品牌所有活动
			if($this->session->userdata('level') < 6):
				$data[$this->table_name.'.branch_id'] = $this->session->userdata('branch_id');
			endif;

			if($activity_id != FALSE):
				$data[$this->table_name.'.activity_id'] = $activity_id;
			endif;

			$this->db->select($this->table_name.'.*, stuff.lastname as stuff_lastname, stuff.firstname as stuff_firstname, biz.name as biz_name, brand.name as brand_name, branch.name as branch_name');
			$this->db->join('biz', $this->table_name.'.biz_id = biz.biz_id', 'left');
			$this->db->join('brand', $this->table_name.'.brand_id = brand.brand_id', 'left');
			$this->db->join('branch', $this->table_name.'.branch_id = branch.branch_id', 'left');
			$this->db->join('stuff', $this->table_name.'.stuff_id = stuff.stuff_id', 'left');
			
			$query = $this->db->get_where($this->table_name, $data);
			return $query->result_array();
		}
		
		//新增活动，并返回插入后的行ID
		public function create()
		{
			$data = array(
				'biz_id' => $this->session->userdata('biz_id'),
				'brand_id' => $this->session->userdata('brand_id'),
				'branch_id' => $this->session->userdata('branch_id'),
				'stuff_id' => $this->input->post('stuff_id'),
				'name' => $this->input->post('name'),
				'url' => $this->input->post('url'),
				'time_start' => $this->input->post('time_start'),
				'time_end' => $this->input->post('time_end'),
				'detail' => $this->input->post('detail'),
				'time_create' => date('Y-m-d H:i:s'),
				'operator_id' => $this->session->userdata('manager_id')
			);

			return $this->db->insert($this->table_name, $data);
			if($this->db->insert($this->table_name, $data)):
				return $this->db->insert_id();
			endif;
		}
		
		//删除活动（标记为已删除状态）
		public function delete($activity_id)
		{
			$data = array(
				'status' => '2',
				'operator_id' => $this->session->userdata('manager_id')
			);
			
			$this->db->where('activity_id', $activity_id);
			return $this->db->update($this->table_name, $data);
		}
		
		
		//编辑活动
		public function edit($activity_id)
		{
		    $data = array(
				'' => '',
				'' => $this->input->post(''),
				'' => $this->session->userdata(''),
				'operator_id' => $this->session->userdata('manager_id')
		    );
			
			$this->db->where('activity_id', $activity_id);
			return $this->db->update($this->table_name, $data);
		}
		
		//获取活动数量
		public function count()
		{
			$data = array();
			
			//系统管理员以上级别可查看所有门店或分公司
			if($this->session->userdata('level') < 8):
				$data['biz_id'] = $this->session->userdata('biz_id');
			endif;
			//公司管理员上级别才可查看本公司所有门店或分公司
			if($this->session->userdata('level') < 7):
				$data['brand_id'] = $this->session->userdata('brand_id');
			endif;
			//品牌管理员上级别才可查看本品牌所有门店或分公司
			if($this->session->userdata('level') < 6):
				$data['branch_id'] = $this->session->userdata('branch_id');
			endif;
			
			$this->db->where($data);
			$this->db->from($this->table_name);
			return $this->db->count_all_results();
		}
	}