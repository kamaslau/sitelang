<?php
	if(!defined('BASEPATH')) exit('此文件不可被直接访问');

	class R extends CI_Controller
	{
		public function __construct()
		{
			parent::__construct();

			$this->load->model('referral_model');
		}

		// 作为RESTful API接收通过微信二维码扫描事件等推送过来的活动统计。
		public function index_api()
		{
			$user_agent = $this->input->post('user_agent')? $this->input->post('user_agent'): NULL;
			$user_ip = $this->input->post('user_ip')? $this->input->post('user_ip'): NULL; // ip地址必须先通过请求API的应用服务器获取后传过来，否则将只能获取该应用服务器IP
			$url = $this->input->post('url');
			// 解密链接
			$link = $this->decode($url);

			// 拆分链接中的参数
			@list($activity_id, $ad_id, $poster_id, $spreader_type, $spreader_id) = split('/', $link);

			// 验证是否存在activity_id指定的活动，若无则自动转到首页
			if(!$this->referral_model->search_activity($activity_id)):
				//redirect(base_url().'?referral_error=no_activity'.'&user_ip='.$user_ip);
			endif;

			// 检查是否有12小时内同user_ip, activity_id, ad_id, poster_id, spreader_type, spreader_id的记录，若有则更新该记录的time_visit并返回referral_id
			if($this->referral_model->find($user_ip, $activity_id, $ad_id, $poster_id, $spreader_type, $spreader_id)):
				$referral_id = $this->referral_model->find($user_ip, $activity_id, $ad_id, $poster_id, $spreader_type, $spreader_id);
				$this->referral_model->update_time($referral_id);

			else:
				// 将链接中的数据存入referral表
				$referral_id = $this->referral_model->create($user_agent, $user_ip, $activity_id, $ad_id, $poster_id, $spreader_type, $spreader_id);

			endif;
			
			if (!empty($referral_id)):
				$output['status'] = 200;
				$output['content']['referral_id'] = $referral_id;
			else:
				$output['status'] = 400;
				$output['content'] = '记录失败！';
			endif;

			header("Content-type:application/json;charset=utf-8");
			$output_json = json_encode($output);
			echo $output_json;
		}

		/**
		 * 解析跟踪链接并进行处理
		 *
		 * @param string $link 待处理的加密参数
		 */
		public function index($url)
		{
			//记录IP地址待用，以防重定向后受访页面访客IP变为服务器本机IP
			if ($_SERVER['HTTP_CLIENT_IP']):
				$user_ip = $_SERVER['HTTP_CLIENT_IP'];
			elseif ($_SERVER['HTTP_X_FORWARDED_FOR']):
				$user_ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
			elseif ($_SERVER['REMOTE_ADDR']):
				$user_ip = $_SERVER['REMOTE_ADDR'];
			elseif (getenv('HTTP_CLIENT_IP')):
				$user_ip = getenv('HTTP_CLIENT_IP');
			elseif (getenv('HTTP_X_FORWARDED_FOR')):
				$user_ip = getenv('HTTP_X_FORWARDED_FOR');
			elseif (getenv('REMOTE_ADDR')):
				$user_ip = getenv('REMOTE_ADDR');
			else:
				$user_ip = 'Unknown';
			endif;
			$user_ip = substr($user_ip, 0, stripos($user_ip, ','));
			$user_agent = $this->session->userdata('user_agent');

			//解密链接
			$link = $this->decode($url);
			//链接中仅允许存在正整数和“/”符号，否则跳转到首页
			//未完成 需写入以下正则表达式：除了（1个正整数 | 1个正整数加1个"/"符号）之外的字符
			/*
			if(preg_match('正则表达式', $link)):
				echo '链接中仅允许存在正整数和“/”符号，否则跳转到首页';
				echo $link;
				exit;
				//redirect(base_url());
			endif;
			*/

			//拆分链接中的参数
			@list($activity_id, $ad_id, $poster_id, $spreader_type, $spreader_id) = split('/', $link);

			//验证是否存在activity_id指定的活动，若无则自动转到首页
			if(!$this->referral_model->search_activity($activity_id)):
				redirect(base_url().'?referral_error=no_activity'.'&user_ip='.$user_ip);
			endif;

			//检查是否有12小时内同user_ip, activity_id, ad_id, poster_id, spreader_type, spreader_id的记录，若有则更新该记录的time_visit并返回referral_id
			if($this->referral_model->find($user_ip, $activity_id, $ad_id, $poster_id, $spreader_type, $spreader_id)):
				$referral_id = $this->referral_model->find($user_ip, $activity_id, $ad_id, $poster_id, $spreader_type, $spreader_id);
				$this->referral_model->update_time($referral_id);
				
			else:
				//将链接中的数据存入referral表
				$referral_id = $this->referral_model->create($user_agent, $user_ip, $activity_id, $ad_id, $poster_id, $spreader_type, $spreader_id);

			endif;

			if($referral_id):
				//将返回的referral_id存入同域cookie待用30分钟
				$this->input->set_cookie('referral_id', $referral_id, 60*30, '.sitelang.cn');

				//获取活动对应的页面，若有则跳转到该页面并将referral_id通过url进行传递，若无则跳转到首页
				if($this->referral_model->getUrl($activity_id)):
					$url = $this->referral_model->getUrl($activity_id);
					if(!empty($url)):
						$url = 'http://'.$url.'/?referral_id='.$referral_id.'&user_ip='.$user_ip;
						redirect($url);

					else:
						redirect(base_url().'?referral_id='.$referral_id.'&referral_error=no_url'.'&user_ip='.$user_ip);

					endif;
					
				else:
					redirect(base_url().'?referral_id='.$referral_id.'&referral_error=no_url'.'&user_ip='.$user_ip);
					
				endif;
				
			endif;
		}
		
		/**
		 * 生成跟踪链接
		 *
		 * @param 	int	$activity_id 活动ID
		 * @param 	int	$ad_id 广告ID（可选）
		 * @param 	int	$poster_id 投放位ID（可选）
		 * @param 	int	$spreader_type 推广员身份类型（1管理员/员工 2会员/用户）（可选）
		 * @param 	int	$spreader_id 投放员ID（可选）
		 * @return	string $link 生成的跟踪链接
		 */
		public function generate($activity_id, $ad_id = NULL, $poster_id = NULL, $spreader_type = 1, $spreader_id = NULL)
		{
			//初步组合链接
			$link = $activity_id;
			if(isset($ad_id)):
				$link.= '/'.$ad_id;
			endif;
			if(isset($poster_id)):
				$link.= '/'.$poster_id;
			endif;
			if(isset($spreader_type)):
				$link.= '/'.$spreader_type;
			endif;
			if(isset($spreader_id)):
				$link.= '/'.$spreader_id;
			endif;

			//将参数进行加密
			$url = $this->encode($link);
			echo $url;
		}

		/**
		 * 对明码参数进行加密，一般为后台功能
		 *
		 * @param string $link 待处理的参数
		 * @return string $code 加密后的参数
		 */
		protected function encode($link)
		{
			$code = strrev(str_rot13( str_rot13(str_shuffle(base64_encode($link))).base64_encode($link) ));
			$code = rawurlencode($code);
			return $code;
		}

		/**
		 * 对加密链接进行解密，一般为前台功能
		 *
		 * @param string $code 待处理的参数
		 * @return string $link 解密后的参数
		 */
		protected function decode($code)
		{
			$code = rawurldecode($code);
			$link = base64_decode( str_rot13(substr(strrev($code), '-'.(strlen( strrev($code) )/2))) );
			return $link;
		}
	}