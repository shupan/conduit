<?php

use Mockery as m;
use Carbon\Carbon;
use Illuminate\Console\Scheduling\Event;

class ConsoleScheduledEventTest extends PHPUnit_Framework_TestCase
{
    /**
     * The default configuration timezone.
     *
     * @var string
     */
    protected $defaultTimezone;

    public function setUp()
    {
        $this->defaultTimezone = date_default_timezone_get();
        date_default_timezone_set('UTC');
    }

    public function tearDown()
    {
        date_default_timezone_set($this->defaultTimezone);
        Carbon::setTestNow(null);
        m::close();
    }

    public function testBasicCronCompilation()
    {
        $app = m::mock('Illuminate\Foundation\Application[isDownForMaintenance,environment]');
        $app->shouldReceive('isDownForMaintenance')->andReturn(false);
        $app->shouldReceive('environment')->andReturn('production');

        $event = new Event('php foo');
        $this->assertEquals('* * * * * *', $event->getExpression());
        $this->assertTrue($event->isDue($app));
        $this->assertTrue($event->skip(function () {
            return true;
        })->isDue($app));
        $this->assertFalse($event->skip(function () {
            return true;
        })->filtersPass($app));

        $event = new Event('php foo');
        $this->assertEquals('* * * * * *', $event->getExpression());
        $this->assertFalse($event->environments('local')->isDue($app));

        $event = new Event('php foo');
        $this->assertEquals('* * * * * *', $event->getExpression());
        $this->assertFalse($event->when(function () {
            return false;
        })->filtersPass($app));

        $event = new Event('php foo');

        // 测试每分钟的验证
        $this->assertEquals('*/5 * * * * *', $event->everyFiveMinutes()->getExpression());
        $event = new Event('php foo');
        $this->assertEquals('0 0 * * * *', $event->daily()->getExpression());

        $event = new Event('php foo');
        $this->assertEquals('0 3,15 * * * *', $event->twiceDaily(3, 15)->getExpression());

        $event = new Event('php foo');
        $this->assertEquals('*/5 * * * 3 *', $event->everyFiveMinutes()->wednesdays()->getExpression());

        $event = new Event('php foo');
        $this->assertEquals('0 * * * * *', $event->everyFiveMinutes()->hourly()->getExpression());

        $event = new Event('php foo');
        $this->assertEquals('0 15 4 * * *', $event->monthlyOn(4, '15:00')->getExpression());

        $event = new Event('php foo');
        $this->assertEquals('0 0 * * 1-5 *', $event->weekdays()->daily()->getExpression());

        $event = new Event('php foo');
        $this->assertEquals('0 * * * 1-5 *', $event->weekdays()->hourly()->getExpression());

        // 每天的15点10分定时发送邮件
        $event = new Event('php foo');
        $this->assertEquals('10 15 * * * *',$event->at('15:10')->getExpression());

        // 指定某年某月某日发送邮件：2016-09-20 10:10:10 @todo
        //$rs = Carbon::setTestNow(Carbon::create(2016, 09, 20, 10, 10, 10));
        //$this->assertEquals('10 10 10 20 09 2016',$event->at('2016/09/20 10:10:10')->getExpression());
        $this->assertEquals('10 10 10 20 09 2016',$event->cron('10 10 10 20 09 2016')->getExpression());

        // chained rules should be commutative
        $eventA = new Event('php foo');
        $eventB = new Event('php foo');
        $this->assertEquals(
            $eventA->daily()->hourly()->getExpression(),
            $eventB->hourly()->daily()->getExpression());

        $eventA = new Event('php foo');
        $eventB = new Event('php foo');
        $this->assertEquals(
            $eventA->weekdays()->hourly()->getExpression(),
            $eventB->hourly()->weekdays()->getExpression());
    }

    public function testEventIsDueCheck()
    {
        $app = m::mock('Illuminate\Foundation\Application[isDownForMaintenance,environment]');
        $app->shouldReceive('isDownForMaintenance')->andReturn(false);
        $app->shouldReceive('environment')->andReturn('production');
        Carbon::setTestNow(Carbon::create(2015, 1, 1, 0, 0, 0));

        $event = new Event('php foo');
        $this->assertEquals('* * * * 4 *', $event->thursdays()->getExpression());
        $this->assertTrue($event->isDue($app));

        $event = new Event('php foo');
        $this->assertEquals('0 19 * * 3 *', $event->wednesdays()->at('19:00')->timezone('EST')->getExpression());
        $this->assertTrue($event->isDue($app));
    }

    public function testTimeBetweenChecks()
    {
        $app = m::mock('Illuminate\Foundation\Application[isDownForMaintenance,environment]');
        $app->shouldReceive('isDownForMaintenance')->andReturn(false);
        $app->shouldReceive('environment')->andReturn('production');
        Carbon::setTestNow(Carbon::now()->startOfDay()->addHours(9));

        $event = new Event('php foo');
        $this->assertTrue($event->between('8:00', '10:00')->filtersPass($app));
        $this->assertTrue($event->between('9:00', '9:00')->filtersPass($app));
        $this->assertFalse($event->between('10:00', '11:00')->filtersPass($app));

        $this->assertFalse($event->unlessBetween('8:00', '10:00')->filtersPass($app));
        $this->assertTrue($event->unlessBetween('10:00', '11:00')->isDue($app));
    }
}
