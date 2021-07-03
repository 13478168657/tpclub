<?php
namespace App\Utils;
use Illuminate\Http\Request;
use Illuminate\Log;
class FileUploader{
    public function upload(Request $request, $file,$subDirectory = '')
    {

        if ($request->hasFile($file)) {
            if (!$subDirectory) {
                $subDirectory = 'upload/image/'.date("Ymd/");
            }else{
                $subDirectory = rtrim($subDirectory).'/'.date("Ymd/");
            }
            $destDirectory = $this->getUploadDirectory() . $subDirectory;
            if (!file_exists($destDirectory)) {
                mkdir($destDirectory, 0777, true);
            }
            $extension = $request->file($file)->guessExtension();
            $mime = $request->file($file)->getMimeType();
            $filename = $this->buildFileName($request, $file,$extension);
            $clientSize = $request->file($file)->getClientSize();
            $request->file($file)->move($destDirectory, $filename);
            return [
                "filename" => $filename,
                "extension" => $extension,
                "mime" => $mime,
                "filesize" => $clientSize,
                "url" => $subDirectory . $filename
            ];
        }
        return false;
    }
    public function base64ImgUpload(Request $request, $subDirectory = '')
    {
        $file =$request->get('file');
        return $this->dealUploadImg($file,$subDirectory);
    }

    public function dealUploadImg($file ,$subDirectory){
        $seg = explode(";",$file);//格式data:image/png;base64,iVBORw0KGg...
        if(sizeof($seg)!=2){
            return $this->returnResult(400,"base64图片格式错误" );
        }
        $segments = explode(",",$seg[1]);//base64,iVB...
        if(sizeof($segments)!=2){
            return $this->returnResult(400,"base64图片格式错误");
        }
        $data = $segments[1];
        $encoding = $segments[0];

        $header = explode(":",$seg[0]);//image/png
        if(sizeof($header)!=2){
            return $this->returnResult(400,"base64图片格式错误");
        }

        $mime = explode("/",$header[1]);
        if(sizeof($header)!=2){
            return $this->returnResult(400,"base64图片格式错误");
        }
        $extName =  strtolower($mime[1]);
        if(!in_array($extName,array("jpeg","jpg","bmp","gif","png"))) {
            return $this->returnResult(403,"图片扩展名有误");
        }
        try{
            $real_data = base64_decode($data);
        }catch(\Exception $e){
            return $this->returnResult(402,"图片解析失败");
        }

        if (!$subDirectory) {
            $subDirectory = 'upload/image/'.date("Ymd/");
        }else{
            $subDirectory = rtrim($subDirectory).'/'.date("Ymd/");
        }
        $destDirectory = $this->getUploadDirectory().$subDirectory;
        if (!file_exists($destDirectory)) {
            mkdir($destDirectory, 0777, true);
        }
        $extension = $extName;
        $mime = $header[1];//格式jpg,png,jpeg,gif
        $filename = $this->buildFileName($extension);
        $result = file_put_contents($destDirectory.$filename,$real_data);
        if($result){
            $this->makeThumbPic($destDirectory.$filename);
        }else{
            return $this->returnResult(400,'图片上传失败');
        }
        return [
            "code" => 0,
            "filename" => $filename,
            "extension" => $extension,
            "mime" => $mime,
            "url" => $subDirectory . $filename
        ];
    }
    public function deleteFile($file){
        $fullName = $this->getUploadDirectory().$file;
        $result = unlink($fullName);
        return $result;
    }
    private function getUploadDirectory()
    {
        return env('IMG_PATH');
    }

    private function buildFileName($extension)
    {
        $file = microtime(true) . rand(99999, 999999);
        return $file . "." . $extension;
    }

    private function returnResult($code,$msg='',$data = []){
        return ['code'=>$code,'message'=>$msg,'data'=>$data];
    }

