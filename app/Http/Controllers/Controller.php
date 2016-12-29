<?php

namespace App\Http\Controllers;

use App\Eloquent\Collection;
use App\Eloquent\Model;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;


    protected function json_or_dd($data, $only_data = true)
    {
        if ($data instanceof Collection) {
            $array = $data->toArray();
        } elseif ($data instanceof Model) {
            $array = $data->toArray();
        } else {
            $array = $data;
        }
        if (\Request::wantsJson() || !env('APP_DEBUG', false)) {
            die(json_encode($array));
        }
        if ($only_data) {
            dd($array);
        }
        dd($data);
    }


    /**
     * 返回结果的数据
     * @param unknown $res
     * @param number $code
     * @param string $msg
     * @param array  $other 其他的数组数据
     */
    protected function _res($res='', $code=0 , $msg='success',$other=array()){
        header("Content-type: application/json");
        $data['code'] = $code;
        $data['msg'] = $msg;
        $data['rows'] = $res;
        if(!empty($other)){
            foreach($other as $key=>$val){
                $data[$key] = $val;
            }
        }
        echo json_encode($data);die();
        exit();
    }

    protected function _debug($data){
        
        if(is_array($data)){
            echo json_encode($data);die();
        }
        print_r($data);exit();
    }

    protected  function validateParam($param,$validate){
        $v = \Validator::make($param,$validate);
        if($v->fails()){
            $this->_res('',-1,$v->messages("email")->first());
        }
    }
}
