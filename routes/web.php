<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::group(["middleware"=>['WechatAuth','UserVisitInfo']],function() {
	Route::group(['middleware' => ['guest']], function () {
		/*
		 * 用户登录
		 */
		Route::get('login', 'Auth\LoginController@login');

		Route::post('auth/login', 'Auth\LoginController@postLogin');
		Route::get('logout', 'Auth\LoginController@logout');
		//用户个人中心管理
		Route::get("/user/followlist", "User\UserController@followList");                 //用户关注列表
		Route::get("/user/fanslist", "User\UserController@fansList");                     //用户粉丝列表
		Route::get("/user/powderlist", "User\UserController@powderList");                 //用户互粉列表
		Route::post("/user/followcancel", "User\UserController@followCancel");            //用户点击取关
		Route::post("/user/followadd", "User\UserController@followAdd");                  //用户点击取关
		Route::get("/user/addmore", "User\UserController@addMore");                       //用户点击关注、粉丝加载更多
		Route::get("/user/addmorepowder", "User\UserController@addMorePowder");           //用户点击互粉加载更多

		Route::get("user/edit", "User\UserController@UserEdit");//编辑个人资料
		Route::get("bind/mobile", "User\UserController@bindMobile");//绑定用户手机号
        Route::post("bind/mobile", "User\UserController@postBindMobile");//绑定手机号
		Route::get("finish/bind", "User\UserController@bindFinish");//完成绑定
		Route::post("bind/interest", "User\UserController@bindInterest");//完成绑定
		Route::get("apply/coach/verify", "User\UserController@coachVerify");//申请教练认证
		Route::post("apply/coach/verify", "User\UserController@applyVerify");//申请教练认证

		Route::post("/user/fileupload", "User\UserController@postUpload");                  //上传客户头像
		Route::post("user/baseUpload", "User\UserController@baseUpload");                  //上传base64客户头像
		Route::post("/user/updateinfo", "User\UserController@userUpdate");                  //上传客户头像


		Route::get("/user/info", "User\UserController@UserIndexInfo");                    //用户个人主页
		Route::get("/user/userstudy", "User\UserController@UserStudy");                   //用户正在学习列表
		Route::get("/user/usercourse", "User\UserController@UserCourse");                 //用户发布课程列表
		Route::get("/user/usercollect", "User\UserController@UserCollect");               //用户收藏课程列表
		Route::get("/user/money", "User\MoneyController@index");                          //我的钱包
		Route::get("/user/news", "User\UserController@news");                             //用户消息
		Route::get("/user/coupons", "User\UserController@coupons"); 					  //我的优惠券
		Route::get("/user/record_coupon", "User\UserController@record_coupon");    		  //我的优惠券
		Route::get("/user/live", "User\UserController@live");    		                  //新建直播
		/**
		 * 用户钱包
		 */
		Route::get("/user/myincome", "User\MoneyController@myincome");                        //我的收入
		Route::get("/user/myrecord", "User\MoneyController@myrecord");                        //支付记录
		Route::get("/user/tixian", "User\MoneyController@tixian");                            //提现界面
		Route::get("/user/help", "User\MoneyController@help");                                //查看帮助
		Route::get("/money/record", "User\MoneyController@getRecord");                        //提现记录分页
		Route::get("/money/myincomeJson", "User\MoneyController@myincomeJson");                //收入json
		/**
		 * 赛普币
		 */
		Route::get("/spb/index", "User\SpbController@index");                               //赛普币首页
		Route::get("/spb/spbJson", "User\SpbController@spbJson");                           //赛普币json
		Route::get("/spb/rules", "User\SpbController@spbRules");                            //赛普币规则

		Route::get("course/commentadd/{course_class_id}", "Course\CourseController@commentAdd");   //添加评论页面
		Route::get('course/collect', 'Course\CourseController@collect');                           //收藏课程
		Route::get('course/nocollect', 'Course\CourseController@noCollect');                       //取消收藏课程

		//抓取推荐文章功能标题
		Route::post('article/capture','Course\CourseController@captureArticle');
		//推荐文章
		Route::get('article/recommend', 'Article\ArticleController@recommend'); 	   	   //文章推荐页面
		Route::get('recommend/success/{id}', 'Article\ArticleController@recommendSuccess');//文章推荐解析页面
		Route::get('article/release/{id}', 'Article\ArticleController@release'); 	   	   //文章推荐发布页面
		Route::get('user/center/{type}.html','User\UserController@userCenter')->where(['id'=>'[0-9]+']); 	//用户中心
		Route::get('user/collect/{type}.html','User\UserController@collect')->where(['id'=>'[0-9]+']); 	//用户信息

		Route::get('collect/addmore/course','User\UserController@addMoreCourse'); 	            //用户信息
		Route::get('wechat/share/{id}','Wechat\WechatController@wechatShare');
		Route::get('wechat/shareArticle/{id}','Wechat\WechatController@wechatShareArticle'); 	//分享专题课程
		Route::get('wechat/shareZt.html','Wechat\WechatController@wechatShareZt'); 	            //分享专题课程

		
		Route::get('zt/experinfo.html', 'Zt\ZtController@experinfo');                           //产品体验官详情页

		/**
		 * 咨询老师分销系统
		 */
		Route::get('dist/sale/index.html','Distribution\DisSaleController@index');                     //分销中心
		Route::get('dist/sale/form','Distribution\DisSaleController@form');                            //提交申请

		//期刊内容
		Route::get('content','Content\ContentController@index');

	});
	Route::get('journal/active','Content\ContentController@activeJournal');
	Route::post('journal/wx/code','Content\ContentController@journalWxCode');
	Route::post('journal/upload','Content\ContentController@codeUpload');
	Route::get('userCenter/addMore','User\UserController@userCenterInfoMore');                  //加载更多信息
	Route::get('register', 'Auth\LoginController@register');
	Route::get('/', 'Course\CourseController@index');
	Route::get('register/access.html', 'Auth\LoginController@registerAccess');
	Route::get('/indextwo', 'Course\CourseController@indextwo');                                //测试新首页
	Route::get('/course/free', 'Course\CourseController@free');                                 //测试新首页


	Route::post('send/acode', 'Auth\LoginController@getVerifyCode');
	Route::post('user/register', 'Auth\LoginController@postRegister');
	Route::post('user/login', 'Auth\LoginController@postLogin');
	Route::get('user/logins', 'Auth\LoginController@postLogins');     //2018-12-21  临时测试
	Route::post('forget/password', 'Auth\LoginController@passwordBack');

	//课程中心

	Route::get('course/getjson', 'Course\CourseController@getJson');                           //加载页
	Route::get('course/tag', 'Course\CourseController@tag');                                   //课程标签页
	Route::get('course/tagdetail/{id}.html', 'Course\CourseController@tagDetail');             //课程标签页
	Route::get('course/TagGetJson', 'Course\CourseController@TagGetJson');                     //课程标签页json页
	Route::get('course/type/{id}.html', 'Course\CourseController@type');                       //课程分类
	Route::get('course/detail/{id?}', 'Course\CourseController@detail');                   	   //课程详细页
	Route::get('course/activity', 'Course\CourseController@activity');                         //课程活动详细页
	Route::get('course/middle/{id}/{vid}', 'Course\CourseController@middle');                  //报名成功关注公众号
	Route::get('course/activityindex', 'Course\CourseController@activityindex');               //课程活动首页
	Route::get('course/activitym', 'Course\CourseController@activitym');               		   //课程活动首页
	Route::get('course/video/{id}/{vid}.html', 'Course\CourseController@video');               //课程详细视频页
	Route::get('group/video/{gid}/{id}.html', 'Course\CourseController@groupVideo');               //课程详细视频页
	Route::get('course/paySpb', 'Course\CourseController@paySpb');               			   //课程详细视频页
	Route::get('course/detailcard/{id}.html', 'Course\CourseController@detailCard');           //课程邀请卡页面
	Route::get('course/activity', 'Course\CourseController@activityAll');                      //全部活动
	Route::get('course/content/{id}/{content_id}.html', 'Course\CourseController@content');    //课程内容页

	/**
	 * 修改后新课程页面
	 */
	Route::get('course/ctypeDetail/{id}/{cid}.html', 'Course\CourseController@ctypeDetail');
	Route::get('course/courseAll/{tagid}.html', 'Course\CourseController@courseAll');
	Route::get('course/getCourseJson/{tagid}/{page}', 'Course\CourseController@getCourseJson');

	/*-----end-----*/

	Route::get('course/enroll', 'Course\CourseController@enroll');                             //报名课程
	Route::post('course/no_entroll', 'Course\CourseController@no_entroll');                    //取消报名课程
	Route::get('video/detail', 'Course\CourseController@videoDetail');                         //取消报名课程

	Route::get('course/detailnew', 'Course\CourseController@detailnew');                       //课程详细页
	Route::get('course/comments/{course_class_id}.html', 'Course\CourseController@comments');  //课程评论页面
	Route::get("course/commentmore", "Course\CourseController@commentMore");                   //用户点击评论加载更多
	Route::post("course/commentdel", "Course\CourseController@commentDel");                    //用户点击删除自己的评论
	Route::get("/fee/course", "Course\CourseController@sendCourse");//免费课程
	Route::get("/user/addmorecourse", "User\UserController@addMoreCourseClass");               //用户点击课程加载更多

	Route::post('course/commentinsert', 'Course\CourseController@commentInsert');              //ajax添加评论
	Route::any('course/consultation/{c_c_id}.html', 'Course\CourseController@consultation');   //在线咨询

	Route::get('course/pay/{c_id}', 'Course\CourseController@pay');           				   //课程支付页面
	Route::any('course/notify', 'Course\CourseController@notify');            			       //微信支付回调页面
	Route::post('course/payh', 'Course\CourseController@payH');               				   //课程H5支付页面
	Route::any('course/notifyh', 'Course\CourseController@notifyH');          				   //微信H5支付回调页面
	Route::get('course/paybalance', 'Course\CourseController@payBalance');    				   //客户余额支付
	Route::post('course/buy', 'Course\CourseController@pay');
	Route::post('course/playrecord', 'Course\CourseController@coursePlay');				  	   //记录课程及视频播放次数
	Route::get('course/playrecordempty', 'Course\CourseController@coursePlayEmpty');		   //处理reids课程视频播放记录
	Route::get('course/tab.html', 'Course\CourseController@courseTab');		   //处理reids课程视频播放记录

	Route::any('activeCourse/notify', 'Course\ActiveCourseController@notify');//活动课程微信支付回调页面
	Route::post('activeCourse/payh', 'Course\ActiveCourseController@payH');//活动课程H5支付页面
	Route::any('activeCourse/notifyh', 'Course\ActiveCourseController@notifyH');//活动课程微信H5支付回调页面
	Route::post('activeCourse/buy', 'Course\ActiveCourseController@pay');//活动课程购买

	//acsm
	Route::post('activeCourse/acsm/buy','A\AcsmController@pay');//acsm课程购买

	Route::any('activeCourse/acsm/notify', 'A\AcsmController@notify');//acsm活动课程微信支付回调页面
	Route::post('activeCourse/acsm/payh', 'A\AcsmController@payH');//acsm活动课程微信支付回调页面
	Route::any('activeCourse/acsm/notifyh', 'A\AcsmController@notifyH');//acsm活动课程微信支付回调页面
	Route::post('activeCourse/acsm/poster','A\AcsmController@acsmPoster');//acsm活动课程分享海报

	Route::get('course/access.html','Course\ActiveCourseController@freeCourse');//免费获课活动领取页
	Route::get('course/train/access.html','Course\ActiveCourseController@freeDoCourse');//免费获课活动领取页
	Route::post('course/free/judge','Course\ActiveCourseController@getFreeCourse');//判断是否可以收获课程
	Route::post('course/video/finish','Course\ActiveCourseController@videoFinish');//判断是否播放完成
	Route::post('course/send/spb','Course\ActiveCourseController@sendSpb');//判断是否播放完成

	//用户个人中心管理
	Route::get("/user/index", "User\UserController@UserIndex");                       //用户个人中心
	Route::get("/user/teacher/{tid}/{type}.html", "User\UserController@teacherInfo");             //讲师详情页面
	Route::get("/user/newuser", "User\UserController@newUser");                       //新手指南
	Route::get("/user/about", "User\UserController@aboutUs");                         //关于我们
	Route::get("/feedback", "User\UserController@feedback");                          //意见反馈
	Route::get("/user/shareFriends", "User\UserController@shareFriends"); 			  //邀请好友
	Route::get("/user/friendsmore", "User\UserController@shareFriendsMore"); 		  //邀请好友加载更多
	Route::get("/user/dataempty", "User\UserController@dataempty"); 			      //数据为空
	//底部导航正在学习
	Route::get("/user/studying", "User\UserController@UserStudying");                 //上传客户头像
	Route::get("/user/clock.html", "User\UserController@clock");                 	  //正在学习列表 --用户打卡课程
	Route::get("/user/train.html", "User\UserController@groupStudy");//组合课程
	Route::get("underline/course.html", "User\UserController@underlineCourse"); //线下大课列表
	Route::get("activeCourse/addUserInfo/{id}.html", "Course\ActiveCourseController@addUserInfo"); //加载更多活动课程
	Route::post("activeCourse/create", "Course\ActiveCourseController@createUserInfo"); //加载更多活动课程

	Route::post("/user/moreclock", "User\UserController@moreclock");             //正在学习列表 --用户打卡课程--加载更多
	Route::get("/user/task", "User\UserController@UserTask");                         //客户任务

	//意见反馈
	Route::post("/feedback/feedback_save", "User\UserController@feedback_save");
	Route::get("/openid", "Course\CourseController@getOpenid");
	Route::get("/wxpush", "Course\CourseController@wxPush");

	//微信开发
	Route::any("/wxinfo", "Wechat\WechatController@index");
	Route::any('/wechat/upload', 'Wechat\WechatController@uplodeTmp');                 //测试上传微信素材
	Route::get('/wechat/qrcode', 'Wechat\WechatController@getQRcode');                 //测试上传微信素材
	Route::get('/wechat/img', 'Course\CourseController@doImage');    		           //测试上传微信素材
	Route::any('wechatTest/index','Wechat\WechatTestReplyController@index');

	//文章

	Route::get('article/articleTag1.html', 'Article\ArticleController@articleTag1');           //文章首页

	Route::get('article/{type_id}.html', 'Article\ArticleController@index');           //文章首页
	Route::get('article/question/{type_id}.html', 'Article\ArticleController@question');//文章首页	
	Route::get('article/tag/{tag_id}.html', 'Article\ArticleController@articleTag');   //文章标签列表页面
	Route::post('article/addmore', 'Article\ArticleController@articleMore');   		   //文章加载更多标签页	
	Route::get('article/addmorei', 'Article\ArticleController@articleMoreIndex');      //文章加载更多首页
	Route::get('article/selectedmore', 'Article\ArticleController@articleSelectedMore'); //文章精选加载更多
	Route::get('article/detail/{id}.html', 'Article\ArticleController@detail');        //文章详情页
	Route::post('article/collect', 'Article\ArticleController@collect');               //文章收藏/取消收藏
	Route::post('article/like', 'Article\ArticleController@like');          		   //文章喜欢/取消喜欢
	Route::post('article/commentinsert', 'Article\ArticleController@commentInsert');   //ajax文章添加评论
	Route::post('article/commentdel', 'Article\ArticleController@commentDel');         //ajax删除文章评论
	Route::get('article/comment/{article_id}.html', 'Article\ArticleController@ArticleComments'); //文章详情页
	Route::get('article/commentmore', 'Article\ArticleController@commentMore'); 	   //文章评论加载更多
	Route::get('search', 'Article\ArticleController@search'); 	   			   		   //文章、课程检索页面
	Route::get('searchr.html', 'Article\ArticleController@searchResult'); 	   		   //文章、课程检索页面
	Route::post('article/spbArticle', 'Article\ArticleController@spbArticle'); 	   	   //分享文章获取spb
	Route::post('article/verify', 'Article\ArticleController@articleVerify'); 	   	   //分享文章获取spb

	Route::get('articletest/{type_id}.html', 'Article\ArticleController@indextest');      //新版文章首页测试	

	Route::get('articles', 'Article\ArticleController@allLink'); 	   		   		   //所有文章链接临时测试
	Route::get('userdata', 'Article\ArticleController@userData'); 	   		   		   //导用户数据

	Route::get('/zt/yearinfo.html', 'Zt\ZtController@yearinfo');                        //限时福利
	Route::get('/zt/rsort.html', 'Zt\ZtController@reserveSort');                        //邀请排行
	Route::get('/zt/addMore', 'Zt\ZtController@getMoreRank');//排行更多

	/*------好友助力--------*/

	Route::get('/assistance/index/{id}.html', 'Assistance\AssistanceController@index');				//好友助力首页
	Route::get('/assistance/friend/{id}.html', 'Assistance\AssistanceController@friend');			//好友助力
	Route::post('/assistance/is_zutuan', 'Assistance\AssistanceController@is_zutuan');				//组团是否成功
	Route::post('/assistance/zhuli', 'Assistance\AssistanceController@store_data');				    //组团是否成功
	Route::get('/assistance/erweima.html', 'Assistance\AssistanceController@erweima');				//组团是否成功
	/*--------end------------------*/
	/*------助力送课-------*/
	Route::get('hand/friend/{id}.html', 'A\HandController@friend');                 //好友助力首页
	Route::get('hand/index.html', 'A\HandController@index');						//好友助力
	Route::post('hand/is_zutuan', 'A\HandController@is_zutuan');	                //组团是否成功
	Route::post('hand/zhuli', 'A\HandController@help');	                            //组团是否成功
	Route::post('hand/poster', 'A\HandController@getPoster');	                    //生成邀请海报
	Route::get('/hand/erweima.html', 'A\HandController@erweima');
	Route::get('hand/record', 'A\HandController@user_play_record');	                //跑数据
	/**
	 *
	 * 专题文章页
	 */
	Route::get('special/list.html', 'Special\SpecialController@dataList');  //专题列表页
	Route::get('special/index/{id}.html', 'Special\SpecialController@index');  //专题首页
	Route::post('special/interest', 'Special\SpecialController@interest'); //关注专题页
	Route::get('article/special/{id}/{sid}.html', 'Article\ArticleController@special');        //文章详情页
	Route::get('special/indexLand/{id}/{sid}.html', 'Special\SpecialController@shareArticle');        //文章登录页
	Route::get('special/indexRegister/{id}/{sid}.html', 'Special\SpecialController@register');        //文章注册页

	/*
	 * 2019课程9.0
	 */
	Route::get('trainer/index.html', 'Zt\ZtController@trainer');  //专题列表页

	/*
     * 活动页面
     */
	Route::get('answer', 'A\ActivityController@index');
	Route::get('get/answer', 'A\ActivityController@scoreInfo');
	Route::any('inviteUser', 'A\ActivityController@inviteUser');
	Route::post('access/course', 'A\ActivityController@getCourse');


	/*
	 * 注册送礼活动
	 */
	Route::get('share/award','A\AwardController@index');
	Route::post('share/get/award','A\AwardController@getAward');
	Route::get('share/receive','A\AwardController@receive');
	Route::get('share/friend','A\AwardController@friend');
	Route::get('share/rank/list','A\AwardController@rank');
	Route::get('share/my/gift','A\AwardController@gift');
	Route::post('share/make/card','A\AwardController@shareCard');

	/**
	 * x新年助力活动送奖品
	 */
	Route::get('newyear/index.html','A\NewyearController@index'); //活动首页
	Route::get('newyear/rule.html','A\NewyearController@rule'); //活动规则
	Route::get('newyear/class/{id}/{aid}.html','A\NewyearController@kecheng'); //活动课程助力
	Route::get('newyear/classhelp/{uid}/{id}/{aid}.html','A\NewyearController@help'); //活动课程助力页
	Route::post('newyear/is_zutuan', 'A\NewyearController@is_zutuan');					//组团是否成功
	Route::post('newyear/zhuli', 'A\NewyearController@store_data');						//组团是否成功
	Route::get('newyear/gift/{aid}.html','A\NewyearController@gift'); 							//礼品页面
	Route::get('newyear/gifthelp/{uid}/{aid}.html','A\NewyearController@gifthelp'); 			//礼品页面
	Route::get('newyear/addr/{aid}.html','A\NewyearController@addr'); 			//礼品页面
	Route::post('newyear/addrsave/{aid}','A\NewyearController@addrsave'); 			//礼品页面
	Route::get('newyear/sharecard/{aid}','A\NewyearController@shareCard'); 			//分享海报链接
	Route::get('newyear/jdshare.html','A\NewyearController@jdshare'); 			//京东卡分配
	Route::get('newyear/erweima.html','A\NewyearController@erweima'); 			//跳转二维码

	Route::get('train/study.html','Course\TrainController@index1');              //20190314活动页
	Route::get('train/success/{gid}.html','Course\TrainController@sponsorBuy');//拼团购买成功参团分享页面
	Route::get('train/join/{id}.html','Course\TrainController@joinBuy');//拼团购买成功参团分享页面
	Route::get('train/study/{id}.html','Course\TrainController@index1');              //20190314活动页
	Route::get('train/pay/{c_id}', 'Course\TrainController@pay');           	//课程支付页面
	Route::any('train/notify', 'Course\TrainController@notify');                //微信支付回调页面
	Route::any('team/train/notify', 'Course\TeamTrainController@notify');       //拼团微信支付回调页面
	Route::post('train/payh', 'Course\TrainController@payH');               	//课程H5支付页面
	Route::post('team/train/payh', 'Course\TeamTrainController@payH');               	//团购h5支付
	Route::any('train/notifyh', 'Course\TrainController@notifyH');          	//微信H5支付回调页面
	Route::any('team/train/notifyh', 'Course\TeamTrainController@notifyH');     //拼团微信H5支付回调页面
	Route::get('train/paybalance', 'Course\TrainController@payBalance');    	//客户余额支付
	Route::post('train/buy', 'Course\TrainController@pay');
	Route::post('team/train/buy', 'Course\TeamTrainController@pay'); //团购微信支付
	Route::get('train/success', 'Course\TrainController@success');    	        //购买成功跳转页面
	Route::get('train/paySpb', 'Course\TrainController@paySpb');                //赛普币支付购买整套课程
	Route::post('train/remark', 'Course\TrainController@remark'); 				//用户信息备注
	Route::get('train/notice', 'Course\TrainController@notice'); 				//用户信息备注
	Route::get('train/refund', 'Course\TrainController@wxRefund'); 				//测试退款
	Route::get('train/refund/result', 'Course\TrainController@wxRefundResult'); //测试查询退款结果
	Route::get('train/list.html', 'Course\TrainController@trainList'); //训练营列表


	//问答专区导师操作页面
	Route::get('ask/special.html','User\SpecialController@askSpecials');              //问答专区列表
	Route::post('ask/specialadd', 'User\SpecialController@askSpecialAdd');            //创建问答专题
	Route::get('ask/specialask/{id}.html', 'User\SpecialController@specailask');      //问答专区待回答
	Route::get('ask/specialtask/{id}.html', 'User\SpecialController@specailtask');    //问答专区作业
	Route::post('ask/taskcreate', 'User\SpecialController@taskCreate');               //导师创建作业
	Route::post('ask/answer', 'User\SpecialController@answerQuestion');               //导师回答问题
	Route::post("/ask/fileupload", "User\SpecialController@postUpload");              //上传问答专区图片
	Route::post("/ask/fileuploadbase", "User\SpecialController@postUploadBase");      //上传问答专区图片2
	Route::post("/ask/deleteimg", "User\SpecialController@deleteImg");                //删除图片
	Route::post("ask/delspecial", "User\SpecialController@delSpecial");               //删除专题
	Route::post('ask/getdetail','User\SpecialController@getDetail');             	  //获取专题详情

	Route::get('ask/answer/{sid}.html','Ask\AskController@index');              		//待导师回答页
	Route::get('ask/question/{sid}.html','Ask\AskController@question');             	//待导师回答页
	Route::get('ask/field/{sid}.html','Ask\AskController@field');              			//待导师回答页
	Route::get('ask/specialdetail.html','Ask\AskController@special');             		//导师专区列表
	Route::post('ask/qadd','Ask\AskController@creates');             					//导师专区列表

	Route::get('ask/zuoye/{zid}/{order}/{can}.html','Ask\AskController@zuoye');           		//作业详情页
	Route::post('ask/loadmore','Ask\AskController@loadmore');             						//加载更多问题
	Route::post('ask/addanswer','Ask\AskController@answer');             						//添加回答
	Route::get('ask/zuoyedetail/{zid}/{aid}/{can}.html','Ask\AskController@zuoyedetail');       //评论页
	Route::get('ask/zyxiangqing/{zid}/{aid}/{can}.html','Ask\AskController@zuoyewendaDetail');//已完成问答详情
	Route::post('ask/zan','Ask\AskController@zan');             								//评论点赞
	Route::post('ask/comment','Ask\AskController@comment');             						//回复评论
	Route::post('ask/morecomment','Ask\AskController@morecomment');             				//加载更多评论
	Route::post('ask/delanswer','Ask\AskController@delanswer');             					//删除答案
	Route::post('ask/loadmorequestion','Ask\AskController@loadmorequestion');             		//加载更多已回答问题

	Route::post('ask/moreanswer','Ask\AskController@moreanswer');//加载更多评论
	Route::get('ask/updatedata','Ask\AskController@updatedata');//导师专区列表

	/*
	 * 常规问答
	 */
	Route::get('cak/{type}.html','Ask\CommonAskController@index');//常规问答列表
	Route::get('cak/loadMore','Ask\CommonAskController@cakLoadMore');//常规问答列表
	Route::post('cak/addQuestion','Ask\CommonAskController@createCommonQuestion');//添加修改问答
	Route::post('cak/delquest','Ask\CommonAskController@delQuestion');//常规问答删除
	Route::post('cak/modquest','Ask\CommonAskController@modQuestion');//常规问答修改
	Route::get('cak/user/add.html','Ask\CommonAskController@create');//常规问答提问页面
	Route::post('cak/addAsk','Ask\CommonAskController@postCreate');//常规问答添加
	Route::post('cak/imgUpload','Ask\CommonAskController@imageUpload');//常规问答
	Route::get('cak/edit.html','Ask\CommonAskController@edit');//常规问答编辑
	Route::get('cak/answer/{qid}/{order}.html','Ask\CommonAskController@answer');//常规回答
    Route::get('cak/loadAnswer','Ask\CommonAskController@loadAnswer');//常规问答加载更多
	Route::get('cak/comment/{aid}.html','Ask\CommonAskController@commComment');//问答评论列表
	Route::get('comment/share/{aid}.html','Ask\CommonAskController@shareComment');//问答评论列表
	Route::post('cak/loadMoreComment','Ask\CommonAskController@loadMoreComment');//加载更多问答评论
	Route::post('cak/addComment','Ask\CommonAskController@addComment');//添加评论
	Route::post('cak/delComment','Ask\CommonAskController@delCommentReply');//删除评论
	Route::post('cak/askagree','Ask\CommonAskController@addAskAgree');//添加评论
	Route::post('cak/answer','Ask\CommonAskController@modifyAnswer');//修改答案
	Route::post('cak/delanswer','Ask\CommonAskController@delAnswer');//删除答案
	Route::post('cak/addanswer','Ask\CommonAskController@postAnswer');//提交答案

	Route::get('get/tags','Ask\CommonAskController@getTags');//常规问答编辑
	Route::post('cak/edit.html','Ask\CommonAskController@postEdit');//常规问答编辑
	Route::post('cak/complain','Ask\CommonAskController@answerComplain');//常规答案举报
	Route::get('cak/search/{tagId}.html','Ask\CommonAskController@searchAsk');//常规答案举报
	Route::get('cak/search/more','Ask\CommonAskController@searchAskByTag');//家在更多常规问答

	/*
	 * 课程顾问分销相关页面
	 */
	Route::get('dist/active/{dis}/{cid}.html','Distribution\DistActiveController@index');//微信咨询
	Route::get('dist/buy/{id}.html','Distribution\DistActiveController@buy');//分销购买
	Route::get('dist/answer/{id}.html','Distribution\DistActiveController@answer');//购买后答题
	Route::post('dist/postAnswer','Distribution\DistActiveController@postAnswer');//购买后答题
	Route::post('dist/payW','Distribution\DistActiveController@pay');//购买
	Route::post('dist/payW/notify','Distribution\DistActiveController@notify');//微信支付回调
	Route::post('dist/payH','Distribution\DistActiveController@payH');//h5微信支付
	Route::post('dist/payH/notify','Distribution\DistActiveController@notifyH');//h5微信支付回调
	Route::get('dist/finish/{cid}/{id}.html','Distribution\DistActiveController@finish');//去打卡
	Route::post('dist/postFinish','Distribution\DistActiveController@postFinish');//去打卡
	Route::get('dist/code.html','Distribution\DistActiveController@disCode');//去打卡
	Route::get('dist/course','Distribution\DistActiveController@disCourse');//课程
	Route::get('dist/study/{id}.html','Distribution\DistActiveController@disStudy');//学习页
	Route::get('dist/share/{cid}/{id}.html','Distribution\DistActiveController@share');//打卡完成分享页
	Route::get('dist/poster/{userId}/{cid}/{id}.html','Distribution\DistActiveController@cardPoster');//分享海报
	Route::post('dist/team/pay','Distribution\TeamDistActiveController@pay');//拼团购买
	Route::post('dist/team/notify','Distribution\TeamDistActiveController@notify');//拼团微信支付回调
	Route::post('dist/team/payh','Distribution\TeamDistActiveController@payH');//拼团h5微信支付
	Route::post('dist/team/notifyh','Distribution\TeamDistActiveController@notifyH');//拼团h5微信支付回调

	//acsm支付考试费用
	Route::post('unline/exam/pay','A\BaomingController@pay');//acsm考试费
	Route::post('unline/exam/notify','A\BaomingController@notify');//acsm考试费
	Route::post('unline/exam/payh','A\BaomingController@payH');//h5支付
	Route::post('unline/exam/notifyh','A\BaomingController@notifyH');//h5支付
	/*
	 * 军事体能教练认证训练课
	 */
    Route::get('coach/{id}.html','Distribution\CoachTrainController@index');                     //微信咨询
    Route::get('coach/code/{id}.html','Distribution\CoachTrainController@generateCode');         //分销购买
    Route::post('coach/share/code.html','Distribution\CoachTrainController@generateShareCode');   //分享二维码
    Route::post('coach/wxshare','Distribution\CoachTrainController@wxShareSuccess');             //微信分享赠送课程

	/**
	 * 课程顾问分销中心
	 */
	//Route::get('distribution/index.html','Distribution\DistributionController@index');         //分销申请流程-分销员中心
	Route::get('distribution/apply.html','Distribution\DistributionController@apply');           //分销申请流程-报名申请
	Route::get('distribution/explain.html','Distribution\DistributionController@disExplain');    //分销说明
	Route::get('distribution/invite/{status}.html','Distribution\DistributionController@invite');//邀请的人
	//Route::get('distribution/home.html','Distribution\DistributionController@home');           //分销主页
	Route::get('distribution/guwen.html','Distribution\DistributionController@guwen');        	 //我的课程顾问
	Route::post('distribution/form_data','Distribution\DistributionController@form_data');       //申请信息s
	Route::post('distribution/loadmore','Distribution\DistributionController@loadmore');         //获取打卡课程更多信息
	Route::post('distribution/shareCard','Distribution\DistributionController@shareCard');        		 //分享卡片
	Route::post('distribution/loadmoreinvite','Distribution\DistributionController@loadmoreinvite');     //加载更多邀请人
	Route::get('distribution/rule.html','Distribution\DistributionController@rule');                     //分销规则
	

	/**
	 * 用户订单列表
	 */
	Route::get('order/group','Order\OrderController@GroupCourseOrder');        //组合大课订单列表
	Route::get('order/clock','Order\OrderController@ClockOrder');              //打卡课程订单列表
	Route::get('order/course','Order\OrderController@CourseOrder');            //精品课程订单列表

	/**
	 * 转介绍测试活动
	 */
	Route::get('intro/staff','Introduction\IntroductionController@staff');                 //转介绍活动员工中心
	Route::get('intro/staffList','Introduction\IntroductionController@staffInfo');         //员工中心
	Route::get('intro/partner/{id}.html','Introduction\IntroductionController@partner');   //合伙人

	Route::get('intro/partnerList','Introduction\IntroductionController@partnerInfo');     //合伙人中心
	Route::post('staff/join','Introduction\IntroductionController@staffJoin');             //用户预定
	Route::post('partner/join','Introduction\IntroductionController@partnerJoin');         //用户预定
	Route::post('intro/poster','Introduction\IntroductionController@getPoster');           //转介绍生成海报
	Route::post('intro/staff/click','Introduction\IntroductionController@staffClicks');    //员工招转介绍人按钮点击次数
	Route::get('intro/load/pic','Introduction\IntroductionController@download');           //转介绍生成海报
	Route::get('intro/share/page','Introduction\IntroductionController@sharePage'); //转介绍页面
	Route::post('intro/partner/card','Introduction\IntroductionController@cardBank'); //转介绍页面
	Route::post('intro/partner/judge','Introduction\IntroductionController@partnerJudge'); //转介绍页面
	Route::get('user/feedback','A\ActivityController@userFeedBack');//就业反馈
	Route::post('post/user/feed','A\ActivityController@postFeedBack');//就业反馈

	Route::get('zt/getclass.html', 'Zt\ZtController@get_class');					//领取课程
	Route::get('zt/getcoupon.html', 'Zt\ZtController@get_coupon');					//领取优惠券
	Route::post('zt/savedata', 'Zt\ZtController@savedata');							//存储手机号
	Route::post('zt/getcoupona', 'Zt\ZtController@getcoupon');							//领取优惠券
    Route::get('travel/manage.html','A\ActivityController@travelManage');


	//问卷调查
	Route::get('user/checkout/{type}.html','A\ActivityController@checkout');
	Route::get('user/feedback/{type}.html','A\ActivityController@feedBack');
	Route::get('feedback/redirect.html','A\ActivityController@feedRedirect');
	Route::post('post/user/feedback','A\ActivityController@postUserFeedback');
	Route::get('brief/intro.html','A\ActivityController@scollInfo');//用户信息

	//nasm活动
	Route::get('nasm/active.html','A\ActivityController@nasmActive');
	Route::post('nasm/apply.html','A\ActivityController@nasmApply');
	Route::get('nasm/form.html','A\ActivityController@nasmForm');
	Route::post('nasm/info/verify','A\ActivityController@infoVerify');
	Route::get('nasm/info/{type}.html','A\ActivityController@nasmInfo');
	Route::get('nasm/access.html','A\ActivityController@nasmAccess');

//

	//教练清单
	Route::get('user/coach/list.html','Distribution\CoachTrainController@coachList');
	Route::get('coach/detail/{id}.html','Distribution\CoachTrainController@coachDetail');
	Route::post('coach/list/agree','Distribution\CoachTrainController@coachAgree');
	Route::post('coach/list/addComment','Distribution\CoachTrainController@addComment');
	Route::post('coach/list/delComment','Distribution\CoachTrainController@delComment');
	Route::post('coach/list/moreComment','Distribution\CoachTrainController@moreComment');
//	Route::get('coach/detail/{id}.html','Distribution\CoachTrainController@coachDetail');
	Route::get('/coach/search/{id}.html"','Distribution\CoachTrainController@coachSearch');

	Route::get('sijiaojingli/mianfei.html','A\SijiaojingliController@mianfei');


	//军体活动页
	Route::get('jt/index.html','A\ActivityController@jtCourse');
	Route::get('jt/junren.html','A\ActivityController@jtJunren');
	Route::get('jt/verify.html','A\ActivityController@jtVerify');
	Route::get('jt/consult.html','A\ActivityController@jtConsult');
	Route::post('jt/user/sync','A\ActivityController@jtSync');


	//活动列表
	Route::post('sy/active/pay','A\GroupCourseController@pay');                 //微信支付
	Route::any('sy/active/notify','A\GroupCourseController@notify');            //微信支付
	Route::post('sy/active/payh','A\GroupCourseController@payH');               //微信支付
	Route::post('sy/active/notifyh','A\GroupCourseController@notifyH');         //微信支付
	//填写表单活动送课
	Route::get('active/form/{id}.html','A\ActivityController@formCourse');//填写表单送课
	Route::post('active/doit/feedback','A\ActivityController@postDoItFeedback');//traindoit活动反馈
    //just do it活动
	Route::get('jdt/active/index','A\JustDoController@index');                  //doit首页
	Route::get('jdt/active/notice','A\JustDoController@notice');                //通知函
	Route::get('jdt/notice/video','A\JustDoController@noticeVideo');            //短视频通知函
	Route::get('jdt/active/baoming','A\JustDoController@baoming');              //doit报名
	Route::post('jdt/active/postJoin','A\JustDoController@postJoin');           //doit参加报名
	Route::post('cover/upload','A\JustDoController@coverUpload');               //doit上传封面
	Route::post('cover/delImg','A\JustDoController@deleteImg');                 //doit删除封面
	Route::get('jdt/active/vote','A\JustDoController@userVote');                //doit投票
	Route::get('jdt/active/vote1','A\JustDoController@userVote1');              //doit投票
	Route::post('jdt/active/postVote','A\JustDoController@postVote');           //doit参与投票
	Route::post('jdt/active/pullTicket','A\JustDoController@pullTicket');       //doit参与投票
	Route::get('jdt/active/rank','A\JustDoController@rank');                    //doit排行
	Route::get('jdt/active/success','A\JustDoController@successPage');          //doit成功页
	Route::get('jdt/active/center/{id}.html','A\JustDoController@center');      //doit个人页面
	Route::post('jdt/active/vote','A\JustDoController@postVote');               //投票
	Route::post('jdt/video/upload','A\JustDoController@videoUpload');           //投票上传视频
	Route::post('jdt/active/delVideo','A\JustDoController@delVideo');           //删除上传视频
	Route::post('jdt/active/poster','A\JustDoController@generatePoster');       //生成分享海报
	Route::get('jdt/active/voteCode','A\JustDoController@createVoteCode');      //生成投票关注公众号二维码
	Route::get('stu/info/collect.html','A\ActivityController@stuCollect'); 	    //生成投票关注公众号二维码
	Route::post('stu/info/create','A\ActivityController@infoCreate'); 	        //生成投票关注公众号二维码

	//20200228优酷直播表单
	Route::get('jdt/youku/baoming','A\JustDoController@youkuBaoming');          //优酷直播报名
	Route::post('jdt/youku/postJoin','A\JustDoController@postJoinYk');          //优酷直播报名执行添加
	//20201124  千人减脂大作战活动
	Route::get('fat/index','A\FatController@index');                            //活动首页
	Route::get('fat/index/load/more','A\FatController@fatLoadMore');                            //活动加载更多
	Route::post('fat/user/vote','A\FatController@userVote');                            //活动首页
	Route::get('fat/hcdel','A\FatController@hcdel');                            //清缓存
	Route::get('fat/user/search','A\FatController@userSearch');                            //活动首页
	Route::get('fat/info','A\FatController@info');                              //活动说明
	Route::get('fat/signup','A\FatController@signUp');                          //活动报名页
	Route::get('fat/ranking','A\FatController@ranking');                        //活动排行
	Route::get('fat/group/rank','A\FatController@groupRank');                        //活动分组排行
	Route::get('fat/member/{id}.html','A\FatController@member');                          //参赛组员详情

	Route::get('fat/body/data','A\FatController@bodyData');                     //录入身体体测数据
	Route::post('fat/cover/upload','A\FatController@CoverUpload');              //上传图片
	Route::post('fat/signup/data','A\FatController@signUpInfo');                //报名信息
	Route::post('fat/body/data','A\FatController@postBodyData');                //体测数据
	Route::get('fat/body/yasuo','A\FatController@yasuo');                      //测试压缩图片
});
//授权登录
Route::get('wechat/auth', 'Auth\WechatAuthController@authLogin');
Route::any('wechat/auth/callback', 'Auth\WechatAuthController@wechatCallback');
Route::get('message/reply', 'Wechat\WeChatMessageController@index');

