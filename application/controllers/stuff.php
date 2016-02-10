<?php
	if(!defined('BASEPATH')) exit('此文件不可被直接访问');

	class Stuff extends CI_Controller
	{
		public function __construct()
		{
			parent::__construct();
			
			//若未登录，转到登录页
			if($this->session->userdata('logged_in') != TRUE):
				redirect(base_url('login'));
			endif;
			
			$this->load->model('stuff_model');
			$this->load->model('biz_model');
			$this->load->model('brand_model');
			$this->load->model('branch_model');
		}
		
		//员工列表
		public function index($stuff_id = FALSE)
		{	
			$data['class'] = 'stuff';
			$data['title'] = '员工管理';
			$data['stuffs'] = $this->stuff_model->select($stuff_id);
			
			if($this->input->is_ajax_request()):
				$this->load->view('stuff/info', $data);
				
			else:
				$this->load->view('templates/header', $data);
				$this->load->view('stuff/index', $data);
				$this->load->view('templates/footer');
				
			endif;
		}
		
		//新增员工
		public function create()
		{
			$data['class'] = 'stuff';
			$data['title'] = '新增员工';
			if($this->session->userdata('level') < 5):
				$data['content'] = '新增员工需要门店/分公司级别或更高级别管理权限';
			endif;
			
			$this->form_validation->set_rules('lastname', '姓氏', 'trim|required');
			$this->form_validation->set_rules('firstname', '名', 'trim|required');
			$this->form_validation->set_rules('gender', '性别', 'trim|required');
			$this->form_validation->set_rules('level', '权限', 'trim|is_natural|required');
			$this->form_validation->set_rules('dob', '生日', 'trim|required');
			$this->form_validation->set_rules('mobile', '手机号', 'trim|required|is_natural|exact_length[11]');
			$this->form_validation->set_rules('email', 'Email', 'trim|valid_email');
	
			if ( $this->form_validation->run() === FALSE ):
				$this->load->view('templates/header', $data);
				$this->load->view('stuff/create');
				$this->load->view('templates/footer');
				
			//若此手机号已被注册过
			elseif ( $this->stuff_model->stuff_check() ):
				$data['content'] = '这个手机号已被注册过，请确认。';
				
				$this->load->view('templates/header', $data);
				$this->load->view('stuff/result', $data);
				$this->load->view('templates/footer');
				
			elseif ( $this->stuff_model->create() ):
				$data['content'] = '新员工创建成功。请告知该员工管理后台登录网址（'.base_url().'），用户名为该员工手机号，初始密码为该员工手机号后6位数字。';

				$this->load->view('templates/header', $data);
				$this->load->view('stuff/result', $data);
				$this->load->view('templates/footer');
				
			endif;
		}
		
		//删除员工
		public function delete($stuff_id)
		{
			$data['class'] = 'stuff';
			$data['title'] = '删除员工';
			if($this->session->userdata('level') < 5):
				$data['content'] = '删除员工需要分店/分公司或更高级别管理权限';
			elseif(!$this->stuff_model->delete($stuff_id)):
				$data['content'] = '删除失败';
			else:
				$data['content'] = '删除成功';
			endif;
			
			$this->load->view('templates/header', $data);
			$this->load->view('stuff/result', $data);
			$this->load->view('templates/footer');
		}
		
		//编辑员工
		public function edit($stuff_id)
		{
			$data['class'] = 'stuff';
			$data['title'] = '编辑员工';
			if($this->session->userdata('level') < 5):
				$data['content'] = '修改员工资料需要门店/分公司或更高级别管理权限';
			endif;
			
			$this->form_validation->set_rules('lastname', '姓', 'trim|required');
			$this->form_validation->set_rules('firstname', '名', 'trim|required');
			$this->form_validation->set_rules('gender', '性别', 'trim|required');
			$this->form_validation->set_rules('dob', '生日', 'trim|required');
			$this->form_validation->set_rules('level', '权限', 'trim|is_natural|required');
			$this->form_validation->set_rules('mobile', '手机号', 'trim|required|is_natural|exact_length[11]|required');
			$this->form_validation->set_rules('email', 'Email', 'trim|valid_email');
	
			if($this->form_validation->run() === FALSE):
				$data['stuffs'] = $this->stuff_model->select($stuff_id);
				$this->load->view('templates/header', $data);
				$this->load->view('stuff/edit', $data);
				$this->load->view('templates/footer');
				
			else:
				if($this->stuff_model->edit($stuff_id)):
					$data['content'] = '保存失败';
					
				else:
					$data['content'] = '保存成功';
					
				endif;
				
				$this->load->view('templates/header', $data);
				$this->load->view('stuff/result', $data);
				$this->load->view('templates/footer');
				
			endif;
		}
	}
	
/* End of file stuff.php */
/* Location: ./application/controllers/stuff.php */