<?php
	class Comment_model extends CI_Model
	{
		public $table_name = 'comment_application';
		
		//初始化模型
		public function __construct()
		{
			$this->load->database();
		}

		//获取所有审批，或根据comment_id获取某一特定审批
		public function select($comment_id = FALSE)
		{
			$this->db->select($this->table_name.'.*, stuff.lastname as stuff_lastname, stuff.firstname as stuff_firstname');
			$this->db->join('stuff', $this->table_name.'.stuff_id = stuff.stuff_id', 'left');
			$this->db->order_by('status asc');
			$data = array();
			
			//系统管理员以上级别可查看所有审批
			if($this->session->userdata('level') < 8):
				$data[$this->table_name.'.comment_id'] = $this->session->userdata('comment_id');
			endif;
			
			if ($comment_id === FALSE):
				$query = $this->db->get_where($this->table_name, $data);
				return $query->result_array();
				
			else:
				$data[$this->table_name.'.comment_id'] = $comment_id;
				$query = $this->db->get_where($this->table_name, $data);
				return $query->result_array();
				//未完成//需准备一个类似comment/single的view来展示单独comment，并在controller中做相应调整 return $query->row_array();
				
			endif;
		}
		
		//新增审批，并返回插入后的行ID
		public function create()
		{
			/* 以下为备用语句，以供参考 */
			$data = array(
				'application_id' => $this->input->post('application_id'),
				'status' => $this->input->post('status'),
				'operator_id' => $this->session->userdata('manager_id')
			);
			if(!empty($this->input->post('note'))):
				$data['note'] = $this->input->post('note');
			endif;

			return $this->db->insert($this->table_name, $data);
			if($this->db->insert($this->table_name, $data)):
				return $this->db->insert_id();
			endif;
		}
		
		//编辑审批
		public function edit($comment_id)
		{
			$data = array(
				'application_id' => $this->input->post('application_id'),
				'status' => $this->input->post('status'),
				'operator_id' => $this->session->userdata('manager_id')
			);
			if(!empty($this->input->post('note'))):
				$data['note'] = $this->input->post('note');
			endif;
			
			$this->db->where('comment_id', $comment_id);
			return $this->db->update($this->table_name, $data);
		}
	}