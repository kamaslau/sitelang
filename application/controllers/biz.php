<?php
	if(!defined('BASEPATH')) exit('此文件不可被直接访问');
	
	class Biz extends CI_Controller
	{
		public function __construct()
		{
			parent::__construct();
			
			//若未登录，转到登录页
			if($this->session->userdata('logged_in') != TRUE):
				redirect(base_url('login'));
			endif;
			
			//只有公司以上级别管理员可以对公司进行管理
			if($this->session->userdata('level') < 7):
				redirect(base_url());
			endif;
			
			$this->load->model('biz_model');
			$this->load->model('industry_model');
		}

		//公司列表
		public function index($biz_id = FALSE)
		{
			$data['class'] = 'biz';
			$data['title'] = '公司管理';
			$data['bizs'] = $this->biz_model->select($biz_id);
		
			$this->load->view('templates/header', $data);
			$this->load->view('biz/index', $data);
			$this->load->view('templates/footer');
		}

		//新建公司
		public function create()
		{
			$data['class'] = 'biz';
			$data['title'] = '新建公司';
			
			$this->load->view('templates/header', $data);
			$this->load->view('biz/create', $data);
			$this->load->view('templates/footer');
		}
		
		//删除公司（标记为已删除状态）
		public function delete($biz_id)
		{
			$data['class'] = 'biz';
			$data['title'] = '删除公司';

			$this->load->view('templates/header', $data);
			$this->load->view('biz/delete', $data);
			$this->load->view('templates/footer');
		}
		
		//编辑公司
		public function edit($biz_id)
		{
			$data['class'] = 'biz';
			$data['title'] = '编辑公司';

			$this->load->view('templates/header', $data);
			$this->load->view('biz/edit', $data);
			$this->load->view('templates/footer');
		}
	}
	
/* End of file biz.php */
/* Location: ./application/controllers/biz.php */