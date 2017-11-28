<?php
namespace app\ios\controller;

use think\Loader;
use think\Request;

class Api
{
    public function index(){

        return '';
    }

    //积分兑换列表
    public function jflist(){
    	
    	$data = Loader::model('Usercoupon')->jflist();

        // 指定json数据输出
        return json(['data'=>$data,'code'=>1,'message'=>'操作完成']);
    }

    //积分数据添加
    public function add(){
        //Request::instance()->post(); // 获取经过过滤的全部post变量
        //Request::instance()->post(false); // 获取全部的post原始变量
        $dataList['user_id'] = Request::instance()->post('user_id'); // 获取某个post变量
        $dataList['user_name'] = Request::instance()->post('user_name');
        $dataList['user_phone'] = Request::instance()->post('user_phone'); // 获取某个post变量
        $dataList['goods_id'] = Request::instance()->post('goods_id');
        $dataList['goods_name'] = Request::instance()->post('goods_name');
        $dataList['goods_num'] = Request::instance()->post('goods_num');
        $dataList['draw_merchant'] = Request::instance()->post('draw_merchant');
        $dataList['draw_status'] = Request::instance()->post('draw_status');
        $dataList['draw_message'] = Request::instance()->post('draw_message');
        $dataList['phone_code'] = Request::instance()->post('phone_code');
        $dataList['reduce_integral'] = Request::instance()->post('reduce_integral');
        $dataList['channel_num'] = Request::instance()->post('channel_num');
        $dataList['channel_name'] = Request::instance()->post('channel_name');
        /*if (empty($dataList['user_phone']))
            return json(['data'=>'','code'=>0,'message'=>'缺少手机号!']);
        if (empty($dataList['goods_id']))
            return json(['data'=>'','code'=>0,'message'=>'缺少商品编号!']);
        if (empty($dataList['goods_name']))
            return json(['data'=>'','code'=>0,'message'=>'缺少商品名称!']);*/
        if (empty($dataList['draw_status']))
            return json(['data'=>'','code'=>0,'message'=>'缺少抽奖状态!']);
        if (empty($dataList['draw_message']))
            return json(['data'=>'','code'=>0,'message'=>'缺少短信!']);
        /*if (empty($dataList['reduce_integral']))
            return json(['data'=>'','code'=>0,'message'=>'缺少消费的积分!']);*/
        if (empty($dataList['phone_code']))
            return json(['data'=>'','code'=>0,'message'=>'缺少手机设备号!']);
        if (empty($dataList['channel_num']))
            return json(['data'=>'','code'=>0,'message'=>'缺少渠道号!']);
        if (empty($dataList['channel_name']))
            return json(['data'=>'','code'=>0,'message'=>'缺少渠道名称!']);

        //解析短信
        $goods = self::pipeigoods($dataList['draw_message']);
        $dataList['goods_id'] = $goods['goods_id'];
        $dataList['goods_name'] = $goods['goods_name'];
        $dataList['reduce_integral'] = $goods['reduce_integral'];
        $data = Loader::model('Usercoupon')->add($dataList);

        // 指定json数据输出
        return json(['data'=>$data,'code'=>1,'message'=>'操作完成']);
    }

    //判断此人今天是否可领
    public function userinfo(){

        $dataList['phone_code'] = Request::instance()->post('phone_code'); // 获取某个post变量
        if (empty($dataList['phone_code'])) {
            return json(['data'=>'','code'=>0,'message'=>'手机设备号为空!']);
        }
        $data = Loader::model('Usercoupon')->userinfo($dataList);
        if (intval($data[0]['count_num']) <= 3) {
            $is_draw = ['is_draw'=>1];
            return json(['data'=>$is_draw,'code'=>1,'message'=>'操作完成']);
        }else{
            $is_draw = ['is_draw'=>0];
            return json(['data'=>$is_draw,'code'=>0,'message'=>'今天已经抽奖3次啦']);
        }
    }

    //判断此人今天是否可领
    public static function goodsList(){

        $goodsList = array(
            1=>array(
                'goods_id'=>'DH805404',
                'goods_name'=>'口红充电宝',
                'goods_pipei'=>'口红',
                'reduce_integral'=>'4090',
                ),
            2=>array(
                'goods_id'=>'DH343720',
                'goods_name'=>'首汽约车5元券',
                'goods_pipei'=>'5元券',
                'reduce_integral'=>'340',
                ),
            3=>array(
                'goods_id'=>'DH343820',
                'goods_name'=>'首汽约车10元券',
                'goods_pipei'=>'10元券',
                'reduce_integral'=>'670',
                ),
            4=>array(
                'goods_id'=>'DH343821',
                'goods_name'=>'首汽约车20元券',
                'goods_pipei'=>'20元券',
                'reduce_integral'=>'1340',
                ),
            5=>array(
                'goods_id'=>'DH253535',
                'goods_name'=>'四件套',
                'goods_pipei'=>'四件套',
                'reduce_integral'=>'15000',
                ),
            6=>array(
                'goods_id'=>'DH801174',
                'goods_name'=>'耳机',
                'goods_pipei'=>'耳机',
                'reduce_integral'=>'3250',
                )
        );

        return $goodsList;
    }

    public static function pipeigoods($draw_message){

        $goodsList = self::goodsList();
        foreach ($goodsList as $key => $value) {
            if(strpos($draw_message,$value['goods_pipei'])!==false){
                return [
                        'goods_id'=>$value['goods_id'],
                        'goods_name'=>$value['goods_name'],
                        'reduce_integral'=>$value['reduce_integral']
                       ];
            }
        }

        return  [
                 'goods_id'=>'',
                 'goods_name'=>'',
                 'reduce_integral'=>0
                ];

    }
}
