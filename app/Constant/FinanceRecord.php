<?php

/**
 * @Author: saipu
 * @Date:   2018-08-07 16:12:49
 * @Last Modified by:   saipu
 * @Last Modified time: 2018-08-13 19:26:15
 */
namespace App\Contant;

class FinanceRecords{
	const APPLIE  = '提现';   //资金流水类型  提现
	const BUY     = '消费';	  //资金流水类型  消费主要用于购买课程
	const ADD     = '课程被购买';   //资金流水类型   自己的课程被购买
	const PLATFROM = '平台';
	
	const BANLANCE = '余额支付';    //资金流水支付方式  
	const WXPAY	   = '微信支付';    //资金流水支付方式 
	const WXPAYH   = '微信H5支付';    //资金流水支付方式 
	

	public static function trans($type){
		switch ($type) {
			case 'APPLIE':
				return '提现';
			case 'BUY':
				return '消费';
			case 'ADD':
				return '课程被购买';
			case 'PLATFROM':
				return '平台';	
			case 'BANLANCE':
				return '余额支付';
			case 'WXPAY':
				return '微信支付';	
			case 'WXPAYH':
				return '微信H5支付';		
			default:
				# code...
				break;
		}
	}
}