//专题页
Route::get('zt/tuibian.html', 'Zt\ZtController@tuibian');
Route::get('zt/jianzhi.html', 'Zt\ZtController@jianzhi');
Route::get('zt/kunkun.html', 'Zt\ZtController@kunkun');
Route::get('zt/chenxuesen.html', 'Zt\ZtController@qianxuesen');

Route::get('zt/chenxuesen_href.html', 'Zt\ZtController@qianxuesen_href');
Route::post('zt/store', 'Zt\ZtController@store');
Route::get('zt/exper.html', 'Zt\ZtController@exper'); //产品体验官首页
Route::get('zt/teacher.html', 'Zt\ZtController@teacherFrom'); //新媒体咨询老师页面
Route::get('zt/course.html', 'Zt\ZtController@ztZhaoSheng'); //新媒体咨询老师页面
Route::get('zt/junren.html', 'Zt\ZtController@junren');	//军人
Route::post('zt/savejunren', 'Zt\ZtController@junren_save');//
Route::get('zt/video.html', 'Zt\ZtController@video');//军人
Route::get('zt/ceyice.html', 'Zt\ZtController@ceyice');						//测一测
Route::post('zt/store_ceyice', 'Zt\ZtController@store_ceyice');				//测一测保存
Route::post('zt/getVerifyCode', 'Zt\ZtController@getVerifyCode');				//发送验证码


