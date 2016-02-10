<?php
	class Order_model extends CI_Model
	{
		//初始化模型
		public function __construct()
		{
			$this->load->database();
		}
	
		//获取所有订单，或根据id特定订单
		public function select($order_id = FALSE, $order_type = 'credit')
		{
			$table_name = 'order_'.$order_type;
			$this->db->select($table_name.'.*, stuff.lastname as stuff_lastname, stuff.firstname as stuff_firstname, user.lastname as user_lastname, user.firstname as user_firstname, product.name as product_name');
			$this->db->join('stuff', $table_name.'.stuff_id = stuff.stuff_id', 'left');
			$this->db->join('user', $table_name.'.user_id = user.user_id', 'left');
			$this->db->join('product', $table_name.'.product_id = product.product_id', 'left');
			$this->db->order_by('status asc, time_create desc');
			$data = array();
			
			//系统管理员以上级别可查看所有公司、品牌、门店的订单
			if($this->session->userdata('level') < 8):
				$data[$table_name.'.biz_id'] = $this->session->userdata('biz_id');
			endif;
			//公司管理员上级别才可查看本公司所有订单
			if($this->session->userdata('level') < 7):
				$data[$table_name.'.brand_id'] = $this->session->userdata('brand_id');
			endif;
			//品牌管理员上级别才可查看本品牌所有订单
			if($this->session->userdata('level') < 6):
				$data[$table_name.'.branch_id'] = $this->session->userdata('branch_id');
			endif;
			
			if ($order_id === FALSE):
				//待完成开始
				$query = $this->db->get_where($table_name, $data);
				return $query->result_array();
				//待完成结束
				
			elseif($order_id == 'all'):
				$query = $this->db->get_where($table_name, $data);
				return $query->num_rows();
				
			elseif($order_id == 'pending'):
				$data[$table_name.'.status'] = 1;
				$query = $this->db->get_where($table_name, $data);
				return $query->num_rows();
				
			else:
				$data[$table_name.'.order_id'] = $order_id;
				$query = $this->db->get_where($table_name, $data);
				return $query->result_array();

			endif;
		}
		
		//新增订单，并返回插入后的行ID
		public function create($order_type = 'credit')
		{
			$table_name = 'order_'.$order_type;
			/* 以下为备用语句，以供参考 */
			$data = array(
				'' => '',
				'' => $this->input->post(''),
				'' => $this->session->userdata(''),
				'time_create' => date('Y-m-d H:i:s')
			);
			if(TRUE){$data[''] = $this->input->post('');}

			return $this->db->insert($table_name, $data);
			if($this->db->insert($table_name, $data)):
				return $this->db->insert_id();
			endif;
		}
		
		//删除订单（标记为已删除状态）
		public function delete($order_id, $order_type = 'credit')
		{
			$table_name = 'order_'.$order_type;
			//将status字段调整为4（已删除），并记录操作时间
			$data = array(
				'status' => '4',
				'time_delete' => date('Y-m-d H:i:s'),
				'operator_id' => $this->session->userdata('manager_id')
			);
			
			$this->db->where('biz_id', $biz_id);
			return $this->db->update($table_name, $data);
		}
				
		//编辑订单
		public function edit($order_id, $order_type = 'credit')
		{
			$table_name = 'order_'.$order_type;
		    $data = array(
				'' => '',
				'' => $this->input->post(''),
				'' => $this->session->userdata(''),
			   'operator_id' => $this->session->userdata('manager_id')
		    );
			
			$this->db->where('order_id', $order_id);
			return $this->db->update($table_name, $data);
		}
		
		//确认订单
		public function confirm($order_id, $order_type = 'credit')
		{
			$table_name = 'order_'.$order_type;
			//将status字段调整为2（已确认），并记录操作时间
			$data = array(
               'status' => '2',
			   'time_confirm' => date('Y-m-d H:i:s'),
			   'operator_id' => $this->session->userdata('manager_id')
            );
			$this->db->where('order_id', $order_id);
			return $this->db->update($table_name, $data);
		}
		
		//取消订单（标记为已取消状态）
		public function cancel($order_id, $order_type = 'credit')
		{
			$table_name = 'order_'.$order_type;
			//将status字段调整为3（已取消），并记录操作时间
			$data = array(
               'status' => '3',
			   'time_cancel' => date('Y-m-d H:i:s'),
			   'operator_id' => $this->session->userdata('manager_id')
            );
			$this->db->where('order_id', $order_id);
			return $this->db->update($table_name, $data);
		}
	}