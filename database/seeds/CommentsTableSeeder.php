<?php

use Illuminate\Database\Seeder;

class CommentsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('comments')->delete();
        
        \DB::table('comments')->insert(array (
            0 => 
            array (
                'id' => 1,
                'user_id' => 14,
                'parent_id' => NULL,
                'post_id' => 25,
                'comment_body' => 'this is some test test comment updated for John doe\'s post',
                'created_at' => '2019-02-16 07:42:52',
                'updated_at' => '2019-02-16 07:44:31',
            ),
            1 => 
            array (
                'id' => 2,
                'user_id' => 14,
                'parent_id' => NULL,
                'post_id' => 25,
                'comment_body' => 'this is some test test comment for John doe\'s post',
                'created_at' => '2019-02-16 07:44:42',
                'updated_at' => '2019-02-16 07:44:42',
            ),
            2 => 
            array (
                'id' => 3,
                'user_id' => 16,
                'parent_id' => NULL,
                'post_id' => 25,
                'comment_body' => 'this is some test test comment for John doe\'s post',
                'created_at' => '2019-02-16 07:44:43',
                'updated_at' => '2019-02-16 07:44:43',
            ),
            3 => 
            array (
                'id' => 5,
                'user_id' => 11,
                'parent_id' => NULL,
                'post_id' => 1,
                'comment_body' => 'this is some test test comment for John doe\'s post',
                'created_at' => '2019-04-19 11:44:29',
                'updated_at' => '2019-04-19 11:44:29',
            ),
            4 => 
            array (
                'id' => 6,
                'user_id' => 1,
                'parent_id' => 1,
                'post_id' => 25,
                'comment_body' => 'this is a reply',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            5 => 
            array (
                'id' => 7,
                'user_id' => 1,
                'parent_id' => 2,
                'post_id' => 25,
                'comment_body' => 'reply',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            6 => 
            array (
                'id' => 8,
                'user_id' => 14,
                'parent_id' => NULL,
                'post_id' => 1,
                'comment_body' => 'Hello I want to apply for the job',
                'created_at' => '2019-04-29 02:07:02',
                'updated_at' => '2019-04-29 02:07:02',
            ),
            7 => 
            array (
                'id' => 9,
                'user_id' => 14,
                'parent_id' => NULL,
                'post_id' => 1,
                'comment_body' => 'Sure leave your phone no and email. We will contact you soon.',
                'created_at' => '2019-04-29 02:08:23',
                'updated_at' => '2019-04-29 02:08:23',
            ),
            8 => 
            array (
                'id' => 10,
                'user_id' => 14,
                'parent_id' => NULL,
                'post_id' => 1,
                'comment_body' => 'Sure leave your phone no and email. We will contact you soon.',
                'created_at' => '2019-04-29 11:32:44',
                'updated_at' => '2019-04-29 11:32:44',
            ),
            9 => 
            array (
                'id' => 11,
                'user_id' => 14,
                'parent_id' => NULL,
                'post_id' => 1,
                'comment_body' => 'Sure leave your phone no and email. We will contact you soon.',
                'created_at' => '2019-04-29 13:10:09',
                'updated_at' => '2019-04-29 13:10:09',
            ),
            10 => 
            array (
                'id' => 12,
                'user_id' => 14,
                'parent_id' => NULL,
                'post_id' => 22,
                'comment_body' => 'asdfsasdfasdf',
                'created_at' => '2019-04-29 14:55:46',
                'updated_at' => '2019-04-29 14:55:46',
            ),
            11 => 
            array (
                'id' => 13,
                'user_id' => 14,
                'parent_id' => NULL,
                'post_id' => 22,
                'comment_body' => 'I want to apply for this job',
                'created_at' => '2019-04-29 14:57:55',
                'updated_at' => '2019-04-29 14:57:55',
            ),
            12 => 
            array (
                'id' => 14,
                'user_id' => 14,
                'parent_id' => NULL,
                'post_id' => 22,
                'comment_body' => 'sdkjfsdl sdlfksjd flksd',
                'created_at' => '2019-04-29 15:02:32',
                'updated_at' => '2019-04-29 15:02:32',
            ),
            13 => 
            array (
                'id' => 15,
                'user_id' => 14,
                'parent_id' => NULL,
                'post_id' => 22,
                'comment_body' => 'aslkdfj laskf sdflk asdlfk',
                'created_at' => '2019-04-29 15:02:41',
                'updated_at' => '2019-04-29 15:02:41',
            ),
            14 => 
            array (
                'id' => 16,
                'user_id' => 14,
                'parent_id' => NULL,
                'post_id' => 22,
                'comment_body' => 'jasdfklsd alskdfj sdlksda fsaldf sdklf sd',
                'created_at' => '2019-04-29 15:02:52',
                'updated_at' => '2019-04-29 15:02:52',
            ),
            15 => 
            array (
                'id' => 17,
                'user_id' => 14,
                'parent_id' => NULL,
                'post_id' => 22,
                'comment_body' => ', so I can see',
                'created_at' => '2019-04-29 15:17:59',
                'updated_at' => '2019-04-29 15:17:59',
            ),
            16 => 
            array (
                'id' => 18,
                'user_id' => 14,
                'parent_id' => NULL,
                'post_id' => 22,
                'comment_body' => 'hello how  are you',
                'created_at' => '2019-04-29 15:23:21',
                'updated_at' => '2019-04-29 15:23:21',
            ),
            17 => 
            array (
                'id' => 19,
                'user_id' => 14,
                'parent_id' => NULL,
                'post_id' => 25,
                'comment_body' => 'Another question',
                'created_at' => '2019-04-29 15:24:33',
                'updated_at' => '2019-04-29 15:24:33',
            ),
            18 => 
            array (
                'id' => 20,
                'user_id' => 14,
                'parent_id' => NULL,
                'post_id' => 27,
                'comment_body' => 'sd sdfsdf sadfsd',
                'created_at' => '2019-04-29 16:58:21',
                'updated_at' => '2019-04-29 16:58:21',
            ),
            19 => 
            array (
                'id' => 21,
                'user_id' => 14,
                'parent_id' => NULL,
                'post_id' => 21,
                'comment_body' => 'ddfgd dsfg sadf',
                'created_at' => '2019-04-29 17:01:11',
                'updated_at' => '2019-04-29 17:01:11',
            ),
            20 => 
            array (
                'id' => 22,
                'user_id' => 14,
                'parent_id' => NULL,
                'post_id' => 21,
                'comment_body' => 'This ASDF sdf asdf',
                'created_at' => '2019-04-29 17:01:24',
                'updated_at' => '2019-04-29 17:01:24',
            ),
            21 => 
            array (
                'id' => 23,
                'user_id' => 14,
                'parent_id' => NULL,
                'post_id' => 23,
                'comment_body' => 'hello',
                'created_at' => '2019-04-30 01:38:09',
                'updated_at' => '2019-04-30 01:38:09',
            ),
            22 => 
            array (
                'id' => 24,
                'user_id' => 14,
                'parent_id' => NULL,
                'post_id' => 27,
                'comment_body' => 'hello',
                'created_at' => '2019-04-30 02:49:33',
                'updated_at' => '2019-04-30 02:49:33',
            ),
            23 => 
            array (
                'id' => 25,
                'user_id' => 28,
                'parent_id' => NULL,
                'post_id' => 29,
                'comment_body' => 'hello how are you',
                'created_at' => '2019-05-03 16:19:24',
                'updated_at' => '2019-05-03 16:19:24',
            ),
            24 => 
            array (
                'id' => 26,
                'user_id' => 28,
                'parent_id' => NULL,
                'post_id' => 29,
                'comment_body' => 'fasdfsadf',
                'created_at' => '2019-05-04 04:11:34',
                'updated_at' => '2019-05-04 04:11:34',
            ),
            25 => 
            array (
                'id' => 27,
                'user_id' => 28,
                'parent_id' => NULL,
                'post_id' => 22,
                'comment_body' => 'Dg',
                'created_at' => '2019-05-05 21:51:25',
                'updated_at' => '2019-05-05 21:51:25',
            ),
            26 => 
            array (
                'id' => 28,
                'user_id' => 28,
                'parent_id' => NULL,
                'post_id' => 22,
                'comment_body' => 'tes',
                'created_at' => '2019-05-07 04:09:14',
                'updated_at' => '2019-05-07 04:09:14',
            ),
            27 => 
            array (
                'id' => 29,
                'user_id' => 28,
                'parent_id' => NULL,
                'post_id' => 22,
                'comment_body' => 'test',
                'created_at' => '2019-05-09 12:38:46',
                'updated_at' => '2019-05-09 12:38:46',
            ),
            28 => 
            array (
                'id' => 30,
                'user_id' => 28,
                'parent_id' => NULL,
                'post_id' => 30,
                'comment_body' => 'hello',
                'created_at' => '2019-05-09 14:11:19',
                'updated_at' => '2019-05-09 14:11:19',
            ),
            29 => 
            array (
                'id' => 31,
                'user_id' => 28,
                'parent_id' => NULL,
                'post_id' => 47,
                'comment_body' => 'Hhdhdhhdj jshehe
hhd',
                'created_at' => '2019-05-10 07:33:38',
                'updated_at' => '2019-05-10 07:33:38',
            ),
            30 => 
            array (
                'id' => 32,
                'user_id' => 28,
                'parent_id' => NULL,
                'post_id' => 21,
                'comment_body' => 'Hello',
                'created_at' => '2019-05-10 07:48:39',
                'updated_at' => '2019-05-10 07:48:39',
            ),
            31 => 
            array (
                'id' => 33,
                'user_id' => 28,
                'parent_id' => NULL,
                'post_id' => 30,
                'comment_body' => 'Jwjjksuhd',
                'created_at' => '2019-05-10 16:51:08',
                'updated_at' => '2019-05-10 16:51:08',
            ),
        ));
        
        
    }
}