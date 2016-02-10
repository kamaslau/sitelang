<?php
	class Process_model extends CI_Model
	{
		public $table_name = 'process';
		
		//初始化模型
		public function __construct()
		{
			$this->load->database();
		}

		//获取所有流程，或根据process_id获取某一特定流程
		public function select($process_id = FALSE)
		{
			$this->db->select($this->table_name.'.*, stuff.lastname as stuff_lastname, stuff.firstname as stuff_firstname');
			$this->db->join('stuff', $this->table_name.'.stuff_id = stuff.stuff_id', 'left');
			$this->db->order_by('status asc');
			$data = array();
			
			//系统管理员以上级别可查看所有流程
			if($this->session->userdata('level') < 8):
				$data[$this->table_name.'.process_id'] = $this->session->userdata('process_id');
			endif;
			
			if ($process_id === FALSE):
				$query = $this->db->get_where($this->table_name, $data);
				return $query->result_array();
				
			else:
				$data[$this->table_name.'.process_id'] = $process_id;
				$query = $this->db->get_where($this->table_name, $data);
				return $query->result_array();
				//未完成//需准备一个类似process/single的view来展示单独process，并在controller中做相应调整 return $query->row_array();
				
			endif;
		}
		
		//新增流程，并返回插入后的行ID
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
		
		//删除流程（标记为已删除状态）
		public function delete($process_id)
		{
			$data = array(
				'' => '0',
				'time_delete' => date('Y-m-d H:i:s'),
				'operator_id' => $this->session->userdata('manager_id')
			);
			
			$this->db->where('process_id', $process_id);
			return $this->db->update($this->table_name, $data);
		}
		
		//编辑流程
		public function edit($process_id)
		{
		    $data = array(
				'' => '',
				'' => $this->input->post(''),
				'' => $this->session->userdata(''),
				'operator_id' => $this->session->userdata('manager_id')
		    );
			
			$this->db->where('process_id', $process_id);
			return $this->db->update($this->table_name, $data);
		}
	}