<?php
	if(!defined('BASEPATH')) exit('此文件不可被直接访问');

	class Activity extends CI_Controller
	{
		public function __construct()
		{
			parent::__construct();
			
			//若未登录，转到登录页
			if($this->session->userdata('logged_in') != TRUE):
				redirect(base_url('login'));
			endif;
			
			//只有门店/分公司以上级别管理员可以对活动进行管理
			if($this->session->userdata('level') < 5):
				redirect(base_url());
			endif;
			
			$this->load->model('activity_model');
			$this->load->model('biz_model');
			$this->load->model('branch_model');
			$this->load->model('brand_model');
			$this->load->model('referral_model');
			$this->load->model('stuff_model');
		}
		
		//活动控制台首页
		public function index($activity_id = FALSE)
		{
			$data['class'] = 'activity';
			$data['title'] = '活动管理';
			
			$this->load->view('templates/header', $data);
			
			if($activity_id == FALSE):
				$data['activities'] = $this->activity_model->select();
				$this->load->view('activity/index', $data);
				
			else:
				$data['activity'] = $this->activity_model->select($activity_id);
				$data['referrals'] = $this->referral_model->select('activity_id', $activity_id);
				$data['spreader_performance'] = $this->referral_model->analyse($activity_id, 1);
				$data['activity_sum'] = $this->referral_model->sum_activity($activity_id);
				$this->load->view('activity/detail', $data);
				
			endif;
			
			$this->load->view('templates/footer');
		}
		
		//新建活动
		public function create()
		{
			$data['bizs'] = $this->biz_model->select();
			$data['brands'] = $this->brand_model->select();
			$data['branchs'] = $this->branch_model->select();
			$data['stuffs'] = $this->stuff_model->select();
			
			$data['class'] = 'activity';
			$data['title'] = '新建活动';

			$this->form_validation->set_rules('name', '活动名称', 'trim|required');
			$this->form_validation->set_rules('url', '活动网址', 'trim|required');
			$this->form_validation->set_rules('time_start', '开始时间', 'trim');
			$this->form_validation->set_rules('time_end', '结束时间', 'trim');
			$this->form_validation->set_rules('detail', '活动简介', 'trim');
		
			//若表单提交不成功
			if ($this->form_validation->run() === FALSE):
				$this->load->view('templates/header', $data);
				$this->load->view('activity/create', $data);
				$this->load->view('templates/footer');
				
			elseif ($this->activity_model->create()):
				$data['content'] = '活动已创建。';
				$this->load->view('templates/header', $data);
				$this->load->view('activity/result', $data);
				$this->load->view('templates/footer');

			endif;
		}
		
		//删除活动（标记为已删除状态）
		public function delete($activity_id)
		{
			$data['class'] = 'activity';
			$data['title'] = '删除活动';
			
			if (!$this->activity_model->delete($activity_id)):
				$data['activity_id'] = $activity_id;
				$this->load->view('templates/header', $data);
				$this->load->view('activity/delete', $data);
				$this->load->view('templates/footer');

			else:
				$data['content'] = '活动已删除。';
				$this->load->view('templates/header', $data);
				$this->load->view('activity/result', $data);
				$this->load->view('templates/footer');

			endif;
		}
		
		//编辑活动
		public function edit($activity_id)
		{
			$data['class'] = 'activity';
			$data['title'] = '编辑活动';

			$this->load->view('templates/header', $data);
			$this->load->view('activity/edit', $data);
			$this->load->view('templates/footer');
		}
	}

/* End of file activity.php */
/* Location: ./application/controllers/activity.php */