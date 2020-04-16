<?php
namespace app\admin\validate;
use think\Validate;

class Links extends Validate
{
  // 验证规则
  protected $rule = [
    'title'  =>  'require|max:25',
    'url' =>  'require',
];

// 错误提示
protected $message  =   [
  'title.require' => '请填写链接标题',
  'tilte.max' => '链接标题长度不得大于25位',
  'url.requir' => '链接地址必须填写',    
];

// 验证场景
protected $scene = [
  'add'  =>  ['title','url'],
  'edit'  =>  ['title','url'],
];

}
