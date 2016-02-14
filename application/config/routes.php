<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes with
| underscores in the controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/

	$route['r/api'] = 'r/index_api';
	$route['r/generate/(:any)'] = 'r/generate/$1';
	$route['r/(:any)'] = 'r/index/$1';

	/* Referral 路由*/
	$route['referral/(:any)'] = 'referral/index/$1';

	/* Manager 登录用户*/
	$route['login/(:any)'] ='manager/login/$1';
	$route['login'] ='manager/login';
	$route['register/(:any)'] ='manager/register/$1';
	$route['register'] = 'manager/register';
	$route['logout'] = 'manager/logout';

	/* Marketing 营销 */
	$route['marketing/create'] = 'marketing/create';
	$route['marketing/(:any)'] = 'marketing/index/$1';
	$route['marketing'] = 'marketing/index';

	/* Activity 活动 */
	$route['activity/edit/(:any)'] = 'activity/edit/$1';
	$route['activity/delete/(:any)'] = 'activity/delete/$1';
	$route['activity/create'] = 'activity/create';
	$route['activity/(:any)'] = 'activity/index/$1';
	$route['activity'] = 'activity/index';

		/* Vote 投票*/
		// Vote Option
		$route['vote/option/edit/(:any)'] = 'vote/option/edit/$1';
		$route['vote/option/restore/(:any)'] = 'vote/option/restore/$1';
		$route['vote/option/delete/(:any)'] = 'vote/option/delete/$1';
		$route['vote/option/create'] = 'vote/option/create';
		$route['vote/option/(:any)'] = 'vote/option/index/$1';
		$route['vote/option'] = 'vote/option/index';
		// Vote
		$route['vote/edit/(:any)'] = 'vote/edit/$1';
		$route['vote/delete/(:any)'] = 'vote/delete/$1';
		$route['vote/create'] = 'vote/create';
		$route['vote/(:any)'] = 'vote/index/$1';
		$route['vote'] = 'vote/index';

	/* Ad 素材 */
	$route['ad/edit/(:any)'] = 'ad/edit/$1';
	$route['ad/delete/(:any)'] = 'ad/delete/$1';
	$route['ad/create'] = 'ad/create';
	$route['ad/(:any)'] = 'ad/index/$1';
	$route['ad'] = 'ad/index';

	/* Poster 广告位 */
	$route['poster/edit/(:any)'] = 'poster/edit/$1';
	$route['poster/delete/(:any)'] = 'poster/delete/$1';
	$route['poster/create'] = 'poster/create';
	$route['poster/(:any)'] = 'poster/index/$1';
	$route['poster'] = 'poster/index';

	/* Biz 公司 */
	$route['biz/edit/(:any)'] = 'biz/edit/$1';
	$route['biz/delete/(:any)'] = 'biz/delete/$1';
	$route['biz/create'] = 'biz/create';
	$route['biz/(:any)'] = 'biz/index/$1';
	$route['biz'] = 'biz/index';

	/* Brand 品牌 */
	$route['brand/edit/(:any)'] = 'brand/edit/$1';
	$route['brand/delete/(:any)'] = 'brand/delete/$1';
	$route['brand/create'] = 'brand/create';
	$route['brand/(:any)'] = 'brand/index/$1';
	$route['brand'] = 'brand/index';

	/* Area 区域 未启用*/
	$route['area/edit/(:any)'] = 'area/edit/$1';
	$route['area/delete/(:any)'] = 'area/delete/$1';
	$route['area/create'] = 'area/create';
	$route['area/(:any)'] = 'area/index/$1';
	$route['area'] = 'area/index';

	/* Branch 门店/分公司 */
	$route['branch/edit/(:any)'] = 'branch/edit/$1';
	$route['branch/delete/(:any)'] = 'branch/delete/$1';
	$route['branch/create'] = 'branch/create';
	$route['branch/(:any)'] = 'branch/index/$1';
	$route['branch'] = 'branch/index';

	/* Stuff 员工 */
	$route['stuff/edit/(:any)'] = 'stuff/edit/$1';
	$route['stuff/delete/(:any)'] = 'stuff/delete/$1';
	$route['stuff/create'] = 'stuff/create';
	$route['stuff/(:any)'] = 'stuff/index/$1';
	$route['stuff'] = 'stuff/index';

	/* Product 产品 */
	$route['product/edit/(:any)'] = 'product/edit/$1';
	$route['product/delete/(:any)'] = 'product/delete/$1';
	$route['product/create'] = 'product/create';
	$route['product/(:any)'] = 'product/index/$1';
	$route['product'] = 'product/index';

	/* User 会员（客户）*/
	$route['user/edit/(:any)'] = 'user/edit/$1';
	$route['user/delete/(:any)'] = 'user/delete/$1';
	$route['user/regroup'] = 'user/regroup';
	$route['user/create'] = 'user/create';
	$route['user/(:any)'] = 'user/index/$1';
	$route['user'] = 'user/index';

	/* Order 订单 */
	$route['order/confirm/(:any)'] = 'order/confirm/$1';
	$route['order/edit/(:any)'] = 'order/edit/$1';
	$route['order/delete/(:any)'] = 'order/delete/$1';
	$route['order/create'] = 'order/create';
	$route['order/(:any)'] = 'order/index/$1';
	$route['order'] = 'order/index';

	/* Summary 消费 */
	$route['summary/edit/(:any)'] = 'summary/edit/$1';
	$route['summary/delete/(:any)'] = 'summary/delete/$1';
	$route['summary/create'] = 'summary/create';
	$route['summary/(:any)'] = 'summary/index/$1';
	$route['summary'] = 'summary/index';

	/* Credit 积分 */
	$route['credit/edit/(:any)'] = 'credit/edit/$1';
	$route['credit/delete/(:any)'] = 'credit/delete/$1';
	$route['credit/create'] = 'credit/create';
	$route['credit/(:any)'] = 'credit/index/$1';
	$route['credit'] = 'credit/index';

	$route['upload/(:any)'] = 'upload/index/$1';
	$route['upload'] = 'upload/index';

	$route['default_controller'] = 'home';
	$route['404_override'] = 'error';
	$route['translate_uri_dashes'] = FALSE;

/* End of file routes.php */
/* Location: ./application/config/routes.php */