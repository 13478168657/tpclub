<?php
namespace App\Utils;


class MakeThumbPic{

    public function makePic($bodyPic='',$headImage='',$codeImage='',$dir = 'upload/wxqrcode/', $name="", $activity=0,$commInfo = []){
        //创建图片对象
        if($activity == 3 || $activity == 2 || $activity == 7){
            // $activity = 3 或=2 base图片上传到image.saipubbs.com 目录
            $bodyPic = $bodyPic;
        }else{
            // $activity = 0 或=1 base图片上传到m.saipubbs.com 目录
            $bodyPic = public_path().$bodyPic;
        }
        if($activity == 4) {
            $activityConfig = config('ImageConfig.activity');
        }elseif($activity == 2) {
            //课程专题页面生成邀请卡
            $activityConfig = config('ImageConfig.activity2');
        }elseif($activity == 5) {
            $activityConfig = config('ImageConfig.introduction');
        }elseif($activity == 6) {
            $activityConfig = config('ImageConfig.hand');
        }elseif($activity == 7) {
            $activityConfig = config('ImageConfig.coachTrain');
        }elseif($activity == 8) {
            $activityConfig = config('ImageConfig.askShare');
        }elseif($activity == 9){
            $activityConfig = config('ImageConfig.nasmShare');
        }elseif($activity == 10){
            $activityConfig = config('ImageConfig.sijiaojingli');
        }elseif($activity == 11 || $activity == 111){
            $activityConfig = config('ImageConfig.acsmShare');
        }elseif($activity == 12){
            $activityConfig = config('ImageConfig.trainShare');
        }elseif($activity == 13){
            $activityConfig = config('ImageConfig.shuangshiyi');
        }elseif($activity == 14) {
            $activityConfig = config('ImageConfig.qingshaoer');
        }elseif($activity == 15){
            $activityConfig = config('ImageConfig.justdoit');
        }else{
            $activityConfig = config('ImageConfig');
        }

//        $headWidth = $activityConfig['headPic']['width'];
//        $headHeight = $activityConfig['headPic']['height'];
        $codeWidth =   $activityConfig['verifyCode']['width'];
        $codeHeight =  $activityConfig['verifyCode']['height'];
        $paddingW   = $activityConfig['paddingRight']['width'];
        $paddingH   = $activityConfig['paddingRight']['height'];


        $headImage = public_path().'/images/listimg.jpg';
        if($activity != 9 && $activity != 10 && $activity != 11){
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
            imagecopymerge($image_4, $true_image_3, imagesx($image_1)-$paddingW, imagesy($image_1)-$paddingH, 0, 0, $codeWidth, $codeHeight, 100);
        }elseif($activity==3){
            //文章专题页  助力邀请
            imagecopymerge($image_4, $true_image_3, imagesx($image_1)-530, imagesy($image_1)-230, 0, 0, $codeWidth, $codeHeight, 100);
        }else{
            //锦鲤活动页面
            imagecopymerge($image_4, $true_image_3, imagesx($image_1)-$paddingW, imagesy($image_1)-$paddingH, 0, 0, $codeWidth, $codeHeight, 100);
        }

        if($activity == 5 || $activity == 7){
            $black = imagecolorallocate($image_4, $activityConfig['fontInfo']['color'], $activityConfig['fontInfo']['color1'], $activityConfig['fontInfo']['color2']);//设置颜色为蓝色
        }elseif($activity == 8){
            $black = imagecolorallocate($image_4, $activityConfig['fontInfo']['color'], $activityConfig['fontInfo']['color1'], $activityConfig['fontInfo']['color2']);//设置颜色为蓝色
            $white = imagecolorallocate($image_4, 0, 0, 0);//设置颜色为蓝色
        }elseif($activity ==11){
            $black = imagecolorallocate($image_4, $activityConfig['fontInfo']['color'], $activityConfig['fontInfo']['color1'], $activityConfig['fontInfo']['color2']);//设置颜色为蓝色
            $white = imagecolorallocate($image_4, 0, 0, 0);//设置颜色为蓝色
        }elseif($activity ==15){
            $black = imagecolorallocate($image_4, $activityConfig['fontInfo']['color'], $activityConfig['fontInfo']['color1'], $activityConfig['fontInfo']['color2']);//设置颜色为蓝色
            $white = imagecolorallocate($image_4, 0, 0, 0);//设置颜色为蓝色
        }else{
            $black = imagecolorallocate($image_4, $activityConfig['fontInfo']['color'], 0, 0);//设置颜色为蓝色
        }

        $font = public_path().'/fonts/兰亭黑简.TTF';
        //img,size,角度，x轴，y轴，color,字体，字符串
//        dd($activityConfig['fontInfo']['fontX']);
        if($activity != 111 && $activity != 12 && $activity != 13 && $activity != 14) {
            if($name){
                imagettftext($image_4, $activityConfig['fontInfo']['size'], 0, $activityConfig['fontInfo']['fontX'], $activityConfig['fontInfo']['fontY'], $black, $font, $name);//循环添加文字
            }
        }
        if($activity == 8){
            $fontX = 60;
            $fontY = 250;
            $questionArr = $commInfo['questionArr'];
            $answerArr = $commInfo['answerArr'];
            foreach($questionArr as $k => $question){
                imagettftext($image_4, 20, 0, $fontX, $fontY+$k*33, $white, $font, $question);//循环添加文字
                imagettftext($image_4, 20, 0, $fontX+1, $fontY+$k*33, $white, $font, $question);
            }
            $afontX = 60;
            $afontY = 470;
            foreach($answerArr as $k => $answer){
                imagettftext($image_4, 17, 0, $afontX, $afontY+$k*30, $white, $font, $answer);//循环添加文字
            }
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

    /*
     * 添加问答文字
     */
    public function generateText(){

    }

    public function getCodeImage($data){

        $shareCode = "http://qr.topscan.com/api.php?text=".$data['url'];
        $destDirectory = "/upload/wxqrcode/";
        if (!file_exists(public_path().'/'.$destDirectory)) {
            $fileDir = mkdir(public_path().'/'.$destDirectory,0777,true);
        }else{
            $fileDir = public_path().'/'.$destDirectory;
        }
        $file = time().rand(1000,9999).".png";
        $codeImg = $this->getImage($shareCode,$fileDir, $file);
        return $codeImg;
    }


    /*
     * 生成图片
     */
    public function getImage($url,$save_dir='',$filename='',$type=0){
        if(trim($url)==''){
            return array('file_name'=>'','save_path'=>'','error'=>1);
        }
        if(trim($save_dir)==''){
            $save_dir='./';
        }
        if(trim($filename)==''){//保存文件名
            $ext=strrchr($url,'.');
            if($ext!='.gif'&&$ext!='.jpg'){
                return array('file_name'=>'','save_path'=>'','error'=>3);
            }
            $filename=time().$ext;
        }
        if(0!==strrpos($save_dir,'/')){
            $save_dir.='/';
        }
        //创建保存目录
        if(!file_exists($save_dir)&&!mkdir($save_dir,0777,true)){
            return array('file_name'=>'','save_path'=>'','error'=>5);
        }
        //获取远程文件所采用的方法
        if($type){
            $ch=curl_init();
            $timeout=5;
            curl_setopt($ch,CURLOPT_URL,$url);
            curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
            curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$timeout);
            $img=curl_exec($ch);
            curl_close($ch);
        }else{
            ob_start();
            readfile($url);
            $img=ob_get_contents();
            ob_end_clean();
        }
        //$size=strlen($img);
        //文件大小
        $fp2=@fopen($save_dir.$filename,'a');
        fwrite($fp2,$img);
        fclose($fp2);
        unset($img,$url);
        return array('file_name'=>$filename,'save_path'=>$save_dir.$filename,'error'=>0);
    }

    /*
     * 生成证书
     * 20200322
     */
    public function makeCert($bodyPic='',$headImage='',$codeImage='',$dir = 'upload/wxqrcode/', $name="社区", $activity=0){
        //创建图片对象
        $bodyPic = public_path().$bodyPic;
        if($activity == 4){
            $activityConfig = config('ImageConfig.activity');
        }else{
            $activityConfig = config('ImageConfig');
        }
        //dd($activityConfig);
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

        //创建真彩画布
        //imagecreatetruecolor(int $width, int $height)--新建一个真彩色图像
        $image_4 = imagecreatetruecolor(imagesx($image_1), imagesy($image_1));

        //为真彩画布创建白色背景
        //imagecolorallocate(resource $image, int $red, int $green, int $blue)
        $color = imagecolorallocate($image_4, 255, 255, 255);
        //在 image 图像的坐标 x，y（图像左上角为 0, 0）处用 color 颜色执行区域填充（即与 x, y 点颜色相同且相邻的点都会被填充）
        imagefill($image_4, 0, 0, $color);

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

        $black = imagecolorallocate($image_4, 0, 0, 0);//设置颜色为蓝色
        $font = public_path().'/fonts/兰亭黑简.TTF';
        //img,size,角度，x轴，y轴，color,字体，字符串
        if(strlen($name)>6){
            imagettftext($image_4, 60, 0, 680, 1100, $black, $font, $name);//添加文字学员姓名 3个字
        }else{
            imagettftext($image_4, 60, 0, 700, 1100, $black, $font, $name);//添加文字学员姓名 两个字
        }
        imagettftext($image_4, 30, 0, 350, 2060, $black, $font, date("Y/m/d"));//添加证书日期
        //imagettftext($image_4, 26, 0, 750, 2570, $black, $font, $activity);//添加证书编号

        $picName   = time().rand(1000,99999).'.jpg';
        $destImage = public_path().'/'.$dir.$picName;
        imagepng($image_4, $destImage);
        imagedestroy($image_1);
        imagedestroy($image_4);
        return [$destImage,$dir.$picName];
    }
}