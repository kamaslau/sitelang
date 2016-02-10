<div id=content class="col-md-9 col-sm-8">
	<div id=general_info class="section bg-success">
		<p>今日新增<strong><?php echo $user_join_today ?></strong>位会员（本月累计新增<strong><?php echo $user_join_this_month ?></strong>位）</p>
		<p>会员累计消费<strong><?php echo $total_summary ?></strong>元 剩余<strong><?php echo $total_credit ?></strong>积分待使用</p>
	</div>
	
	<nav id=naver>
		<?php if($this->session->userdata('level') > 0): ?>
		<div class="section panel panel-primary">
			<div class="panel-heading">
				<h2 class="panel-title">主要业务</h2>
		  	</div>
			<ul id=main class="list-inline panel-body row">
				<li class="col-md-3 col-sm-4 col-xs-12">
					<a title="积分换购管理" href="<?php echo base_url('order'); ?>">换购</a>
					<div class=brief>
						共<a title="全部积分换购订单" href="<?php echo base_url('order'); ?>"><?php echo $orders_all ?></a>笔
						<br>
						<a title="待处理积分换购订单" href="<?php echo base_url('order'); ?>"><?php echo $orders_pending ?></a>笔未处理
					</div>
				</li>
				<li class="col-md-3 col-sm-4 col-xs-12">
					<a title="积分管理" href="<?php echo base_url('credit'); ?>">积分</a>
				</li>
				<?php if($this->session->userdata('level') > 4): ?>
				<li class="col-md-3 col-sm-4 col-xs-12">
					<a title="会员管理" href="<?php echo base_url('user'); ?>">会员</a>
					<div class=brief>
						<a title="今日生日会员" href="<?php echo base_url('user/recent_dob/1'); ?>"><?php echo $user_dob_today ?></a>位今日生日
						<br>
						<a title="本月生日会员" href="<?php echo base_url('user/recent_dob/2'); ?>"><?php echo $user_dob_this_month ?></a>位本月生日
					</div>
				</li>
				<li class="col-md-3 col-sm-4 col-xs-12">
					<a title="活动管理" href="<?php echo base_url('activity'); ?>">营销</a>
					<div class=brief>
						<a title="活动数量" href="<?php echo base_url('activity'); ?>"><?php echo $activity_count ?></a>个活动
						<br>
						<a title="关注人次" href="<?php echo base_url('activity'); ?>"><?php echo $referral_count ?></a>人次关注
					</div>
				</li>
				<li class="col-md-3 col-sm-4 col-xs-12">
					<a title="产品管理" href="<?php echo base_url('product'); ?>">产品</a>
					<div class=brief>
						<a title="在售产品" href="<?php echo base_url('product'); ?>"><?php echo $product_on ?></a>款在售
						<br>
						<a title="停售产品" href="<?php echo base_url('product'); ?>"><?php echo $product_off ?></a>款停售
					</div>
				</li>
				<li class="col-md-3 col-sm-4 col-xs-12">
					<a title="员工管理" href="<?php echo base_url('stuff') ?>">员工</a>
				</li>
				<?php endif;?>
				<?php if($this->session->userdata('level') > 5): ?>
				<li class="col-md-3 col-sm-4 col-xs-12">
					<a title="门店、分公司管理" href="<?php echo base_url('branch') ?>">门店/分公司</a>
				</li>
				<?php endif;?>
				<?php if($this->session->userdata('level') > 5): ?>
				<li class="col-md-3 col-sm-4 col-xs-12">
					<a title="品牌管理" href="<?php echo base_url('brand') ?>">品牌</a>
				</li>
				<?php endif;?>
				<?php if($this->session->userdata('level') > 5): ?>
				<li class="col-md-3 col-sm-4 col-xs-12">
					<a title="公司管理" href="<?php echo base_url('biz') ?>">公司</a>
				</li>
				<?php endif;?>
			</ul>
			<?php endif;?>
		</div>
		<div class="section panel panel-default">
			<div class="panel-heading">
				<h2 class="panel-title">其它平台商户中心</h2>
		  	</div>
			<ul id=other class="list-inline panel-body row">
				<li class="col-md-3 col-sm-4 col-xs-12">
					<a title="微信公众平台" href="http://mp.weixin.qq.com" target=_blank>微信公众平台</a>
				</li>
				<li class="col-md-3 col-sm-4 col-xs-12">
					<a title="微博企业账号" href="http://weibo.com/login.php" target=_blank>微博企业账号</a>
				</li>
				<li class="col-md-3 col-sm-4 col-xs-12">
					<a title="大众点评商户中心" href="http://e.dianping.com" target=_blank>大众点评</a>
				</li>
				<li class="col-md-3 col-sm-4 col-xs-12">
					<a title="美团商户中心" href="http://e.meituan.com" target=_blank>美团</a>
				</li>
				<li class="col-md-3 col-sm-4 col-xs-12">
					<a title="窝窝团商户中心" href="http://ubp.55.com" target=_blank>窝窝团</a>
				</li>
				<li class="col-md-3 col-sm-4 col-xs-12">
					<a title="拉手网商户中心" href="http://sp.lashou.com" target=_blank>拉手</a>
				</li>
			</ul>
		</div>
		<div class="section panel panel-default">
			<div class="panel-heading">
				<h2 class="panel-title">其它平台</h2>
		  	</div>
			<ul id=shopping class="list-inline panel-body row">
				<li class="col-md-3 col-sm-4 col-xs-12">
					<a title="大众点评" href="http://c.duomai.com/track.php?site_id=62176&aid=299&euid=&t=http%3A%2F%2Ft.dianping.com%2Fqingdao" target=_blank>大众点评</a>
				</li>
				<li class="col-md-3 col-sm-4 col-xs-12">
					<a title="美团" href="http://r.union.meituan.com/url/visit/?a=1&key=6FUHEzwp48rlZSDquAXLVTnY5QxcyR27&url=http://qd.meituan.com/" target=_blank>美团</a>
				</li>
				<li class="col-md-3 col-sm-4 col-xs-12">
					<a title="窝窝团" href="http://55tuan.com" target=_blank>窝窝团</a>
				</li>
				<li class="col-md-3 col-sm-4 col-xs-12">
					<a title="拉手" href="http://c.duomai.com/track.php?site_id=62176&aid=195&euid=&t=http%3A%2F%2Fqingdao.lashou.com%2F" target=_blank>拉手</a>
				</li>
			</ul>
		</div>
		<div class="section panel panel-default">
			<div class="panel-heading">
		    	<h2 class="panel-title">网上支付</h2>
		  	</div>
			<ul id=pay class="list-inline panel-body row">
				<li class="col-md-3 col-sm-4 col-xs-12">
					<a title="支付宝" href="https://www.alipay.com" target=_blank>支付宝</a>
				</li>
				<li class="col-md-3 col-sm-4 col-xs-12">
					<a title="财付通" href="https://www.tenpay.com" target=_blank>财付通</a>
				</li>
				<li class="col-md-3 col-sm-4 col-xs-12">
					<a title="中国银联" href="https://online.unionpay.com" target=_blank>中国银联</a>
				</li>
				<li class="col-md-3 col-sm-4 col-xs-12">
					<a title="快钱" href="https://www.99bill.com" target=_blank>快钱</a>
				</li>
			</ul>
		</div>
		<div class="section panel panel-default">
			<div class="panel-heading">
				<h2 class="panel-title">网上银行</h2>
		  	</div>
			<ul id=bank class="list-inline panel-body row">
				<li class="col-md-3 col-sm-4 col-xs-12">
					<a title="工商银行" href="http://www.icbc.com.cn" target=_blank>工商银行</a>
				</li>
				<li class="col-md-3 col-sm-4 col-xs-12">
					<a title="建设银行" href="http://www.ccb.com" target=_blank>建设银行</a>
				</li>
				<li class="col-md-3 col-sm-4 col-xs-12">
					<a title="交通银行" href="http://www.bankcomm.com" target=_blank>交通银行</a>
				</li>
				<li class="col-md-3 col-sm-4 col-xs-12">
					<a title="农业银行" href="http://www.abchina.com" target=_blank>农业银行</a>
				</li>
				<li class="col-md-3 col-sm-4 col-xs-12">
					<a title="兴业银行" href="http://www.cib.com.cn" target=_blank>兴业银行</a>
				</li>
				<li class="col-md-3 col-sm-4 col-xs-12">
					<a title="招商银行" href="http://www.cmbchina.com" target=_blank>招商银行</a>
				</li>
				<li class="col-md-3 col-sm-4 col-xs-12">
					<a title="中国银行" href="http://www.boc.cn" target=_blank>中国银行</a>
				</li>
				<li class="col-md-3 col-sm-4 col-xs-12">
					<a title="中信银行" href="http://bank.ecitic.com" target=_blank>中信银行</a>
				</li>
			</ul>
		</div>
	</nav>
</div>