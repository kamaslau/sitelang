<?php
	if(!defined('BASEPATH')) exit('此文件不可被直接访问');

	/**
	* Order Class
	*
	* @author Kamas 'Iceberg' Lau <kamaslau@outlook.com>
	* @copyright SenseStrong <www.sensestrong.com>
	*/
	class Order extends CI_Controller
	{
		public function __construct()
		{
			parent::__construct();
			
			// Redirect to login page if not logged in.
			if ($this->session->logged_in != TRUE):
				redirect(base_url('login'));
			endif;
			
			$this->load->model('order_model');
			$this->load->model('credit_model');
		}
		
		// 订单列表
		public function index($order_id = FALSE)
		{
			$data['class'] = 'order';
			$data['title'] = '订单管理';
			
			$data['orders'] = $this->order_model->select($order_id);
		
			$this->load->view('templates/header', $data);
			$this->load->view('order/index', $data);
			$this->load->view('templates/footer');
		}
		
		// TODO:删除订单（标记为已删除状态）
		public function delete($order_id)
		{
			$data['class'] = 'order';
			$data['title'] = '删除订单';

			$this->load->view('templates/header', $data);
			$this->load->view('order/delete', $data);
			$this->load->view('templates/footer');
		}
				
		// TODO:编辑订单
		public function edit($order_id)
		{
			$data['class'] = 'order';
			$data['title'] = '编辑订单';

			$this->load->view('templates/header', $data);
			$this->load->view('order/edit', $data);
			$this->load->view('templates/footer');
		}
		
		// 确认订单
		public function confirm($order_id)
		{
			$data['class'] = 'order';
			$data['title'] = '确认订单';
			
			if (!$this->order_model->confirm($order_id)):
				$data['content'] = '订单确认失败（网络原因），请重试！';
			else:
				$data['content'] = '订单确认成功，请为客人加菜！';
			endif;
				
			$this->load->view('templates/header', $data);
			$this->load->view('order/result', $data);
			$this->load->view('templates/footer');
		}
		
		// 取消订单（标记为已取消状态）
		public function cancel($order_id)
		{
			$data['class'] = 'order';
			$data['title'] = '取消订单';
			
			// 获取订单信息
			$data['order'] = $this->order_model->select($order_id);
			$amount = $data['order']['total'];
			$user_id = $data['order']['user_id'];
			
			// 若修改订单信息失败
			if (!$this->order_model->cancel($order_id)):
				$data['content'] = '修改订单状态失败，请重试！';

			elseif (!$this->credit_model->change_credit($user_id, $amount, 1, 4, $this->session->from, $this->session->from_id)):
				$data['content'] = '将积分退回用户失败，请重试！';

			else:
				$data['content'] = '订单取消成功!';

			endif;
			
			$this->load->view('templates/header', $data);
			$this->load->view('order/result', $data);
			$this->load->view('templates/footer');
		}
	}
	
/* End of file Order.php */
/* Location: ./application/controllers/Order.php */