<?php
	if(!defined('BASEPATH')) exit('此文件不可被直接访问');

	/**
	* Credit Class
	*
	* @author Kamas 'Iceberg' Lau <kamaslau@outlook.com>
	* @copyright SenseStrong <www.sensestrong.com>
	*/
	class Credit extends CI_Controller
	{
		public function __construct()
		{
			parent::__construct();
			
			// Redirect to login page if not logged in.
			if ($this->session->logged_in != TRUE):
				redirect(base_url('login'));
			endif;
			
			$this->load->model('credit_model');
		}
		
		// 积分管理首页（积分查看等）
		public function index($type = FALSE)
		{
			$data['class'] = 'credit';
			$data['title'] = '积分管理';
			
			// 默认查看除注册、签到之外的积分，并按时间排序（从新到旧）
			$data['credits'] = $this->credit_model->select($type);

			$this->load->view('templates/header', $data);
			$this->load->view('credit/index', $data);
			$this->load->view('templates/footer');
		}
		
		// TODO:新建积分
		public function create()
		{
			$data['class'] = 'credit';
			$data['title'] = '新建积分';
			
			$this->load->view('templates/header', $data);
			$this->load->view('credit/create', $data);
			$this->load->view('templates/footer');
		}
		
		// TODO:删除积分（标记为已删除状态）
		public function delete($credit_id)
		{
			$data['class'] = 'credit';
			$data['title'] = '删除积分';

			$this->load->view('templates/header', $data);
			$this->load->view('credit/delete', $data);
			$this->load->view('templates/footer');
		}
		
		// TODO:编辑积分
		public function edit($credit_id)
		{
			$data['class'] = 'credit';
			$data['title'] = '编辑积分';

			$this->load->view('templates/header', $data);
			$this->load->view('credit/edit', $data);
			$this->load->view('templates/footer');
		}
	}

/* End of file Credit.php */
/* Location: ./application/controllers/Credit.php */