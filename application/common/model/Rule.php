<?php
namespace app\common\model;
use think\Config;
use think\Db;
use think\Model;
use think\Request;
use think\Session;
use think\Url;
use think\Redirect;

class Rule extends Model
{
    /**
     * [user description]
     * @author Zcc<2351976426@qq.com>
     * @dateTime 2016-10
     * @return   [type]                   [description]
     */
    public function parent()
    {
       return $this->hasMany('Rule', 'parent_id', 'id');
    }

    /**
     * 获取图标
     * @param  [type] $islink [description]
     * @param  [type] $data   [description]
     * @return [type]         [description]
     */
    public function getIconAttr($islink, $data)
    {
        return ($islink === '') ? '' : '<i class="' . $islink . '"></i>';
    }

    /**
     * 检查权限
     * @param  integer $roleId [description]
     * @param  [type]  $name   [description]
     * @return [type]          [description]
     */
    public function checkRule($uid)
    {
        $request = Request::instance();
        $name    = $request->controller().'/'.$request->action();

        $ruleRow = Db::table('groupdata')->find($uid);
        $zcc=$ruleRow['rules'];
        $ids = array();
        $ids = array_merge($ids, explode(',', trim($zcc, ',')));
        $map['id']  = array('in',$ids);
        $ruleRow = Db::table('rule')->where($map)->where('name',$name)->count();
        // dump($ruleRow);exit();
        if ($ruleRow>0) {
         return true;  
        }else{
        	return false; }
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
        $articlecatRow = self::get($id);
        if ($articlecatRow == false) {
            $this->error = "分类不存在";
            return false;
        }
        if ($articlecatRow->parent()->count() > 0) {
            $this->error = "本分类下还有其他分类,不能删除";
            return false;
        }
        return $articlecatRow->delete();
    }
    
  
    
    
}
