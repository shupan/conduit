<?php

namespace app\Console\Commands;

use Illuminate\Console\Command;
use EasyWeChat\Foundation\Application;

class DailyStats extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'stats';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'daily stats';

    protected $api = null;

    /**
     * 数据的统计
     * 1. 连接ad库
     * 2. 根据指标能够查询线上的数据，完成基本的日常数据的统计
     * 3. 根据现有的数据库，深入的分析
     *     a. 业务的广告情况，包括在FB和PMD的统计情况
     *     b. 业务人员的使用情况
     *     c. 业务人员的收入和利润的情况
     *     d. 业务人员的操作情况
     * 4. 生成规定格式的markdown操作
     * @return mixed
     */
    public function handle()
    {

    }

}
