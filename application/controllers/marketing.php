<?php
	if(!defined('BASEPATH')) exit('此文件不可被直接访问');

	class Marketing extends CI_Controller
	{
		public function __construct()
		{
			parent::__construct();
			
			//若未登录，转到登录页
			if($this->session->userdata('logged_in') != TRUE):
				redirect(base_url('login'));
			endif;
			
			//只有品牌以上级别管理员可以对营销进行管理
			if($this->session->userdata('level') < 6):
				redirect(base_url());
			endif;
			
			$this->load->model('activity_model');
			$this->load->model('ad_model');
			$this->load->model('biz_model');
			$this->load->model('branch_model');
			$this->load->model('brand_model');
			$this->load->model('poster_model');
			$this->load->model('referral_model');
			$this->load->model('stuff_model');
		}
		
		//营销活动首页
		public function index()
		{
			$data['class'] = 'marketing';
			$data['title'] = '营销管理';

			$data['activities'] = $this->activity_model->select();
			$data['ads'] = $this->ad_model->select();
			$data['posters'] = $this->poster_model->select();
			
			$this->load->view('templates/header', $data);
			$this->load->view('marketing/index', $data);
			$this->load->view('templates/footer');
		}
		
		//新建营销活动
		public function create()
		{
			$data['class'] = 'marketing';
			$data['title'] = '新建营销活动';

			$data['activities'] = $this->activity_model->select();
			$data['ads'] = $this->ad_model->select();
			$data['posters'] = $this->poster_model->select();
			
			$this->load->view('templates/header', $data);
			$this->load->view('marketing/create', $data);
			$this->load->view('templates/footer');
		}

	}
	
/* End of file marketing.php */
/* Location: ./application/controllers/marketing.php */