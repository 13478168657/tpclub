<?php
namespace App\Utils;


class ImageThumb{

    public function makePic($bodyPic='',$headImage='',$codeImage='',$dir = 'upload/wxqrcode/', $name="社区", $activity=0){
        //创建图片对象
       if($activity == 3 || $activity == 2 ||$activity == 10){
             // $activity = 3 或=2 base图片上传到image.saipubbs.com 目录
            $bodyPic = $bodyPic;
       }elseif($activity == 4){
           $bodyPic = env('IMG_URL').$bodyPic;
       }else{
            // $activity = 0 或=1 base图片上传到m.saipubbs.com 目录
            $bodyPic = public_path().$bodyPic;
       }
       
        $headWidth = config('ImageConfig.headPic.width');
        $headHeight = config('ImageConfig.headPic.height');
        $codeWidth =  config('ImageConfig.verifyCode.width');
        $codeHeight =  config('ImageConfig.verifyCode.height');
        $paddingW   = config('ImageConfig.paddingRight.width');
        $paddingH   = config('ImageConfig.paddingRight.height');
        
        
        $headImage = public_path().'/images/listimg.jpg';
       // $codeImage = public_path().$codeImage;
        if($activity == 4){//分销员活动
            $codeImage = env('IMG_URL').$codeImage;
            $codeWidth =  config('ImageConfig.fenxiao.verifyCode.width');
            $codeHeight =  config('ImageConfig.fenxiao.verifyCode.height');
        }else{
            $codeImage = public_path().$codeImage;
        }

        if($activity==3){
            $codeWidth =  150;
            $codeHeight =  150;
        }

        $image = getimagesize($bodyPic);

        switch ($image[2]) { // 图像类型判断
            case 1:
                $image_1 = imagecreatefromgif($bodyPic);
                break;
            case 2:
                $image_1 = imagecreatefromjpeg($bodyPic);
                break;
            case 3:
                $image_1 = imagecreatefrompng($bodyPic);
                break;
        }

        $image1 = getimagesize($codeImage);

        switch ($image1[2]) { // 图像类型判断
            case 1:
                $image_3 = imagecreatefromgif($codeImage);
                break;
            case 2:
                $image_3 = imagecreatefromjpeg($codeImage);
                break;
            case 3:
                $image_3 = imagecreatefrompng($codeImage);
                break;
        }
        
        //$true_image_2 = imagecreatetruecolor($headWidth, $headHeight);
        $true_image_3 = imagecreatetruecolor($codeWidth, $codeHeight);
        //imagecopyresampled($true_image_2, $image_2, 0, 0, 0, 0, $headWidth, $headHeight, imagesx($image_2), imagesy($image_2));
        imagecopyresampled($true_image_3, $image_3, 0, 0, 0, 0, $codeWidth, $codeHeight, imagesx($image_3), imagesy($image_3));
        //创建真彩画布
        //imagecreatetruecolor(int $width, int $height)--新建一个真彩色图像
        $image_4 = imagecreatetruecolor(imagesx($image_1), imagesy($image_1));
        
        //为真彩画布创建白色背景
        //imagecolorallocate(resource $image, int $red, int $green, int $blue)
        $color = imagecolorallocate($image_4, 255, 255, 255);
        //imagefill(resource $image ,int $x ,int $y ,int $color)
        //在 image 图像的坐标 x，y（图像左上角为 0, 0）处用 color 颜色执行区域填充（即与 x, y 点颜色相同且相邻的点都会被填充）
        imagefill($image_4, 0, 0, $color);

        //imagecopyresampled(resource $dst_image ,resource $src_image ,int $dst_x ,int $dst_y ,int $src_x , int $src_y ,int $dst_w ,int $dst_h ,int $src_w ,int $src_h)
        // dst_image:目标图象连接资源
        // src_image:源图象连接资源
        // dst_x:目标 X 坐标点
        // dst_y:目标 Y 坐标点
        // src_x:源的 X 坐标点
        // src_y:源的 Y 坐标点
        // dst_w:目标宽度
        // dst_h:目标高度
        // src_w:源图象的宽度
        // src_h:源图象的高度
        imagecopyresampled($image_4, $image_1, 0, 0, 0, 0, imagesx($image_1), imagesy($image_1), imagesx($image_1), imagesy($image_1));
        //与图片二合成
        //imagecopymerge ( resource $dst_im , resource $src_im , int $dst_x , int $dst_y , int $src_x , int $src_y , int $src_w , int $src_h , int $pct )---拷贝并合并图像的一部分
        // //将 src_im 图像中坐标从 src_x，src_y 开始，宽度为 src_w，高度为 src_h 的一部分拷贝到 dst_im 图像中坐标为 dst_x 和 dst_y 的位置上。两图像将根据 pct 来决定合并程度，其值范围从 0 到 100。当 pct = 0 时，实际上什么也没做，当为 100 时对于调色板图像本函数和 imagecopy() 完全一样，它对真彩色图像实现了 alpha 透明。
        //imagecopymerge($image_4, $true_image_2, 0, 0, 0, 0, $headWidth, $headHeight, 100);
        if($activity==0){
            //默认课程
            imagecopymerge($image_4, $true_image_3, imagesx($image_1)-$paddingW, imagesy($image_1)-$paddingH, 0, 0, $codeWidth, $codeHeight, 100);
        }elseif($activity==2){
            //赛普品牌课程单页面用于咨询老师发给学员
            imagecopymerge($image_4, $true_image_3, imagesx($image_1)-530, imagesy($image_1)-205, 0, 0, $codeWidth, $codeHeight, 100);
        }elseif($activity==3){
            //文章专题页  助力邀请
            imagecopymerge($image_4, $true_image_3, imagesx($image_1)-530, imagesy($image_1)-230, 0, 0, $codeWidth, $codeHeight, 100);
        }elseif($activity == 4){
            imagecopymerge($image_4, $true_image_3, imagesx($image_1)-210, imagesy($image_1)-245, 0, 0, $codeWidth, $codeHeight, 100);
        }else{
            //锦鲤活动页面
            imagecopymerge($image_4, $true_image_3, imagesx($image_1)-550, imagesy($image_1)-200, 0, 0, $codeWidth, $codeHeight, 100);
        }
        $black = imagecolorallocate($image_4, 0, 0, 0);//设置颜色为蓝色
        $font = public_path().'/fonts/兰亭黑简.TTF';
        //img,size,角度，x轴，y轴，color,字体，字符串
       
        if($activity==0){
            imagettftext($image_4, 22, 0, 290, 690, $black, $font, $name);//循环添加文字
        }elseif($activity==3 ||$activity==8){
            imagettftext($image_4, 22, 0, 290, 850, $black, $font, $name);//循环添加文字
        }elseif($activity == 4){

        }else{
            imagettftext($image_4, 22, 0, 290, 820, $black, $font, $name);//循环添加文字
        }
        
        $picName = time().rand(1000,99999).'.jpg';

        $destImage = public_path().'/'.$dir.$picName;
        imagepng($image_4, $destImage);
        imagedestroy($image_1);
        //imagedestroy($image_2);
        imagedestroy($image_3);
        imagedestroy($image_4);
        //imagedestroy($true_image_2);
        imagedestroy($true_image_3);
        return [$destImage,$dir.$picName];
    }

