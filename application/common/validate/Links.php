<?php
namespace app\common\validate;
use \think\Validate;

class Links extends Validate
{
    protected $rule = [
        'title'  => ['require','unique:Links,title', 'length:2,25'],
        'url'    => ['require', 'url'],
        'linker' => ['max:255'],
        'status' => ['in:0,1'],
        'sort'   => ['require', 'integer'],

    ];

    protected $message = [
    
        'title.require' => '标题必须填写',
        'title.length'  => '标题长度必须在2-25个字符之宰',
        'url.require'   => '友情链接必须填写',
        'url.url'       => '友情链接必须是一个网址',
        'status.in'     => '状态值不正确',
        'sort.integer'  => '排序必须是一个整数',
    ];

    protected $scene = [
        'add'  => ['title', 'url', 'linker', 'status', 'sort'],
        'edit' => ['title', 'url', 'linker', 'status', 'sort'],
    ];
}
