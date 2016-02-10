<?php
	class Product_model extends CI_Model
	{
		public $table_name = 'product';
		
		//初始化模型
		public function __construct()
		{
			$this->load->database();
		}
	
		//获取所有商品，或根据id获取特定商品
		public function select($product_id = FALSE)
		{
			$data = array();
			$this->db->order_by('status');
		
			//系统管理员以上级别可查看所有公司、品牌、门店的产品
			if($this->session->userdata('level') < 8):
				$data['biz_id'] = $this->session->userdata('biz_id');
			endif;
			//公司管理员上级别才可查看本公司所有产品
			if($this->session->userdata('level') < 7):
				$data['brand_id'] = $this->session->userdata('brand_id');
			endif;
			//品牌管理员上级别才可查看本品牌所有产品
			if($this->session->userdata('level') < 6):
				$data['branch_id'] = $this->session->userdata('branch_id');
			endif;
		
			if ($product_id === FALSE):
				$query = $this->db->get_where($this->table_name, $data);
				return $query->result_array();
				/*
			elseif($product_id == 'credit'):
				$this->db->where('price_credit IS NOT NULL');
				$query = $this->db->get('product');
				*/
			elseif($product_id == 'on'):
				$data['status'] = 1;
				$query = $this->db->get_where($this->table_name, $data);
				return $query->num_rows();
			
			elseif($product_id == 'off'):
				$data['status'] = 2;
				$query = $this->db->get_where($this->table_name, $data);
				return $query->num_rows();
			
			else:
				$data['product_id'] = $product_id;
				$query = $this->db->get_where($this->table_name, $data);
				return $query->result_array();
			
			endif;
		}
	
		//新增产品，并返回插入后的行ID
		public function create($image_url)
		{
			$data = array(
				'name' => $this->input->post('name'),
				'detail' => $this->input->post('detail'),
				'image' => $image_url,
				'credit_group' => $this->input->post('credit_group'),
				'credit_rate' => $this->input->post('credit_rate'),
				'time_create' => date('Y-m-d H:i:s'),
				'operator_id' => $this->session->userdata('manager_id')
			);
			if($this->input->post('price_cash') != '0.00'){$data['price_cash'] = $this->input->post('price_cash');}
			if($this->input->post('price_credit') != '0.00'){$data['price_credit'] = $this->input->post('price_credit');}
		
			if($this->db->insert($this->table_name, $data)):
				return $this->db->insert_id();
			endif;
		}
		
		//删除产品（标记为已删除状态）
		public function delete($product_id)
		{
			$data = array(
				'' => '0',
				'operator_id' => $this->session->userdata('manager_id')
			);
			
			$this->db->where('product_id', $product_id);
			return $this->db->update($this->table_name, $data);
		}
		
		//编辑产品
		public function edit($product_id)
		{
		    $data = array(
				'' => '',
				'' => $this->input->post(''),
				'' => $this->session->userdata(''),
				'operator_id' => $this->session->userdata('manager_id')
		    );
			
			$this->db->where('product_id', $product_id);
			return $this->db->update($this->table_name, $data);
		}
	
		//产品上下架
		public function status($product_id, $status)
		{
			//将status字段调整为传入值
			$data = array(
				'status' => $status,
				'operator_id' => $this->session->userdata('manager_id')
			);
			$this->db->where('product_id', $product_id);
			return $this->db->update($this->table_name, $data);
		}
	}