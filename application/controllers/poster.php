<?php
	if(!defined('BASEPATH')) exit('此文件不可被直接访问');

	/**
	* Poster Class
	*
	* @author Kamas 'Iceberg' Lau <kamaslau@outlook.com>
	* @copyright SenseStrong <www.sensestrong.com>
	*/
	class Poster extends CI_Controller
	{
		public function __construct()
		{
			parent::__construct();
			
			// Redirect to login page if not logged in.
			if ($this->session->logged_in != TRUE):
				redirect(base_url('login'));
			endif;
			
			// 只有门店/分公司以上级别管理员可以对广告位进行管理
			if ($this->session->level < 5):
				redirect(base_url());
			endif;
			
			$this->load->model('poster_model');
			$this->load->model('referral_model');
		}
		
		// 活动控制台首页
		public function index($poster_id = FALSE)
		{
			$data['class'] = 'poster';
			$data['title'] = '广告位管理';
			
			$this->load->view('templates/header' , $data);
			
			if ($poster_id == FALSE):
				$data['posters'] = $this->poster_model->select();
				$this->load->view('poster/index' , $data);
				
			else:
				$data['poster'] = $this->poster_model->select($poster_id);
				$data['referrals'] = $this->referral_model->select('poster_id' , $poster_id);
				// 注意和activity的控制器和模板对比相应功能并修改$data['spreader_performance'] = $this->referral_model->analyse($poster_id , 1);
				// 注意和activity的控制器和模板对比相应功能并修改$data['poster_sum'] = $this->referral_model->sum_activity($poster_id);
				$this->load->view('poster/detail' , $data);
				
			endif;
			
			$this->load->view('templates/footer');
		}
		
		// TODO:新建广告位
		public function create()
		{
			$data['class'] = 'poster';
			$data['title'] = '新建广告位';
			
			$this->load->view('templates/header' , $data);
			$this->load->view('poster/create' , $data);
			$this->load->view('templates/footer');
		}
		
		// TODO:删除广告位（标记为已删除状态）
		public function delete($poster_id)
		{
			$data['class'] = 'poster';
			$data['title'] = '删除广告位';

			$this->load->view('templates/header', $data);
			$this->load->view('poster/delete', $data);
			$this->load->view('templates/footer');
		}
		
		// TODO:编辑广告位
		public function edit($poster_id)
		{
			$data['class'] = 'poster';
			$data['title'] = '编辑广告位';

			$this->load->view('templates/header', $data);
			$this->load->view('poster/edit', $data);
			$this->load->view('templates/footer');
		}
	}
	
/* End of file Poster.php */
/* Location: ./application/controllers/Poster.php */