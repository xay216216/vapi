<?php
namespace app\back\controller;
use think\View;
use think\Input;
use think\Loader;
use think\Controller;
use app\common\model\User;
use Captcha;//extend文件夹。验证码类，你也可以在线composer
use think\Url;
class Login extends controller {

    public function index() {
        
       return $this->fetch();
    }
  /**
     * [login description]
     * @author Zcc<2351976426@qq.com>
     * @dateTime 2016-10-19
     */
    public function logining() {
        $name = input('request.name');
        $password = input('request.password');
        $data = input('request.captcha');
        /*if (!captcha_check($data)) {
            //验证失败
            return $this->error("验证码错误");
        }*/

        $check =User::login($name, $password);
        if ($check) {
        	Loader::model('SystemLog')->record("登陆成功:[{$name}]");
         return $this->success('登陆成功', Url::build('back/Index/index'));
        } else {
            return $this->error("用户名密码错误！");
        }
          
    }
        //验证码类
        function captcha_img($id = "") {
            return '<img src="'.captcha_src($id).'"alt="captcha" />';
        }
    

}