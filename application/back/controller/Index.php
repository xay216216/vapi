<?php
namespace app\back\controller;
use app\common\controller\AdminBase;
// use app\common\model\User;
use think\View;//视图
use think\Controller;//控制器
use think\Redirect;//重定向
use think\Session;//session
use think\Loader;//引入model
use think\Request;//请求
use think\File;//文件上传
use think\Url;//路由

class Index extends AdminBase {
    public function index() {
        if (!session('?ext_user')) {
            return $this->Redirect('back/login/index');
        }
        return $this->fetch('index');
    }

    //个人信息
    public function profile() {
        $zid = session('ext_user.zid');
        $userModel = Loader::model('User');
        $userRow = $userModel::row($zid);
		
        $this->assign('userRow', $userRow);
        return $this->fetch();
    }
     /**
     * 编辑个人信息
     * @author 
     * @dateTime 2016-10-16
     * @return   [type]   [description]
     */
    
    public function proedit() {
        $zid = session('ext_user.zid');
        $userModel = Loader::model('User');
        $userRow = $userModel::row($zid);
        $this->assign('userRow', $userRow);
        $request = Request::instance();
        if ($request->isPost()) {
            $params = $request->param();
            $file = request()->file('image');
   
             //上传头像
            $info = $file->move(ROOT_PATH.'public'.DS.'head');
            if ($info) {
                $params['head'] = '/head/'.date("Ymd")."/".$info->getFilename();
                $params['zid'] = $zid;
            } else {
                // 上传失败获取错误信息
                return $this->getError();
            }
            //引入app\common\validate,里面有很多字段的验证规则！但是我选这个proedit场景来验证，每个场景自定义验证不同的字段！
            if (loader::validate('User')->scene('proedit')->check($params) === false) {
                return $this->error(loader::validate('User')->getError());
            }
            //实例化对象，然后自定义封装方法userrow。具体看源码。
            if (Loader::model('User')->userrow($params) === false) {
                return $this->error(loader::model('User')->getError());
            }
              Loader::model('SystemLog')->record("个人信息修改:[{$zid}]");
            return $this->success('个人信息修改成功', Url::build('back/index/index'));
        }
        return $this->fetch();
    }

  //没有权限
    public function auth() {
        $this->error("您没有权限,请和管理员联系吧！");
    }
    /**
     * 注销登录
     * @author Zcc<2351976426@qq.com>
     * @dateTime 2016-10-16
     * @return   [type]    [description]
     */
    public function logout() {
    	  $zid = session('ext_user.zid');
    	  Loader::model('SystemLog')->record("退出登录:[{$zid}]");
        Session::clear();
        return $this->success('注销成功！', 'back/login/index');
    }

}