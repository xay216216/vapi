<?php
namespace app\common\validate;
use \think\Validate;

class Rule extends Validate
{
    
    protected $rule = [
        'name'      => ['require', 'unique:rule,name', 'length:3,25'],
        'title'     => ['require', 'length:3,25'],
        'parent_id' => ['require'],
        'status'    => ['in:0,1'],
        'sort'      => ['number', 'between:0,255'], 
    ];

    protected $message = [
        'name.require'      => '权限&菜单必须填写',
        'name.unique'       => '权限&菜单已存在',
        'name.length'       => '权限&菜单必须大于3个字符小于25个字符',
        'title.require'     => '权限菜单名称必须填写',
        'title.length'      => '权限菜单名称必须大于3个字符小于25个字符',
        'parent_id.require' => '上级菜单必须填写',
        'status.in'         => '是否菜单选值不正确',
        'sort.number'       => '排序只能是一个数字',
        'sort.between'      => '排序范围值只能在0-255之间',
    ];

    protected $scene = [
        'add'        => ['name', 'title', 'parent_id', 'status', 'sort', 'class'],
        'edit'        => ['name', 'title', 'parent_id', 'status', 'sort', 'class'],
    ];

}
