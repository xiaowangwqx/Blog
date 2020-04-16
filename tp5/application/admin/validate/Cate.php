<?php
namespace app\admin\validate;
use think\Validate;

class Cate extends Validate
{
  // 验证规则
  protected $rule = [
    'catename'  =>  'require|max:25|unique:cate',
];

// 错误提示
protected $message  =   [
  'catename.require' => '请填写栏目名称',
  'catename.max' => '栏目名称长度不得大于25位', 
  'catename.unique' => '栏目名称不得重复', 
];

// 验证场景
protected $scene = [
  'add'  =>  ['catename'=>'require|unique:cate'],
  'edit'  =>  ['catename'=>'require|unique:cate'],
];

}
