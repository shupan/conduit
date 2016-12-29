<?php

namespace app\Services\Sys;


use App\Services\SysService;
use Illuminate\Support\Facades\Storage;
use Log;
use App\Eloquent\Notice\Notice;
use App\Exceptions\Notice\NoticeException;

class NoticeService extends SysService
{
    const MIN_NUM = 0;
    const MAX_NUM = 10;


    /**
     *  获取推送的消息
     * @param $payload
     * @return array
     * @throws NoticeException
     */
   public function push($payload) {

       $data = array();
       if(!isset($payload['date'])){
           throw new NoticeException('date is required');
       }

       if(!isset($payload['isForce'])){
           throw new NoticeException('isForce is required');
       }

       $data = [
           'push' => $this->getCnt('new'),//Notice::auth()->ofStatus('new')->count(),
       ];

       if (empty($date)) {
           $date = date('Y-m-d H:i:s');
           $data['date'] = $date;
           $data['notices'] = $this->getData();
       } else {
           $data['date'] = $date;
           if ($payload['isForce'] || Notice::auth()->after($data['date'])->count()) {
               $data['notices'] = $this->getData();
           }
           if (isset($data['notices']) && count($data['notices'])) {
               $data['date'] = $date;
           } else {
               unset($data['notices']);
           }
       }

       $this->temp();
       return $data;
   }

    private function getCnt($status){

        //$data = Notice::auth()->where('status',$status)->get()->count();
        $data = Notice::count(['status'=>$status,'user_id'=>\Auth()->id()]);
        return $data;
    }

    private function getData(){
        //return Notice::auth()->desc()->get()->slice(self::MIN_NUM, self::MAX_NUM)->toArray();
        return Notice::query(null,['user_id'=>\Auth()->id()],['id'=>'desc'],10);
    }
    
    private function temp(){

        Storage::disk('local')->put('file.txt', 'Contents');

        //$this->_debug($this->getData());
        //$this->_debug(Notice::count(['status'=>'new']));
       // $this->_debug(Notice::testModel());
        //$this->_debug(Notice::queryOne(['id','user_id','status']));
        //$this->_debug(Notice::query(['id','user_id','status']));
    }

}
