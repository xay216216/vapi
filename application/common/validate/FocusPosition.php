<?php
namespace app\common\validate;
use \think\Validate;

class FocusPosition extends Validate
{
    
    protected $rule = [
        'code' => ['require', 'alphaDash', 'length:3,25', 'unique:focus_position,code'],
        'name' => ['require', 'length:3,25'],
    ];
    protected $message = [
        'code.require'   => '调用代码必须填写',
        'code.alphaDash' => '调用代码只能为字母和数字，下划线_及破折号-',
        'code.length'    => '调用代码长度3-25之间',
        'code.unique'    => '调用代码已存在',
        'name.require'   => '调用名称必须填写',
        'name.length'    => '调用名称长度3-25之间',
    ];
    protected $scene = [];
}
