<?php

use Illuminate\Database\Seeder;

class MediaTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('media')->delete();
        
        \DB::table('media')->insert(array (
            0 => 
            array (
                'id' => 4,
                'is_primary' => 1,
                'post_id' => 23,
                'user_id' => 1,
                'url' => 'https://s3-ap-southeast-2.amazonaws.com/lottery/lottery/1/23/3b9zvtfLY4NPlAAocGVkcANWi7qOyDzW9pl2g1LC.jpeg',
                'created_at' => '2019-02-16 15:28:07',
                'updated_at' => '2019-02-16 15:28:07',
            ),
            1 => 
            array (
                'id' => 5,
                'is_primary' => 0,
                'post_id' => 23,
                'user_id' => 1,
                'url' => 'https://s3-ap-southeast-2.amazonaws.com/lottery/lottery/1/23/d9TUOgIqa9E2KjTJFqsIxh8pWwXYovXVp4spi84I.jpeg',
                'created_at' => '2019-02-16 15:28:08',
                'updated_at' => '2019-02-16 15:28:08',
            ),
            2 => 
            array (
                'id' => 6,
                'is_primary' => 1,
                'post_id' => 24,
                'user_id' => 1,
                'url' => 'https://s3-ap-southeast-2.amazonaws.com/lottery/lottery/1/24/6INb8oGnVT35FMm16mOdPX8LolUeftRT7ne0b5nk.jpeg',
                'created_at' => '2019-02-16 15:29:14',
                'updated_at' => '2019-02-16 15:29:14',
            ),
            3 => 
            array (
                'id' => 7,
                'is_primary' => 1,
                'post_id' => 25,
                'user_id' => 1,
                'url' => 'https://s3-ap-southeast-2.amazonaws.com/lottery/lottery/1/25/qwmfXL0tWYREcB4wJ3GH3IdH3mixLp1MskcAIP7g.jpeg',
                'created_at' => '2019-02-16 15:29:52',
                'updated_at' => '2019-02-16 15:29:52',
            ),
            4 => 
            array (
                'id' => 8,
                'is_primary' => NULL,
                'post_id' => 25,
                'user_id' => 1,
                'url' => 'https://s3-ap-southeast-2.amazonaws.com/lottery/lottery/1/25/Z6xN9uKS7rCRuxbE63nRbs72UZgt1tGRNV36kFg3.jpeg',
                'created_at' => '2019-02-16 15:29:54',
                'updated_at' => '2019-02-16 15:29:54',
            ),
            5 => 
            array (
                'id' => 9,
                'is_primary' => 1,
                'post_id' => 27,
                'user_id' => 14,
                'url' => 'https://s3-ap-southeast-2.amazonaws.com/lottery/lottery/14/27/26oMEoNJAiIRCfujKy6tkNiT01a14s9WIk41nBfw.png',
                'created_at' => '2019-04-22 11:58:00',
                'updated_at' => '2019-04-22 11:58:00',
            ),
            6 => 
            array (
                'id' => 10,
                'is_primary' => NULL,
                'post_id' => 27,
                'user_id' => 14,
                'url' => 'https://s3-ap-southeast-2.amazonaws.com/lottery/lottery/14/27/gzHwb7xR6xP3QMeKPYlEpYL0XfUlwCGsX0Plyjeb.png',
                'created_at' => '2019-04-22 11:58:01',
                'updated_at' => '2019-04-22 11:58:01',
            ),
            7 => 
            array (
                'id' => 11,
                'is_primary' => 1,
                'post_id' => 28,
                'user_id' => 14,
                'url' => 'https://s3-ap-southeast-2.amazonaws.com/lottery/lottery/14/28/rTKgnXDH6rNWfEQxc7Pq5Ug9Phw0m2mMG6OvF0HX.png',
                'created_at' => '2019-05-01 14:09:37',
                'updated_at' => '2019-05-01 14:09:37',
            ),
            8 => 
            array (
                'id' => 12,
                'is_primary' => NULL,
                'post_id' => 28,
                'user_id' => 14,
                'url' => 'https://s3-ap-southeast-2.amazonaws.com/lottery/lottery/14/28/MTR4dkwS4YN1zuzDezUCxL5DyNQ4isk0XuVQipFI.png',
                'created_at' => '2019-05-01 14:09:38',
                'updated_at' => '2019-05-01 14:09:38',
            ),
            9 => 
            array (
                'id' => 13,
                'is_primary' => NULL,
                'post_id' => 28,
                'user_id' => 14,
                'url' => 'https://s3-ap-southeast-2.amazonaws.com/lottery/lottery/14/28/5lo681RMbeLN9wZpNPYukXz4PRAs5q92pFXlwEZP.png',
                'created_at' => '2019-05-01 14:09:39',
                'updated_at' => '2019-05-01 14:09:39',
            ),
            10 => 
            array (
                'id' => 14,
                'is_primary' => 1,
                'post_id' => 31,
                'user_id' => 28,
                'url' => 'https://s3-ap-southeast-2.amazonaws.com/lottery/lottery/28/31/ldoKVEHioOMbqc8IRbfvsUNhFtISv6jCFhnxhFNK.png',
                'created_at' => '2019-05-05 20:30:21',
                'updated_at' => '2019-05-05 20:30:21',
            ),
            11 => 
            array (
                'id' => 15,
                'is_primary' => NULL,
                'post_id' => 31,
                'user_id' => 28,
                'url' => 'https://s3-ap-southeast-2.amazonaws.com/lottery/lottery/28/31/8HObAl9pELajH6q30faOZpC6FpdTqNhr1APjfZVh.png',
                'created_at' => '2019-05-05 20:30:21',
                'updated_at' => '2019-05-05 20:30:21',
            ),
            12 => 
            array (
                'id' => 16,
                'is_primary' => 1,
                'post_id' => 36,
                'user_id' => 28,
                'url' => 'https://s3-ap-southeast-2.amazonaws.com/lottery/lottery/28/36/geO8lJNQcWjPwDNBeRZU6YLu97mEhnTbEx9dgvew.jpeg',
                'created_at' => '2019-05-05 21:35:38',
                'updated_at' => '2019-05-05 21:35:38',
            ),
            13 => 
            array (
                'id' => 17,
                'is_primary' => 1,
                'post_id' => 37,
                'user_id' => 28,
                'url' => 'https://s3-ap-southeast-2.amazonaws.com/lottery/lottery/28/37/JoNHof8lAInCcsQE1JgbybrxXG5gBlNgC1UoyoVS.jpeg',
                'created_at' => '2019-05-05 21:35:42',
                'updated_at' => '2019-05-05 21:35:42',
            ),
            14 => 
            array (
                'id' => 18,
                'is_primary' => 1,
                'post_id' => 40,
                'user_id' => 28,
                'url' => 'https://s3-ap-southeast-2.amazonaws.com/lottery/lottery/28/40/TLKMVA6nHGYXuHTOhPZjWg1UHpBMP9zlC62NPW8y.jpeg',
                'created_at' => '2019-05-05 21:39:07',
                'updated_at' => '2019-05-05 21:39:07',
            ),
            15 => 
            array (
                'id' => 19,
                'is_primary' => 1,
                'post_id' => 41,
                'user_id' => 28,
                'url' => 'https://s3-ap-southeast-2.amazonaws.com/lottery/lottery/28/41/mJ9lxZDQbzNluB4n32hJCy7zBCnyN9GSkp5bVY9t.png',
                'created_at' => '2019-05-05 21:53:08',
                'updated_at' => '2019-05-05 21:53:08',
            ),
            16 => 
            array (
                'id' => 20,
                'is_primary' => NULL,
                'post_id' => 41,
                'user_id' => 28,
                'url' => 'https://s3-ap-southeast-2.amazonaws.com/lottery/lottery/28/41/zbxJfO068waWAP9i4PpwYdo5aCidZ9hFn3WFf0lv.png',
                'created_at' => '2019-05-05 21:53:09',
                'updated_at' => '2019-05-05 21:53:09',
            ),
            17 => 
            array (
                'id' => 21,
                'is_primary' => 1,
                'post_id' => 42,
                'user_id' => 28,
                'url' => 'https://s3-ap-southeast-2.amazonaws.com/lottery/lottery/28/42/p2iaCn5O8sKc3j4FCpEwsfWVzJBRnOU5I1uUcYTE.png',
                'created_at' => '2019-05-05 21:54:52',
                'updated_at' => '2019-05-05 21:54:52',
            ),
            18 => 
            array (
                'id' => 22,
                'is_primary' => NULL,
                'post_id' => 42,
                'user_id' => 28,
                'url' => 'https://s3-ap-southeast-2.amazonaws.com/lottery/lottery/28/42/kLtJxrH105qL6ipGzaS5P6T4w19lGopmonogx1CZ.png',
                'created_at' => '2019-05-05 21:55:14',
                'updated_at' => '2019-05-05 21:55:14',
            ),
            19 => 
            array (
                'id' => 23,
                'is_primary' => 1,
                'post_id' => 44,
                'user_id' => 28,
                'url' => 'https://s3-ap-southeast-2.amazonaws.com/lottery/lottery/28/44/khE9FTeKcEWciR1dfcMZ2qHLLE52ep8ODo01qJGS.png',
                'created_at' => '2019-05-05 21:56:25',
                'updated_at' => '2019-05-05 21:56:25',
            ),
            20 => 
            array (
                'id' => 24,
                'is_primary' => NULL,
                'post_id' => 44,
                'user_id' => 28,
                'url' => 'https://s3-ap-southeast-2.amazonaws.com/lottery/lottery/28/44/AmFHCF03WHFdfAG5xI6MC1Wh3ravI2IgU9NOCeKA.png',
                'created_at' => '2019-05-05 21:56:44',
                'updated_at' => '2019-05-05 21:56:44',
            ),
            21 => 
            array (
                'id' => 25,
                'is_primary' => 1,
                'post_id' => 46,
                'user_id' => 28,
                'url' => 'https://s3-ap-southeast-2.amazonaws.com/lottery/lottery/28/46/RXkldC7bz9yoYi4iV5FStYyFxH1qNQxD6zXTGikB.jpeg',
                'created_at' => '2019-05-05 22:06:39',
                'updated_at' => '2019-05-05 22:06:39',
            ),
            22 => 
            array (
                'id' => 26,
                'is_primary' => NULL,
                'post_id' => 46,
                'user_id' => 28,
                'url' => 'https://s3-ap-southeast-2.amazonaws.com/lottery/lottery/28/46/cXmSmj6AWcWk5P9QPEUoPsY8iYac5ByzwU8Y5KHE.jpeg',
                'created_at' => '2019-05-05 22:06:40',
                'updated_at' => '2019-05-05 22:06:40',
            ),
            23 => 
            array (
                'id' => 27,
                'is_primary' => NULL,
                'post_id' => 46,
                'user_id' => 28,
                'url' => 'https://s3-ap-southeast-2.amazonaws.com/lottery/lottery/28/46/8IDH81AJq3kSybmbe3AGCdNYTgIUbgmDj7mB2q2x.jpeg',
                'created_at' => '2019-05-05 22:06:40',
                'updated_at' => '2019-05-05 22:06:40',
            ),
            24 => 
            array (
                'id' => 28,
                'is_primary' => NULL,
                'post_id' => 46,
                'user_id' => 28,
                'url' => 'https://s3-ap-southeast-2.amazonaws.com/lottery/lottery/28/46/3GUkQi7zyHjVswzblKuriuj4mAx7aFwh5k7I7e2w.jpeg',
                'created_at' => '2019-05-05 22:06:40',
                'updated_at' => '2019-05-05 22:06:40',
            ),
            25 => 
            array (
                'id' => 32,
                'is_primary' => 1,
                'post_id' => 54,
                'user_id' => 28,
                'url' => 'https://s3-ap-southeast-2.amazonaws.com/lottery/lottery/28/54/EY3uTYxq7LoJDEzz7SXsCELUnDExg8mXzwGWcSr9.jpeg',
                'created_at' => '2019-05-05 22:33:48',
                'updated_at' => '2019-05-05 22:33:48',
            ),
            26 => 
            array (
                'id' => 33,
                'is_primary' => NULL,
                'post_id' => 54,
                'user_id' => 28,
                'url' => 'https://s3-ap-southeast-2.amazonaws.com/lottery/lottery/28/54/85AdJgTibl6k1YQhbLSNygmsQWSbdqwRDTXLcC0k.jpeg',
                'created_at' => '2019-05-05 22:33:48',
                'updated_at' => '2019-05-05 22:33:48',
            ),
            27 => 
            array (
                'id' => 34,
                'is_primary' => NULL,
                'post_id' => 54,
                'user_id' => 28,
                'url' => 'https://s3-ap-southeast-2.amazonaws.com/lottery/lottery/28/54/Fw758qpOwX3jFadMBLXUrSzGuEOpxBXLcY6PX8VI.png',
                'created_at' => '2019-05-05 22:33:48',
                'updated_at' => '2019-05-05 22:33:48',
            ),
            28 => 
            array (
                'id' => 35,
                'is_primary' => NULL,
                'post_id' => 54,
                'user_id' => 28,
                'url' => 'https://s3-ap-southeast-2.amazonaws.com/lottery/lottery/28/54/X9xyVFyD4rkMD6QDnn9NWnNNLdRMc40Fa1zp8O78.jpeg',
                'created_at' => '2019-05-05 22:33:48',
                'updated_at' => '2019-05-05 22:33:48',
            ),
            29 => 
            array (
                'id' => 36,
                'is_primary' => 1,
                'post_id' => 55,
                'user_id' => 28,
                'url' => 'https://s3-ap-southeast-2.amazonaws.com/lottery/lottery/28/55/g3fn5lzWKn3TYv39cGlzlC1tYUJK1fndSIT0ye4l.jpeg',
                'created_at' => '2019-05-06 05:10:11',
                'updated_at' => '2019-05-06 05:10:11',
            ),
            30 => 
            array (
                'id' => 37,
                'is_primary' => NULL,
                'post_id' => 55,
                'user_id' => 28,
                'url' => 'https://s3-ap-southeast-2.amazonaws.com/lottery/lottery/28/55/uYqy1lAjeTqVGhLqRzdSKee5iFCpGE6Qf9qGlKwR.jpeg',
                'created_at' => '2019-05-06 05:10:11',
                'updated_at' => '2019-05-06 05:10:11',
            ),
            31 => 
            array (
                'id' => 38,
                'is_primary' => 1,
                'post_id' => 56,
                'user_id' => 28,
                'url' => 'https://s3-ap-southeast-2.amazonaws.com/lottery/lottery/28/56/jlInfl1apTGa9VaZU1PgEgId6yXYrzlMN5LFxiCB.jpeg',
                'created_at' => '2019-05-06 16:24:57',
                'updated_at' => '2019-05-06 16:24:57',
            ),
            32 => 
            array (
                'id' => 39,
                'is_primary' => NULL,
                'post_id' => 56,
                'user_id' => 28,
                'url' => 'https://s3-ap-southeast-2.amazonaws.com/lottery/lottery/28/56/SL8DstQ4hvM02Hr9mbJ1k73CE4RnP6MabLfeMAY2.jpeg',
                'created_at' => '2019-05-06 16:24:58',
                'updated_at' => '2019-05-06 16:24:58',
            ),
            33 => 
            array (
                'id' => 40,
                'is_primary' => NULL,
                'post_id' => 56,
                'user_id' => 28,
                'url' => 'https://s3-ap-southeast-2.amazonaws.com/lottery/lottery/28/56/ZyNZWVI8j8IVw6iY0CtyasZn0KBZgPPMT83MRwm0.jpeg',
                'created_at' => '2019-05-06 16:24:59',
                'updated_at' => '2019-05-06 16:24:59',
            ),
            34 => 
            array (
                'id' => 42,
                'is_primary' => NULL,
                'post_id' => 49,
                'user_id' => 28,
                'url' => 'https://s3-ap-southeast-2.amazonaws.com/lottery/lottery/28/49/sHrtOvNTi8ZMAhoeOo7yULLLXNLwcA7mjkhkEMtR.jpeg',
                'created_at' => '2019-05-07 22:10:12',
                'updated_at' => '2019-05-07 22:10:12',
            ),
            35 => 
            array (
                'id' => 43,
                'is_primary' => 1,
                'post_id' => 49,
                'user_id' => 28,
                'url' => 'https://s3-ap-southeast-2.amazonaws.com/lottery/lottery/28/49/ixeuATiACaY37OVnnpX74RUhynBFm9glPedGbJ5F.jpeg',
                'created_at' => '2019-05-07 22:11:09',
                'updated_at' => '2019-05-07 22:11:09',
            ),
            36 => 
            array (
                'id' => 44,
                'is_primary' => NULL,
                'post_id' => 49,
                'user_id' => 28,
                'url' => 'https://s3-ap-southeast-2.amazonaws.com/lottery/lottery/28/49/bnvZT24Rsq6POeTDbidIyQuHArHphzEWZ5lsuAE2.png',
                'created_at' => '2019-05-07 22:11:09',
                'updated_at' => '2019-05-07 22:11:09',
            ),
            37 => 
            array (
                'id' => 45,
                'is_primary' => NULL,
                'post_id' => 49,
                'user_id' => 28,
                'url' => 'https://s3-ap-southeast-2.amazonaws.com/lottery/lottery/28/49/OTLwMT4g6Aor3d1b7jGo7L47f9jJwzJ4JI5jrqD4.jpeg',
                'created_at' => '2019-05-07 22:11:10',
                'updated_at' => '2019-05-07 22:11:10',
            ),
            38 => 
            array (
                'id' => 47,
                'is_primary' => NULL,
                'post_id' => 45,
                'user_id' => 28,
                'url' => 'https://s3-ap-southeast-2.amazonaws.com/lottery/lottery/28/45/delJdkKdMTOCJA2ug7HIjCe3qrTqfjssnoDBedZl.jpeg',
                'created_at' => '2019-05-07 22:27:37',
                'updated_at' => '2019-05-07 22:27:37',
            ),
            39 => 
            array (
                'id' => 48,
                'is_primary' => 1,
                'post_id' => 45,
                'user_id' => 28,
                'url' => 'https://s3-ap-southeast-2.amazonaws.com/lottery/lottery/28/45/UgaQwMxEsJfROhj8NvhZ6YBUv5Avo1DnE1NguB7a.jpeg',
                'created_at' => '2019-05-07 22:28:06',
                'updated_at' => '2019-05-07 22:28:06',
            ),
            40 => 
            array (
                'id' => 49,
                'is_primary' => NULL,
                'post_id' => 45,
                'user_id' => 28,
                'url' => 'https://s3-ap-southeast-2.amazonaws.com/lottery/lottery/28/45/YRu7yRta2W8IWIIDLQNsdoxj0yKaZzlozJa0MHJa.jpeg',
                'created_at' => '2019-05-07 22:28:07',
                'updated_at' => '2019-05-07 22:28:07',
            ),
            41 => 
            array (
                'id' => 50,
                'is_primary' => 1,
                'post_id' => 46,
                'user_id' => 28,
                'url' => 'https://s3-ap-southeast-2.amazonaws.com/lottery/lottery/28/46/uvWRW25Y74lhp0cBtHWBXpGFz2SH2gZ0SxnTm9OF.jpeg',
                'created_at' => '2019-05-07 22:29:23',
                'updated_at' => '2019-05-07 22:29:23',
            ),
            42 => 
            array (
                'id' => 51,
                'is_primary' => 1,
                'post_id' => 45,
                'user_id' => 28,
                'url' => 'https://s3-ap-southeast-2.amazonaws.com/lottery/lottery/28/45/usxA9155nFbA0BbH8p3iTSUVqBmQ5qlVuqC1RwmG.jpeg',
                'created_at' => '2019-05-07 22:31:51',
                'updated_at' => '2019-05-07 22:31:51',
            ),
            43 => 
            array (
                'id' => 52,
                'is_primary' => 1,
                'post_id' => 46,
                'user_id' => 28,
                'url' => 'https://s3-ap-southeast-2.amazonaws.com/lottery/lottery/28/46/MLNqeQ5JiailjzeeajBIsyIgMr4VEWO9bY1vUqkt.jpeg',
                'created_at' => '2019-05-09 12:37:04',
                'updated_at' => '2019-05-09 12:37:04',
            ),
            44 => 
            array (
                'id' => 53,
                'is_primary' => 1,
                'post_id' => 46,
                'user_id' => 28,
                'url' => 'https://s3-ap-southeast-2.amazonaws.com/lottery/lottery/28/46/4Sqn9u5TMcAC3WAx2fnbrYBNcZt9fjjzCWWiJgn0.jpeg',
                'created_at' => '2019-05-09 12:37:09',
                'updated_at' => '2019-05-09 12:37:09',
            ),
            45 => 
            array (
                'id' => 54,
                'is_primary' => NULL,
                'post_id' => 46,
                'user_id' => 28,
                'url' => 'https://s3-ap-southeast-2.amazonaws.com/lottery/lottery/28/46/cO68nXzvqDcxcUCupODlSZOmdU15GYMPZaW8fs54.jpeg',
                'created_at' => '2019-05-09 12:37:10',
                'updated_at' => '2019-05-09 12:37:10',
            ),
            46 => 
            array (
                'id' => 55,
                'is_primary' => NULL,
                'post_id' => 46,
                'user_id' => 28,
                'url' => 'https://s3-ap-southeast-2.amazonaws.com/lottery/lottery/28/46/ySbpYfZrXB3xwuE8ZTIdhXycybCn4T1togAjQiGZ.jpeg',
                'created_at' => '2019-05-09 12:37:13',
                'updated_at' => '2019-05-09 12:37:13',
            ),
            47 => 
            array (
                'id' => 56,
                'is_primary' => NULL,
                'post_id' => 46,
                'user_id' => 28,
                'url' => 'https://s3-ap-southeast-2.amazonaws.com/lottery/lottery/28/46/LX59CRwWysoA38HeKxF8fVFzPVGy8cz8FDhir1zZ.jpeg',
                'created_at' => '2019-05-09 12:37:13',
                'updated_at' => '2019-05-09 12:37:13',
            ),
            48 => 
            array (
                'id' => 57,
                'is_primary' => 1,
                'post_id' => 47,
                'user_id' => 28,
                'url' => 'https://s3-ap-southeast-2.amazonaws.com/lottery/lottery/28/47/S8aEhE0S7jdT61bOkIe1uT82RtmtXN9nkm39N2az.png',
                'created_at' => '2019-05-10 05:05:00',
                'updated_at' => '2019-05-10 05:05:00',
            ),
            49 => 
            array (
                'id' => 58,
                'is_primary' => 1,
                'post_id' => 48,
                'user_id' => 28,
                'url' => 'https://s3-ap-southeast-2.amazonaws.com/lottery/lottery/28/48/hsefWU02s115jDNh3c15fbzHFV0R7WciyFm3BiSP.jpeg',
                'created_at' => '2019-05-10 07:52:00',
                'updated_at' => '2019-05-10 07:52:00',
            ),
            50 => 
            array (
                'id' => 59,
                'is_primary' => NULL,
                'post_id' => 48,
                'user_id' => 28,
                'url' => 'https://s3-ap-southeast-2.amazonaws.com/lottery/lottery/28/48/YDWB1vqmMtkTFLjAFBEQUartvmwx6qmDLigfUrFJ.jpeg',
                'created_at' => '2019-05-10 07:52:00',
                'updated_at' => '2019-05-10 07:52:00',
            ),
            51 => 
            array (
                'id' => 60,
                'is_primary' => NULL,
                'post_id' => 48,
                'user_id' => 28,
                'url' => 'https://s3-ap-southeast-2.amazonaws.com/lottery/lottery/28/48/xLhSPcoY979wWQSk3a4uBQfmjLW2LfUHnjur82hi.jpeg',
                'created_at' => '2019-05-10 07:52:00',
                'updated_at' => '2019-05-10 07:52:00',
            ),
            52 => 
            array (
                'id' => 61,
                'is_primary' => 1,
                'post_id' => 49,
                'user_id' => 28,
                'url' => 'https://s3-ap-southeast-2.amazonaws.com/lottery/lottery/28/49/Q2612HHnxRLA2xP9sEQ5pclrbjaH7EdqB2EdtAC4.jpeg',
                'created_at' => '2019-05-10 16:48:07',
                'updated_at' => '2019-05-10 16:48:07',
            ),
            53 => 
            array (
                'id' => 62,
                'is_primary' => NULL,
                'post_id' => 49,
                'user_id' => 28,
                'url' => 'https://s3-ap-southeast-2.amazonaws.com/lottery/lottery/28/49/lI3ynDTtlixhaKbEvnQDraCijwPgYczcOgL0AI1H.jpeg',
                'created_at' => '2019-05-10 16:48:07',
                'updated_at' => '2019-05-10 16:48:07',
            ),
            54 => 
            array (
                'id' => 63,
                'is_primary' => NULL,
                'post_id' => 49,
                'user_id' => 28,
                'url' => 'https://s3-ap-southeast-2.amazonaws.com/lottery/lottery/28/49/besg1tsX87v1855yVOm7ejcJTP5lJHIogmfC0AM9.jpeg',
                'created_at' => '2019-05-10 16:48:07',
                'updated_at' => '2019-05-10 16:48:07',
            ),
            55 => 
            array (
                'id' => 64,
                'is_primary' => 1,
                'post_id' => 50,
                'user_id' => 28,
                'url' => 'https://s3-ap-southeast-2.amazonaws.com/lottery/lottery/28/50/beBtH8mNY5TSzoL87jBQb74VItU1aY3kTMyIuiIZ.jpeg',
                'created_at' => '2019-05-10 22:38:43',
                'updated_at' => '2019-05-10 22:38:43',
            ),
            56 => 
            array (
                'id' => 65,
                'is_primary' => NULL,
                'post_id' => 50,
                'user_id' => 28,
                'url' => 'https://s3-ap-southeast-2.amazonaws.com/lottery/lottery/28/50/LlBoDKifGES2fX7IQ1uiihGjMk8A3NqMdmtVbmd2.jpeg',
                'created_at' => '2019-05-10 22:38:43',
                'updated_at' => '2019-05-10 22:38:43',
            ),
        ));
        
        
    }
}