<?php

Route::group(['prefix' => 'sys/user'], function () {
    
     /** 用户注册*/
     Route::post('register', 'Sys\UserController@register');
    
     /** 用户登录*/
     Route::post('login', 'Sys\UserController@login');
    
     /** 查看*/
     Route::get('read', 'Sys\UserController@read');
    
     /** 根据邮箱的token找回密码*/
     Route::post('findPwd', 'Sys\UserController@findPwd');
    
     /** 根据已有密码重置密码*/
     Route::post('resetPwd', 'Sys\UserController@resetPwd');
    
     /** 发送重置密码的url，超过24个小时，默认失效*/
     Route::post('sendEmail', 'Sys\UserController@sendEmail');
    
     /** 更新头像信息*/
     Route::post('uploadProtrait', 'Sys\UserController@uploadProtrait');
    
     /** 更新用户的信息*/
     Route::post('update', 'Sys\UserController@update');
    
     /** 邀请好友 
email  格式：["a@qq.com","b@qq.com"]
message 'aaa'*/
     Route::post('invite', 'Sys\UserController@invite');

});


