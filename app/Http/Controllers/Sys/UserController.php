<?php

namespace app\Http\Controllers\Sys;

/*
 * User Controller
 * @description  个人信息的简介
 * @author  Shu Pan
 * @email  king_fans@126.com
 * @date 2016-09-30 16:49:15
 */

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use App\Http\Controllers\Controller;
use App\Services\Sys\UserService;
use App\Exceptions\Sys\UserException;
use Log;

class UserController extends Controller
{

    /**
	* 用户注册
    * @return array
    */
    public function register(Request $request)
    {
        $data = array();
        $validate = [
            ['nickname'=> 'required'],     //昵称
            ['email'=> 'required'],     //邮件地址
            ['password'=> 'required'],     //密码
            ['token'=> 'optional'],     //token
        
        ];
        $param = $request->all();
        $this->validateParam($param,$validate);
        try{
            $data = UserService::getInstance()->register($param['payload'] );
            
        }catch(UserException $e){
            //日志记录
            $this->_res('',$e->getCode(),$e->getMessage());
        }
    
        $this->_res($data);
    
    }

    /**
	* 用户登录
    * @return array
    */
    public function login(Request $request)
    {
        $data = array();
        $validate = [
            ['email'=> 'required'],     //邮件地址
            ['password'=> 'required'],     //密码
        
        ];
        $param = $request->all();
        $this->validateParam($param,$validate);
        try{
            $data = UserService::getInstance()->login($param['email'], $param['password'] );
            
        }catch(UserException $e){
            //日志记录
            $this->_res('',$e->getCode(),$e->getMessage());
        }
    
        $this->_res($data);
    
    }

    /**
	* 查看
    * @return array
    */
    public function read(Request $request)
    {
        $data = array();
        $validate = [
        
        ];
        $param = $request->all();
        $this->validateParam($param,$validate);
        $data = UserService::getInstance()->read();
        
        $result = new Collection($data);
        $result->map(function ($item) {
            return $item;
        })->all();
        $this->_res($result->all());
    
    }

    /**
	* 根据邮箱的token找回密码
    * @return array
    */
    public function findPwd(Request $request)
    {
        $data = array();
        $validate = [
            ['token'=> 'required'],     //生成的token
            ['new_pwd'=> 'required'],     //生成的新密码
        
        ];
        $param = $request->all();
        $this->validateParam($param,$validate);
        try{
            $data = UserService::getInstance()->findPwd($param['token'], $param['new_pwd'] );
            
        }catch(UserException $e){
            //日志记录
            $this->_res('',$e->getCode(),$e->getMessage());
        }
    
        $this->_res($data);
    
    }

    /**
	* 根据已有密码重置密码
    * @return array
    */
    public function resetPwd(Request $request)
    {
        $data = array();
        $validate = [
            ['token'=> 'required'],     //生成的token
            ['new_pwd'=> 'required'],     //生成的新密码
            ['cur_pwd'=> 'required'],     //当前的密码
        
        ];
        $param = $request->all();
        $this->validateParam($param,$validate);
        try{
            $data = UserService::getInstance()->resetPwd($param['token'], $param['new_pwd'], $param['cur_pwd'] );
            
        }catch(UserException $e){
            //日志记录
            $this->_res('',$e->getCode(),$e->getMessage());
        }
    
        $this->_res($data);
    
    }

    /**
	* 发送重置密码的url，超过24个小时，默认失效
    * @return array
    */
    public function sendEmail(Request $request)
    {
        $data = array();
        $validate = [
            ['email'=> 'required'],     //email
        
        ];
        $param = $request->all();
        $this->validateParam($param,$validate);
        try{
            $data = UserService::getInstance()->sendEmail($param['email'] );
            
        }catch(UserException $e){
            //日志记录
            $this->_res('',$e->getCode(),$e->getMessage());
        }
    
        $this->_res($data);
    
    }

    /**
	* 更新头像信息
    * @return array
    */
    public function uploadProtrait(Request $request)
    {
        $data = array();
        $validate = [
            ['avatar_src'=> 'required'],     //头像地址
            ['avatar_data'=> 'required'],     //头像数据
            ['avatar_file'=> 'required'],     //头像文件地址
        
        ];
        $param = $request->all();
        $this->validateParam($param,$validate);
        try{
            $data = UserService::getInstance()->uploadProtrait($param['avatar_src'], $param['avatar_data'], $param['avatar_file'] );
            
        }catch(UserException $e){
            //日志记录
            $this->_res('',$e->getCode(),$e->getMessage());
        }
    
        $this->_res($data);
    
    }

    /**
	* 更新用户的信息
    * @return array
    */
    public function update(Request $request)
    {
        $data = array();
        $validate = [
            ['id'=> 'required'],     //用户ID
            ['name'=> 'required'],     //用户名
            ['role'=> 'required'],     //用户的角色
            ['status'=> 'required'],     //用户的状态
        
        ];
        $param = $request->all();
        $this->validateParam($param,$validate);
        try{
            $data = UserService::getInstance()->update($param['id'], $param['name'], $param['role'], $param['status'] );
            
        }catch(UserException $e){
            //日志记录
            $this->_res('',$e->getCode(),$e->getMessage());
        }
    
        $this->_res($data);
    
    }

    /**
	* 邀请好友 
	* email  格式：["a@qq.com","b@qq.com"]
	* message 'aaa'
    * @return array
    */
    public function invite(Request $request)
    {
        $data = array();
        $validate = [
            ['email'=> 'required'],     //email
            ['message'=> 'required'],     //邀请的信息
            ['role'=> 'required'],     //用户的角色
        
        ];
        $param = $request->all();
        $this->validateParam($param,$validate);
        try{
            $data = UserService::getInstance()->invite($param['email'], $param['message'], $param['role'] );
            
        }catch(UserException $e){
            //日志记录
            $this->_res('',$e->getCode(),$e->getMessage());
        }
    
        $this->_res($data);
    
    }

}
