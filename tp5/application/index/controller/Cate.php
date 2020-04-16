<?php
namespace app\index\controller;
use app\index\controller\Base;
use think\Db;

class Cate extends Base
{
    public function index()
    {
       $cateid=input('cateid');
       $articles=db('article')->where(array('cateid'=>$cateid))->select();
       $this->assign('articles',$articles);
        return $this->fetch('cate');
    }
}
