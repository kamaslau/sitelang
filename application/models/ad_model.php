<?php
	class Ad_model extends CI_Model
	{
		public $table_name = 'ad';
		
		//初始化模型
		public function __construct()
		{
			$this->load->database();
		}

		//获取所有素材，或根据id获取特定素材
		public function select($ad_id = FALSE)
		{
			$data = array();
			
			//系统管理员以上级别可查看所有门店或分公司
			if($this->session->userdata('level') < 8):
				$data[$this->table_name.'.biz_id'] = $this->session->userdata('biz_id');
			endif;
			//公司管理员上级别才可查看本公司所有门店或分公司
			if($this->session->userdata('level') < 7):
				$data[$this->table_name.'.brand_id'] = $this->session->userdata('brand_id');
			endif;
			//品牌管理员上级别才可查看本品牌所有门店或分公司
			if($this->session->userdata('level') < 6):
				$data[$this->table_name.'.branch_id'] = $this->session->userdata('branch_id');
			endif;

			if($ad_id != FALSE):
				$data[$this->table_name.'.ad_id'] = $ad_id;
			endif;

			$this->db->select($this->table_name.'.*, activity.activity_id as activity_id, activity.name as activity_name, stuff.lastname as stuff_lastname, stuff.firstname as stuff_firstname');
			$this->db->join('activity', $this->table_name.'.activity_id = activity.activity_id', 'left');
			$this->db->join('stuff', $this->table_name.'.stuff_id = stuff.stuff_id', 'left');
			
			$query = $this->db->get_where($this->table_name, $data);
			return $query->result_array();
		}
		
		//新增素材，并返回插入后的行ID
		public function create()
		{
			/* 以下为备用语句，以供参考 */
			$data = array(
				'' => '0',
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
		
		//删除素材（标记为已删除状态）
		public function delete($ad_id)
		{
			$data = array(
				'' => '0',
				'operator_id' => $this->session->userdata('manager_id')
			);
			
			$this->db->where('ad_id', $ad_id);
			return $this->db->update($this->table_name, $data);
		}
		
		//编辑素材
		public function edit($ad_id)
		{
		    $data = array(
				'' => '',
				'' => $this->input->post(''),
				'' => $this->session->userdata(''),
				'operator_id' => $this->session->userdata('manager_id')
		    );
			
			$this->db->where('ad_id', $ad_id);
			return $this->db->update($this->table_name, $data);
		}
		
		//获取活动数量
		public function count()
		{
			$data = array();
			
			//系统管理员以上级别可查看所有门店或分公司
			if($this->session->userdata('level') < 8):
				$data['biz_id'] = $this->session->userdata('biz_id');
			endif;
			//公司管理员上级别才可查看本公司所有门店或分公司
			if($this->session->userdata('level') < 7):
				$data['brand_id'] = $this->session->userdata('brand_id');
			endif;
			//品牌管理员上级别才可查看本品牌所有门店或分公司
			if($this->session->userdata('level') < 6):
				$data['branch_id'] = $this->session->userdata('branch_id');
			endif;
			
			$this->db->where($data);
			$this->db->from($this->table_name);
			return $this->db->count_all_results();
		}
	}