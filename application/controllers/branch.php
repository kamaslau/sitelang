<?php
	if(!defined('BASEPATH')) exit('此文件不可被直接访问');
	
	/**
	* Branch Class
	*
	* @author Kamas 'Iceberg' Lau <kamaslau@outlook.com>
	* @copyright SenseStrong <www.sensestrong.com>
	*/
	class Branch extends CI_Controller
	{
		public function __construct()
		{
			parent::__construct();
			
			// Redirect to login page if not logged in.
			if ($this->session->logged_in != TRUE):
				redirect(base_url('login'));
			endif;
			
			// 只有门店/分公司以上级别管理员可以对门店/分公司进行管理
			if ($this->session->level < 5):
				redirect(base_url());
			endif;
			
			$this->load->model('branch_model');
			$this->load->model('industry_model');
		}

		// 门店/分公司列表
		public function index($branch_id = FALSE)
		{
			$data['class'] = 'branch';
			$data['title'] = '门店/分公司管理';

			$data['branchs'] = $this->branch_model->select($branch_id);
		
			$this->load->view('templates/header' , $data);
			$this->load->view('branch/index' , $data);
			$this->load->view('templates/footer');
		}
		
		// 新建门店/分公司
		public function create()
		{
			$data['class'] = 'branch';
			$data['title'] = '新建门店/分公司';
			
			$this->form_validation->set_rules('industry_id', '所在行业', 'trim|is_natural|required');
			$this->form_validation->set_rules('name', '门店/分公司名', 'trim|required');
			$this->form_validation->set_rules('tel', '联系电话', 'trim|is_natural|required');
			$this->form_validation->set_rules('address', '地址', 'trim|required');
			$this->form_validation->set_rules('latitude', '纬度', 'trim');
			$this->form_validation->set_rules('longitude', '经度', 'trim');
			$this->form_validation->set_rules('time_open', '营业开始时间', 'trim|is_natural|required');
			$this->form_validation->set_rules('time_end', '营业结束时间', 'trim|is_natural|required');

			if ($this->form_validation->run() === FALSE):
				// 载入行业列表
				$data['industries'] = $this->industry_model->select();
				
				$this->load->view('templates/header', $data);
				$this->load->view('branch/create', $data);
				$this->load->view('templates/footer');
				
			else:
				if ($this->branch_model->create()):
					$data['title'] = '保存成功';
					$data['content'] = '已经保存新门店资料，请告知公司级管理员进行审核<br><a href="'.base_url('login').'">登录</a>！';
					$this->load->view('templates/header', $data);
					$this->load->view('branch/result', $data);
					$this->load->view('templates/footer');
				endif;
				
			endif;
		}
		
		// 删除/关闭分店/分公司
		public function delete($branch_id)
		{
			$data['class'] = 'branch';
			$data['title'] = '关闭门店/分公司';
			if ($this->session->level < 6):
				$data['content'] = '关闭门店/分公司需要品牌或更高级别管理权限。';

			elseif (!$this->branch_model->status($branch_id, 2)):
				$data['content'] = '关闭失败！';
			
			// 公司负责人可直接关闭门店，否则只能将门店标记为待关闭状态提交公司级管理员审核
			elseif ($this->session->level < 7):
				$data['content'] = '已将该门店/分公司标记为待关闭状态，请告知公司级管理员进行审核。';

			// 关闭成功
			else:
				$data['content'] = '成功关闭！';

			endif;
			
			$this->load->view('templates/header', $data);
			$this->load->view('branch/result', $data);
			$this->load->view('templates/footer');
		}
		
		// TODO:编辑门店/分公司
		public function edit($branch_id)
		{
			$data['class'] = 'branch';
			$data['title'] = '编辑门店/分公司';

			$this->load->view('templates/header', $data);
			$this->load->view('branch/edit', $data);
			$this->load->view('templates/footer');
		}

		// 恢复/开通分店/分公司
		public function restore($branch_id)
		{
			$data['class'] = 'branch';
			$data['title'] = '开通门店/分公司';

			if ($this->session->level < 6):
				$data['content'] = '开通门店/分公司需要品牌级或更高级别管理权限。';
			elseif (!$this->branch_model->status($branch_id, 1)):
				$data['content'] = '开通失败！';

			// 开通成功
			else:
				$data['content'] = '成功开通！';

			endif;
			
			$this->load->view('templates/header', $data);
			$this->load->view('branch/result', $data);
			$this->load->view('templates/footer');
		}
	}
	
/* End of file Branch.php */
/* Location: ./application/controllers/Branch.php */