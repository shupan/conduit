<?php
namespace App\Services\Sys\__tests__;

/*
 * UserService Unit Test
 * @description  个人信息的简介
 * @author  Shu Pan
 * @email  king_fans@126.com
 * @date 2016-09-30 16:49:15
 */
use App\Tests\AbstractTestCase;
use App\Services\Sys\UserService;
use Log;


class UserServiceTest extends AbstractTestCase
{

     public function testRegister(){

         $param = array();
         $param['nickname'] = '';     //昵称
         $param['email'] = '';     //邮件地址
         $param['password'] = '';     //密码
         $param['token'] = '';     //token
         $data = UserService::getInstance()->register($param['payload'] );
         $this->assertNotEmpty($data);
    }

     public function testLogin(){

         $param = array();
         $param['email'] = '';     //邮件地址
         $param['password'] = '';     //密码
         $data = UserService::getInstance()->login($param['email'], $param['password'] );
         $this->assertNotEmpty($data);
    }

     public function testRead(){

         $param = array();
             $data = UserService::getInstance()->read();
         $this->assertNotEmpty($data);
    }

     public function testFindPwd(){

         $param = array();
         $param['token'] = '';     //生成的token
         $param['new_pwd'] = '';     //生成的新密码
         $data = UserService::getInstance()->findPwd($param['token'], $param['new_pwd'] );
         $this->assertNotEmpty($data);
    }

     public function testResetPwd(){

         $param = array();
         $param['token'] = '';     //生成的token
         $param['new_pwd'] = '';     //生成的新密码
         $param['cur_pwd'] = '';     //当前的密码
         $data = UserService::getInstance()->resetPwd($param['token'], $param['new_pwd'], $param['cur_pwd'] );
         $this->assertNotEmpty($data);
    }

     public function testSendEmail(){

         $param = array();
         $param['email'] = '';     //email
         $data = UserService::getInstance()->sendEmail($param['email'] );
         $this->assertNotEmpty($data);
    }

     public function testUploadProtrait(){

         $param = array();
         $param['avatar_src'] = '';     //头像地址
         $param['avatar_data'] = '';     //头像数据
         $param['avatar_file'] = '';     //头像文件地址
         $data = UserService::getInstance()->uploadProtrait($param['avatar_src'], $param['avatar_data'], $param['avatar_file'] );
         $this->assertNotEmpty($data);
    }

     public function testUpdate(){

         $param = array();
         $param['id'] = '';     //用户ID
         $param['name'] = '';     //用户名
         $param['role'] = '';     //用户的角色
         $param['status'] = '';     //用户的状态
         $data = UserService::getInstance()->update($param['id'], $param['name'], $param['role'], $param['status'] );
         $this->assertNotEmpty($data);
    }

     public function testInvite(){

         $param = array();
         $param['email'] = '';     //email
         $param['message'] = '';     //邀请的信息
         $param['role'] = '';     //用户的角色
         $data = UserService::getInstance()->invite($param['email'], $param['message'], $param['role'] );
         $this->assertNotEmpty($data);
    }


}
