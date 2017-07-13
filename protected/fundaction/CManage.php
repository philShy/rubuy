<?php
/**
 * Created by PhpStorm.
 * Class: CAuth
 * Auth: @phil
 * Date: 2017/6/9
 * Time: 9:42
 */
class CManage
{
    //查找所有权限
    public static function searchAll_authpage($page=1,$size=2)
    {
        $result = Yii::app()->db->createCommand("SELECT * FROM `auth` ORDER BY path asc LIMIT :start,:size")
        ->bindValue(':start',(int)($page-1)*$size)
        ->bindValue(':size',(int)$size)->queryAll();
        return $result;
    }
    public static function searchAll_auth()
    {
        $result = Yii::app()->db->createCommand("SELECT * FROM `auth` ORDER BY path DESC ")->queryAll();
        return $result;
    }
    //查询所有管理员
    public static function searchAllmanager()
    {
        $result = Yii::app()->db->createCommand("SELECT admin.*,role.role,role.auth_id,role.auth_join FROM `admin` LEFT JOIN role ON admin.role_id=role.id WHERE admin.is_delete=0")->queryAll();
        return $result;
    }
    //查询所有角色
    public static function searchAllrole()
    {
        $result = Yii::app()->db->createCommand("SELECT * FROM `role` WHERE is_delete=0 ORDER BY id asc ")->queryAll();
        return $result;
    }
    //查找所有级别为0权限
    public static function searchAll_auth0()
    {
        $result = Yii::app()->db->createCommand("SELECT * FROM `auth` WHERE level=0")->queryAll();
        return $result;
    }
    //查找所有级别为1权限
    public static function searchAll_auth1($pid)
    {
        $result = Yii::app()->db->createCommand("SELECT * FROM `auth` WHERE level>0 AND pid=:pid")->bindParam('pid',$pid)->queryAll();
        return $result;
    }
    //通过登陆的用户id查找角色权限
    public static function searchAuth_Byadminid($adminid)
    {
        $result = Yii::app()->db->createCommand("SELECT * FROM `admin` LEFT JOIN role ON admin.role_id=role.id WHERE admin.id=:id")->bindParam('id',$adminid)->queryRow();
        return $result;
    }
    //通过登陆用户的权限id($arr)查找权限
    public static function searchAuth0_Byauthid($authid_arr)
    {
        $sql = "SELECT * FROM `auth` WHERE id IN ($authid_arr) AND `level`=0";
        $result = Yii::app()->db->createCommand($sql)->queryAll();
        return $result;
    }
    //通过登陆用户的权限id($arr)查找权限
    public static function searchAuth1_Byauthid($authid_arr='',$authpid)
    {
        if($authid_arr)
        {
            $where = "WHERE id IN ($authid_arr) AND";
        }else{
            $where = 'WHERE';
        }
        $sql = "SELECT * FROM `auth` $where `level`=1 AND pid=$authpid";
        $result = Yii::app()->db->createCommand($sql)->queryAll();
        return $result;
    }
    //最高管理员登录获取0级
    public static function searchAdmin_auth()
    {
        $sql = "SELECT * FROM `auth` WHERE `level`=0";
        $result = Yii::app()->db->createCommand($sql)->queryAll();
        return $result;
    }
    //查询控制器名
    public static function searchAction($aid)
    {
        $sql = "SELECT `contrl`,`action` FROM `auth` WHERE `id`=$aid";
        $result = Yii::app()->db->createCommand($sql)->queryRow();
        return $result;
    }
    //添加角色
    public static function insertRole($role_name,$auth_id,$auth_join,$role_introduce)
    {
        $data = date("Y-m-d H:i:s");
        $result = Yii::app()->db->createCommand('INSERT INTO `role` (`role`,`auth_id`,`auth_join`,`create_time`,`introduce`) VALUES (:role,:auth_id,:auth_join,:create_time,:introduce)')
        ->bindParam(':role',$role_name)->bindParam(':auth_id',$auth_id)->bindParam(':auth_join',$auth_join)->bindParam(':create_time',$data)->bindParam(':introduce',$role_introduce)->execute();
        return $result;
    }
    //添加管理员
    public static function insertAdmin($manage,$password,$sex,$phone,$email,$role_id,$note)
    {
        $data = date("Y-m-d H:i:s");
        $result = Yii::app()->db->createCommand('INSERT INTO `admin` (`manager`,`password`,`sex`,`phone`,`email`,`role_id`,`create_time`,`note`)
        VALUES (:manager,:password,:sex,:phone,:email,:role_id,:create_time,:note)')
        ->bindParam(':manager',$manage)->bindParam(':password',$password)->bindParam(':sex',$sex)
        ->bindParam(':phone',$phone)->bindParam(':email',$email)->bindParam(':role_id',$role_id)
        ->bindParam(':create_time',$data)->bindParam(':note',$note)->execute();
        return $result;
    }

    public static function insertAuth($auth_name='',$contrl='',$action='',$pid=0,$path='',$level=0)
    {
         $data = date("Y-m-d H:i:s");
         Yii::app()->db->createCommand('INSERT INTO `auth` (`auth_name`,`contrl`,`action`,`pid`,`path`,`level`,`create_time`)
         VALUES (:auth_name,:contrl,:action,:pid,:path,:level,:create_time)')
         ->bindParam(':auth_name',$auth_name)->bindParam(':contrl',$contrl)->bindParam(':action',$action)->bindParam(':pid',$pid)
         ->bindParam(':path',$path)->bindParam(':level',$level)->bindParam(':create_time',$data)->execute();
         $eid = Yii::app()->db->getLastInsertID();
        return $eid;
    }
    //修改权限路径
    public static function updateAuth($path,$id)
    {
        $result = Yii::app()->db->createCommand('UPDATE `auth` SET path = :path WHERE id=:id')->bindParam(':path',$path)->bindParam(':id',$id)->execute();
        $log_res = CSystem::opration(Yii::app()->session['manager'],Yii::app()->session['rolr_id'],'auth','update');
        return $result;
    }
    //通过ID查找权限详情
    public static function searchAuth_one($id)
    {
        $result = Yii::app()->db->createCommand("SELECT * FROM `auth` WHERE id=:id")->bindParam(':id',$id)->queryRow();
        return $result;
    }
    //修改权限详情通过id
    public static function updateAuth_byid($id,$auth_name,$contrl,$action,$level)
    {
        $data = date("Y-m-d H:i:s");
        $result = Yii::app()->db->createCommand('UPDATE `auth` SET auth_name = :auth_name,contrl=:contrl,action=:action,level=:level,create_time=:create_time WHERE id=:id')
        ->bindParam(':auth_name',$auth_name)->bindParam(':contrl',$contrl)->bindParam(':action',$action)
        ->bindParam(':level',$level)->bindParam(':create_time',$data)->bindParam(':id',$id)
        ->execute();
        $log_res = CSystem::opration(Yii::app()->session['manager'],Yii::app()->session['rolr_id'],'auth','update');
        return $result;
    }
    //通过管理员ID查找管理员信息
    public static function searchManager_one($manager_id)
    {
        $result = Yii::app()->db->createCommand("SELECT admin.*,role.role,role.auth_id,role.auth_join FROM `admin` LEFT JOIN role ON admin.role_id=role.id WHERE admin.id=:id and admin.is_delete=0")
        ->bindparam(':id',$manager_id)->queryRow();
        return $result;
    }
    //通过管理员ID修改管理员信息
    public static function editManager($managerid,$manager,$password,$sex,$phone,$email,$role_id,$create_time,$note)
    {
        $result = Yii::app()->db->createCommand('UPDATE `admin` SET manager=:manager,password=:password,sex=:sex,phone=:phone,email=:email,role_id=:role_id,create_time=:create_time,note=:note WHERE id=:id')
        ->bindParam(':manager',$manager)->bindParam(':password',$password)->bindParam(':sex',$sex)
        ->bindParam(':phone',$phone)->bindParam(':email',$email)->bindParam(':role_id',$role_id)
        ->bindParam(':create_time',$create_time)->bindParam(':note',$note)->bindParam(':id',$managerid)->execute();
        $log_res = CSystem::opration(Yii::app()->session['manager'],Yii::app()->session['rolr_id'],'admin','update');
        return $result;
    }
    //通过管理员ID修改管理员状态
    public static function editManagerstate($manager_id,$state)
    {
        $result = Yii::app()->db->createCommand('UPDATE `admin` SET state=:state WHERE id=:id')
        ->bindParam(':state',$state)->bindParam(':id',$manager_id)->execute();
        $log_res = CSystem::opration(Yii::app()->session['manager'],Yii::app()->session['rolr_id'],'admin','update');
        return $result;
    }
    //通过管理员ID删除管理员
    public static function deleteManager($manager_id,$is_delete)
    {
        $result = Yii::app()->db->createCommand('UPDATE `admin` SET is_delete=:is_delete WHERE id=:id')
        ->bindParam(':is_delete',$is_delete)->bindParam(':id',$manager_id)->execute();
        $log_res = CSystem::opration(Yii::app()->session['manager'],Yii::app()->session['rolr_id'],'admin','delete');
        return $result;
    }
    //通过角色ID修改角色状态
    public static function editRolestate($role_id,$state)
    {
        $result = Yii::app()->db->createCommand('UPDATE `role` SET states=:states WHERE id=:id')
        ->bindParam(':states',$state)->bindParam(':id',$role_id)->execute();
        $log_res = CSystem::opration(Yii::app()->session['manager'],Yii::app()->session['rolr_id'],'role','update');
        return $result;
    }
    //通过角色ID删除角色
    public static function deleteRole($role_id,$is_delete)
    {
        $result = Yii::app()->db->createCommand('UPDATE `role` SET is_delete=:is_delete WHERE id=:id')
        ->bindParam(':is_delete',$is_delete)->bindParam(':id',$role_id)->execute();
        $log_res = CSystem::opration(Yii::app()->session['manager'],Yii::app()->session['rolr_id'],'role','delete');
        return $result;
    }
}