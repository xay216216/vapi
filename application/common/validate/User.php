<?php
namespace app\common\validate;
use\think\Validate;
class User extends Validate {
    protected $rule = [
        'id' => ['require', 'length:0,6'],
        //这里的unique ，唯一性，第一个是数据库名字User，第二个是字段name,自动验证
        'name' => ['require', 'unique:user,name', 'length:3,25'],
        'password' => ['length:6,20'],
          //这里的密码，确认密码，自动验证
        'repassword' => ['confirm:password'],
        'status' => ['in:0,1'],
    ];


    protected $message = [
        'name.require' => '用户名必须填写',
        'id.require' => '用户组必须填写',
        'name.unique' => '用户名已存在',
        'name.length' => '用户名必须大于3个字符小于25个字符',
        'uid.length' => '用户名必须大于0个字符小于6个字符',
        'status.in' => '状态值不可用',
    ];

//不同的场景验证的字段不同
    protected $scene = [
        'add' => ['uid', 'name', 'password', 'repassword', 'status', ],
        'edit' => ['uid', 'status'],
        'proedit' => ['uid', 'name', 'password', 'repassword', 'status', ],
    ];
}