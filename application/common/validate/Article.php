<?php
namespace app\common\validate;
use think\Validate;
class Article extends Validate
{
   
    protected $rule = [
        'category_id'      => ['require'],
        'title'            => ['require','unique:Article,title','max:255'],
        'keyword'          => ['max:100'],
        'attr'           => ['require', 'integer'],
        'thumbnail' => ['max:255'],
        'description'      => ['max:255'],
    ];

    protected $message = [
        'category_id.require'  => '分类必须填写',
        'title.require'        => '标题必须填写',
        'title.unique'        => '标题已经存在',
        'title.max'            => '标题长度不能超来100个字符',
        'keyword.max'          => '关键词长度不能超来100个字符',
        'description.max'      => '简介长度不能超来100个字符',
        'attr.require'      => '文章属性必须选择',
    ];

    protected $scene = [
        'add'  => ['category_id', 'title', 'keyword', 'attr'],
        'edit' => ['category_id', 'title', 'keyword', 'attr'],
    ];
}
