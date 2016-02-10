<?php
	class Branch_model extends CI_Model
	{
		public $table_name = 'branch';
		
		//初始化模型
		public function __construct()
		{
			$this->load->database();
		}
	
		//获取所有分店，或根据branch_id获取单独分店
		public function select($branch_id = FALSE)
		{
			$this->db->select($this->table_name.'.*, stuff.lastname as stuff_lastname, stuff.firstname as stuff_firstname, biz.name as biz_name, brand.name as brand_name_cn, brand.name_en as brand_name_en');
			$this->db->join('stuff', $this->table_name.'.stuff_id = stuff.stuff_id', 'left');
			$this->db->join('biz', $this->table_name.'.biz_id = biz.biz_id', 'left');
			$this->db->join('brand', $this->table_name.'.brand_id = brand.brand_id', 'left');
			$this->db->order_by($this->table_name.'.status asc');
			$data = array();
			
			//系统管理员以上级别可查看所有门店或分公司
			if($this->session->userdata('level') < 8):
				$data[$this->table_name.'.biz_id'] = $this->session->userdata('biz_id');
			endif;
			//公司管理员上级别才可查看本公司所有门店或分公司
			if($this->session->userdata('level') < 7):
				$data[$this->table_name.'.brand_id'] = $this->session->userdata('brand_id');
			endif;

			if ($branch_id === FALSE):
				$query = $this->db->get_where($this->table_name, $data);
				return $query->result_array();
				
			else:
				$data[$this->table_name.'.branch_id'] = $branch_id;
				$query = $this->db->get_where($this->table_name, $data);
				return $query->result_array();
				//未完成//需准备一个类似biz/single的view来展示单独biz，并在controller中做相应调整 return $query->row_array();
				
			endif;
		}
		
		//新增门店/分公司，并返回插入后的行ID
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
		
		//删除门店/分公司（标记为已删除状态）
		public function delete($branch_id)
		{
			$data = array(
				'' => '0',
				'time_delete' => date('Y-m-d H:i:s'),
				'operator_id' => $this->session->userdata('manager_id')
			);
			
			$this->db->where('branch_id', $branch_id);
			return $this->db->update($this->table_name, $data);
		}
		
		//编辑门店/分公司
		public function edit($biz_id)
		{
		    $data = array(
				'' => '',
				'' => $this->input->post(''),
				'' => $this->session->userdata(''),
				'operator_id' => $this->session->userdata('manager_id')
		    );
			
			$this->db->where('branch_id', $branch_id);
			return $this->db->update($this->table_name, $data);
		}
		
		//门店/分公司状态 0待开通1已开通2待关闭3已关闭
		public function status($branch_id, $status)
		{
			$data = array(
				'operator_id' => $this->session->userdata('manager_id')
			);
			//公司管理员可直接关闭门店/分公司，品牌和公司管理员可直接开通门店/分公司，否则只能将门店/分公司标记为相应待审核状态提交公司级管理员审核
			if($status == 2):
				if($this->session->userdata('level') > 6):
					$data['status'] = 3;
				endif;
			else:
				$data['status'] = $status;
			endif;

			$this->db->where('branch_id', $branch_id);
			return $this->db->update($this->table_name, $data);
		}
	}