//品牌词start

Route::get('pinpaici/index.html', 'Zt\ZtController@pinpaici');
Route::get('pinpaici/z_card.html', 'Zt\ZtController@z_card');
Route::get('pinpaici/z_class.html', 'Zt\ZtController@z_class');
Route::get('pinpaici/z_envior.html', 'Zt\ZtController@z_envior');
Route::get('pinpaici/z_job.html', 'Zt\ZtController@z_job');
Route::get('pinpaici/z_prize.html', 'Zt\ZtController@z_prize');
Route::get('pinpaici/z_teacher.html', 'Zt\ZtController@z_teacher');

//转介绍预定
Route::get('intro/reserve/{id}.html','Introduction\IntroductionController@reserve');//用户预定
Route::post('intro/addReserve','Introduction\IntroductionController@postReserve');//用户预定
Route::post('intro/code/send','Introduction\IntroductionController@sendCode');//转介绍短信发送
Route::get('intro/explain.html','Introduction\IntroductionController@tiaoLi');//转介绍短信发送
Route::post('intro/partner/set','Introduction\IntroductionController@clickSet');//合伙人点击量统计
Route::get('intro/share/code.html','Introduction\IntroductionController@joinPartnerPage');//转介绍人加入页
//品牌词end

Route::get('toutiao/access', 'Course\LiveController@touTiao');

