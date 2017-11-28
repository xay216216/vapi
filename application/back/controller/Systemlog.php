<?php
namespace app\back\controller;
use app\common\controller\AdminBase;
use think\Loader;
use think\Request;
use think\Url;
use think\helper\Time;
class SystemLog extends AdminBase
{
    /**
     * 日志列表
     * @author Zcc<2351976426@qq.com>
     * @dateTime 2016-10
     * @return [type] [description]
     */
    public function index()
    {
        $LogModel = Loader::model('SystemLog');
        $time=Time::daysAgo(7);
       //一星期前的系统日志删除
        $LogModel->where('op_time','<',$time)->delete();
        $LogModel->record("定时清理一星期前系统日志");
       //读取数据库系统日志
        $LogRows  = $LogModel::listlog()->paginate(15);
        $this->assign('LogRows', $LogRows);
        
        $this->assign('pages', $LogRows->render());
        return $this->fetch();
    }

}
