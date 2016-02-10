		</div>
		<footer id=footer class=container-fluid>
			<p id=copyright>&copy;<?php echo date('Y'); ?> <a title="思特朗精准管理中枢" href="<?php echo base_url(); ?>">思特朗</a> <a href="http://www.miitbeian.gov.cn/" target="_blank" rel="nofollow">鲁ICP备14013078号</a> 思特朗精准管理中枢由<a id=support title="青岛森思壮电子商务有限公司" href="http://www.sensestrong.com/" target=_blank>森思壮SenseStrong</a>研发</p>
		</footer>
		<script>
			//百度统计代码
			var _bdhmProtocol = (('https:' == document.location.protocol) ? 'https://' : 'http://');
			document.write(unescape("%3Cscript src='" + _bdhmProtocol + "hm.baidu.com/h.js%3Fb364fc0562b496249ad7bb1cd573ca78'%3E%3C/script%3E"));
		
			//隐藏微信底部导航栏
			document.addEventListener('WeixinJSBridgeReady', function onBridgeReady() {
				WeixinJSBridge.call('hideToolbar');
			});
			
			$(function(){
				// 表格可排序
				$('table').tablesorter();
				
				//jQueryUi日期选择器(仅非iOS设备)
				<?php if(!strpos($this->input->server('HTTP_USER_AGENT'), 'like Mac OS X')): ?>
				$.datepicker.regional['zh-CN'] = {   
				        clearText: '清除',
				        clearStatus: '清除已选日期',   
				        closeText: '关闭',
				        closeStatus: '不改变当前选择',   
				        prevText: '上月',
				        prevStatus: '显示上月',
				        prevBigText: '<<',
				        prevBigStatus: '显示上一年',   
				        nextText: '下月',
				        nextStatus: '显示下月',   
				        nextBigText: '>>',
				        nextBigStatus: '显示下一年',   
				        currentText: '今天',
				        currentStatus: '显示本月',
				        monthNames: ['一月','二月','三月','四月','五月','六月', '七月','八月','九月','十月','十一月','十二月'],
						monthNamesShort: ['一月','二月','三月','四月','五月','六月', '七月','八月','九月','十月','十一月','十二月'],
				        monthStatus: '选择月份',
				        yearStatus: '选择年份',
				        weekHeader: '周',
				        weekStatus: '年内周次',
				        dayNames: ['星期日','星期一','星期二','星期三','星期四','星期五','星期六'],
				        dayNamesShort: ['周日','周一','周二','周三','周四','周五','周六'],
				        dayNamesMin: ['日','一','二','三','四','五','六'],
				        dayStatus: '设置 DD 为一周起始',
				        dateStatus: '选择 m月 d日, DD',
				        dateFormat: 'yy-mm-dd',
				        firstDay: 7,
				        initStatus: '请选择日期',
				        isRTL: false
					};
				  $.datepicker.setDefaults($.datepicker.regional['zh-CN']);
				  $.datepicker.setDefaults(
					  {
						  showAnim:"clip",
						  showButtonPanel:true,
						  changeMonth:true,
						  changeYear:true,
						  showMonthAfterYear:true
					  }
				  );
				  <?php endif; ?>
				// AJAX获取信息
				/*
				$('.branch td>a , .credit td>a , .order td>a, .summary td>a').hover(
					function(){
						var href = $(this).attr('href');
						$(this).append( $('<span id=info>') );
						getInfo(href);
						return false;
					},
					function(){
						$(this).find('span').remove();
					}
				);
				function getInfo(href){
					//函数主体
					$.get(href , function(data){
						$('#info').html(data);
					});
				}
				*/

				//生成二维码
				$('.generate').click(function(){
					$(this).closest('tr').next('tr.qrcode').slideDown(2000);
					$(this).slideUp();
					return false;
				});
			});
		</script>
	</body>
<!-- 内容结束 -->
</html>