$(function (){
    //弹窗
    $('.baomingBtn').click(function(){
        layer.open({
            type: 1,
            title: false, //不显示标题栏
            skin: 'bm_success_layer_wrap', //样式类名
            id: 'bm_success_layer', //设定一个id，防止重复弹出
            closeBtn: 1, //不显示关闭按钮
            anim: 2,
            shadeClose: true, //开启遮罩关闭
            area: ['80%', '70%'],
/*
            content:'<div class="bm_success_layer text_center tan-font"><div class="mt30 pt20 clearfix"><p class="fz bold color_gray666 f30 fl">可保存<br>图片扫码</p><div class="fr"><p class="fz color_gray666 f28 mt10">也可直接加微信号</p><p class="fz bold color_333 f30">18511386354</p></div></div><img src="images/weixiner.jpg" class="bm_success" alt="" /></div>',
*/
            content:'' +
            '<div class="bm_success_layer text_center tan-font">' +
            '<div class="mt30 pt40 plr20">' +
            '<ul class="clearfix mt20">' +
            '<li class="fl f30 bold">' +
            '<p class="fz color_gray666">可保存<br>图片扫码</p>' +
            '</li>' +
            '<li class="fr fz f30 bold">' +
            '<p class="color_gray666">可加微信号</p>' +
            '<p class="color_333">18511386354</p>' +
            '</li>' +
            '</ul>' +
            '</div>' +
            '<img src="images/weixiner.jpg" class="bm_success" alt="" />' +
            '</div>',
            btn:false
        });
    })
})

/*---------------------------本喵是分割线-------------------------------------------------*/

/*左边悬浮返回*/
$(function(){

    /*距离上78处隐藏*/
    if($(window).scrollTop()<=78){
        console.log($(window).scrollTop())
        $('.btn_fanhui').fadeIn("slow");
    }
    $(window).scroll(function (){
        var scrollTop = $(this).scrollTop();
        //console.log(scrollTop);
        if(scrollTop<=78){
            $('.btn_fanhui').fadeOut("slow");
        }else{
            $('.btn_fanhui').fadeIn("slow");
        }
    })

    /*上滑出现 下滑消失*/
    /*var beforeScrollTop = $(window).scrollTop();
    $(window).scroll(function() {
        var afterScrollTop = $(window).scrollTop(),
            updown = afterScrollTop - beforeScrollTop;
        if( updown === 0 ) return false;
        beforeScrollTop = afterScrollTop;
        console.log(updown > 0 ? "down" : "up");

        var isUpDown = updown > 0 ? "down" : "up";  //判断往上还是往下
        var scrollTop = $(window).scrollTop();
        if(isUpDown == 'down' && scrollTop >=78) {  //数据自取，可依据元素的scrollTop值
            $('.btn_fanhui').fadeOut("slow");
        } else if(isUpDown == 'up') {   //往上时做相反
            $('.btn_fanhui').fadeIn("slow");
        }

    });*/

})

/*---------------------------本喵是分割线-------------------------------------------------*/

//播放视频
$(function (){
    //播放视频
    $('.con .video .box2').click(function(){
        $(this).hide();
        /*//首页下点击图片播放的id  //教师下点击图片播放的id
        document.getElementById('video').play();*/
    })
})
$(document).ready(function(){
    $(".thumb").click(function(){
        $(this).parent().next().trigger('play');
    });
});


//点击其中一个播放时，其他的停止播放
// 获取所有video
var videoclose = document.getElementsByTagName("video");
// 暂停函数
function pauseAll() {
    var self = this;
    [].forEach.call(videoclose, function (i) {
        // 将video中其他的video全部暂停
        i !== self && i.pause();
    })
}
// 给play事件绑定暂停函数
[].forEach.call(videoclose, function (i) {
    i.addEventListener("play", pauseAll.bind(i));
})



/*---------------------------本喵是分割线-------------------------------------------------*/
$(function (){
    var topHeight= $(".topimg").height();
    var nav=$('.card-nav');
    var conts=$(".cont");
    nav.find('li').click(function (){
        var index=$(this).index();
        $(this).addClass('cur').siblings().removeClass('cur');
        conts.find('.empty').remove();
        conts.eq(index).prepend("<div class='empty'></div>");
        $("html,body").animate({
            "scrollTop":conts.eq(index).offset().top
        },1000);
    })
    $(window).scroll(function(){
        var top=$(window).scrollTop();
        if($(this).scrollTop()>topHeight){
            nav.addClass("navFix");
        }else{
            nav.removeClass("navFix");
            nav.find('li').removeClass('cur');
        }
        for(i=0;i<conts.length; i++){
            if(top >= $(conts[i]).offset().top-40){
                nav.find('li').eq(i).addClass('cur').siblings().removeClass('cur');
            }
        }
    })

})

