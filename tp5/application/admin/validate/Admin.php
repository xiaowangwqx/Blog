<?php
namespace app\admin\validate;
use think\Validate;

class Admin extends Validate
{
  // 验证规则
  protected $rule = [
    'username'  =>  'require|max:25|unique:admin',
    'password' =>  'require',
];

// 错误提示
protected $message  =   [
  'username.require' => '请填写管理员名称',
  'username.max' => '管理员名称长度不得大于25位',
  'password.requir' => '管理员密码必须填写', 
  'username.unique' => '管理员名称不能重复',    
];

// 验证场景
protected $scene = [
  'add'  =>  ['username'=>'require|unique:admin','password'],
  'edit'  =>  ['username'=>'require|unique:admin'],
];

}
