<?php
	if(!defined('BASEPATH')) exit('此文件不可被直接访问');

	class Credit extends CI_Controller
	{
		public function __construct()
		{
			parent::__construct();
			
			//若未登录，转到登录页
			if($this->session->userdata('logged_in') != TRUE):
				redirect(base_url('login'));
			endif;
			
			$this->load->model('credit_model');
		}
		
		//积分管理控制台首页（积分查看等）
		public function index($type = FALSE)
		{
			$data['class'] = 'credit';
			$data['title'] = '积分管理';
			
			//默认查看除注册、签到之外的积分，并按时间排序（从新到旧）
			$data['credits'] = $this->credit_model->select($type);

			$this->load->view('templates/header', $data);
			$this->load->view('credit/index', $data);
			$this->load->view('templates/footer');
		}
		
		//新建积分
		public function create()
		{
			$data['class'] = 'credit';
			$data['title'] = '新建积分';
			
			$this->load->view('templates/header', $data);
			$this->load->view('credit/create', $data);
			$this->load->view('templates/footer');
		}
		
		//删除积分（标记为已删除状态）
		public function delete($credit_id)
		{
			$data['class'] = 'credit';
			$data['title'] = '删除积分';

			$this->load->view('templates/header', $data);
			$this->load->view('credit/delete', $data);
			$this->load->view('templates/footer');
		}
		
		//编辑积分
		public function edit($credit_id)
		{
			$data['class'] = 'credit';
			$data['title'] = '编辑积分';

			$this->load->view('templates/header', $data);
			$this->load->view('credit/edit', $data);
			$this->load->view('templates/footer');
		}
	}

/* End of file credit.php */
/* Location: ./application/controllers/credit.php */