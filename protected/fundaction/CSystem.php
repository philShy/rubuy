<?php
/**
 * class CSystem
 * @Auth phil
 * data 2017/6/20
 * time 15:30
 */
class CSystem{
    //获取ip
    public static function getip()
    {
        if(getenv('HTTP_CLIENT_IP')) {
            $ip = getenv('HTTP_CLIENT_IP');
        } elseif(getenv('HTTP_X_FORWARDED_FOR')) {
            $ip = getenv('HTTP_X_FORWARDED_FOR');
        } elseif(getenv('REMOTE_ADDR')) {
            $ip = getenv('REMOTE_ADDR');
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }
    //获取数据表id
    public static function getTable_id($name)
    {
        $result = Yii::app()->db->createCommand("SELECT id FROM `table_info` WHERE table_name=:table_name")
        ->bindValue(':table_name',$name)->queryRow();
        return $result['id'];
    }
    //获取操作表id
    public static function getCurd_id($name)
    {
        $result = Yii::app()->db->createCommand("SELECT id FROM `curd_info` WHERE curd_name=:curd_name")
        ->bindValue(':curd_name',$name)->queryRow();
        return $result['id'];
    }
    //添加操作记录
    public static function opration($login_user,$login_role,$table_name,$curl_name)
    {
        if (!empty($table_name))
        {
            $table_id=self::getTable_id($table_name);
        }
        if (!empty($curl_name))
        {
            $curl_id=self::getCurd_id($curl_name);
        }
        $operate_time = date('Y-m-d H:i:s',time());
        $login_ip = self::getip();
        Yii::app()->db->createCommand('INSERT INTO `system_log` (`login_user`,`login_role_id`,`table_id`,`operate_id`,`login_ip`,`operate_time`)
        VALUES (:login_user,:login_role_id,:table_id,:operate_id,:login_ip,:operate_time)')
        ->bindValue(':login_user',$login_user)->bindValue(':login_role_id',$login_role)->bindValue(':table_id',$table_id)
        ->bindValue(':operate_id',$curl_id)->bindValue(':login_ip',$login_ip)->bindValue(':operate_time',$operate_time)->execute();
    }
    //删除操作记录
    public static function delOpration($id)
    {
        $result = Yii::app()->db->createCommand("DELETE FROM `system_log` WHERE id=:id")
        ->bindValue(':id',$id)->execute();
        if($result)
        {
            $log_res = CSystem::opration(Yii::app()->session['manager'],Yii::app()->session['rolr_id'],'system_log','delete');
        }
        return $result;
    }

    //查询操作记录
    public static function searchSystem_log()
    {
        $result = Yii::app()->db->createCommand("SELECT a.id,a.login_user,a.login_ip,a.operate_time,b.role,c.table_cname,d.curd_cname FROM system_log a LEFT JOIN role b ON a.login_role_id = b.id
        LEFT JOIN table_info c ON a.table_id=c.id LEFT JOIN curd_info d ON a.operate_id=d.id ORDER BY a.operate_time desc ")->queryAll();
        return $result;
    }
    //按条件查询操作记录
    public static function log_where($manager,$datetime)
    {
        $result = Yii::app()->getDb()->createCommand();
        $result->select('a.id,a.login_user,a.login_ip,a.operate_time,b.role,c.table_cname,d.curd_cname');
        $result->from('system_log a');
        $result->join('role b','a.login_role_id = b.id');
        $result->join('table_info c','a.table_id=c.id');
        $result->join('curd_info d','a.operate_id=d.id');
        if($manager)
        {
            $result->andWhere("a.login_user='$manager'");
        }
        if($datetime)
        {
            $date_t = date('Y-m-d H:i:s',(strtotime($datetime))+3600*24);
            $result->andWhere("a.operate_time>'$datetime'");
            $result->andWhere("a.operate_time<'$date_t'");
        }
        $list =$result ->queryAll();
        return $list;
    }
    //查找导航栏
    public static function searchNav()
    {
        $result = Yii::app()->db->createCommand("SELECT * FROM `nav` WHERE is_delete=0")->queryAll();
        return $result;
    }
    //添加导航栏
    public static function addNav($nav_name,$nav_url,$nav_sort)
    {
        $create_time = date('Y-m-d H:i:s',time());
        $result = Yii::app()->db->createCommand('INSERT INTO `nav` (`nav_name`,`nav_url`,`nav_sort`,`create_time`)
        VALUES (:nav_name,:nav_url,:nav_sort,:create_time)')
        ->bindValue(':nav_name',$nav_name)->bindValue(':nav_url',$nav_url)->bindValue(':nav_sort',$nav_sort)
        ->bindValue(':create_time',$create_time)->execute();
        $eid = Yii::app()->db->getLastInsertID();
        if($result)
        {
            $log_res = CSystem::opration(Yii::app()->session['manager'],Yii::app()->session['rolr_id'],'nav','insert');
        }
        return $eid;
    }
    //查询单个导航
    public static function searchnav_byid($navid)
    {
        $result = Yii::app()->db->createCommand("SELECT * FROM `nav` WHERE id=:id")->bindParam(':id',$navid)->queryRow();
        return $result;
    }
    //修改导航
    public static function editNav_byid($nav_id,$nav_name,$nav_url,$nav_sort)
    {
        $create_time = date('Y-m-d H:i:s',time());
        $result = Yii::app()->db->createCommand('UPDATE `nav` SET nav_name=:nav_name,nav_url=:nav_url,nav_sort=:nav_sort,create_time=:create_time WHERE id=:id')
        ->bindParam(':nav_name',$nav_name)->bindParam(':nav_url',$nav_url)->bindParam(':nav_sort',$nav_sort)
        ->bindParam(':create_time',$create_time)->bindParam(':id',$nav_id)->execute();
        if($result)
        {
            $log_res = CSystem::opration(Yii::app()->session['manager'],Yii::app()->session['rolr_id'],'nav','update');
        }
        return $result;
    }
    //修改导航状态
    public static function editNavstadus_byid($nav_id,$stadus)
    {
        $result = Yii::app()->db->createCommand('UPDATE `nav` SET stadus=:stadus WHERE id=:id')
        ->bindParam(':stadus',$stadus)->bindParam(':id',$nav_id)->execute();
        if($result)
        {
            $log_res = CSystem::opration(Yii::app()->session['manager'],Yii::app()->session['rolr_id'],'nav','update');
        }
        return $result;
    }
    //删除导航
    public static function deleteNav_byid($nav_id,$is_delete)
    {
        $result = Yii::app()->db->createCommand('UPDATE `nav` SET is_delete=:is_delete WHERE id=:id')
            ->bindParam(':is_delete',$is_delete)->bindParam(':id',$nav_id)->execute();
        if($result)
        {
            $log_res = CSystem::opration(Yii::app()->session['manager'],Yii::app()->session['rolr_id'],'nav','delete');
        }
        return $result;
    }

    //添加系统文档类别
    public static function addDoc_category($cate_name,$cate_sort,$introduce)
    {
        $create_time = date('Y-m-d H:i:s',time());
        $result = Yii::app()->db->createCommand('INSERT INTO `system_doc_category` (`name`,`sort`,`introduce`,`create_time`)VALUES (:name,:sort,:introduce,:create_time)')
        ->bindValue(':name',$cate_name)->bindValue(':sort',$cate_sort)->bindValue(':introduce',$introduce)->bindValue(':create_time',$create_time)->execute();
        $log_res = CSystem::opration(Yii::app()->session['manager'],Yii::app()->session['rolr_id'],'article_category','insert');
        return $result;
    }
    //
    public static function searchCategor_byid($doc_cateid)
    {
        $result = Yii::app()->db->createCommand('SELECT * FROM `system_doc_category` WHERE id=:id AND is_delete=0')
        ->bindparam(':id',$doc_cateid)->queryRow();
        return $result;
    }
    //查看系统文档类别
    public static function searchDoc_category()
    {
        $result = Yii::app()->db->createCommand("SELECT * FROM `system_doc_category` WHERE is_delete=0")->queryAll();
        return $result;
    }
    //修改文档类别
    public static function editcategory_byid($doc_cate_id,$cate_name,$introduce,$cate_sort)
    {
        $result = Yii::app()->db->createCommand('UPDATE `system_doc_category` SET name=:name,introduce=:introduce,sort=:sort WHERE id=:id')
            ->bindParam(':name',$cate_name)->bindParam(':introduce',$introduce)
            ->bindParam(':sort',$cate_sort)->bindParam(':id',$doc_cate_id)->execute();
        $log_res = CSystem::opration(Yii::app()->session['manager'],Yii::app()->session['rolr_id'],'system_doc_category','update');
        return $result;
    }
    //通过文章类别ID删除文章类别
    public static function deletedoc_category($category_id,$is_delete)
    {
        $result = Yii::app()->db->createCommand('UPDATE `system_doc_category` SET is_delete=:is_delete WHERE id=:id')
        ->bindParam(':is_delete',$is_delete)->bindParam(':id',$category_id)->execute();
        $log_res = CSystem::opration(Yii::app()->session['manager'],Yii::app()->session['rolr_id'],'article_category','delete');
        return $result;
    }
    //查找所有文档
    public static function searchAll_doc()
    {
        $result = Yii::app()->db->createCommand('SELECT * FROM `system_doc` WHERE is_delete=0')->queryAll();
        return $result;
    }
    //查找不同类别下的文档通过文档类别id
    public static function searchDoc_bycateid($cate_id)
    {
        $result = Yii::app()->db->createCommand('SELECT * FROM `system_doc` WHERE is_delete=0 AND doc_category_id=:doc_category_id')
            ->bindValue(':doc_category_id',$cate_id)->queryAll();
        return $result;
    }
    public static function searchAlldoc_bycate($param)
    {
        $result = Yii::app()->db->createCommand('SELECT * FROM `system_doc` WHERE doc_category_id=:doc_category_id AND is_delete=0')
            ->bindValue(':doc_category_id',$param)->queryAll();
        return $result;
    }
    //修改文档状态
    public static function editDocstate($doc_id,$state)
    {
        $result = Yii::app()->db->createCommand('UPDATE `system_doc` SET states=:state WHERE id=:id')
        ->bindParam(':state',$state)->bindParam(':id',$doc_id)->execute();
        $log_res = CSystem::opration(Yii::app()->session['manager'],Yii::app()->session['rolr_id'],'system_doc','update');
        return $result;
    }
    //删除文档
    public static function deleteDoc($doc_id,$is_delete)
    {
        $result = Yii::app()->db->createCommand('UPDATE `system_doc` SET is_delete=:is_delete WHERE id=:id')
            ->bindParam(':is_delete',$is_delete)->bindParam(':id',$doc_id)->execute();
        $log_res = CSystem::opration(Yii::app()->session['manager'],Yii::app()->session['rolr_id'],'system_doc','update');
        return $result;
    }
    //添加文档
    public static function addDoc($doc_title,$introduce,$author='',$recommend=0,$cate,$content,$hit=0,$thumb=0)
    {
        $create_time = date('Y-m-d H:i:s',time());
        Yii::app()->db->createCommand('INSERT INTO `system_doc` (`title`,`introduce`,`author`,`is_recommend`,`doc_category_id`,`content`,`create_time`,`hit`,`thumb`)VALUES (:title,:introduce,:author,:recommend,:doc_category_id,:content,:create_time,:hit,:thumb)')
            ->bindValue(':title',$doc_title)->bindValue(':introduce',$introduce)->bindValue(':author',$author)
            ->bindValue(':recommend',$recommend)->bindValue(':doc_category_id',$cate)->bindValue(':content',$content)
            ->bindValue(':hit',$hit)->bindValue(':thumb',$thumb)->bindValue(':create_time',$create_time)->execute();
        $eid = Yii::app()->db->getLastInsertID();
        CSystem::opration(Yii::app()->session['manager'],Yii::app()->session['rolr_id'],'system_doc','insert');
        return $eid;
    }
    //通过ID查找文档信息
    public static function searchDoc_byid($doc_id)
    {
        $result = Yii::app()->db->createCommand('SELECT * FROM `system_doc` WHERE id=:id AND is_delete=0')
            ->bindparam(':id',$doc_id)->queryRow();
        return $result;
    }
    //修改文档
    public static function editDoc($doc_id,$doc_title,$introduce,$author,$recommend,$cate,$content,$hit,$thumb)
    {
        $create_time = date('Y-m-d H:i:s',time());
        $result = Yii::app()->db->createCommand('UPDATE `system_doc` SET title=:title,introduce=:introduce,author=:author,is_recommend=:is_recommend,doc_category_id=:doc_category_id,content=:content,create_time=:create_time,hit=:hit,thumb=:thumb WHERE id=:id')
        ->bindParam(':title',$doc_title)->bindParam(':introduce',$introduce)->bindParam(':author',$author)
        ->bindParam(':is_recommend',$recommend)->bindParam(':doc_category_id',$cate)->bindParam(':content',$content)
        ->bindParam(':create_time',$create_time)->bindParam(':id',$doc_id)
        ->bindParam(':hit',$hit)->bindParam(':thumb',$thumb)->execute();
        $log_res = CSystem::opration(Yii::app()->session['manager'],Yii::app()->session['rolr_id'],'system_doc','update');
        return $result;
    }
    //订单通知表
    public static function order_notice($id,$operat)
    {
        $create_time = date('Y-m-d H:i:s',time());
        $res = Yii::app()->db->createCommand('INSERT INTO `order_notice` (`order_id`,`operat`,`create_time`)VALUES (:order_id,:operat,:create_time)')
        ->bindValue(':order_id',$id)->bindValue(':operat',$operat)->bindValue(':create_time',$create_time)->execute();
        return $res;
    }
}

