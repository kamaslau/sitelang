<?php
	class Industry_model extends CI_Model
	{
		public $table_name = 'industry';
		
		//初始化模型
		public function __construct()
		{
			$this->load->database();
		}
	
		//获取所有行业，或根据id获取特定行业
		public function select($industry_id = FALSE)
		{
			$data = array();
			
			if ($industry_id === FALSE):
				$query = $this->db->get_where($this->table_name, $data);
				return $query->result_array();
				
			else:
				$data['industry_id'] = $industry_id;
				$query = $this->db->get_where($this->table_name, $data);
				return $query->row_array();
				
			endif;
		}
		
		//新增行业，并返回插入后的行ID
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
		
		//删除行业（标记为已删除状态）
		public function delete($biz_id)
		{
			$data = array(
				'' => '0',
				'operator_id' => $this->session->userdata('manager_id')
			);
			
			$this->db->where('biz_id', $biz_id);
			return $this->db->update($this->table_name, $data);
		}
		
		//编辑行业
		public function edit($biz_id)
		{
		    $data = array(
				'' => '',
				'' => $this->input->post(''),
				'' => $this->session->userdata(''),
				'operator_id' => $this->session->userdata('manager_id')
		    );
			
			$this->db->where('biz_id', $biz_id);
			return $this->db->update($this->table_name, $data);
		}
	}