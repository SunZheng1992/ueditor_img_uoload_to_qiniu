<?php
namespace myqiniu;
use Qiniu\Auth;
// 引入上传类
use Qiniu\Storage\UploadManager;
use Qiniu\Storage\BucketManager;
class Qiniu
{
	private static $accessKey;
	private static $secretKey;
	private static $bucket;
	private static $token;
	private $auth;
	public $error;
	public function __construct($config)
	{
		require_once('qiniu/autoload.php');
		self::$accessKey = $config['accessKey'];
		self::$secretKey = $config['secrectKey'];
		self::$bucket 	 = $config['bucket'];
		self::$token 	 = $this->getToken(self::$accessKey,self::$secretKey);
	}

	private function getToken($accessKey,$secretKey)
	{

		// 构建鉴权对象
		$this->auth = new Auth($accessKey, $secretKey);

		// 要上传的空间
		$bucket = self::$bucket;

		// 生成上传 Token
		$token = $this->auth->uploadToken($bucket);

		return $token;
	}
	//删除
	public function delete($file)
	{
		$accessKey = self::$accessKey;
		$secretKey = self::$secretKey;

		//初始化Auth状态：
		$auth = $this->auth;

		//初始化BucketManager
		$bucketMgr = new BucketManager($auth);

		//你要测试的空间， 并且这个key在你空间中存在
		$bucket = self::$bucket;
		$key = $file;

		//删除$bucket 中的文件 $key
		$err = $bucketMgr->delete($bucket, $key);
		if ($err !== null) {
		    $this->error = $err;
			return false;
		} else {
		    return true;;
		}
	}
	public function copy($fromBucket,$fromFile,$toBucket,$toFile)
	{

		//初始化BucketManager
		$bucketMgr = new BucketManager($this->auth);

		//你要测试的空间， 并且这个key在你空间中存在
		/*$bucket = $fromBucket;
		$key = $fromFile;

		//将文件从文件$key 复制到文件$key2。 可以在不同bucket复制
		$key2 = $toFile;*/
		$err = $bucketMgr->copy($fromBucket, $fromFile, $toBucket, $toFile);
		
		if ($err !== null) {
		    $this->error = $err;
			return false;
		} else {
		    return true;
		}
	}
	 public function upload($file)
    {
    	
    	
    	$accessKey = self::$accessKey;
		$secretKey = self::$secretKey;
		// 生成上传 Token
		$token = self::$token;

		// 要上传文件的本地路径
		$filePath = $file['tmp_name'];

		//文件后缀
		$fileType = '.'.$this->getFileType($file['name']); 
	
		// 上传到七牛后保存的文件名
		$key = $this->randName($fileType);

		// 初始化 UploadManager 对象并进行文件的上传。
		$uploadMgr = new UploadManager();

		// 调用 UploadManager 的 putFile 方法进行文件的上传。
		list($ret, $err) = $uploadMgr->putFile($token, $key, $filePath);

		//echo "\n====> putFile result: \n";
		if ($err !== null) {
		    $this->error = $err;
		    return false;
		} else {
		    return $ret;
		}
    }
    //获取文件状态
    public function stat($key,$bucket=null)
    {
    	$bucket = $bucket?$bucket:self::$bucket;
    	

		//初始化BucketManager
		$bucketMgr = new BucketManager($this->auth);

		//你要测试的空间， 并且这个key在你空间中存在
		//$bucket = 'Bucket_Name';
		//$key = 'php-logo.png';

		//获取文件的状态信息
		list($ret, $err) = $bucketMgr->stat($bucket, $key);
		//echo "\n====> $key stat : \n";
		if ($err !== null) {
		    $this->error = $err;
			return false;
		} else {
		    return $ret;
		}
    }
    //产生随机文件名
    public function randName($fileType)
    {
    	return time().rand(10000,999999).$fileType;
    }
    //获取文件格式
    public function getFileType($file)
    {
    	return substr(strrchr($file, '.'), 1);
    }

    //获取错误
    public function getError()
    {
    	return $this->error;
    }

}