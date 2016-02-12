<!doctype html>
<html lang=zh-cn>
	<head>
		<meta charset=utf-8>
		<meta http-equiv=x-dns-prefetch-control content=on>
		<link rel=dns-prefetch href="http://cdn.key2all.com">
		<link rel=dns-prefetch href="http://images.key2all.com">
		<title><?php echo isset($title)? $title.' - 思特朗精准营销中枢': '思特朗精准营销中枢 - 世界首款大数据精准营销产品'; ?></title>
		<meta name=description content="思特朗精准营销中枢是世界首款将大数据科学应用到精准营销领域的产品，给予企业高精准度个性化营销及客户关系管理深度管理能力。由森思壮SenseStrong自主研发。">
		<meta name=keywords content="思特朗,精准营销,精准营销管理,精准客户管理,大数据管理,数据库营销">
		<meta name=robots content="nofollow">
		<meta name=version content="revision20160211">
		<meta name=author content="刘亚杰">
		<meta name=copyright content="刘亚杰, 森思壮SenseStrong">
		<meta name=contact content="lianxi@sensestrong.com, http://weibo.com/sensestrong">
		<meta name=viewport content="width=device-width">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<!--[if (lt IE 9) & (!IEMobile)]>
			<script src="http://cdn.key2all.com/js/html5.js"></script>
			<script src="http://cdn.key2all.com/js/css3-mediaqueries.js"></script>
		<![endif]-->
		<script src="http://cdn.key2all.com/js/jquery/new.js"></script>
		<script src="http://cdn.key2all.com/js/jquery/jquery.ui.js"></script>
		<script src="http://cdn.key2all.com/js/jquery/jquery.qrcode.js"></script>
		<script src="http://cdn.key2all.com/js/jquery/jquery.tablesorter.js"></script>
		<script src="http://cdn.key2all.com/js/bootstrap.js"></script>
		<script src="http://cdn.key2all.com/js/highcharts.js"></script>
		
		<link rel=stylesheet media=all href="http://cdn.key2all.com/css/reset.css">
		<link rel=stylesheet media=all href="http://cdn.key2all.com/css/bootstrap.css">
		<link rel=stylesheet media=all href="http://cdn.key2all.com/css/bootstrap-theme.css">
		<link rel=stylesheet media=all href="http://cdn.key2all.com/css/jqueryui/lightness.css">
		<link rel=stylesheet media=all href="<?php echo base_url('css/style.css'); ?>">
		
		<link rel="shortcut icon" href="http://images.key2all.com/logo/brand/3_32x32.png">
		<link rel="apple-touch-icon" href="http://images.key2all.com/logo/brand/3_120x120.png">
		
		<link rel=canonical href="<?php echo current_url() ?>">
		
		<meta name=format-detection content="telephone=yes, address=no, email=no">
		
		<!-- 苹果设备优化 -->
		<meta name=apple-mobile-web-app-capable content=yes>
		<meta name=apple-mobile-web-app-status-bar-style content="black-translucent">
	</head>
<?php
	// 将head内容立即输出，让用户浏览器立即开始请求head中各项资源，提高页面加载速度
	ob_flush();flush();
?>
<!-- 内容开始 -->
	<body class="<?php echo $class ?>">
		<header id=header class="navbar navbar-default navbar-fixed-top" role=navigation>
			<nav class=container-fluid>
				<div class=navbar-header>
					<button type=button class=navbar-toggle data-toggle=collapse data-target=".navbar-collapse">
					<span class="sr-only">展开/收起菜单</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					</button>
					<h1>
						<a id=logo class=navbar-brand title="思特朗精准营销中枢" href="<?php echo base_url() ?>">思特朗精准营销中枢</a>
					</h1>
				</div>
				<div class="navbar-collapse collapse">
					<?php if ($this->session->level > 0): ?>
				    <ul class="nav navbar-nav">
						<li><a title="回到首页" href="<?php echo base_url() ?>">首页</a></li>
						<?php if ($this->session->level > 4): ?>
						<li class=dropdown>
							<a href=# class=dropdown-toggle data-toggle=dropdown>企业<b class=caret></b></a>
							<ul class=dropdown-menu>
								<?php if ($this->session->level > 7): ?>
								<li><a title="管理公司" href="<?php echo base_url('biz') ?>">公司</a></li>
								<?php endif ?>
								<?php if ($this->session->level > 6): ?>
								<li><a title="管理品牌" href="<?php echo base_url('brand') ?>">品牌</a></li>
								<?php endif ?>
								<!--<li><a title="管理区域" href="<?php echo base_url('area') ?>">区域</a></li>-->
								<?php if ($this->session->level > 5): ?>
								<li><a title="管理门店" href="<?php echo base_url('branch') ?>">门店</a></li>
								<?php endif ?>
								<?php if ($this->session->level > 4): ?>
								<li><a title="管理员工" href="<?php echo base_url('stuff') ?>">员工</a></li>
								<?php endif ?>
							</ul>
						</li>
						<?php endif ?>
						<li class=dropdown>
							<a href=# class=dropdown-toggle data-toggle=dropdown>业务<b class=caret></b></a>
							<ul class=dropdown-menu>
								<li><a title="管理产品" href="<?php echo base_url('product') ?>">产品</a></li>
								<li><a title="管理订单" href="<?php echo base_url('order') ?>">订单</a></li>
								<li><a title="管理消费记录" href="<?php echo base_url('summary') ?>">消费记录</a></li>
								<li><a title="管理积分" href="<?php echo base_url('credit') ?>">积分</a></li>
							</ul>
						</li>
						<?php if ($this->session->level > 4): ?>
						<li><a title="管理会员" href="<?php echo base_url('user') ?>">会员</a></li>
						<li class=dropdown>
							<a href=# class=dropdown-toggle data-toggle=dropdown>营销<b class=caret></b></a>
							<ul class=dropdown-menu>
								<li><a title="管理活动" href="<?php echo base_url('activity') ?>">活动</a></li>
								<li><a title="管理广告位" href="<?php echo base_url('poster') ?>">广告位</a></li>
								<li><a title="管理素材" href="<?php echo base_url('ad') ?>">素材</a></li>
							</ul>
						</li>
						<?php endif ?>
					</ul>
					<?php endif ?>
					<ul class="nav navbar-nav navbar-right">
						<?php if ($this->session->logged_in != TRUE): ?>
						<li><a title="登录" href="<?php echo base_url('login') ?>"><span class="glyphicon glyphicon-log-in"></span> 登录</a></li>
						<?php else: ?>
						<li><a title="个人中心" href="<?php echo base_url('stuff/'.$this->input->cookie($this->config->item('cookie_prefix').'manager_id')); ?>"><span class="glyphicon glyphicon-user"></span> <?php echo $this->session->lastname.$this->session->firstname; ?></a></li>
						<li><a title="退出" href="<?php echo base_url('logout') ?>"><span class="glyphicon glyphicon-log-out"></span> 退出</a></li>
						<?php endif;?>
					</ul>
				</div>
			</nav>
		</header>
		<div id=maincontainer class=container-fluid>