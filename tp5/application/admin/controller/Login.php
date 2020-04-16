<?php
namespace app\Admin\controller;
use think\Controller;
use think\Db;
use app\admin\model\Admin;

class Login extends Controller
{
	// 链接列表
    public function index()
    {
      if(request()->isPost()){
        // 实例化对象
        $admin=new Admin();
        $data=input('post.');
        $num=$admin->login($data);
        if($num==3){
        $this->error('信息正确,跳转ing','index/index');
      }elseif($num==4){
        $this->error('验证码错误');
      }
      else{
        $this->error('用户名或密码错误');
      }
    }
      return $this->fetch('login');
    }


}