//外部接口
Route::get('api/ureserve', 'Api\ApiController@updateReserve');                    //外部api接口
Route::get('api/reservedetail', 'Api\ApiController@getUpdateReserve');            //外部api接口查看用户预定状态
Route::get('token', 'Wechat\WechatController@cur_token');                         //获取token    临时接口
Route::get('unionid', 'User\UserController@UserUnionid');                         //获取unionid  临时接口
Route::get('isfollow', 'User\UserController@isFollow');                           //查看是否关注 临时接口
Route::get('up_order', 'User\UserController@update_order');                       //临时接口删除0.01元课程 目的商户号可以发红包
Route::get('api/form', 'Api\ApiController@receiveData');                          //新媒体老师表单
Route::get('api/student/join', 'Api\ApiController@studentIsJoin');                //查看学员是否入学
Route::get('api/employee', 'Api\ApiController@employeeResource');                 //测试代理录入资源
Route::get('api/employee/info', 'Api\ApiController@studentInfo');                 //测试查看资源信息
Route::get('api/employee/status', 'Api\ApiController@studentStatus');             //测试查看资源状态
Route::get('api/get/wxinfo', 'Api\ApiController@wxinfo');             			  //测试查看
Route::get('api/wxshare', 'Api\ApiController@regWxShare');             			  //测试查看微信分享参数
Route::get('api/staff', 'Api\ApiController@staffPerson');             			  //批量将数据发送导系统
Route::get('api/wxopenid', 'Api\ApiController@wxopenid');             			  //20200620获取用户openid

