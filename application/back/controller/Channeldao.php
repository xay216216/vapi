<?php
namespace app\back\controller;
use app\common\controller\AdminBase;
use app\common\model\Usercoupon;
use think\File;
use think\Db;
use think\Request;
use think\Controller;
use think\Loader;
use think\Url;
class Channeldao extends AdminBase {
	
    public function index() {
        /*$channel = User_coupon::field("id,user_phone,goods_id,goods_name,channel_num,channel_name,phone_type")->where('draw_status=1')->paginate(10);
        var_dump($channel);
        die();
        $page = $channel->render();
        $this->assign('channel', $channel);
        $this->assign('page', $page);
        return $this->fetch();*/
        //$dataList = Loader::model('Usercoupon')->channellist();

        $channel = Usercoupon::field("channel_num")->where('deleted=0 and draw_status=1')->group('channel_num')->paginate(10);
        $dataList = array();
        foreach ($channel as $key => $value) {
            $count_num = Loader::model('Usercoupon')->countnum($value['channel_num']);
            $dataList[$key]['channel_num'] = $value['channel_num'];
            $dataList[$key]['count_num'] = $count_num[0]['count_num'];
            $dataList[$key]['xuhao'] = $key+1;
        }
        $page = $channel->render();
        $this->assign('dataList', $dataList);
        $this->assign('page', $page);

        return $this->fetch();

    }

    
    public function add()
    {
        /*$request = Request::instance();
        if ($request->isPost()) {
            $params = $request->param();

            if (loader::validate('Articlecat')->scene('add')->check($params) === false) {
                return $this->error(loader::validate('Articlecat')->getError());
            }

            if (($ArticlecatId = Loader::model('Articlecat')->ArticlecatAdd($params)) === false) {
                return $this->error(Loader::model('Articlecat')->getError());
            }
               Loader::model('SystemLog')->record("文章分类添加,ID:[{$ArticlecatId}]");
            return $this->success('文章分类添加成功', Url::build('back/Articlecat/index'));
        }

        $ArticlecatModel = Loader::model('Articlecat');
        $ArticlecatRows  = $ArticlecatModel::selectField()->where(['parent_id' => 0])->select();
        $this->assign('articlecatRows', $ArticlecatRows);*/

        return $this->fetch();
    }

   
    public function search()
    {
        $get    = input('get.');
        $channel_num    = input('channel_num');
        $start_time    = input('start_time');
        $end_time    = input('end_time');
        $draw_status    = input('draw_status');
        $goods_name    = input('goods_name');

        $pageParam    = ['query' =>[]];
        if ($channel_num) {
            Usercoupon::where('channel_num', '=', "{$channel_num}");
            $this->assign('channel_num', $channel_num);
            $pageParam['query']['channel_num'] = $channel_num;
        }
        if ($start_time) {
            Usercoupon::where('create_date', '>=', "{$start_time}");
            $this->assign('start_time', $start_time);
            $pageParam['query']['start_time'] = $start_time;
        }
        if ($end_time) {
            Usercoupon::where('create_date', '<=', "{$end_time}");
            $this->assign('end_time', $end_time);
            $pageParam['query']['end_time'] = $end_time;
        }
        if ($draw_status) {
            Usercoupon::where('draw_status', '=', "{$draw_status}");
            $this->assign('draw_status', $draw_status);
            $pageParam['query']['draw_status'] = $draw_status;
        }else{
            $this->assign('draw_status', 1);
        }
        if ($goods_name) {
            Usercoupon::where('goods_name', 'like', "%{$goods_name}%");
            $this->assign('goods_name', $goods_name);
            $pageParam['query']['goods_name'] = $goods_name;
        }
        //$dataList = Usercoupon::field("id,channel_num,order_id,user_phone,goods_name,reduce_integral,create_date,draw_status")->paginate(10, false, $pageParam);
        $backList = Usercoupon::field("order_id")->group('order_id')->paginate(10, false, $pageParam);
        $dataList = [];
        if ($backList) {
            foreach ($backList as $key => $value) {
                //$dataList[$key] = Usercoupon::get($value['id']);
                if ($draw_status) {
                    $querydata = Db::query("select * from user_coupon where order_id='{$value['order_id']}' and draw_status='{$draw_status}' order by id desc limit 1");
                }else{
                    $querydata = Db::query("select * from user_coupon where order_id='{$value['order_id']}' order by id desc limit 1");
                }
                $dataList[$key] = $querydata[0];
            }
        }
        $page = $backList->render();
        $this->assign('page', $page);
        $this->assign('dataList', $dataList);
        
        return $this->fetch();

    }

    public function message()
    {
        $order_id = $_GET['order_id'];
        $datainfo = Db::query("select * from user_coupon where order_id='{$order_id}'");
        $this->assign('datainfo', $datainfo);
        return $this->fetch('message2');

    }

    public function message2()
    {
        $id = $_GET['id'];
        $datainfo = Usercoupon::get($id);

        $this->assign('datainfo', $datainfo);
        return $this->fetch();
    }
}