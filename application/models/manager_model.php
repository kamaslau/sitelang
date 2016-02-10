<?php
	class Manager_model extends CI_Model
	{
		public $table_name = 'stuff';
		
		//初始化模型
		public function __construct()
		{
			$this->load->database();
		}
		
		//员工登录 从manager表中验证输入的密码与用户名是否匹配,若匹配则登录
		public function login()
		{
			$data = array(
				'mobile' => $this->input->post('mobile'),
				'password' => sha1($this->input->post('password'))
			);
			$query = $this->db->get_where($this->table_name, $data);
			return $query->row_array();
		}
	
		//未完成 //重置密码 将密码重置链接通发送到需要重置的Email，员工点击连接后设置新密码
		public function password_forget()
		{

		}
	
		//未完成 //更改密码 根据session中的manager_id更新对应stuff_id的密码
		public function password_reset()
		{
			$data = array(
				'password' => sha1($this->input->post('new_password')),
				'time_edit' => date('Y-m-d H:i:s'),
				'operator_id' => $this->session->userdata('manager_id')
			);
			$this->db->where('stuff_id', $this->session->userdata('manager_id'));
			return $this->db->update($this->table_name, $data);
		}
	}