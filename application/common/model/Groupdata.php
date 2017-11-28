<?php
namespace app\common\model;
use think\Config;
use think\Db;
use think\Model;
use think\Request;
use think\Session;

class Groupdata extends Model
{
    /**
     * 获取器 获取用户数量
     * @author Zcc<2351976426@qq.com>
     * @dateTime 2016-05-19T15:47:23+0800
     * @param    [type]                   $value [description]
     * @param    [type]                   $data  [description]
     * @return   [type]                          [description]
     */
    public function getUserCountAttr($value, $data)
    {
        return $this->user()->count();
    }
    /**
     * 添加角色
     * @author Zcc<2351976426@qq.com>
     * @dateTime 2016-05-19T15:04:27+0800
     * @param    array                    $data [description]
     */
    public function addRole(array $data)
    {
            return $this->save([
                'status' => $data['status'],
                'title'   => $data['title'],
                'remark' => $data['remark'],
                'rules' => $data['rules']
            ]);
    }

    /**
     * [editRole description]
     * @author Zcc<2351976426@qq.com>
     * @dateTime 2016-10
     * @param    array                    $data [description]
     * @param    [type]                   $id   [description]
     * @return   [type]                         [description]
     */
    public function editRule(array $data)
    {
            // 更新
            return $this->save([
                'title'   => $data['title'],
                'remark' => $data['remark'],
                'rules' => $data['rules']
            ], ['id' => $data['id']]) ;

    
    }
    /**
     * [deleteRole description]
     * @author Zcc<2351976426@qq.com>
     * @dateTime 2016-10
     * @param    [type]                   $id [description]
     * @return   [type]                       [description]
     */
    public function deleteRule($id)
    {
        $ruleModel = $this->find($id);
        if ($ruleModel == false) {
            $this->error = '用户组不存在，或者已删除！';
            return false;
        }
        if ($ruleModel->user()->count() > 0) {
            $this->error = '用户组下存在用户，不能删除！';
            return false;
        }
            $ruleModel->delete();
    }

    /**
     * [user description]
     * @author Zcc<2351976426@qq.com>
     * @dateTime 2016-10
     * @return   [type]                   [description]
     */
    public function user()
    {
        return $this->hasMany('User', 'uid', 'id');
    }
    
     /**
     * 获取状态
     * @author Zcc<2351976426@qq.com>
     * @dateTime 2016-04-19T16:00:40+0800
     * @param    string                   $value [description]
     * @return   [type]                          [description]
     */
    // public function getStatusAttr($value, $data)
    // {
    //     $status = [1 => '<span class="label label-success">启用</span>', 0 => '<span class="label label-warning">禁用</span>'];
    //     return $status[$value];
    // }
}
