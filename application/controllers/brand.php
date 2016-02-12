<?php
	if(!defined('BASEPATH')) exit('此文件不可被直接访问');
	
	/**
	* Brand Class
	*
	* @author Kamas 'Iceberg' Lau <kamaslau@outlook.com>
	* @copyright SenseStrong <www.sensestrong.com>
	*/
	class Brand extends CI_Controller
	{
		public function __construct()
		{
			parent::__construct();
			
			// Redirect to login page if not logged in.
			if ($this->session->logged_in != TRUE):
				redirect(base_url('login'));
			endif;
			
			// 只有品牌以上级别管理员可以对品牌进行管理
			if ($this->session->level < 6):
				redirect(base_url());
			endif;
			
			$this->load->model('brand_model');
			$this->load->model('industry_model');
		}

		// 品牌列表
		public function index($brand_id = FALSE)
		{
			$data['class'] = 'brand';
			$data['title'] = '品牌管理';
			$data['brands'] = $this->brand_model->select($brand_id);
			
			$this->load->view('templates/header' , $data);
			$this->load->view('brand/index' , $data);
			$this->load->view('templates/footer');
		}

		// TODO:新建品牌
		public function create()
		{
			$data['class'] = 'brand';
			$data['title'] = '新建品牌';
			
			$this->load->view('templates/header', $data);
			$this->load->view('brand/create', $data);
			$this->load->view('templates/footer');
		}
		
		// TODO:删除品牌（标记为已删除状态）
		public function delete($brand_id)
		{
			$data['class'] = 'brand';
			$data['title'] = '删除品牌';

			$this->load->view('templates/header', $data);
			$this->load->view('brand/delete', $data);
			$this->load->view('templates/footer');
		}
		
		// TODO:编辑品牌
		public function edit($brand_id)
		{
			$data['class'] = 'brand';
			$data['title'] = '编辑品牌';

			$this->load->view('templates/header', $data);
			$this->load->view('brand/edit', $data);
			$this->load->view('templates/footer');
		}
	}

/* End of file Brand.php */
/* Location: ./application/controllers/Brand.php */