<?php
	if(!defined('BASEPATH')) exit('此文件不可被直接访问');

	class User extends CI_Controller
	{
		public function __construct()
		{
			parent::__construct();
		
			//若未登录，转到登录页
			if($this->session->userdata('logged_in') != TRUE):
				redirect(base_url('login'));
			endif;
			
			//只有门店/分公司以上级别管理员可以对会员进行操作
			if($this->session->userdata('level') < 5):
				redirect(base_url());
			endif;

			$this->load->model('user_model');
			$this->load->model('summary_model');
		}
	
		//会员管理（会员资料查看等）
		public function index($user_id = FALSE, $period = FALSE)
		{
			$data['class'] = 'user';
			$data['title'] = '会员管理';
			$data['users'] = $this->user_model->select($user_id, $period);

			if($this->input->is_ajax_request()):
				$this->load->view('user/info', $data);
			else:
				$this->load->view('templates/header', $data);
				$this->load->view('user/index', $data);
				$this->load->view('templates/footer');
			endif;
		}
		
		//新建会员
		public function create()
		{
			$data['class'] = 'user';
			$data['title'] = '新建会员';
			
			$this->load->view('templates/header', $data);
			$this->load->view('user/create', $data);
			$this->load->view('templates/footer');
		}
		
		//删除会员（标记为已删除状态）
		public function delete($user_id)
		{
			$data['class'] = 'user';
			$data['title'] = '删除会员';

			$this->load->view('templates/header', $data);
			$this->load->view('user/delete', $data);
			$this->load->view('templates/footer');
		}
		
		//编辑会员
		public function edit($user_id)
		{
			$data['class'] = 'user';
			$data['title'] = '编辑会员';

			$this->load->view('templates/header', $data);
			$this->load->view('user/edit', $data);
			$this->load->view('templates/footer');
		}
	
		//调整用户等级 $type=2升级为充值会员 $type=1降级为普通会员
		public function regroup($user_id, $type = 2)
		{
			$data['class'] = 'user';
		
			//如果是升级，检查是否用户有充值（超过一定数额的消费），边际线暂定为500元
			if( ($type == 2) && ($this->summary_model->check_record($user_id, '500') == 0) ):
				$data['title'] = '调整失败';
				$data['content'] = '未检查到该会员的充值记录，请先协助会员通过“我的会员卡”页“消费兑换积分”项将充值作为消费记录录入，然后重试。';
				$this->load->view('templates/header', $data);
				$this->load->view('user/result', $data);
				$this->load->view('templates/footer');
		
			//调整失败
			elseif( !$this->user_model->regroup($user_id, $type) ):
				$data['title'] = '调整失败';
				$data['content'] = '由于网络原因，用户等级调整失败，请重试！';
				$this->load->view('templates/header', $data);
				$this->load->view('user/result', $data);
				$this->load->view('templates/footer');

			//调整成功
			else:
				$data['title'] = '调整成功';
				$data['content'] = '成功调整了用户的等级';
				$this->load->view('templates/header', $data);
				$this->load->view('user/result', $data);
				$this->load->view('templates/footer');
			endif;
		}
	}

/* End of file user.php */
/* Location: ./application/controllers/user.php */