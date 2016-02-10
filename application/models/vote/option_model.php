<?php
	class Option_model extends CI_Model
	{
		public $table_name = 'activity_vote_option';
		
		//初始化模型
		public function __construct()
		{
			$this->load->database();
		}
	
		//获取所有选项，或根据option_id获取特定选项
		public function select($vote_id, $option_id)
		{
			$data['vote_id'] = $vote_id;
			$this->db->order_by('status asc, count desc, time_create asc');//根据是否被删除、所得票数从高到低、创建时间从低到高排序

			if ($option_id === FALSE):
				$query = $this->db->get_where($this->table_name, $data);
				return $query->result_array();
				
			else:
				$data['option_id'] = $option_id;
				$query = $this->db->get_where($this->table_name, $data);
				return $query->result_array();
			
			endif;
		}
	
		//新增选项，并返回插入后的行ID
		public function create($image_url)
		{
			$data = array(
				'vote_id' => $this->input->post('vote_id'),
				'name' => $this->input->post('name'),
				'detail' => $this->input->post('detail'),
				'image' => $image_url,
				'time_create' => date('Y-m-d H:i:s'),
				'operator_id' => $this->session->userdata('manager_id')
			);
		
			if($this->db->insert($this->table_name, $data)):
				return $this->db->insert_id();
			endif;
		}
		
		//编辑投票选项
		public function edit($option_id)
		{
		    $data = array(
				'name' => $this->input->post('name'),
				'detail' => $this->input->post('detail'),
				'operator_id' => $this->session->userdata('manager_id')
		    );
			
			$this->db->where('option_id', $option_id);
			return $this->db->update($this->table_name, $data);
		}
		
		//删除投票选项（status字段标记为2，当前时间写入time_delete字段）
		public function delete($option_id)
		{
			$data = array(
				'status' => '2',
				'time_delete' => date('Y-m-d H:i:s'),
				'operator_id' => $this->session->userdata('manager_id')
			);
			
			$this->db->where('option_id', $option_id);
			return $this->db->update($this->table_name, $data);
		}
		
		//恢复投票选项（status字段标记为1，删除time_delete字段内容）
		public function restore($option_id)
		{
			$data = array(
				'status' => '1',
				'time_delete' => NULL,
				'operator_id' => $this->session->userdata('manager_id')
			);
			
			$this->db->where('option_id', $option_id);
			return $this->db->update($this->table_name, $data);
		}
	}