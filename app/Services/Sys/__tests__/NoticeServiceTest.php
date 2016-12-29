<?php
/**
 * @author    Mauri de Souza Nunes <mauri870@gmail.com>
 * @copyright Copyright (c) 2016, Mauri de Souza Nunes <github.com/mauri870>
 * @license   https://opensource.org/licenses/MIT MIT License
 */
namespace App\Services\Notice\__tests__;

use App\Services\Sys\NoticeService;
use App\Tests\AbstractTestCase;
use Log;


 class NoticeServiceTest extends AbstractTestCase
{

     public function testPushNotice()
     {

         Log::info("start Notice Service testing ......");
         $this->assertTrue(true);
         $data = NoticeService::getInstance()->push(['date'=>'', 'isForce'=>'']);
         $this->assertNotEmpty($data);
         $this->assertEquals(0, $data['push']);

         $date = '2016-09-11 13:09:12';
         $data = NoticeService::getInstance()->push(['date'=>$date, 'isForce'=>'']);
         //$this->assertEquals($date,$data['date']);


     }

     public function testStrHereDoc(){

         //忽略Tag字符串本身
         $serviceContent = <<<'TAG'
		
		$data = [
           'push' => $this->getCnt('new'),//Notice::auth()->ofStatus('new')->count(),
       ];
        $data['date'] = $date;
	   if ($payload['isForce'] || Notice::auth()->after($data['date'])->count()) {
		   $data['notices'] = $this->getData();
	   }
	   if (isset($data['notices']) && count($data['notices'])) {
		   $data['date'] = $date;
	   } else {
		   unset($data['notices']);
	   }
TAG;

         $this->assertNotEmpty($serviceContent);
     }
}
