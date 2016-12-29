<?php

namespace App\Eloquent\Sys;
 /*
 * User Model
 * @description  个人信息的简介
 * @author  Shu Pan
 * @email  king_fans@126.com
 * @date 2016-09-30 16:49:15
 * @author  shupan
 */

use App\Eloquent\Model;

class User extends Model
{

    /** 表名 */
    protected $table = 'sys_user';


    /** 需要填充的字段 */
    protected $fillable = [];

}
