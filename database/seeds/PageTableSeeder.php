<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PageTableSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('pages')->truncate();

        DB::table('pages')->insert([
            [
                'title' => 'About',
                'slug' => 'about',
                'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc nisi sapien, pulvinar in 
                    libero quis, tempus ultricies risus. Morbi vitae vulputate orci. Vivamus dictum, est ut malesuada 
                    scelerisque, tortor ex faucibus turpis, sit amet vulputate ex tellus et augue. Vivamus dolor velit, 
                    interdum non vestibulum et, convallis ut orci. Suspendisse porta libero at elit dapibus, in porttitor 
                    risus condimentum. Suspendisse at mattis turpis, nec commodo neque. Aenean suscipit, ipsum id mollis 
                    tempor, eros lectus tristique nulla, vel fermentum justo neque eu erat. Integer eu enim dui. Aliquam 
                    erat volutpat. Curabitur non malesuada eros, vitae placerat enim. Proin vitae eros sed quam aliquet 
                    egestas. Cras sit amet arcu elit. Etiam tincidunt, purus in commodo malesuada, mi nisi tristique justo, 
                    a sagittis justo lectus at velit. Nunc iaculis nulla eget tortor auctor, ac dignissim sem congue. 
                    Curabitur vel lobortis ipsum. Sed bibendum rhoncus tortor sed pulvinar. Fusce lorem ex, aliquam non 
                    fermentum vitae, vulputate ultricies ante. Donec mauris ipsum, viverra a gravida in, rhoncus a quam. 
                    Etiam consequat lacus vel libero accumsan, ut volutpat massa semper. Duis faucibus quis sapien dignissim 
                    laoreet. Nulla varius purus nec ligula ornare ultrices. Integer sed leo libero. Sed nec vestibulum orci. 
                    Quisque tristique tortor id finibus suscipit. Curabitur ipsum sem, vehicula sed venenatis sed, sodales 
                    non nisi. Aliquam laoreet venenatis vulputate. Sed magna risus, dictum non purus quis, blandit rhoncus orci. 
                    Vestibulum mattis nisi a diam aliquet luctus. In eu placerat lacus, sed aliquet lacus. Ut mollis, 
                    massa ut tincidunt tempus, purus justo auctor eros, pulvinar dictum lorem sapien ut lorem. Vivamus varius, 
                    ante ac bibendum consequat, eros mauris euismod est, quis fermentum mauris arcu ut tellus. Praesent eget 
                    ex ante. Aliquam erat volutpat. Fusce tincidunt, ipsum eget elementum semper, mauris elit facilisis magna, 
                    in iaculis justo metus eget libero.
                ',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ],
            [
                'title' => 'FAQ',
                'slug' => 'faq',
                'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc nisi sapien, pulvinar in 
                    libero quis, tempus ultricies risus. Morbi vitae vulputate orci. Vivamus dictum, est ut malesuada 
                    scelerisque, tortor ex faucibus turpis, sit amet vulputate ex tellus et augue. Vivamus dolor velit, 
                    interdum non vestibulum et, convallis ut orci. Suspendisse porta libero at elit dapibus, in porttitor 
                    risus condimentum. Suspendisse at mattis turpis, nec commodo neque. Aenean suscipit, ipsum id mollis 
                    tempor, eros lectus tristique nulla, vel fermentum justo neque eu erat. Integer eu enim dui. Aliquam 
                    erat volutpat. Curabitur non malesuada eros, vitae placerat enim. Proin vitae eros sed quam aliquet 
                    egestas. Cras sit amet arcu elit. Etiam tincidunt, purus in commodo malesuada, mi nisi tristique justo, 
                    a sagittis justo lectus at velit. Nunc iaculis nulla eget tortor auctor, ac dignissim sem congue. 
                    Curabitur vel lobortis ipsum. Sed bibendum rhoncus tortor sed pulvinar. Fusce lorem ex, aliquam non 
                    fermentum vitae, vulputate ultricies ante. Donec mauris ipsum, viverra a gravida in, rhoncus a quam. 
                    Etiam consequat lacus vel libero accumsan, ut volutpat massa semper. Duis faucibus quis sapien dignissim 
                    laoreet. Nulla varius purus nec ligula ornare ultrices. Integer sed leo libero. Sed nec vestibulum orci. 
                    Quisque tristique tortor id finibus suscipit. Curabitur ipsum sem, vehicula sed venenatis sed, sodales 
                    non nisi. Aliquam laoreet venenatis vulputate. Sed magna risus, dictum non purus quis, blandit rhoncus orci. 
                    Vestibulum mattis nisi a diam aliquet luctus. In eu placerat lacus, sed aliquet lacus. Ut mollis, 
                    massa ut tincidunt tempus, purus justo auctor eros, pulvinar dictum lorem sapien ut lorem. Vivamus varius, 
                    ante ac bibendum consequat, eros mauris euismod est, quis fermentum mauris arcu ut tellus. Praesent eget 
                    ex ante. Aliquam erat volutpat. Fusce tincidunt, ipsum eget elementum semper, mauris elit facilisis magna, 
                    in iaculis justo metus eget libero.
                ',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ],
            [
                'title' => 'Privacy Policy',
                'slug' => 'privacy-policy',
                'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc nisi sapien, pulvinar in 
                    libero quis, tempus ultricies risus. Morbi vitae vulputate orci. Vivamus dictum, est ut malesuada 
                    scelerisque, tortor ex faucibus turpis, sit amet vulputate ex tellus et augue. Vivamus dolor velit, 
                    interdum non vestibulum et, convallis ut orci. Suspendisse porta libero at elit dapibus, in porttitor 
                    risus condimentum. Suspendisse at mattis turpis, nec commodo neque. Aenean suscipit, ipsum id mollis 
                    tempor, eros lectus tristique nulla, vel fermentum justo neque eu erat. Integer eu enim dui. Aliquam 
                    erat volutpat. Curabitur non malesuada eros, vitae placerat enim. Proin vitae eros sed quam aliquet 
                    egestas. Cras sit amet arcu elit. Etiam tincidunt, purus in commodo malesuada, mi nisi tristique justo, 
                    a sagittis justo lectus at velit. Nunc iaculis nulla eget tortor auctor, ac dignissim sem congue. 
                    Curabitur vel lobortis ipsum. Sed bibendum rhoncus tortor sed pulvinar. Fusce lorem ex, aliquam non 
                    fermentum vitae, vulputate ultricies ante. Donec mauris ipsum, viverra a gravida in, rhoncus a quam. 
                    Etiam consequat lacus vel libero accumsan, ut volutpat massa semper. Duis faucibus quis sapien dignissim 
                    laoreet. Nulla varius purus nec ligula ornare ultrices. Integer sed leo libero. Sed nec vestibulum orci. 
                    Quisque tristique tortor id finibus suscipit. Curabitur ipsum sem, vehicula sed venenatis sed, sodales 
                    non nisi. Aliquam laoreet venenatis vulputate. Sed magna risus, dictum non purus quis, blandit rhoncus orci. 
                    Vestibulum mattis nisi a diam aliquet luctus. In eu placerat lacus, sed aliquet lacus. Ut mollis, 
                    massa ut tincidunt tempus, purus justo auctor eros, pulvinar dictum lorem sapien ut lorem. Vivamus varius, 
                    ante ac bibendum consequat, eros mauris euismod est, quis fermentum mauris arcu ut tellus. Praesent eget 
                    ex ante. Aliquam erat volutpat. Fusce tincidunt, ipsum eget elementum semper, mauris elit facilisis magna, 
                    in iaculis justo metus eget libero.
                ',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ],
            [
                'title' => 'Terms',
                'slug' => 'terms',
                'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc nisi sapien, pulvinar in 
                    libero quis, tempus ultricies risus. Morbi vitae vulputate orci. Vivamus dictum, est ut malesuada 
                    scelerisque, tortor ex faucibus turpis, sit amet vulputate ex tellus et augue. Vivamus dolor velit, 
                    interdum non vestibulum et, convallis ut orci. Suspendisse porta libero at elit dapibus, in porttitor 
                    risus condimentum. Suspendisse at mattis turpis, nec commodo neque. Aenean suscipit, ipsum id mollis 
                    tempor, eros lectus tristique nulla, vel fermentum justo neque eu erat. Integer eu enim dui. Aliquam 
                    erat volutpat. Curabitur non malesuada eros, vitae placerat enim. Proin vitae eros sed quam aliquet 
                    egestas. Cras sit amet arcu elit. Etiam tincidunt, purus in commodo malesuada, mi nisi tristique justo, 
                    a sagittis justo lectus at velit. Nunc iaculis nulla eget tortor auctor, ac dignissim sem congue. 
                    Curabitur vel lobortis ipsum. Sed bibendum rhoncus tortor sed pulvinar. Fusce lorem ex, aliquam non 
                    fermentum vitae, vulputate ultricies ante. Donec mauris ipsum, viverra a gravida in, rhoncus a quam. 
                    Etiam consequat lacus vel libero accumsan, ut volutpat massa semper. Duis faucibus quis sapien dignissim 
                    laoreet. Nulla varius purus nec ligula ornare ultrices. Integer sed leo libero. Sed nec vestibulum orci. 
                    Quisque tristique tortor id finibus suscipit. Curabitur ipsum sem, vehicula sed venenatis sed, sodales 
                    non nisi. Aliquam laoreet venenatis vulputate. Sed magna risus, dictum non purus quis, blandit rhoncus orci. 
                    Vestibulum mattis nisi a diam aliquet luctus. In eu placerat lacus, sed aliquet lacus. Ut mollis, 
                    massa ut tincidunt tempus, purus justo auctor eros, pulvinar dictum lorem sapien ut lorem. Vivamus varius, 
                    ante ac bibendum consequat, eros mauris euismod est, quis fermentum mauris arcu ut tellus. Praesent eget 
                    ex ante. Aliquam erat volutpat. Fusce tincidunt, ipsum eget elementum semper, mauris elit facilisis magna, 
                    in iaculis justo metus eget libero.
                ',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ],
        ]);
    }
}