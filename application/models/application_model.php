<?php
	class Application_model extends CI_Model
	{
		public $table_name = 'application';
		
		//初始化模型
		public function __construct()
		{
			$this->load->database();
		}

		//获取所有申请，或根据application_id获取某一特定申请
		public function select($application_id = FALSE)
		{
			$this->db->select($this->table_name.'.*, stuff.lastname as stuff_lastname, stuff.firstname as stuff_firstname');
			$this->db->join('stuff', $this->table_name.'.stuff_id = stuff.stuff_id', 'left');
			$this->db->order_by('status asc');
			$data = array();
			
			//系统管理员以上级别可查看所有申请
			if($this->session->userdata('level') < 8):
				$data[$this->table_name.'.application_id'] = $this->session->userdata('application_id');
			endif;
			
			if ($application_id === FALSE):
				$query = $this->db->get_where($this->table_name, $data);
				return $query->result_array();
				
			else:
				$data[$this->table_name.'.application_id'] = $application_id;
				$query = $this->db->get_where($this->table_name, $data);
				return $query->result_array();
				//未完成//需准备一个类似application/single的view来展示单独application，并在controller中做相应调整 return $query->row_array();
				
			endif;
		}
		
		//新增申请，并返回插入后的行ID
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
		
		//删除申请（标记为已删除状态）
		public function delete($application_id)
		{
			$data = array(
				'' => '0',
				'time_delete' => date('Y-m-d H:i:s'),
				'operator_id' => $this->session->userdata('manager_id')
			);
			
			$this->db->where('application_id', $application_id);
			return $this->db->update($this->table_name, $data);
		}
		
		//编辑申请
		public function edit($application_id)
		{
		    $data = array(
				'' => '',
				'' => $this->input->post(''),
				'' => $this->session->userdata(''),
				'operator_id' => $this->session->userdata('manager_id')
		    );
			
			$this->db->where('application_id', $application_id);
			return $this->db->update($this->table_name, $data);
		}
	}