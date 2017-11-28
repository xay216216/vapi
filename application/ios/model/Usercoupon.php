<?php
namespace app\ios\model;

use think\Model;
use think\Db;

class Usercoupon extends Model
{
	// 设置当前模型对应的完整数据表名称
    protected $table = 'user_coupon';

    //自定义初始化
    protected function initialize(){
        //需要调用`Model`的`initialize`方法
        parent::initialize();
        //TODO:自定义的初始化
    }

    public function add($dataList){

        $data = [
            'user_id' => $dataList['user_id'] ? intval($dataList['user_id']) : '',
            'user_name' => $dataList['user_name'] ? $dataList['user_name'] : '',
            'user_phone' => $dataList['user_phone'] ? $dataList['user_phone'] : '',
            'goods_id' => $dataList['goods_id'] ? $dataList['goods_id'] : '',
            'goods_name' => $dataList['goods_name'] ? $dataList['goods_name'] : '',
            'goods_num' => $dataList['goods_num'] ? $dataList['goods_num'] : 1,
            'draw_merchant' => $dataList['draw_merchant'] ? $dataList['draw_merchant'] : '',
            'channel_num' => $dataList['channel_num'] ? $dataList['channel_num'] : '',
            'channel_name' => $dataList['channel_name'] ? $dataList['channel_name'] : '',
            'deleted' => 0,
            'create_time' => date("Y-m-d H:i:s"),
            'create_date' => date("Y-m-d"),
            'phone_type' => 2,
            'draw_status' => $dataList['draw_status'] ? intval($dataList['draw_status']) : 1,
            'draw_message' => $dataList['draw_message'] ? $dataList['draw_message'] : '',
            'phone_code' => $dataList['phone_code'] ? $dataList['phone_code'] : '',
            'reduce_integral' => $dataList['reduce_integral'] ? intval($dataList['reduce_integral']) : ''
        ];

        Db::table('user_coupon')->insert($data);
        $userCouponId = Db::name('user_coupon')->getLastInsID();

        return $userCouponId;
    }

    //列表
    public function jflist(){

        /*$Usercoupon = new Usercoupon();
        $Usercoupon = Usercoupon::get();
                return $Usercoupon->visible(['id','user_name','user_phone'])->toJson();*/
        $dataList = Db::query("select id,user_phone,goods_name from user_coupon where deleted=0 and draw_status=1 ORDER BY id DESC limit 10");

        return $dataList;
    }

    //用户信息
    public function userinfo($dataList){
        
        //Db::query("select * from think_user where id=? AND status=?",[8,1]);
        $phone_code = $dataList['phone_code'];
        $where = "deleted=0 and phone_code={$phone_code} and (create_time < DATE_FORMAT(NOW(),'%Y-%m-%d 23:59:59')) and (create_time > DATE_FORMAT(NOW(),'%Y-%m-%d 00:00:00'))";
        $sql = "SELECT count(id) AS count_num FROM user_coupon WHERE {$where}";
        $count_num = Db::query($sql);

        return $count_num;   
    }
}