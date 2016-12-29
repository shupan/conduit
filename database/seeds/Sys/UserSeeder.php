<?php

/**
 * User Seeder
 * @description  个人信息的简介
 * @author  Shu Pan
 * @email  king_fans@126.com
 * @date 2016-09-30 16:49:15
 * @author  shupan
 */
use App\Eloquent\Sys\User;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();
        for ($i = 0; $i < 10; $i++) {
        User::create([
                "name"=> $faker->name,
                "parent_id"=> '',
                "cname"=> $faker->name,
                "password"=> $faker->password(6,20),
                "phone"=> $faker->randomNumber(11),
                "email"=> $faker->email,
                "fb_id"=> '',
                "fb_status"=> '',
                "company_name"=> $faker->company,
                "company_website"=> $faker->url,
                "country"=> $faker->country,
                "location"=> $faker->locale,
                "role"=> '',
                "status"=> '',
                "comment"=> '',
                "updated_time"=> $faker->unixTime,
                "created_time"=> $faker->unixTime,
                "production_token"=> '',
                "pre_release_token"=> '',
                "testing_token"=> '',
                "dev_testing_token"=> '',
                "development_token"=> '',
                "portrait"=> $faker->imageUrl(100),
        
            ]);
        }
    }
}
