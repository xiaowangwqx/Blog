<?php
namespace app\admin\controller;
// use think\Controller;
use think\Db;
use app\admin\model\Cate as CateModel;
use app\admin\controller\Base;

class Cate extends Base
{
	// 栏目列表
    public function lst()
    {
      // 分页输出列表 每页显示3条数据
      $list = CateModel::paginate(3);
      $this->assign('list',$list);
      return $this->fetch();
    }

    // 栏目添加
    public function add()
    {

     if(request()->isPost()){

      $data=[
      'catename'=>input('catename'),
      ];
      // 验证添加场景
      $validate = \think\Loader::validate('Cate');
      if(!$validate->scene('add')->check($data)){
        $this->error($validate->getError());
        die;
      }
      if(Db::name('cate')->insert($data)){
        return $this->success('添加栏目成功！','lst');
      }else{
        return $this->error('添加栏目失败！');
      }
      return;
     }
     return $this->fetch();
    }
    // 栏目编辑
    public function edit(){
      $id=input('id');
      $cates=db('cate')->find($id);
      if(request()->isPost()){
        $data=[
          'id'=>input('id'),
          'catename'=>input('catename'),
        ];
        // 验证编辑场景
        $validate = \think\Loader::validate('cate');
        if(!$validate->scene('edit')->check($data)){
          $this->error($validate->getError());
          die;
        }
        $save=db('cate')->update($data);
        if($save !== false){
          $this->success('修改栏目名称成功！','lst');
        }else{
          $this->error('修改栏目名称失败！');
        }
        return;
      }
      $this->assign('cates',$cates);
      return $this->fetch();
    }

    public function del(){
      $id=input('id');
      // 设置11为初始化栏目
      if($id!=11){
        // 使用助手函数根据主键删除
        if(db('cate')->delete(input('id'))){
          $this->success('删除栏目成功！','lst');
        }else{
          $this->error('删除栏目失败！');
        }
      }else{
        $this->error('初始化栏目不能删除！');
      }
    }
}
