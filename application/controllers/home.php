<?php
	if(!defined('BASEPATH')) exit('此文件不可被直接访问');

	/**
	* Home Class
	*
	* @author Kamas 'Iceberg' Lau <kamaslau@outlook.com>
	* @copyright SenseStrong <www.sensestrong.com>
	*/
	class Home extends CI_Controller
	{
		public function __construct()
		{
			parent::__construct();

			// Redirect to login page if not logged in.
			if ($this->session->logged_in != TRUE):
				redirect(base_url('login'));
			endif;
			
			$this->load->model('activity_model');
			$this->load->model('referral_model');
			$this->load->model('order_model');
			$this->load->model('user_model');
			$this->load->model('manager_model');
			$this->load->model('branch_model');
			$this->load->model('product_model');
			$this->load->model('credit_model');
		}
		
		// 管理后台首页
		public function index()
		{
			$data['class'] = 'home';
			
			$data['orders_all'] = $this->order_model->select('all');
			$data['orders_pending'] = $this->order_model->select('pending');
			$data['total_summary'] = $this->user_model->total_summary();
			$data['total_summary'] = $data['total_summary'][0]['amount'];
			// 获取总积分余额
			$data['total_credit_get'] = $this->user_model->total_credit(1);
			$data['total_credit_get'] = $data['total_credit_get'][0]['amount'];
			$data['total_credit_used'] = $this->user_model->total_credit(2);
			$data['total_credit_used'] = $data['total_credit_used'][0]['amount'];
			$data['total_credit'] = $data['total_credit_get'] - $data['total_credit_used'];

			$data['product_on'] = $this->product_model->select('on');
			$data['product_off'] = $this->product_model->select('off');
			
			// 获取最近注册会员
			$data['user_join_today'] = $this->user_model->recent_join(1);
			$data['user_join_this_month'] = $this->user_model->recent_join(2);
			
			// 获取最近生日会员
			$data['user_dob_today'] = $this->user_model->recent_dob(1);
			$data['user_dob_this_month'] = $this->user_model->recent_dob(2);
			
			// 营销活动数量
			$data['activity_count'] = $this->activity_model->count();
			
			// 参与活动人次
			$data['referral_count'] = $this->referral_model->sum_activity();
			
			$this->load->view('templates/header', $data);
			$this->load->view('index', $data);
			$this->load->view('templates/sidebar');
			$this->load->view('templates/footer');
		}
	}
	
/* End of file Home.php */
/* Location: ./application/controllers/Home.php */