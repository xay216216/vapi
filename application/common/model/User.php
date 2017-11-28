<?php
namespace app\common\model;
use\think\Config;
use\think\Db;
use\think\Loader;
use\think\Model;
use\think\Session;
class User extends Model {

/**
     * [添加User description]
     * @author Zcc<2351976426@qq.com>
     * @dateTime 2016-10-19
     */
    public function userInc(array $params) {
        return $this->save([
            'uid' => $params['id'],
            'name' => $params['name'],
            'password' => $params['password'],
            'head' => $params['head'],
            'status' => isset($params['status']) ? $params['status'] : 0,
            'create_time' => time(),
        ]);
    }

     /**
     * [编辑更新User description Index控制器]
     * @author Zcc<2351976426@qq.com>
     * @dateTime 2016-10-19
     */
    public function userrow(array $params) {
        return $this->update([
            'name' => $params['name'],
            'password' => $params['password'],
            'head' => $params['head'],
            'update_time' => time(),], 
            //这里要注意的是，我们添加的时候不需要id，自增长！但是编辑的时候更新就可以这样把id传进来！
            ["zid" => $params['zid']]);
    }

     /**
     * [编辑更新User description User控制器]
     * @author Zcc<2351976426@qq.com>
     * @dateTime 2016-10-19
     */
    public function userUpe(array $params) {
        return $this->update([
            'uid' => $params['id'],
            'status' => isset($params['status']) ? $params['status'] : 0,
            'update_time' => time(),], 
             //这里要注意的是，编辑的时候更新就可以这样把主键id传进来！注意数组写法
            ["zid" => $params['zid']]);
    }

/**
     * [ description Index控制器]
     * @author Zcc<2351976426@qq.com>
     * @dateTime 2016-10-22
     */
    public static function read() {
        return Db::table('user')->join('groupdata', 'user.uid = groupdata.id') -> field('uid,name,zid,status,title,rules')->select();
    }

/**
     * [编辑更新User description Index控制器]
     * @author Zcc<2351976426@qq.com>
     * @dateTime 2016-10-23
     */
    public static function row($zid) {
        return Db::table('user')->join('groupdata', 'user.uid = groupdata.id') -> field('name,status,title,head')->find($zid);
    }

    /**
     * [login description]
     * @author Zcc<2351976426@qq.com>
     * @dateTime 2016-10-19
     */
    public static function login($name, $password) {
        $where['name'] = $name;
        $where['password'] = $password;
        $where['status'] = 1;
        $user = loader::model("user")->where($where)->find();
        if ($user) {
            unset($user["password"]);
            session("ext_user", $user);
            return true;
        } else {
            return false;
        }
    }

    /**
     * 获取状态
     * [ description]
     * @author Zcc<2351976426@qq.com>
     * @dateTime 2016-10-19
     */
    public function getStatusAttr($value, $data) {
        $status = [0 => '禁用', 1 => '启用'];
        return $status[$value];
    }


    /**
     * 删除User description ]
     * @author Zcc<2351976426@qq.com>
     * @dateTime 2016-10-19
     */
    public function deleteuser($id) {
        $articleRow = self::get($id);
        $filename = ".".$articleRow->head;
        if (is_file($filename) && file_exists($filename)) {
            unlink($filename);
        }
        return $articleRow->delete();
    }


}