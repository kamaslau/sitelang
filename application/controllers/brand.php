<?php
	if(!defined('BASEPATH')) exit('此文件不可被直接访问');
	
	class Brand extends CI_Controller
	{
		public function __construct()
		{
			parent::__construct();
			
			//若未登录，转到登录页
			if($this->session->userdata('logged_in') != TRUE):
				redirect(base_url('login'));
			endif;
			
			//只有品牌以上级别管理员可以对品牌进行管理
			if($this->session->userdata('level') < 6):
				redirect(base_url());
			endif;
			
			$this->load->model('brand_model');
			$this->load->model('industry_model');
		}

		//品牌列表
		public function index($brand_id = FALSE)
		{
			$data['class'] = 'brand';
			$data['title'] = '品牌管理';
			$data['brands'] = $this->brand_model->select($brand_id);
			
			$this->load->view('templates/header' , $data);
			$this->load->view('brand/index' , $data);
			$this->load->view('templates/footer');
		}

		//新建品牌
		public function create()
		{
			$data['class'] = 'brand';
			$data['title'] = '新建品牌';
			
			$this->load->view('templates/header', $data);
			$this->load->view('brand/create', $data);
			$this->load->view('templates/footer');
		}
		
		//删除品牌（标记为已删除状态）
		public function delete($brand_id)
		{
			$data['class'] = 'brand';
			$data['title'] = '删除品牌';

			$this->load->view('templates/header', $data);
			$this->load->view('brand/delete', $data);
			$this->load->view('templates/footer');
		}
		
		//编辑品牌
		public function edit($brand_id)
		{
			$data['class'] = 'brand';
			$data['title'] = '编辑品牌';

			$this->load->view('templates/header', $data);
			$this->load->view('brand/edit', $data);
			$this->load->view('templates/footer');
		}
	}
	
/* End of file brand.php */
/* Location: ./application/controllers/brand.php */