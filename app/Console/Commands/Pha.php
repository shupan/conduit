<?php

namespace app\Console\Commands;

use Illuminate\Console\Command;

class Pha extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'pha';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Pha conduit';

    protected $api = null;

    /**
     * 可以根据Pha的接口打通
     * 1. 可以通过系统操作pha的接口情况
     * 2. 可以实现更加方便的，Task 和 Bug管理
     * 3. token 是跟用户绑定的。 这样只需要给用户赋予好项目和角色就可以很好的来达到Task的管理和Bug的管理
     * @return mixed
     */
    public function handle()
    {

        $this->api = new \Phabricator\Phabricator('http://phabricator.pmdchina.com', 'api-5hxvg73ru7ixvvxdneypfgniybs4');
//        $result = $this->api->Project('query', ['status' => 'status-assign']);
//        $result = $api->Feed('query',['limit'=>2,'after'=>5, 'before'=>3]);


        //$this->createTask();
        $result = $this->readUser();
        //$result = $this->readUserSearch();
        dd($result);
        die("aaa");

    }

    private function createTask(){
        $result = $this->api->Maniphest('createtask',
            [
                'title'=>'test',
                'description'=>'test',
                'viewPolicy'=>'PHID-USER-jvd4zfrovpdallxkt4pj',
                'ownerPHID'=>'PHID-USER-jvd4zfrovpdallxkt4pj',
                'ccPHIDs'=>['PHID-USER-jvd4zfrovpdallxkt4pj'],
                'priority'=>'80',
                'projectPHIDs'=>['PHID-PROJ-3odsvj44a2puo3crk7w2']
            ]);
        return $result;
    }

    /**
     * 获取用户
     */
    private function readUser(){
        return $this->api->User('query',['limit'=>'10']);
    }

    /**
     * 当前Pha 不支持
     * @return mixed
     */
    private function readUserSearch(){
        return $this->api->User('search',['limit'=>'10']);
    }
}
