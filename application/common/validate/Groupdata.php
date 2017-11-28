<?php
namespace app\common\validate;
use \think\Validate;
class Groupdata extends Validate
{
    protected $rule = [
        'title'   => ['require', 'unique:Groupdata,title', 'length:3,25'],
        'rules'  => ['require'],
    ];

    protected $message = [
        'title.require'  => '角色名称必须填写',
        'title.unique'   => '角色名称已存在',
        'title.length'   => '角色名称必须大于3个字符小于25个字符',
        'rules.require'   => '权限必须存在',
    ];

    protected $scene = [
        'add'        => ['title', 'status', 'rules'],
        'edit'       => ['title', 'status', 'rules'],
 
    ];
}
