<?php
namespace app\common\model;
use think\Model;
use \think\Response;
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

    //列表
    public function channellist(){

        $dataList = Db::query("select count(*) AS num,channel_num from user_coupon where deleted=0 and draw_status=1 group by channel_num ");

        return $dataList;
    }

    //列表
    public function countnum($channel_num){
       
        $where = "deleted=0 and draw_status=1 and channel_num = '{$channel_num}'";
        $sql = "SELECT count(id) AS count_num FROM user_coupon WHERE {$where}";
        $count_num = Db::query($sql);
        return $count_num;
    }

    //列表
    public function searchlist($params){
       
        $params['draw_status'] = intval($params['draw_status']);
       /* $page = intval($page);
        $pcount = intval($pcount);*/
        $where = array();
        $where[] = "deleted = 0";
        if (!empty($params['channel_num'])) {
            $where[] = "channel_num = '{$params['channel_num']}'";
        }
        if (!empty($params['start_time'])) {
            $where[] = "create_date >= '{$params['start_time']}'";
        }
        if (!empty($params['end_time'])) {
            $where[] = "create_date <= '{$params['end_time']}'";
        }
        if (!empty($params['draw_status'])) {
            $where[] = "draw_status = '{$params['draw_status']}'";
        }
        if (!empty($params['goods_name'])) {
            $where[] = "goods_name LIKE '%{$params['goods_name']}%' ";
        }
        $where = implode(' AND ', $where);
        if ($page > 0 && $pcount > 0) {
            $sqllimit = " LIMIT " . ($page - 1) * $pcount . "," . $pcount . " ";
        }
        else {
            $sqllimit = "";
        }
        $backdata = [];
        //$sql = "SELECT id,channel_num,order_id,user_phone,goods_name,reduce_integral,create_time,draw_status FROM user_coupon  WHERE {$where} ORDER BY id DESC {$sqllimit}";
        $backdata['page'] = Usercoupon::field("id")->where($where)->paginate(2);
        $backdata['data'] = Db::query($sql);
        return $backdata;
    }

}
