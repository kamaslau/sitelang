<?php
	if(!defined('BASEPATH')) exit('此文件不可被直接访问');
	
	class Summary extends CI_Controller
	{
		public function __construct()
		{
			parent::__construct();
			
			//若未登录，转到登录页
			if($this->session->userdata('logged_in') != TRUE):
				redirect(base_url('login'));
			endif;
			
			//只有经理以上级别管理员可以对消费记录进行管理
			if($this->session->userdata('level') < 4):
				redirect(base_url());
			endif;
			
			$this->load->model('summary_model');
		}

		//消费记录列表
		public function index($summary_id = FALSE)
		{
			$data['class'] = 'summary';
			$data['title'] = '消费记录管理';
			$data['summarys'] = $this->summary_model->select($summary_id);
		
			$this->load->view('templates/header' , $data);
			$this->load->view('summary/index' , $data);
			$this->load->view('templates/footer');
		}

		//新建消费记录
		public function create()
		{
			$data['class'] = 'summary';
			$data['title'] = '新建消费记录';
			
			$this->load->view('templates/header', $data);
			$this->load->view('summary/create', $data);
			$this->load->view('templates/footer');
		}
		
		//删除消费记录（标记为已删除状态）
		public function delete($summary_id)
		{
			$data['class'] = 'summary';
			$data['title'] = '删除消费记录';

			$this->load->view('templates/header', $data);
			$this->load->view('summary/delete', $data);
			$this->load->view('templates/footer');
		}
		
		//编辑消费记录
		public function edit($summary_id)
		{
			$data['class'] = 'summary';
			$data['title'] = '编辑消费记录';

			$this->load->view('templates/header', $data);
			$this->load->view('summary/edit', $data);
			$this->load->view('templates/footer');
		}
	}
	
/* End of file summary.php */
/* Location: ./application/controllers/summary.php */