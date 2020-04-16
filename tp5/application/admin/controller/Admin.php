<?php
namespace app\admin\controller;
// use think\Controller;
use think\Db;
use app\admin\model\Admin as AdminModel;
use app\admin\controller\Base;

class Admin extends Base
{
	// 管理员列表
    public function lst()
    {
      // 分页输出列表 每页显示3条数据
      $list = AdminModel::paginate(3);
      $this->assign('list',$list);
      return $this->fetch();
    }

    // 管理员添加
    public function add()
    {

     if(request()->isPost()){

      $data=[
      'username'=>input('username'),
      'password'=>md5(input('password')),
      ];
      // 验证添加场景
      $validate = \think\Loader::validate('Admin');
      if(!$validate->scene('add')->check($data)){
        $this->error($validate->getError());
        die;
      }
      if(Db::name('admin')->insert($data)){
        return $this->success('添加管理员成功！','lst');
      }else{
        return $this->error('添加管理员失败！');
      }
      return;
     }
     return $this->fetch();
    }

    public function edit(){
      $id=input('id');
      $admins=db('admin')->find($id);
      if(request()->isPost()){
        $data=[
          'id'=>input('id'),
          'username'=>input('username'),
          'password'=>input('password'),
        ];
        if(input('password')){
          $data['password']=md5(input('password'));
        }else{
          $data['password']=$admins['password'];
        }
        // 验证编辑场景
        $validate = \think\Loader::validate('Admin');
        if(!$validate->scene('edit')->check($data)){
          $this->error($validate->getError());
          die;
        }
        $save=db('admin')->update($data);
        if($save!==false){
          $this->success('修改管理员成功！','lst');
        }else{
          $this->error('修改管理员失败！');
        }
        return;
      }
      $this->assign('admins',$admins);
      return $this->fetch();
    }

    public function del(){
      $id=input('id');
      // 设置11为初始化管理员
      if($id!=11){
        // 使用助手函数根据主键删除
        if(db('admin')->delete(input('id'))){
          $this->success('删除管理员成功！','lst');
        }else{
          $this->error('删除管理员失败！');
        }
      }else{
        $this->error('初始化管理员不能删除！');
      }
    }
    public function logout(){
      session(null);
      $this->success('退出成功！','Login/index');
    }
}
