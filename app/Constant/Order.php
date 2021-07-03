<?php
namespace App\Constant;
/**
 * @Author: saipu
 * @Date:   2018-08-09 13:59:29
 * @Last Modified by:   saipu
 * @Last Modified time: 2018-09-26 11:18:50
 */
class Order{
	const BANLANCE = '余额支付';    //订单支付方式余额支付  
	const WXPAY	   = '微信支付';    //订单支付方式微信内部支付  
	const WXPAYH   = '微信H5支付';  //订单支付方式微信外部支付
	const SPB      = '赛普币';      //订单支付方式赛普币支付

	public static function trans($type){
		switch ($type) {
			case 'BANLANCE':
				return '余额支付';
			case 'WXPAY':
				return '微信支付';
			case 'WXPAYH':
				return '微信H5支付';	
			case 'SPB':
				return '赛普币';					
			default:
				# code...
				break;
		}
	}
}