<?php
namespace app\common\validate;
use \think\Validate;

class Focus extends Validate
{
    protected $rule = [
        'position_id' => ['require'],
        'focus_image' => ['require'],
        'title'       => ['require', 'length:2,100', 'unique:focus,title'],
        'url'         => ['require', 'length:2,255'],
        'status'      => ['in:0,1'],
        'sort'        => ['require', 'integer'],
    ];

    protected $message = [
        'position_id.require' => '位置必须填写',
        'focus_image.require' => '必须上传图片',
        'url.require'         => 'url必须填写',
        'url.length'          => 'url长度2-255个字符之间',
        'title.require'       => '标题必须填写',
        'title.length'        => '标题长度3-100之间',
        'title.unique'        => '该焦点图已存在',
        'status.in'           => '状态值不正确',
        'sort.length'         => '排序必须填写',
        'sort.integer'        => '排序必须是整数',
    ];

    protected $scene = [
        'add'  => ['position_id', 'title', 'url', 'status', 'sort'],
        'edit' => ['position_id', 'title', 'url', 'status', 'sort'],
    ];
}