    /*
    * 生成缩略图
    */
    private function makeThumbPic($src) {
        $size = getimagesize($src);
        if (!$size)
            return false;

        list($src_w, $src_h, $src_type) = $size;
        $this->getFanImg($src);
        return;
        if(min($src_w,$src_h) > 1000){
            $width = $src_w > $src_h?($src_w/($src_h/1000)):1000;
            $height = $src_h > $src_w?($src_h/($src_w/1000)):1000;
        }else{

            return ;
        }
        switch($src_type) {
            case 1 :
                $img_type = 'gif';
                break;
            case 2 :
                $img_type = 'jpeg';
                break;
            case 3 :
                $img_type = 'png';
                break;
            case 15 :
                $img_type = 'wbmp';
                break;
            default :
                return false;
        }
        $imageCreateFunc = 'imagecreatefrom' . $img_type;
        $src_img = $imageCreateFunc($src);
        $dest_img = imagecreatetruecolor($width, $height);

        imagecopyresampled($dest_img, $src_img, 0, 0, 0, 0, $width, $height, $src_w, $src_h);
        $imagefunc = 'image' . $img_type;
        $imagefunc($dest_img, $src);
        imagedestroy($src_img);
        imagedestroy($dest_img);
        return true;
    }

    public function getFanImg($src){
        $size = getimagesize($src);

//        logger()->info($_SERVER['HTTP_USER_AGENT']);
        if(!strpos($_SERVER['HTTP_USER_AGENT'], 'iPhone')){
            return ;
        }
        list($src_w, $src_h, $src_type) = $size;
        switch($src_type) {
            case 1 :
                $img_type = 'gif';
                break;
            case 2 :
                $img_type = 'jpeg';
                break;
            case 3 :
                $img_type = 'png';
                break;
            case 15 :
                $img_type = 'wbmp';
                break;
            default :
                return false;
        }
        $imageCreateFunc = 'imagecreatefrom' . $img_type;
        $img = $imageCreateFunc($src);
//        $width = imagesx($img);
//        $height = imagesy($img);
//        $img2 = imagecreatetruecolor($height, $width);
//
//        for($x = 0; $x < $height; $x ++) {
//            for($y = 0; $y < $width; $y ++) {
//                imagecopy($img2, $img, $x, $y, $width - 1 - $y, $x, 1, 1 );
//            }
//        }
        $rotate = imagerotate($img,-270, 0);
        //旋转后的图片保存

        $imagefunc = 'image' . $img_type;
        $imagefunc($rotate, $src);
        imagedestroy($img);
//        imagedestroy($img2);
    }

    public function formUpload($file,$subDirectory = ''){

        $picname = $file['name']; 
        $picsize = $file['size'];
        $type    = strtolower(strstr($picname, '.'));
        if ($picsize > 10240000){
            return '{"code":0,"msg":"文件大小不能超过10M"}';
            exit;
        }
        $allow_type = return_type();  // 获取文件上传格式
//        logger()->info($type);
        if(!in_array($type, $allow_type)){
            return '{"code":0,"msg":"文件格式不对！"}';
            exit;
        }
        //新文件名
        $rand = rand(100, 999);
        $pics = date("YmdHis").$rand.$type;
        //上传路径
        if (!$subDirectory) {
            $subDirectory = 'upload/image/'.date("Ymd/");
        }else{
            $subDirectory = rtrim($subDirectory).'/'.date("Ymd/");
        }
        $path = $this->getUploadDirectory().$subDirectory;
        if(!file_exists($path)){
            mkdir($path, 0777,true);
        }
        $pic_path = $path.$pics;
        $img_path = $subDirectory.$pics;
        if(move_uploaded_file($_FILES['image']['tmp_name'], $pic_path)){
            $size = round($picsize/1024,2);
            $arr = array(
                'code'=>1,
                'name'=>$picname,
                'pic'=>$pics,
                'size'=>$size,
                'path'=>$img_path,
            );
            return json_encode($arr);
        };
    }
}