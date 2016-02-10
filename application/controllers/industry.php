<?php
	if(!defined('BASEPATH')) exit('此文件不可被直接访问');
	
	class Industry extends CI_Controller
	{
		public function __construct()
		{
			parent::__construct();
			
			//若未登录，转到登录页
			if($this->session->userdata('logged_in') != TRUE):
				redirect(base_url('login'));
			endif;
			
			//只有管理员以上级别管理员可以对行业进行管理
			if($this->session->userdata('level') < 8):
				redirect(base_url());
			endif;
			
			$this->load->model('industry_model');
		}

		//行业列表
		public function index($industry_id = FALSE)
		{
			$data['class'] = 'industry';
			$data['title'] = '行业管理';
			$data['industrys'] = $this->industry_model->select($industry_id);
		
			$this->load->view('templates/header' , $data);
			$this->load->view('industry/index' , $data);
			$this->load->view('templates/footer');
		}

		//新建行业
		public function create()
		{
			$data['class'] = 'industry';
			$data['title'] = '新建行业';
			
			$this->load->view('templates/header', $data);
			$this->load->view('industry/create', $data);
			$this->load->view('templates/footer');
		}
		
		//删除行业（标记为已删除状态）
		public function delete($industry_id)
		{
			$data['class'] = 'industry';
			$data['title'] = '删除行业';

			$this->load->view('templates/header', $data);
			$this->load->view('industry/delete', $data);
			$this->load->view('templates/footer');
		}
		
		//编辑行业
		public function edit($industry_id)
		{
			$data['class'] = 'industry';
			$data['title'] = '编辑行业';

			$this->load->view('templates/header', $data);
			$this->load->view('industry/edit', $data);
			$this->load->view('templates/footer');
		}
	}
	
/* End of file industry.php */
/* Location: ./application/controllers/industry.php */