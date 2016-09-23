<?php

//构建文件目录
function mkdirs(){
	$chars=array('0','1','2','3','4','5','6','7','8','9','a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z','A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
	$rootPath2='uploads/';
	$a = '';
	foreach($chars as $c1){
		$tmpPath = $rootPath2.$c1.'/';
		if(!file_exists($tmpPath)){
			mkdir($tmpPath,0755,true);
		}
		foreach ($chars as $c2){
			$tmpPath2 = $tmpPath.$c2.'/';
			if(!file_exists($tmpPath2)){
				mkdir($tmpPath2,0755,true);
			}
		}
	}
	return $a;
}

/**
 * 得到保存目录
 *
 * @param $filename 文件名   WWnzSfxUanqNQKmDFGyzeIEdoXyDxv.jpg
 * @return string   保存目录 E:\www\jsmy\public\uploads\W\W\
 */
function getSaveFullPath($filename)
{
	return getRootPath().getSavePath($filename);
}

/**
 * 得到文件保存路径
 *
 * @param $filename 文件名   WWnzSfxUanqNQKmDFGyzeIEdoXyDxv.jpg
 * @return string   保存路径 E:\www\jsmy\public\uploads\W\W\nzSfxUanqNQKmDFGyzeIEdoXyDxv.jpg
 */
function getFileSaveFullPath($filename)
{
	return getRootPath().getSavePath($filename).getFileSaveName($filename);
}

/**
 * 得到图片服务器全路径
 *
 * @param $filename 文件名          WWnzSfxUanqNQKmDFGyzeIEdoXyDxv.jpg
 * @return string   图片服务器全路径  http://img.lemonhut.cn/W\W\nzSfxUanqNQKmDFGyzeIEdoXyDxv.jpg
 */
function getImgFullUrl($filename)
{
	if(file_exists(getFileSaveFullPath($filename))){
		return config('global.imgURL').config('global.rootPath').getSavePath($filename).getFileSaveName($filename);
	}else{
		return '图片资源不存在';
	}
}

/**
 * 上传
 *
 * @param $file        上传文件
 * @return bool|string 文件名 WWnzSfxUanqNQKmDFGyzeIEdoXyDxv.jpg
 */
function upload($file,$width=100,$height=100)
{

	//判断文件是否上传完成
	if($file->isValid()){
		//得到文件后娺名
		$ext=$file->getClientOriginalExtension();
		//得到文件名
		$fileName=getFileName().'.'.$ext;
		//通过文件名得到保存目录
		$saveFullPath=getSaveFullPath($fileName);
		//判断目录是否存在
		if(!file_exists($saveFullPath)){
			//创建目录
			mkdir($saveFullPath,0755,true);
		}
		//得到去除目录后的文件名
		$fileSaveName=getFileSaveName($fileName);
		//移动文件到对应的目录
		if($file->move($saveFullPath,$fileSaveName)){
			#TODO
			//原图路径
			//$source=$saveFullPath.$fileSaveName;
			//缩略图路径
			//$thumb=$saveFullPath.$width.$fileSaveName;
			//生成缩略图
			//\Image::make($source)->resize($width,$height)->save($thumb);

			return $fileName;
		}
	}
	return FALSE;
}

/**
 * 删除文件
 *
 * @param $filename 文件名 WWnzSfxUanqNQKmDFGyzeIEdoXyDxv.jpg
 */
function unlinkFile($filename)
{
	$fileSaveFullPath=getFileSaveFullPath($filename);
	if(file_exists($fileSaveFullPath)){
		@unlink($fileSaveFullPath);
	}
}

/**
 * 得到上传文件名
 *
 * @param $file    上传文件
 * @param int $len 文件长度
 * @return string  上传文件名 WWnzSfxUanqNQKmDFGyzeIEdoXyDxv
 */
function getFileName($len=32)
{
	return str_random($len);
}

/**
 * 得到截取后的文件名
 *
 * @param $filename  文件名        WWnzSfxUanqNQKmDFGyzeIEdoXyDxv
 * @param int $start 开始位置
 * @return string    截取后的文件名 nzSfxUanqNQKmDFGyzeIEdoXyDxv
 */
function getFileSaveName($filename,$start=2)
{
	return substr($filename,$start);
}

/**
 * 从文件名中截取出保存路径
 *
 * @param $filename 文件名      WWnzSfxUanqNQKmDFGyzeIEdoXyDxv
 * @return string   截取出的路径 W/W/
 */
function getSavePath($filename)
{
	return substr($filename,0,1).'/'.substr($filename,1,1).'/';
}



/**
 * 上传根目录
 *
 * @return string E:\www\jsmy\public\uploads/
 */
 function getRootPath()
{
	return public_path(config('global.rootPath'));
}

/**
 * 数组转成树状
 *
 * @param array $data  数组
 * @param int $pid     父id
 * @return array       树状数组
 */
function arrayTOtree($data=array(),$pid=0)
{
	$tree=[];
	$func=__FUNCTION__;
	foreach($data as $k=>$v){
		if($v['pid']==$pid){
			$tree[$v['id']]=$v;
			$tree[$v['id']]['child']=$func($data,$v['id']);

		}
	}
	return $tree;
}

function getPath($fileName)
{
	return asset('uploads/'.substr($fileName,0,1).'/'.substr($fileName,1,1).'/'.substr($fileName,2));
}