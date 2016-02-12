<?php
	if(!defined('BASEPATH')) exit('此文件不可被直接访问');

	/**
	* Option Class
	*
	* @author Kamas 'Iceberg' Lau <kamaslau@outlook.com>
	* @copyright SenseStrong <www.sensestrong.com>
	*/
	class Option extends CI_Controller
	{
		public function __construct()
		{
			parent::__construct();
			
			// Redirect to login page if not logged in.
			if ($this->session->logged_in != TRUE):
				redirect(base_url('login'));
			endif;
			
			$this->load->model('vote/option_model', 'option_model');
		}
		
		// 投票选项列表
		public function index($vote_id = 1, $option_id = FALSE)
		{
			$data['class'] = 'vote';
			$data['title'] = '投票选项管理';
			$data['options'] = $this->option_model->select($vote_id, $option_id);

			$this->load->view('templates/header', $data);
			$this->load->view('vote/option/index', $data);
			$this->load->view('templates/footer');

		}
		
		// 新增投票选项
		public function create()
		{
			$data['class'] = 'vote';
			$data['title'] = '新增选项';
	
			$this->form_validation->set_rules('name', '名称', 'trim|required');
			$this->form_validation->set_rules('detail', '详情', 'trim');
			$this->form_validation->set_rules('userfile', '图片', 'trim');
		
			// 若表单提交不成功
			if ($this->form_validation->run() === FALSE):
				$this->load->view('templates/header', $data);
				$this->load->view('vote/option/create', $data);
				$this->load->view('templates/footer');
				
			else:
				// 尝试上传
				$config['upload_path'] = './uploads/activity/vote/1/';
				$config['allowed_types'] = 'jpg|png';
				$config['max_size'] = '4096';//文件大小不得高于4M
				$config['max_width']  = '4096';
				$config['max_height']  = '4096';
				$config['encrypt_name'] = TRUE;
				$this->load->library('upload', $config);
				
				// 若上传不成功
				if (!$this->upload->do_upload()):
				    $data['error'] = $this->upload->display_errors();

					$this->load->view('templates/header', $data);
					$this->load->view('vote/option/create', $data);
					$this->load->view('templates/footer');
					
				else:
					$data['upload_data'] = $this->upload->data();
					//获取上传的文件路径，与其它表单字段一起写入数据库，并返回刚上传的产品ID
					$image_url = $data['upload_data']['file_name'];
					$item_id = $this->option_model->create($image_url);
					//获取数据记录
					$data['option'] = $this->option_model->select($this->input->post('vote_id'), $item_id);
					//若新建成功
					$data['title'] = '新建成功';
					$data['content'] = '<p class="alert alert-success">已经成功创建该选项，您可以<a class=alert-link href="'.base_url('vote/option/create').'">继续添加新选项</a></p>';
					$data['content'] .= '<blockquote>文件路径 http://sitelang.cn/uploads/activity/vote/1/'.$data['option'][0]['image'].'</blockquote>';
		 		
					$this->load->view('templates/header', $data);
					$this->load->view('vote/option/result', $data);
					$this->load->view('templates/footer');
					
				endif;
			endif;
		}
		
		// 编辑选项
		public function edit($vote_id, $option_id)
		{
			$data['class'] = 'vote';
			$data['title'] = '编辑投票选项';

			if ($this->session->level < 5):
				$data['content'] = '修改投票选项需要门店/分公司或更高级别管理权限';
			endif;
			
			$this->form_validation->set_rules('name', '名称', 'trim|required');
			$this->form_validation->set_rules('detail', '详情', 'trim');
	
			if ($this->form_validation->run() === FALSE):
				$data['options'] = $this->option_model->select($vote_id, $option_id);
				$this->load->view('templates/header', $data);
				$this->load->view('vote/option/edit', $data);
				$this->load->view('templates/footer');
				
			else:
				if (!$this->option_model->edit($option_id)):
					$data['content'] = '<p class="alert alert-warning">保存失败。</p>';
					
				else:
					$data['content'] = '<p class="alert alert-success">保存成功。</p>';
					
				endif;
				
				$this->load->view('templates/header', $data);
				$this->load->view('vote/option/result', $data);
				$this->load->view('templates/footer');
				
			endif;
			
		}
		
		// 删除选项（标记为已删除状态）
		public function delete($option_id)
		{
			$data['class'] = 'vote';
			$data['title'] = '删除投票选项';
			
			if (!$this->option_model->delete($option_id)):
				$data['content'] = '<p class="alert alert-warning">'.$data['title'].'失败，请重试。</p>';
			
			else:
				$data['content'] = '<p class="alert alert-success">'.$data['title'].'成功。</p>';
				
			endif;

			$this->load->view('templates/header', $data);
			$this->load->view('vote/option/result', $data);
			$this->load->view('templates/footer');
		}
		
		// 恢复选项（标记为正常状态）
		public function restore($option_id)
		{
			$data['class'] = 'vote';
			$data['title'] = '恢复投票选项';

			if (!$this->option_model->restore($option_id)):
				$data['content'] = '<p class="alert alert-warning">'.$data['title'].'失败，请重试。</p>';
			
			else:
				$data['content'] = '<p class="alert alert-success">'.$data['title'].'成功。</p>';
				
			endif;

			$this->load->view('templates/header', $data);
			$this->load->view('vote/option/result', $data);
			$this->load->view('templates/footer');
		}
	}
	
/* End of file Option.php */
/* Location: ./application/controllers/vote/Option.php */