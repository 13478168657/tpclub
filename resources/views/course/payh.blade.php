<html>
<head>
    <meta http-equiv="content-type" content="text/html;charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/> 
    <title>微信h5支付</title>
    <script type="text/javascript">
	//调用微信JS api 支付
	function jsApiCall()
	{
		WeixinJSBridge.invoke(
			'getBrandWCPayRequest',
			'llaljoijoj',
			function(res){
				WeixinJSBridge.log(res.err_msg);
				//alert(res.err_code+res.err_desc+res.err_msg);
				if(res.err_msg=='get_brand_wcpay_request:ok'){
					alert('支付成功');
					blacktle2();
				}else{
					alert(res.err_code+res.err_desc+res.err_msg);
				}
			}
		);
	}

	function callpay()
	{
		if (typeof WeixinJSBridge == "undefined"){
		    if( document.addEventListener ){
		        document.addEventListener('WeixinJSBridgeReady', jsApiCall, false);
		    }else if (document.attachEvent){
		        document.attachEvent('WeixinJSBridgeReady', jsApiCall); 
		        document.attachEvent('onWeixinJSBridgeReady', jsApiCall);
		    }
		}else{
		    jsApiCall();
		}
	}
	</script>
	<script type="text/javascript">
	//获取共享地址
	// function editAddress()
	// {
		// WeixinJSBridge.invoke(
			// 'editAddress',
			
			// function(res){
				// var value1 = res.proviceFirstStageName;
				// var value2 = res.addressCitySecondStageName;
				// var value3 = res.addressCountiesThirdStageName;
				// var value4 = res.addressDetailInfo;
				// var tel = res.telNumber;
				
				// alert(value1 + value2 + value3 + value4 + ":" + tel);
			// }
		// );
	// }
	
	window.onload = function(){
		if (typeof WeixinJSBridge == "undefined"){
		    if( document.addEventListener ){
		        document.addEventListener('WeixinJSBridgeReady', editAddress, false);
		    }else if (document.attachEvent){
		        document.attachEvent('WeixinJSBridgeReady', editAddress); 
		        document.attachEvent('onWeixinJSBridgeReady', editAddress);
		    }
		}else{
			editAddress();
		}
	};
	
	</script>
</head>
<body>
    <br/>
    <font color="#9ACD32"><b>该笔订单支付金额为<span style="color:#f00;font-size:50px">1分</span>钱</b></font><br/><br/>
	<div align="center">
		@if($is_buy==1)
			<a style="width:210px; height:100px;background-color:#FE6714; border:0px #FE6714 solid; cursor: pointer;  color:white;  font-size:16px;padding: 20px 20px;border-radius: 5px;" onclick="alert('您已购买')">测试H5支付</a>
		@else
		<a style="width:210px; height:100px;background-color:#FE6714; border:0px #FE6714 solid; cursor: pointer;  color:white;  font-size:16px;padding: 20px 20px;border-radius: 5px;" href="<?php echo $objectxml['mweb_url'];?>">测试H5支付</a>
		@endif
	</div>
</body>
</html>