Route::get('/captcha', 'Auth\LoginController@captcha');//生成验证码


Route::get('train/ask/selectzuoye','Ask\AskController@selectzuoye');		      //课程组作业列表

Route::get('course/zhuanlun','Ask\AskController@zhuanlun');                       //课程组作业列表

/*
 * 20200827新媒体投放页
 */
Route::post('tf/send/code', 'A\ActivityController@getVerifyCode');
Route::post('tf/pay', 'A\ToufangController@pay');
Route::post('tf/notify', 'A\ToufangController@notify');
Route::post('tf/payh', 'A\ToufangController@payH');
Route::post('tf/notifyh', 'A\ToufangController@notifyH');
Route::get('tf/success/{id}.html', 'A\ToufangController@success');
Route::get('tf/successyd/{id}.html', 'A\ToufangController@successYd');
Route::get('tf/result/{id}.html', 'A\ToufangController@result');
Route::get('tf/cert', 'A\ToufangController@cert');
Route::post('tf/info/add', 'A\ToufangController@infoAdd');
Route::post('tf/info/school', 'A\ToufangController@infoAddSchool');  
Route::get('tf/click', 'A\ToufangController@clickNum');         //统计点击数
Route::get('line/vote.html', 'A\ActivityController@lineliveCourse');
Route::get('line/sendCode', 'A\ActivityController@sendInfo');   //临时发送验证码
