<?php
class CLogin
{
    public static function searchUser($username)
    {
        $result = Yii::app()->db->createCommand('SELECT password FROM `admin` WHERE username=:username')->bindParam(':manager',$username)
        ->queryRow();
        return $result;
    }
}