<?php
	if(!defined('BASEPATH')) exit('此文件不可被直接访问');

	/**
	* Product Class
	*
	* @author Kamas 'Iceberg' Lau <kamaslau@outlook.com>
	* @copyright SenseStrong <www.sensestrong.com>
	*/
	class Product extends CI_Controller
	{
		public function __construct()
		{
			parent::__construct();
			
			// Redirect to login page if not logged in.
			if ($this->session->logged_in != TRUE):
				redirect(base_url('login'));
			endif;

			$this->load->model('product_model');
		}
		
		// 产品列表
		public function index($product_id = FALSE)
		{
			$data['class'] = 'product';
			$data['title'] = '产品管理';
			$data['products'] = $this->product_model->select($product_id);

			if($this->input->is_ajax_request()):
				$this->load->view('product/info', $data);
			else:
				$this->load->view('templates/header', $data);
				$this->load->view('product/index', $data);
				$this->load->view('templates/footer');
			endif;
		}
		
		// 新增产品
		public function create()
		{
			$data['class'] = 'product';
			$data['title'] = '新增产品';
	
			$this->form_validation->set_rules('name', '名称', 'trim|required');
			$this->form_validation->set_rules('detail', '详情', 'trim|required');
			$this->form_validation->set_rules('userfile', '图片', 'trim');
			$this->form_validation->set_rules('price_cash', '现金价格', 'trim|is_natural');
			$this->form_validation->set_rules('price_credit', '积分价格', 'trim|is_natural');
			$this->form_validation->set_rules('credit_group', '可用积分兑换此产品用户', 'trim|is_natural');

			// 若表单提交不成功
			if ($this->form_validation->run() === FALSE):
				$this->load->view('templates/header', $data);
				$this->load->view('product/create', $data);
				$this->load->view('templates/footer');

			else:
				// 尝试上传
				$config['upload_path'] = '../'.$this->session->userdata('biz_name_en').'/uploads/product/';
				$config['allowed_types'] = 'jpg|png';
				$config['max_size'] = '2048';//文件大小不得高于2M
				$config['max_width']  = '1280';
				$config['max_height']  = '1280';
				$config['encrypt_name'] = TRUE;
				$this->load->library('upload', $config);
				
				// 若上传不成功
				if (!$this->upload->do_upload()):
				    $data['error'] = $this->upload->display_errors();

					$this->load->view('templates/header', $data);
					$this->load->view('product/create', $data);
					$this->load->view('templates/footer');
					
				else:
					$data['upload_data'] = $this->upload->data();
					// 获取上传的文件路径，与其它表单字段一起写入数据库，并返回刚上传的产品ID
					$image_url = $data['upload_data']['client_name'];
					$item_id = $this->product_model->create($image_url);
					// 获取数据记录
					$data['product'] = $this->product_model->select($item_id);
					// 若新建成功
					$data['title'] = '新建成功';
		 		
					$this->load->view('templates/header', $data);
					$this->load->view('product/create-result', $data);
					$this->load->view('templates/footer');
					
				endif;
			endif;
		}
		
		// TODO:删除产品（标记为已删除状态）
		public function delete($product_id)
		{
			$data['class'] = 'product';
			$data['title'] = '删除产品';

			$this->load->view('templates/header', $data);
			$this->load->view('product/delete', $data);
			$this->load->view('templates/footer');
		}
		
		// TODO:产品编辑
		public function edit($product_id)
		{
			$data['class'] = 'product';
			$data['title'] = '编辑产品';

			// 可一次返回多个产品数据
			$data['products'] = $this->product_model->select($product_id);
			
			$this->load->view('templates/header', $data);
			$this->load->view('product/edit', $data);
			$this->load->view('templates/footer');
		}
		
		// 产品上下架
		public function status($product_id, $status)
		{
			$data['class'] = 'product';
			$data['title'] = '产品'.($status == 1 ? '上架' : '下架');

			// 若产品上下架失败
			if (!$this->product_model->status($product_id, $status)):
				$data['content'] = $data['title'].'失败';
				$this->load->view('templates/header', $data);
				$this->load->view('product/result', $data);
				$this->load->view('templates/footer');
			
			// 若产品上下架成功
			else:
				$data['content'] = $data['title'].'成功';
				$this->load->view('templates/header', $data);
				$this->load->view('product/result', $data);
				$this->load->view('templates/footer');

			endif;
		}
	}
	
/* End of file Product.php */
/* Location: ./application/controllers/Product.php */