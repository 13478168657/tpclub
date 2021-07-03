<?php

/**
 * @Author: saipu
 * @Date:   2018-08-07 16:20:10
 * @Last Modified by:   saipu
 * @Last Modified time: 2018-08-07 16:25:08
 */
namespace App\Contant;

class Message{
	const COMMENT  = '评论';   //消息类型  评论
	const LIKE     = '喜欢';   //消息类型  喜欢
	const BUY      = '购买';   //消息类型  购买
	

	public static function trans($type){
		switch ($type) {
			case 'COMMENT':
				return '评论';
			case 'LIKE':
				return '喜欢';
			case 'BUY':
				return '购买';
			default:
				# code...
				break;
		}
	}
}