<?php
namespace app\common\validate;
use \think\Validate;
class Articlecat extends Validate
{
    protected $rule = [
        'parent_id'   => ['require'],
        'title'       => ['require','unique:Articlecat,title', 'max:100'],
        'keyword'     => ['max:100'],
        'description' => ['max:255'],
        'sort'        => ['require', 'integer'],
    ];
    protected $message = [
        'parent_id.require'  => '上级单页面必须填写',
        'title.require'      => '分类必须填写',
        'title.require'      => '分类已经存在',
        'title.max'          => '分类长度不能超来10个字符',
        'keyword.max'        => '关键词长度不能超来100个字符',
        'description.max'    => '简介长度不能超来100个字符',
        'sort.require'       => '排序必须填写',
        'sort.integer'       => '排序值不正确',
    ];
    protected $scene = [
        'add'  => ['parent_id', 'title', 'keyword', 'sort'],
        'edit' => ['parent_id', 'title', 'keyword', 'sort'],
    ];
}