    /*
     * 活动图片制作
     */
    public function makeActivityPic($bodyPic='',$codeImage='',$name,$score,$info){
        //创建图片对象
        $paddingW   = $info['code'][0];
        $paddingH   = $info['code'][1];
        $nameW = $info['name'][0];
        $nameH = $info['name'][1];
        $scoreW = $info['score'][0];
        $scoreH = $info['score'][1];
        $scoreJ = $info['score'][2];
        $scoreJH = $info['score'][3];
        $image = getimagesize($bodyPic);

        switch ($image[2]) { // 图像类型判断
            case 1:
                $image_1 = imagecreatefromgif($bodyPic);
                break;
            case 2:
                $image_1 = imagecreatefromjpeg($bodyPic);
                break;
            case 3:
                $image_1 = imagecreatefrompng($bodyPic);
                break;
        }
//        $image_2 = imagecreatefromjpeg($headImage);

        $image1 = getimagesize($codeImage);

        switch ($image1[2]) { // 图像类型判断
            case 1:
                $image_3 = imagecreatefromgif($codeImage);
                break;
            case 2:
                $image_3 = imagecreatefromjpeg($codeImage);
                break;
            case 3:
                $image_3 = imagecreatefrompng($codeImage);
                break;
        }
        if($score<=45){
            $codeWidth = imagesx($image_3)*1.3;
            $codeHeight = imagesy($image_3)*1.3;
        }else{
            $codeWidth = imagesx($image_3)*1.6;
            $codeHeight = imagesy($image_3)*1.6;
        }


        // $image_3 = imagecreatefromjpeg($codeImage);
        //$true_image_2 = imagecreatetruecolor($headWidth, $headHeight);
        $true_image_3 = imagecreatetruecolor($codeWidth, $codeWidth);
//        dd(imagesx($image_3)+1000,imagesy($image_3)+1000);
        //imagecopyresampled($true_image_2, $image_2, 0, 0, 0, 0, $headWidth, $headHeight, imagesx($image_2), imagesy($image_2));
        $color = imagecolorallocate($true_image_3, 240, 240, 240);
        //imagefill(resource $image ,int $x ,int $y ,int $color)
        //在 image 图像的坐标 x，y（图像左上角为 0, 0）处用 color 颜色执行区域填充（即与 x, y 点颜色相同且相邻的点都会被填充）
        imagefill($true_image_3, 0, 0, $color);
        imagecopyresampled($true_image_3, $image_3, 0, 0, 0, 0, $codeWidth, $codeHeight, imagesx($image_3), imagesy($image_3));
        $trans = imagecolorallocate($true_image_3, 240,240,240);
        $true_image_3 = imagerotate($true_image_3,10,$trans);
        //创建真彩画布
        //imagecreatetruecolor(int $width, int $height)--新建一个真彩色图像
        $image_4 = imagecreatetruecolor(imagesx($image_1), imagesy($image_1));

        //为真彩画布创建白色背景
        //imagecolorallocate(resource $image, int $red, int $green, int $blue)
        $color = imagecolorallocate($image_4, 255, 255, 255);
        //imagefill(resource $image ,int $x ,int $y ,int $color)
        //在 image 图像的坐标 x，y（图像左上角为 0, 0）处用 color 颜色执行区域填充（即与 x, y 点颜色相同且相邻的点都会被填充）
        imagefill($image_4, 0, 0, $color);

        //imagecopyresampled(resource $dst_image ,resource $src_image ,int $dst_x ,int $dst_y ,int $src_x , int $src_y ,int $dst_w ,int $dst_h ,int $src_w ,int $src_h)
        // dst_image:目标图象连接资源
        // src_image:源图象连接资源
        // dst_x:目标 X 坐标点
        // dst_y:目标 Y 坐标点
        // src_x:源的 X 坐标点
        // src_y:源的 Y 坐标点
        // dst_w:目标宽度
        // dst_h:目标高度
        // src_w:源图象的宽度
        // src_h:源图象的高度
        imagecopyresampled($image_4, $image_1, 0, 0, 0, 0, imagesx($image_1), imagesy($image_1), imagesx($image_1), imagesy($image_1));
        //与图片二合成
        //imagecopymerge ( resource $dst_im , resource $src_im , int $dst_x , int $dst_y , int $src_x , int $src_y , int $src_w , int $src_h , int $pct )---拷贝并合并图像的一部分
        // //将 src_im 图像中坐标从 src_x，src_y 开始，宽度为 src_w，高度为 src_h 的一部分拷贝到 dst_im 图像中坐标为 dst_x 和 dst_y 的位置上。两图像将根据 pct 来决定合并程度，其值范围从 0 到 100。当 pct = 0 时，实际上什么也没做，当为 100 时对于调色板图像本函数和 imagecopy() 完全一样，它对真彩色图像实现了 alpha 透明。
        //imagecopymerge($image_4, $true_image_2, 0, 0, 0, 0, $headWidth, $headHeight, 100);
        if($score <=45){
            imagecopymerge($image_4, $true_image_3, imagesx($image_1)-$paddingW-20, imagesy($image_1)-$paddingH+10, 0, 0, $codeWidth+30, $codeHeight+30,100);
        }else{
            imagecopymerge($image_4, $true_image_3, imagesx($image_1)-$paddingW-20, imagesy($image_1)-$paddingH-30, 0, 0, $codeWidth+43, $codeHeight+43, 100);
        }

        $black = imagecolorallocate($image_4, 0, 0, 0);//设置颜色为蓝色
        $font = public_path().'/fonts/兰亭黑简.TTF';
        //img,size,角度，x轴，y轴，color,字体，字符串
        $red = imagecolorallocate($image_4, 255, 0, 0);//设置颜色为蓝色
        imagettftext($image_4, 38, 0, $nameW, $nameH, $black, $font, $name);//添加文字
        imagettftext($image_4, 38, 0, $scoreJ, $scoreJH, $black, $font, '成绩：');//添加文字
        imagettftext($image_4, 38, 0, $scoreW, $scoreH, $red, $font, $score.'分');//循环添加文字


        $picName = time().rand(1000,99999).'.jpg';

        $destImage = public_path().'/images/activity/'.$picName;
        imagepng($image_4, $destImage);
        imagedestroy($image_1);
        //imagedestroy($image_2);
        imagedestroy($image_3);
        imagedestroy($image_4);
        //imagedestroy($true_image_2);
        imagedestroy($true_image_3);
        return [$destImage,'/images/activity/'.$picName];
    }
}