<?php
	class Stuff_model extends CI_Model
	{
		public $table_name = 'stuff';
		
		//初始化模型
		public function __construct()
		{
			$this->load->database();
		}
	
		//获取所有员工，或根据id获取特定员工
		public function select($stuff_id = FALSE)
		{
			$data = array();
			$this->db->order_by('level', 'desc');
			$this->db->order_by('time_create');
			
			//系统管理员以上级别可查看所有公司、品牌、门店的员工
			if($this->session->userdata('level') < 8):
				$data[$this->table_name.'.biz_id'] = $this->session->userdata('biz_id');
			endif;
			//公司管理员上级别才可查看本公司所有员工
			if($this->session->userdata('level') < 7):
				$data[$this->table_name.'.brand_id'] = $this->session->userdata('brand_id');
			endif;
			//品牌管理员上级别才可查看本品牌所有员工
			if($this->session->userdata('level') < 6):
				$data[$this->table_name.'.branch_id'] = $this->session->userdata('branch_id');
			endif;
			
			if ($stuff_id != FALSE):
				$data[$this->table_name.'.stuff_id'] = $stuff_id;
			endif;

			$this->db->select($this->table_name.'.*, biz.vi_logo as vi_logo, biz.vi_color_light as vi_color_light, biz.vi_color_dark as vi_color_dark, biz.name as biz_name, brand.name as brand_name, branch.name as branch_name, branch.address as branch_address, branch.tel as branch_tel');
			$this->db->join('biz', $this->table_name.'.biz_id = biz.biz_id', 'left');
			$this->db->join('brand', $this->table_name.'.brand_id = brand.brand_id', 'left');
			$this->db->join('branch', $this->table_name.'.branch_id = branch.branch_id', 'left');
			
			$query = $this->db->get_where($this->table_name, $data);
			return $query->result_array();
		}
		
		//创建员工
		public function create()
		{
			$data = array(
				'lastname' => $this->input->post('lastname'),
				'firstname' => $this->input->post('firstname'),
				'gender' => $this->input->post('gender'),
				'dob' => $this->input->post('dob'),
				'level' => $this->input->post('level'),
				'email' => $this->input->post('email'),
				'mobile' => $this->input->post('mobile'),
				'password' => sha1( substr($this->input->post('mobile') , 5) ),//初始密码为手机号后6位
				//从session中获取添加员工的管理员ID及所属机构ID
				'biz_id' => $this->session->userdata('biz_id'),
				'brand_id' => $this->session->userdata('brand_id'),
				'branch_id' => $this->session->userdata('branch_id'),
				'time_create' => date('Y-m-d H:i:s'),
				'operator_id' => $this->session->userdata('manager_id')
			);
			return $this->db->insert($this->table_name, $data);
		}
		
		//取消员工授权(删除员工)
		public function delete($stuff_id)
		{
			$data = array(
				'level' => '0',
				'operator_id' => $this->session->userdata('manager_id')
			);
			$this->db->where('stuff_id', $stuff_id);
			return $this->db->update($this->table_name, $data);
		}
		
		//编辑员工
		public function edit($stuff_id)
		{
		    $data = array(
				'lastname' => $this->input->post('lastname'),
				'firstname' => $this->input->post('firstname'),
				'gender' => $this->input->post('gender'),
				'level' => $this->input->post('level'),
				'email' => $this->input->post('email'),
				'mobile' => $this->input->post('mobile'),
				'dob' => $this->input->post('dob'),
				'operator_id' => $this->session->userdata('manager_id')
		    );
			$this->db->where('stuff_id', $stuff_id);
			return $this->db->update($this->table_name, $data);
		}
				
		//检查是否存在已用该手机号注册过的员工
		public function stuff_check()
		{
			$data = array(
				'mobile' => $this->input->post('mobile')
			);
			$query = $this->db->get_where($this->table_name, $data);
			return $query->row_array();
		}
	}