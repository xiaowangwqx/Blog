<?php
namespace app\index\controller;
use app\index\controller\Base;
use think\Db;

class Article extends Base
{
    public function index()
    {
       return $this->fetch('article');
    }
}
