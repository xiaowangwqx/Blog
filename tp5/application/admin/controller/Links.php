<?php
namespace app\Admin\controller;
// use think\Controller;
use think\Db;
use app\Admin\model\Links as LinksModel;
use app\admin\controller\Base;

class Links extends Base
{
	// 链接列表
    public function lst()
    {
      // 分页输出列表 每页显示3条数据
      $list = LinksModel::paginate(3);
      $this->assign('list',$list);
      return $this->fetch();
    }

    // 链接添加
    public function add()
    {

     if(request()->isPost()){

      $data=[
      'title'=>input('title'),
      'url'=>input('url'),
      'des'=>input('des'),
      ];
      // 验证添加场景
      $validate = \think\Loader::validate('Links');
      if(!$validate->scene('add')->check($data)){
        $this->error($validate->getError());
        die;
      }
      if(Db::name('Links')->insert($data)){
        return $this->success('添加链接成功！','lst');
      }else{
        return $this->error('添加链接失败！');
      }
      return;
     }
     return $this->fetch();
    }

    public function edit(){
      $id=input('id');
      $Links=db('Links')->find($id);
      if(request()->isPost()){
        $data=[
          'id'=>input('id'),
          'title'=>input('title'),
          'url'=>input('url'),
          'des'=>input('des'),
        ];
      
        // 验证编辑场景
        $validate = \think\Loader::validate('Links');
        if(!$validate->scene('edit')->check($data)){
          $this->error($validate->getError());
          die;
        }
        if(db('Links')->update($data)){
          $this->success('修改链接成功！','lst');
        }else{
          $this->error('修改链接失败！');
        }
        return;
      }
      $this->assign('Links',$Links);
      return $this->fetch();
    }

    public function del(){
      $id=input('id');
      // 使用助手函数根据主键删除
      if(db('Links')->delete(input('id'))){
        $this->success('删除链接成功！','lst');
      }else{
        $this->error('删除链接失败！');
      }
    
    }
}
