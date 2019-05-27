<?php

use Illuminate\Database\Seeder;

class PostsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('posts')->delete();
        
        \DB::table('posts')->insert(array (
            0 => 
            array (
                'id' => 1,
                'user_id' => 1,
                'post_title' => 'John doe is looking for room updated',
                'post_body' => 'this is some test test descriotion for John doe\'s post',
                'location_id' => 1,
                'category_id' => 1,
                'expire_at' => '2019-05-15 00:00:00',
                'created_at' => '2019-02-16 04:56:45',
                'updated_at' => '2019-02-16 06:06:53',
            ),
            1 => 
            array (
                'id' => 21,
                'user_id' => 1,
                'post_title' => 'John doe is looking for room',
                'post_body' => 'this is some test test descriotion for John doe\'s post',
                'location_id' => 2,
                'category_id' => 2,
                'expire_at' => '2019-05-16 00:00:00',
                'created_at' => '2019-02-16 15:25:45',
                'updated_at' => '2019-02-16 15:25:45',
            ),
            2 => 
            array (
                'id' => 22,
                'user_id' => 1,
                'post_title' => 'John doe is looking for room',
                'post_body' => 'this is some test test descriotion for John doe\'s post',
                'location_id' => 2,
                'category_id' => 2,
                'expire_at' => '2019-06-21 00:00:00',
                'created_at' => '2019-02-16 15:27:44',
                'updated_at' => '2019-02-16 15:27:44',
            ),
            3 => 
            array (
                'id' => 23,
                'user_id' => 1,
                'post_title' => 'Sudip doe is looking for room',
                'post_body' => 'this is some test test descriotion for John doe\'s post',
                'location_id' => 3,
                'category_id' => 3,
                'expire_at' => '2019-05-18 00:00:00',
                'created_at' => '2019-02-16 15:28:05',
                'updated_at' => '2019-02-16 15:28:05',
            ),
            4 => 
            array (
                'id' => 24,
                'user_id' => 1,
                'post_title' => 'John doe is looking for room',
                'post_body' => 'Sudip is some test test descriotion for John doe\'s post',
                'location_id' => 1,
                'category_id' => 1,
                'expire_at' => '2019-05-31 00:00:00',
                'created_at' => '2019-02-16 15:29:11',
                'updated_at' => '2019-02-16 15:29:11',
            ),
            5 => 
            array (
                'id' => 25,
                'user_id' => 1,
                'post_title' => 'John doe is looking for room',
                'post_body' => 'this is some test test descriotion for John doe\'s post',
                'location_id' => 1,
                'category_id' => 1,
                'expire_at' => '2019-05-24 00:00:00',
                'created_at' => '2019-02-16 15:29:49',
                'updated_at' => '2019-02-16 15:29:49',
            ),
            6 => 
            array (
                'id' => 26,
                'user_id' => 14,
                'post_title' => 'John doe is looking for room',
                'post_body' => 'this is some test test descriotion for John doe\'s post',
                'location_id' => 1,
                'category_id' => 1,
                'expire_at' => '2019-05-27 00:00:00',
                'created_at' => '2019-04-22 04:43:11',
                'updated_at' => '2019-04-22 04:43:11',
            ),
            7 => 
            array (
                'id' => 27,
                'user_id' => 14,
                'post_title' => 'John doe is looking for room',
                'post_body' => 'this is some test test descriotion for John doe\'s post',
                'location_id' => 1,
                'category_id' => 1,
                'expire_at' => '2019-05-17 00:00:00',
                'created_at' => '2019-04-22 11:57:57',
                'updated_at' => '2019-04-22 11:57:57',
            ),
            8 => 
            array (
                'id' => 28,
                'user_id' => 14,
                'post_title' => 'Waiter needed',
                'post_body' => 'Excellent is some test test descriotion for John doe\'s post',
                'location_id' => 1,
                'category_id' => 1,
                'expire_at' => NULL,
                'created_at' => '2019-05-01 14:09:35',
                'updated_at' => '2019-05-01 14:09:35',
            ),
            9 => 
            array (
                'id' => 29,
                'user_id' => 28,
                'post_title' => 'John doe is looking for room',
                'post_body' => 'this is some test test descriotion for John doe\'s post',
                'location_id' => 1,
                'category_id' => 1,
                'expire_at' => NULL,
                'created_at' => '2019-05-03 07:14:20',
                'updated_at' => '2019-05-03 07:14:20',
            ),
            10 => 
            array (
                'id' => 30,
                'user_id' => 1,
                'post_title' => 'asdfs',
                'post_body' => 'asfsa',
                'location_id' => 1,
                'category_id' => 1,
                'expire_at' => '2019-05-09 00:00:00',
                'created_at' => '2019-05-06 00:00:00',
                'updated_at' => '2019-05-06 00:00:00',
            ),
            11 => 
            array (
                'id' => 31,
                'user_id' => 28,
                'post_title' => 'John doe is looking for room',
                'post_body' => 'this is some test test descriotion for John doe\'s post',
                'location_id' => 1,
                'category_id' => 1,
                'expire_at' => NULL,
                'created_at' => '2019-05-05 20:30:18',
                'updated_at' => '2019-05-05 20:30:18',
            ),
            12 => 
            array (
                'id' => 32,
                'user_id' => 28,
                'post_title' => 'sadfsda sadf',
                'post_body' => 'asdfasdfas sadf SF asdfs fsadfasdf',
                'location_id' => 1,
                'category_id' => 5,
                'expire_at' => NULL,
                'created_at' => '2019-05-05 20:41:39',
                'updated_at' => '2019-05-05 20:41:39',
            ),
            13 => 
            array (
                'id' => 33,
                'user_id' => 28,
                'post_title' => 'sadfsda sadf',
                'post_body' => 'asdfasdfas sadf SF asdfs fsadfasdf',
                'location_id' => 1,
                'category_id' => 5,
                'expire_at' => NULL,
                'created_at' => '2019-05-05 20:45:10',
                'updated_at' => '2019-05-05 20:45:10',
            ),
            14 => 
            array (
                'id' => 34,
                'user_id' => 28,
                'post_title' => 'John doe is looking for room agat',
                'post_body' => 'this is some test test descriotion for John doe\'s post',
                'location_id' => 1,
                'category_id' => 1,
                'expire_at' => NULL,
                'created_at' => '2019-05-05 20:45:11',
                'updated_at' => '2019-05-07 19:36:54',
            ),
            15 => 
            array (
                'id' => 35,
                'user_id' => 28,
                'post_title' => 'sadfsda sadf',
                'post_body' => 'asdfasdfas sadf SF asdfs fsadfasdf',
                'location_id' => 1,
                'category_id' => 5,
                'expire_at' => NULL,
                'created_at' => '2019-05-05 20:47:43',
                'updated_at' => '2019-05-05 20:47:43',
            ),
            16 => 
            array (
                'id' => 36,
                'user_id' => 28,
                'post_title' => 'sadfsa fsasdf',
                'post_body' => 'asfsajdklf asfsfsd',
                'location_id' => 1,
                'category_id' => 5,
                'expire_at' => NULL,
                'created_at' => '2019-05-05 21:35:37',
                'updated_at' => '2019-05-05 21:35:37',
            ),
            17 => 
            array (
                'id' => 37,
                'user_id' => 28,
                'post_title' => 'sadfsa fsasdf',
                'post_body' => 'asfsajdklf asfsfsd',
                'location_id' => 1,
                'category_id' => 5,
                'expire_at' => NULL,
                'created_at' => '2019-05-05 21:35:41',
                'updated_at' => '2019-05-05 21:35:41',
            ),
            18 => 
            array (
                'id' => 38,
                'user_id' => 28,
                'post_title' => 'sadfsa fsasdf',
                'post_body' => 'asfsajdklf asfsfsd',
                'location_id' => 1,
                'category_id' => 5,
                'expire_at' => NULL,
                'created_at' => '2019-05-05 21:37:17',
                'updated_at' => '2019-05-05 21:37:17',
            ),
            19 => 
            array (
                'id' => 39,
                'user_id' => 28,
                'post_title' => 'another update post tile',
                'post_body' => 'asfsajdklf asfsfsd asfsd',
                'location_id' => 1,
                'category_id' => 6,
                'expire_at' => '2019-05-31 00:00:00',
                'created_at' => '2019-05-05 21:38:29',
                'updated_at' => '2019-05-07 22:37:16',
            ),
            20 => 
            array (
                'id' => 40,
                'user_id' => 28,
                'post_title' => 'sadfsa fsasdf',
                'post_body' => 'asfsajdklf asfsfsd',
                'location_id' => 1,
                'category_id' => 5,
                'expire_at' => NULL,
                'created_at' => '2019-05-05 21:39:05',
                'updated_at' => '2019-05-05 21:39:05',
            ),
            21 => 
            array (
                'id' => 41,
                'user_id' => 28,
                'post_title' => 'John doe is looking for room',
                'post_body' => 'this is some test test descriotion for John doe\'s post',
                'location_id' => 1,
                'category_id' => 1,
                'expire_at' => NULL,
                'created_at' => '2019-05-05 21:53:05',
                'updated_at' => '2019-05-05 21:53:05',
            ),
            22 => 
            array (
                'id' => 42,
                'user_id' => 28,
                'post_title' => 'John doe is looking for room',
                'post_body' => 'this is some test test descriotion for John doe\'s post',
                'location_id' => 1,
                'category_id' => 1,
                'expire_at' => '2019-01-01 00:00:00',
                'created_at' => '2019-05-05 21:54:28',
                'updated_at' => '2019-05-05 21:54:28',
            ),
            23 => 
            array (
                'id' => 45,
                'user_id' => 28,
                'post_title' => 'new update',
                'post_body' => 'sadfsdaf sadf sfas safs',
                'location_id' => 1,
                'category_id' => 5,
                'expire_at' => '2019-05-30 00:00:00',
                'created_at' => '2019-05-05 21:59:28',
                'updated_at' => '2019-05-07 22:31:49',
            ),
            24 => 
            array (
                'id' => 46,
                'user_id' => 28,
                'post_title' => 'sadfsdfassa',
                'post_body' => 'sadfsdaf sadf sfas safs',
                'location_id' => 1,
                'category_id' => 4,
                'expire_at' => '2019-01-01 00:00:00',
                'created_at' => '2019-05-05 22:06:37',
                'updated_at' => '2019-05-09 12:35:46',
            ),
            25 => 
            array (
                'id' => 47,
                'user_id' => 28,
                'post_title' => 'John doe is looking for room',
                'post_body' => 'this is some test test descriotion for John doe\'s post',
                'location_id' => 1,
                'category_id' => 1,
                'expire_at' => NULL,
                'created_at' => '2019-05-10 05:03:51',
                'updated_at' => '2019-05-10 05:03:51',
            ),
            26 => 
            array (
                'id' => 48,
                'user_id' => 28,
                'post_title' => 'Yesh',
                'post_body' => 'Nsjsh',
                'location_id' => 1,
                'category_id' => 5,
                'expire_at' => '2019-05-31 00:00:00',
                'created_at' => '2019-05-10 07:51:59',
                'updated_at' => '2019-05-10 07:51:59',
            ),
            27 => 
            array (
                'id' => 49,
                'user_id' => 28,
                'post_title' => 'sdfsdasdfsd',
                'post_body' => 'sadfsdfsdf',
                'location_id' => 1,
                'category_id' => 6,
                'expire_at' => '2019-05-31 00:00:00',
                'created_at' => '2019-05-10 16:48:07',
                'updated_at' => '2019-05-10 16:48:07',
            ),
            28 => 
            array (
                'id' => 50,
                'user_id' => 28,
                'post_title' => 'Looking for room partner',
                'post_body' => '$125 for single person',
                'location_id' => 1,
                'category_id' => 1,
                'expire_at' => '2019-05-15 00:00:00',
                'created_at' => '2019-05-10 22:38:43',
                'updated_at' => '2019-05-10 22:38:43',
            ),
        ));
        
        
    }
}