<?php
namespace app\back\controller;
use app\common\controller\AdminBase;
use app\common\model\Groupname;
use\think\Db;
use\think\Loader;
use\think\Request;
use\think\Url;
use think\Controller;

class User extends AdminBase {
    /**
     * 后台主面板
     * @author Zcc<2351976426@qq.com>
     * @dateTime 2016-10-16
     * @return [type] [description]
     */
    public function index() {
        $userModel = Loader::model('User');
        $userRows = $userModel::read();
        $this->assign('userRows', $userRows);
        return $this->fetch();
    }


    /**
     * [add description]
     * @author Zcc<2351976426@qq.com>
     * @dateTime 2016-10-27
     */
    public function add() {
        $request = Request::instance();
        if ($request->isPost()) {
            $params = $request->param();
            // dump($params);exit();

            if (loader::validate('User')->scene('add')->check($params) === false) {
                return $this->error(loader::validate('User')->getError());
            }

            if (($userId = Loader::model('User')->userInc($params)) === false) {
                return $this->error(loader::model('User')->getError());
            }
               Loader::model('SystemLog')->record("用户添加,ID:[{$userId}]");
            return $this->success('后台用户添加成功', Url::build('back/user/index'));
        }
        //用户属于哪个用户组
        $groupRows = Loader::model('Groupdata')->select();
        $this->assign('groupRows', $groupRows);
        return $this->fetch();
    }

    /**
     * [edit description]
     * @author Zcc<2351976426@qq.com>
     * @dateTime 2016-10-27
     * @param  [type] $id [description]
     * @return [type] [description]
     */
    public function edit($zid) {
        $request = Request::instance();
        if ($request->isPost()) {
            $params = $request->param();
            $userModel = Loader::model('User');
            $params['zid'] = $zid;
            if (loader::validate('User')->scene('edit')->check($params) === false) {
                return $this->error(loader::validate('User')->getError());
            }

            if (Loader::model('User')->userUpe($params) === false) {
                return $this->error(loader::model('User')->getError());
            }
            Loader::model('SystemLog')->record("编辑用户,ID:[{$zid}]");
            return $this->success('后台用户修改成功', Url::build('back/user/index'));


        }

        $userRow = Db::table('user')->where(['zid' => $zid])->find();
        // dump($userRow);exit();
        $groupRows = Loader::model('Groupdata')->select();
        $this->assign('groupRows', $groupRows);
        $this->assign('userRow', $userRow);
        return $this->fetch();
    }

    /**
     * [destroy description]
     * @author Zcc<2351976426@qq.com>
     * @dateTime 2016-10-27
     * @param  string $value [description]
     * @return [type] [description]
     */
    public function destroy($zid) {
        if (Loader::model('User')->deleteuser($zid) === false) {
            return $this->error(Loader::model('User')->getError());
        }
        Loader::model('SystemLog')->record("删除用户,ID:[{$zid}]");
        return $this->success('用户删除成功', Url::build('back/user/index'));
    }
}