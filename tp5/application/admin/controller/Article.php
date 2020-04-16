<?php
namespace app\Admin\controller;
// use think\Controller;
use think\Db;
use app\Admin\model\Article as ArticleModel;
use app\admin\controller\Base;

class Article extends Base
{
	// 文章列表
    public function lst()
    {
      // 分页输出列表 每页显示3条数据
      // $list = ArticleModel::paginate(3);
      // 数据表链接查询
      // $list=db('article')->alias('a')->join('cate c','c.id=a.cateid')->field('a.id,a.title,a.pic,a.author,a.state,c.catename')->paginate(3);
      // 用关联关系查询数据
      $list = ArticleModel::paginate(3);
      $this->assign('list',$list);
      return $this->fetch();
    }

    // 文章添加
    public function add()
    {

     if(request()->isPost()){
      // var_dump($_POST);die;
      $data=[
      'title'=>input('title'),
      'author'=>input('author'),
      'des'=>input('des'),
      'keywords'=>input('keywords'),
      'content'=>input('content'),
      'cateid'=>input('cateid'),
      'time'=>time(),
      ];
      if(input('state')=='on'){
        $data['state']=1;
      }
      if($_FILES['pic']['tmp_name']){
        $file=request()->file('pic');
        $info = $file->move(ROOT_PATH . 'public' . DS . 'static/uploads');
        $data['pic']='/static/uploads/'.$info->getSaveName();
      }
      // 验证添加场景
      $validate = \think\Loader::validate('Article');
      if(!$validate->scene('add')->check($data)){
        $this->error($validate->getError());
        die;
      }
      if(Db::name('Article')->insert($data)){
        return $this->success('添加文章成功！','lst');
      }else{
        return $this->error('添加文章失败！');
      }
      return;
     }
     $cateres=db('cate')->select();
     $this->assign('cateres',$cateres);

     return $this->fetch();
    }

    public function edit(){
      $id=input('id');
      $articles=db('Article')->find($id);
      if(request()->isPost()){
        $data=[
          'id'=>input('id'),
          'title'=>input('title'),
          'author'=>input('author'),
          'des'=>input('des'),
          'keywords'=>input('keywords'),
          'content'=>input('content'),
          'cateid'=>input('cateid'),
        ];
        if(input('state')=='on'){
          $data['state']=1;
        }else{
          $data['state']=0;
        }
        // 判断图片、保存图片
        if($_FILES['pic']['tmp_name']){
          // 删除原有图片
          // $picstr=SITE_URL.'/public'.$articles['pic'];
          // @unlink($picstr);
          $file=request()->file('pic');
          $info = $file->move(ROOT_PATH . 'public' . DS . 'static/uploads');
          $data['pic']='/static/uploads/'.$info->getSaveName();
        }
        // 验证编辑场景
        $validate = \think\Loader::validate('Article');
        if(!$validate->scene('edit')->check($data)){
          $this->error($validate->getError());
          die;
        }
        if(db('Article')->update($data)){
          $this->success('修改文章成功！','lst');
        }else{
          $this->error('修改文章失败！');
        }
        return;
      }
      $this->assign('articles',$articles);
      $cateres=db('cate')->select();
     $this->assign('cateres',$cateres);
      return $this->fetch();
    }

    public function del(){
      $id=input('id');
      // 使用助手函数根据主键删除
      if(db('Article')->delete(input('id'))){
        $this->success('删除文章成功！','lst');
      }else{
        $this->error('删除文章失败！');
      }
    
    }
}
