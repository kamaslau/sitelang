<?php
	class Brand_model extends CI_Model
	{
		public $table_name = 'brand';
		
		//初始化模型
		public function __construct()
		{
			$this->load->database();
		}
	
		//获取所有品牌，或根据brand_id获取某一特定品牌
		public function select($brand_id = FALSE)
		{
			$this->db->select($this->table_name.'.*, stuff.lastname as stuff_lastname, stuff.firstname as stuff_firstname, biz.name as biz_name');
			$this->db->join('stuff', $this->table_name.'.stuff_id = stuff.stuff_id', 'left');
			$this->db->join('biz', $this->table_name.'.biz_id = biz.biz_id', 'left');
			$this->db->order_by('status asc');
			$data = array();
			
			//系统管理员以上级别可查看所有品牌
			if($this->session->userdata('level') < 8):
				$data[$this->table_name.'.biz_id'] = $this->session->userdata('biz_id');
			endif;
			//公司管理员上级别可查看本公司所有品牌
			if($this->session->userdata('level') < 7):
				$data[$this->table_name.'.brand_id'] = $this->session->userdata('brand_id');
			endif;
			
			if ($brand_id === FALSE):
				$query = $this->db->get_where($this->table_name, $data);
				return $query->result_array();
				
			else:
				$data[$this->table_name.'.brand_id'] = $brand_id;
				$query = $this->db->get_where($this->table_name, $data);
				return $query->result_array();
				//未完成//需准备一个类似biz/single的view来展示单独biz，并在controller中做相应调整 return $query->row_array();
				
			endif;
		}
		
		//新增品牌，并返回插入后的行ID
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
		
		//删除品牌（标记为已删除状态）
		public function delete($brand_id)
		{
			$data = array(
				'' => '0',
				'time_delete' => date('Y-m-d H:i:s'),
				'operator_id' => $this->session->userdata('manager_id')
			);
			
			$this->db->where('brand_id', $brand_id);
			return $this->db->update($this->table_name, $data);
		}
		
		//编辑品牌
		public function edit($brand_id)
		{
		    $data = array(
				'' => '',
				'' => $this->input->post(''),
				'' => $this->session->userdata(''),
				'operator_id' => $this->session->userdata('manager_id')
		    );
			
			$this->db->where('brand_id', $brand_id);
			return $this->db->update($this->table_name, $data);
		}
	}