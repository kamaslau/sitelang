<?php
	if(!defined('BASEPATH')) exit('此文件不可被直接访问');

	class Ad extends CI_Controller
	{
		public function __construct()
		{
			parent::__construct();
			
			//若未登录，转到登录页
			if($this->session->userdata('logged_in') != TRUE):
				redirect(base_url('login'));
			endif;
			
			//只有门店/分公司以上级别管理员可以对素材进行管理
			if($this->session->userdata('level') < 5):
				redirect(base_url());
			endif;
			
			$this->load->model('ad_model');
			$this->load->model('referral_model');
		}
		
		//广告控制台首页
		public function index($ad_id = FALSE)
		{
			$data['class'] = 'ad';
			$data['title'] = '素材管理';
			
			$this->load->view('templates/header', $data);
			
			if($ad_id == FALSE):
				$data['ads'] = $this->ad_model->select();
				$this->load->view('ad/index', $data);
				
			else:
				$data['ad'] = $this->ad_model->select($ad_id);
				$data['referrals'] = $this->referral_model->select('ad_id', $ad_id);
				//注意和activity的控制器和模板对比相应功能并修改$data['spreader_performance'] = $this->referral_model->analyse($ad_id , 1);
				//注意和activity的控制器和模板对比相应功能并修改$data['ad_sum'] = $this->referral_model->sum_activity($ad_id);
				$this->load->view('ad/detail', $data);
				
			endif;
			
			$this->load->view('templates/footer');
		}
		
		//新建素材
		public function create()
		{
			$data['class'] = 'ad';
			$data['title'] = '新建素材';
			
			$this->load->view('templates/header', $data);
			$this->load->view('ad/create', $data);
			$this->load->view('templates/footer');
		}
		
		//删除素材（标记为已删除状态）
		public function delete($ad_id)
		{
			$data['class'] = 'ad';
			$data['title'] = '删除素材';

			$this->load->view('templates/header', $data);
			$this->load->view('ad/delete', $data);
			$this->load->view('templates/footer');
		}
		
		//编辑素材
		public function edit($ad_id)
		{
			$data['class'] = 'ad';
			$data['title'] = '编辑素材';

			$this->load->view('templates/header', $data);
			$this->load->view('ad/edit', $data);
			$this->load->view('templates/footer');
		}
	}
	
/* End of file ad.php */
/* Location: ./application/controllers/ad.php */