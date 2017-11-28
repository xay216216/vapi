<?php
namespace app\common\validate;
use think\Validate;
class Attr extends Validate
{
   
    protected $rule = [
        'attr_name'  => ['require','unique:Attr,attr_name','max:20'],
    ];
    protected $message = [
        'attr_name.require'        => '文章属性必须填写',
        'attr_name.unique'        => '文章属性已经存在',
        'attr_name.max'            => '属性长度不能超来20个字符',

    ];
    protected $scene = [
        'add'  => ['attr_name'],
        'edit' => ['attr_name'],
    ];
}
