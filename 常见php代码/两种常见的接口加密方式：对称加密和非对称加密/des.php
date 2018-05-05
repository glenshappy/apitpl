<?php 
define("DES_KEY","ASDFJAJDSFJAJDSFA");
function getSign($data){
	$filterArr = array_filter($data,function($v,$k){
		if('sign'==$k || trim($v)===''){
			return false;
		}
		return true;
	},ARRAY_FILTER_USE_BOTH );
	ksort($filterArr);
	//使用&符号生成字符串
	$str = implode('&',$filterArr);
	$sign = md5(DES_KEY.$str);
	return $sign;	
}
$arr = [
	'name'=>'wanjn',
	'age'=>28,
	'hobby'=>'basketball',
	'class'=>'三班',
	'sign'=>'ajdjfajsdfads',
	'score'=>'',
	'time'=>time()
];
$sign = getSign($arr);

//验证
function checkSign($data,$inputSign){
	$filterArr = array_filter($data,function($v,$k){
		if('sign'==$k || trim($v)===''){
			return false;
		}
		return true;
	},ARRAY_FILTER_USE_BOTH );
	ksort($filterArr);
	//使用&符号生成字符串
	$str = implode('&',$filterArr);
	$sign = md5(DES_KEY.$str);
	return $inputSign === $sign;
}
$res = checkSign($arr,$sign);
var_dump("验证结果：",$res);
