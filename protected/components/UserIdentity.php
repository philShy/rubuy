<?php
/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
	public $id;
	public function __construct()
	{
	}

	public function authenticate($data=array())
	{
		$user= Yii::app()->db->createCommand('select * from admin where manager=:manager AND password=:password')
		->bindValue(':manager',$data['username'])->bindValue(':password',md5($data['password']))->queryRow();
		if($user){
			$this->id=$user['id'];
			$this->username= $user['manager'];
			$this->setPersistentStates($user);
			$login_time = date('Y-m-d H:i:s');
			$res = Yii::app()->db->createCommand('UPDATE admin SET login_time = :login_time WHERE id = :id;')
			->bindValue(':login_time',$login_time)->bindValue(':id',$user['id'])->execute();
			if($res)
			{
				Yii::app()->session['manager']=$user['manager'];
				Yii::app()->session['rolr_id']=$user['role_id'];
				$log_res = CSystem::opration(Yii::app()->session['manager'],Yii::app()->session['rolr_id'],'admin','login');
			}
			return !$this->errorCode==self::ERROR_NONE;
		}
	}

	public function getId()
	{
		return $this->id;
	}
}