/*---------------------------本喵是分割线-------------------------------------------------*/

$(document).ready(function() {
    //首先将#back-to-top隐藏
    $("#back-to-top").hide();

    //当滚动条的位置处于距顶部100像素以下时，跳转链接出现，否则消失
    $(function() {
        $(window).scroll(function() {
            if ($(window).scrollTop() > 500) {
                $("#back-to-top").fadeIn(1500);
            }
            else {
                $("#back-to-top").fadeOut(1500);
            }
        });
        //当点击跳转链接后，回到页面顶部位置
        $("#back-to-top").click(function() {
            $('body,html').animate({
                    scrollTop: 0
                },
                500);
            return false;
        });
    });
});

/*---------------------------本喵是分割线-------------------------------------------------*/













/*=======以下为跳转========*/
/*跳转荣誉下*/
function z_prize(){
    window.open("z_prize.html",'_self');
}

function z_prize_youshi(){
    window.open("z_prize.html#youshi",'_self');
}

/*跳转环境下  -----本页面统称a页面*/

/*a页面【学样在哪个城市模块】---> b页面【训练模块】*/
function z_envior_envior(){
    window.open("z_envior.html?#envior",'_self');
}

/*a页面【学样在哪个城市模块】---> b页面【上海模块】*/
function z_envior_shanghai(){
    window.open("z_envior.html?#shanghai",'_self');
}

/*a页面【学样在哪个城市模块】---> b页面【北京模块】*/
function z_envior_beijing(){
    window.open("z_envior.html?#beijing",'_self');
}

/*a页面【学样在哪个城市模块】---> b页面【深圳模块】*/
function z_envior_shenzhen(){
    window.open("z_envior.html?#shenzhen",'_self');
}


/*a页面【学样在哪个城市模块】---> b页面【训练模块】*/
function z_envior_xunlian(){
    /*window.location="z_envior.html?#xunlian"*/
    window.open("z_envior.html?#xunlian",'_self');
}

/*a页面【校园环境】---> b页面【食堂环境】*/
function z_envior_shitang(){
    /*window.location="z_envior.html?#shitang"*/
    window.open("z_envior.html?#shitang",'_self');
}

/*a页面【宿舍环境】---> b页面【宿舍环境】*/
function z_envior_sushe(){
    /*window.location="z_envior.html?#sushe"*/
    window.open("z_envior.html?#sushe",'_self');
}


/*a页面【推荐就业】---> b页面【就业页面】*/
function z_job_job(){
    /*window.location="z_job.html?#job"*/
    window.open("z_job.html?#job",'_self');
}


/*跳转证书下  -----本页面统称a页面*/
/*a页面【国家证书】---> b页面【国家证书】*/

function z_card(){
    /*window.location="z_card.html?#guojia"*/
    window.open("z_card.html",'_self');
}
function z_card_guojia(){
    /*window.location="z_card.html?#guojia"*/
    window.open("z_card.html?#guojia",'_self');
}

/*a页面【技能证书】---> b页面【高级证书】*/
function z_card_gaoji(){
    /*window.location="z_card.html?#gaoji"*/
    window.open("z_card.html?#gaoji",'_self');
}

/*a页面【国际证书】---> b页面【国际证书】*/
function z_card_guoji(){
    /*window.location="z_card.html?#guoji"*/
    window.open("z_card.html?#guoji",'_self');
}

/*a页面【学历证书】---> b页面【学历证书】*/
function z_card_xueli(){
    /*window.location="z_card.html?#xueli"*/
    window.open("z_card.html?#xueli",'_self');
}




/*a页面【课程】---> b页面【课程页面】*/
function z_class_class(){
    /*window.location="z_class.html?#class"*/
    window.open("z_class.html?#class",'_self');
}
/*a页面【课程】---> b页面【课程高级】*/
function z_class_gaoji(){
    /*window.location="z_class.html?#gaoji"*/
    window.open("z_class.html?#gaoji",'_self');
}
/*a页面【课程】---> b页面【课程中级】*/
function z_class_zhongji(){
    /*window.location="z_class.html?#zhongji"*/
    window.open("z_class.html?#zhongji",'_self');
}
/*a页面【课程】---> b页面【课程初级】*/
function z_class_chuji(){
    /*window.location="z_class.html?#chuji"*/
    window.open("z_class.html?#chuji",'_self');
}


/*a页面【首页教师】---> b页面【教师页面】*/
function z_teacher(){
    window.open("z_teacher.html",'_self');
}





