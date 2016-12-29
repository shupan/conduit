<?php

namespace app\Services\Sys;

/*
 * UserService
 * @description  个人信息的简介
 * @author  Shu Pan
 * @email  king_fans@126.com
 * @date 2016-09-30 16:49:15
 */

use Illuminate\Support\Facades\Storage;
use Log;
use App\Eloquent\Sys\User;
use App\Exceptions\Sys\UserException;
use App\Services\Sys\SysService;

class UserService extends SysService
{


    /**
     * 用户注册
     * @param  $payload  数据包
     * @return array
     * @throws UserException
     */
   public function register($payload ) {
        $data = array();
        if (empty($payload))  throw new UserException('payload'.self::EMPTY_NOTE);
        
        return $data;
   }

    /**
     * token 转成 ID
     * @param  $token  数据包
     * @return array
     * @throws UserException
     */
   public function tokenToId($token ) {
        $data = array();
        if (empty($token))  throw new UserException('token'.self::EMPTY_NOTE);
        
        return $data;
   }

    /**
     * 检查邮件是否存在
     * @param  $email  email
     * @return array
     * @throws UserException
     */
   public function existEmail($email ) {
        $data = array();
        if (empty($email))  throw new UserException('email'.self::EMPTY_NOTE);
        
        return $data;
   }



    /**
     * 用户登录
     * @param  $email  邮件地址
     * @param  $password  密码
     * @return array
     * @throws UserException
     */
   public function login($email, $password ) {
        $data = array();
        if (empty($email))  throw new UserException('email'.self::EMPTY_NOTE);
        if (empty($password))  throw new UserException('password'.self::EMPTY_NOTE);
        
        return $data;
   }

    /**
     * 更新登录的时间
     * @param  $user_id  用户的ID
     * @return array
     * @throws UserException
     */
   public function updateLoginTime($user_id ) {
        $data = array();
        if (empty($user_id))  throw new UserException('user_id'.self::EMPTY_NOTE);
        
        return $data;
   }

   /**
   	* 查看
     * @return array
     */
    public function read() {
        $data = array();
        $data = User::query(['id','name']);
        return $data;
   }

   /**
   	* 根据邮箱的token找回密码
     * @param  $token  生成的token
     * @param  $new_pwd  生成的新密码
     * @return array
     * @throws UserException
     */
    public function findPwd($token, $new_pwd ) {
        $data = array();
        if (empty($token))  throw new UserException('token'.self::EMPTY_NOTE);
        if (empty($new_pwd))  throw new UserException('new_pwd'.self::EMPTY_NOTE);
        
        return $data;
   }

   /**
   	* 根据已有密码重置密码
     * @param  $token  生成的token
     * @param  $new_pwd  生成的新密码
     * @param  $cur_pwd  当前的密码
     * @return array
     * @throws UserException
     */
    public function resetPwd($token, $new_pwd, $cur_pwd ) {
        $data = array();
        if (empty($token))  throw new UserException('token'.self::EMPTY_NOTE);
        if (empty($new_pwd))  throw new UserException('new_pwd'.self::EMPTY_NOTE);
        if (empty($cur_pwd))  throw new UserException('cur_pwd'.self::EMPTY_NOTE);
        
        return $data;
   }

   /**
   	* 发送重置密码的url，超过24个小时，默认失效
     * @param  $email  email
     * @return array
     * @throws UserException
     */
    public function sendEmail($email ) {
        $data = array();
        if (empty($email))  throw new UserException('email'.self::EMPTY_NOTE);
        //sendEmail

        return $data;
   }

   /**
   	* 更新头像信息
     * @param  $avatar_src  头像地址
     * @param  $avatar_data  头像数据
     * @param  $avatar_file  头像文件地址
     * @return array
     * @throws UserException
     */
    public function uploadProtrait($avatar_src, $avatar_data, $avatar_file ) {
        $data = array();
        if (empty($avatar_src))  throw new UserException('avatar_src'.self::EMPTY_NOTE);
        if (empty($avatar_data))  throw new UserException('avatar_data'.self::EMPTY_NOTE);
        if (empty($avatar_file))  throw new UserException('avatar_file'.self::EMPTY_NOTE);
        
        return $data;
   }

   /**
   	* 更新用户的信息
     * @param  $id  用户ID
     * @param  $name  用户名
     * @param  $role  用户的角色
     * @param  $status  用户的状态
     * @return array
     * @throws UserException
     */
    public function update($id, $name, $role, $status ) {
        $data = array();
        if (empty($id))  throw new UserException('id'.self::EMPTY_NOTE);
        if (empty($name))  throw new UserException('name'.self::EMPTY_NOTE);
        if (empty($role))  throw new UserException('role'.self::EMPTY_NOTE);
        if (empty($status))  throw new UserException('status'.self::EMPTY_NOTE);
        
        return $data;
   }

   /**
   	* 邀请好友 
	* email  格式：["a@qq.com","b@qq.com"]
	* message 'aaa'
     * @param  $email  email
     * @param  $message  邀请的信息
     * @param  $role  用户的角色
     * @return array
     * @throws UserException
     */
    public function invite($email, $message, $role ) {
        $data = array();
        if (empty($email))  throw new UserException('email'.self::EMPTY_NOTE);
        if (empty($message))  throw new UserException('message'.self::EMPTY_NOTE);
        if (empty($role))  throw new UserException('role'.self::EMPTY_NOTE);
        
        return $data;
   }


}
