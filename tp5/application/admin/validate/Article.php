<?php
namespace app\admin\validate;
use think\Validate;

class Article extends Validate
{
  // 验证规则
  protected $rule = [
    'title'  =>  'require|max:25',
    'cateid' =>  'require',
];

// 错误提示
protected $message  =   [
  'title.require' => '请填写文章标题',
  'tilte.max' => '文章标题长度不得大于25位',
  'cateid.require' => '请选择文章所属栏目',    
];

// 验证场景
protected $scene = [
  'add'  =>  ['title','cateid'],
  'edit'  =>  ['title','cateid'],
];

}
