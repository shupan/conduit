<?php

namespace app\Console\Commands;

use Illuminate\Console\Command;
use EasyWeChat\Foundation\Application;

class Program extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'program';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'small program';

    protected $api = null;

    /**
     * Program 基本功能
     * 1. 可以获取基本的信息
     * 2. 可以对接口进行一些操作
     * 3. 验证是否支持支付功能
     * @return mixed
     */
    public function handle()
    {

       // $this->api = new \Phabricator\Phabricator('http://phabricator.pmdchina.com', 'api-5hxvg73ru7ixvvxdneypfgniybs4');
        $options = [
            'debug'     => true,
            'app_id'    => 'wx3cf0f39249eb0e60',
            'secret'    => 'f1c242f4f28f735d4687abb469072a29',
            'token'     => 'easywechat',
            'log' => [
                'level' => 'debug',
                'file'  => '/tmp/easywechat.log',
            ],
            // ...
        ];

        $app = new Application($options);
        $server = $app->server;
        $user = $app->user;

        $server->setMessageHandler(function($message) use ($user) {
            $fromUser = $user->get($message->FromUserName);
            return "{$fromUser->nickname} 您好！欢迎关注 overtrue!";
        });

        $server->serve()->send();

    }

}
