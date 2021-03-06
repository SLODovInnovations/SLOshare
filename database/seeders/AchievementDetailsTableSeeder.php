<?php

namespace Database\Seeders;

use Assada\Achievements\Model\AchievementDetails as AchievementDetail;
use Illuminate\Database\Seeder;

class AchievementDetailsTableSeeder extends Seeder
{
    private $achievementDetails;

    public function __construct()
    {
        $this->achievementDetails = $this->getAchievementDetails();
    }

    /**
     * Auto generated seed file.
     */
    public function run(): void
    {
        foreach ($this->achievementDetails as $ad) {
            AchievementDetail::updateOrCreate($ad);
        }
    }

    private function getAchievementDetails(): array
    {
        return [
            [
                'id'          => 2,
                'name'        => 'PrviKomentar',
                'description' => 'Čestitamo! Podali ste svoj prvi komentar!',
                'points'      => 1,
                'secret'      => 0,
                'class_name'  => \App\Achievements\UserMadeComment::class,
                'created_at'  => '2017-02-28 17:22:37',
                'updated_at'  => '2017-04-21 12:52:01',
            ],
            [
                'id'          => 3,
                'name'        => '10Komentarji',
                'description' => 'Čestitamo! Podali ste že 10 komentarjev!',
                'points'      => 10,
                'secret'      => 0,
                'class_name'  => \App\Achievements\UserMadeTenComments::class,
                'created_at'  => '2017-02-28 17:22:37',
                'updated_at'  => '2017-04-21 12:21:06',
            ],
            [
                'id'          => 4,
                'name'        => 'PrvoNalaganj',
                'description' => 'Čestitamo! Naložili ste svoj prvi torrent!',
                'points'      => 1,
                'secret'      => 0,
                'class_name'  => \App\Achievements\UserMadeUpload::class,
                'created_at'  => '2017-03-01 13:31:50',
                'updated_at'  => '2017-03-22 14:59:32',
            ],
            [
                'id'          => 5,
                'name'        => '25Nalaganj',
                'description' => 'Naložili ste 25 torrentov!',
                'points'      => 25,
                'secret'      => 0,
                'class_name'  => \App\Achievements\UserMade25Uploads::class,
                'created_at'  => '2017-03-02 23:19:34',
                'updated_at'  => '2017-04-21 12:21:06',
            ],
            [
                'id'          => 6,
                'name'        => '50Komentarjev',
                'description' => 'Čestitamo! Podali ste že 50 komentarjev!',
                'points'      => 50,
                'secret'      => 0,
                'class_name'  => \App\Achievements\UserMade50Comments::class,
                'created_at'  => '2017-04-21 13:04:26',
                'updated_at'  => '2017-04-21 13:04:26',
            ],
            [
                'id'          => 7,
                'name'        => '100Komentarjev',
                'description' => 'Čestitamo! Podali ste že 100 komentarjev!',
                'points'      => 100,
                'secret'      => 0,
                'class_name'  => \App\Achievements\UserMade100Comments::class,
                'created_at'  => '2017-04-21 13:04:26',
                'updated_at'  => '2017-04-21 13:04:26',
            ],
            [
                'id'          => 8,
                'name'        => '200Komentarjev',
                'description' => 'Čestitamo! Podali ste že 200 komentarjev!',
                'points'      => 200,
                'secret'      => 0,
                'class_name'  => \App\Achievements\UserMade200Comments::class,
                'created_at'  => '2017-04-21 13:04:26',
                'updated_at'  => '2017-04-21 13:04:26',
            ],
            [
                'id'          => 9,
                'name'        => '300Komentarji',
                'description' => 'Čestitamo! Podali ste že 300 komentarjev!',
                'points'      => 300,
                'secret'      => 0,
                'class_name'  => \App\Achievements\UserMade300Comments::class,
                'created_at'  => '2017-04-21 13:04:26',
                'updated_at'  => '2017-04-21 13:04:26',
            ],
            [
                'id'          => 10,
                'name'        => '400Komentarji',
                'description' => 'Čestitamo! Podali ste že 400 komentarjev!',
                'points'      => 400,
                'secret'      => 0,
                'class_name'  => \App\Achievements\UserMade400Comments::class,
                'created_at'  => '2017-04-21 13:04:26',
                'updated_at'  => '2017-04-21 13:04:26',
            ],
            [
                'id'          => 11,
                'name'        => '500Komentarji',
                'description' => 'Čestitamo! Podali ste že 500 komentarjev!',
                'points'      => 500,
                'secret'      => 0,
                'class_name'  => \App\Achievements\UserMade500Comments::class,
                'created_at'  => '2017-04-21 13:04:26',
                'updated_at'  => '2017-04-21 13:04:26',
            ],
            [
                'id'          => 12,
                'name'        => '600Komentarji',
                'description' => 'Čestitamo! Podali ste že 600 komentarjev!',
                'points'      => 600,
                'secret'      => 0,
                'class_name'  => \App\Achievements\UserMade600Comments::class,
                'created_at'  => '2017-04-21 13:04:26',
                'updated_at'  => '2017-04-21 13:04:26',
            ],
            [
                'id'          => 13,
                'name'        => '700Komentarji',
                'description' => 'Čestitamo! Podali ste že 700 komentarjev!',
                'points'      => 700,
                'secret'      => 0,
                'class_name'  => \App\Achievements\UserMade700Comments::class,
                'created_at'  => '2017-04-21 13:04:26',
                'updated_at'  => '2017-04-21 13:04:26',
            ],
            [
                'id'          => 14,
                'name'        => '800Komentarji',
                'description' => 'Čestitamo! Podali ste že 800 komentarjev!',
                'points'      => 800,
                'secret'      => 0,
                'class_name'  => \App\Achievements\UserMade800Comments::class,
                'created_at'  => '2017-04-21 13:04:26',
                'updated_at'  => '2017-04-21 13:04:26',
            ],
            [
                'id'          => 15,
                'name'        => '900Komentarji',
                'description' => 'Podali ste že 900 komentarjev!',
                'points'      => 900,
                'secret'      => 0,
                'class_name'  => \App\Achievements\UserMade900Comments::class,
                'created_at'  => '2017-04-21 13:04:26',
                'updated_at'  => '2017-04-21 13:04:26',
            ],
            [
                'id'          => 16,
                'name'        => '50Nalaganj',
                'description' => 'Naložili ste 50 torrentov!',
                'points'      => 50,
                'secret'      => 0,
                'class_name'  => \App\Achievements\UserMade50Uploads::class,
                'created_at'  => '2017-04-21 13:29:51',
                'updated_at'  => '2017-04-21 13:29:51',
            ],
            [
                'id'          => 17,
                'name'        => '100Nalaganj',
                'description' => 'Naložili ste 100 torrentov!',
                'points'      => 100,
                'secret'      => 0,
                'class_name'  => \App\Achievements\UserMade100Uploads::class,
                'created_at'  => '2017-04-21 13:29:51',
                'updated_at'  => '2017-04-21 13:29:51',
            ],
            [
                'id'          => 18,
                'name'        => '200Nalaganj',
                'description' => 'Naložili ste 200 torrentov!',
                'points'      => 200,
                'secret'      => 0,
                'class_name'  => \App\Achievements\UserMade200Uploads::class,
                'created_at'  => '2017-04-21 13:29:51',
                'updated_at'  => '2017-04-21 13:29:51',
            ],
            [
                'id'          => 19,
                'name'        => '300Nalaganj',
                'description' => 'Naložili ste 300 torrentov!',
                'points'      => 300,
                'secret'      => 0,
                'class_name'  => \App\Achievements\UserMade300Uploads::class,
                'created_at'  => '2017-04-21 13:29:51',
                'updated_at'  => '2017-04-21 13:29:51',
            ],
            [
                'id'          => 20,
                'name'        => '400Nalaganj',
                'description' => 'Naložili ste 400 torrentov!',
                'points'      => 400,
                'secret'      => 0,
                'class_name'  => \App\Achievements\UserMade400Uploads::class,
                'created_at'  => '2017-04-21 13:29:51',
                'updated_at'  => '2017-04-21 13:29:51',
            ],
            [
                'id'          => 21,
                'name'        => '500Nalaganj',
                'description' => 'Naložili ste 500 torrentov!',
                'points'      => 500,
                'secret'      => 0,
                'class_name'  => \App\Achievements\UserMade500Uploads::class,
                'created_at'  => '2017-04-21 13:29:51',
                'updated_at'  => '2017-04-21 13:29:51',
            ],
            [
                'id'          => 22,
                'name'        => '600Nalaganj',
                'description' => 'Naložili ste 600 torrentov!',
                'points'      => 600,
                'secret'      => 0,
                'class_name'  => \App\Achievements\UserMade600Uploads::class,
                'created_at'  => '2017-04-21 13:29:51',
                'updated_at'  => '2017-04-21 13:29:51',
            ],
            [
                'id'          => 23,
                'name'        => '700Nalaganj',
                'description' => 'You have made 700 torrent uploads!',
                'points'      => 700,
                'secret'      => 0,
                'class_name'  => \App\Achievements\UserMade700Uploads::class,
                'created_at'  => '2017-04-21 13:29:51',
                'updated_at'  => '2017-04-21 13:29:51',
            ],
            [
                'id'          => 24,
                'name'        => '800Nalaganj',
                'description' => 'Naložili ste 800 torrentov!',
                'points'      => 800,
                'secret'      => 0,
                'class_name'  => \App\Achievements\UserMade800Uploads::class,
                'created_at'  => '2017-04-21 13:29:51',
                'updated_at'  => '2017-04-21 13:29:51',
            ],
            [
                'id'          => 25,
                'name'        => '900Nalaganj',
                'description' => 'Naložili ste 900 torrentov!',
                'points'      => 900,
                'secret'      => 0,
                'class_name'  => \App\Achievements\UserMade900Uploads::class,
                'created_at'  => '2017-04-21 13:29:51',
                'updated_at'  => '2017-04-21 13:29:51',
            ],
            [
                'id'          => 26,
                'name'        => 'PrvaObjava',
                'description' => 'Čestitamo! Naredili ste svojo prvo objavo!',
                'points'      => 1,
                'secret'      => 0,
                'class_name'  => \App\Achievements\UserMadeFirstPost::class,
                'created_at'  => '2017-04-21 18:37:09',
                'updated_at'  => '2017-04-21 18:38:48',
            ],
            [
                'id'          => 27,
                'name'        => '25Objave',
                'description' => 'Čestitamo! Naredili ste že 25 objav!',
                'points'      => 25,
                'secret'      => 0,
                'class_name'  => \App\Achievements\UserMade25Posts::class,
                'created_at'  => '2017-04-21 18:37:09',
                'updated_at'  => '2017-04-21 18:37:09',
            ],
            [
                'id'          => 28,
                'name'        => '50Objave',
                'description' => 'Čestitamo! Naredili ste že 50 objav!',
                'points'      => 50,
                'secret'      => 0,
                'class_name'  => \App\Achievements\UserMade50Posts::class,
                'created_at'  => '2017-04-21 18:37:09',
                'updated_at'  => '2017-04-21 18:37:09',
            ],
            [
                'id'          => 29,
                'name'        => '100Objave',
                'description' => 'Čestitamo! Naredili ste že 100 objav!',
                'points'      => 100,
                'secret'      => 0,
                'class_name'  => \App\Achievements\UserMade100Posts::class,
                'created_at'  => '2017-04-21 18:37:09',
                'updated_at'  => '2017-04-21 18:37:09',
            ],
            [
                'id'          => 30,
                'name'        => '200Objave',
                'description' => 'Čestitamo! Naredili ste že 200 objav!',
                'points'      => 200,
                'secret'      => 0,
                'class_name'  => \App\Achievements\UserMade200Posts::class,
                'created_at'  => '2017-04-21 18:37:09',
                'updated_at'  => '2017-04-21 18:37:09',
            ],
            [
                'id'          => 31,
                'name'        => '300Objave',
                'description' => 'Čestitamo! Naredili ste že 300 objav!',
                'points'      => 300,
                'secret'      => 0,
                'class_name'  => \App\Achievements\UserMade300Posts::class,
                'created_at'  => '2017-04-21 18:37:09',
                'updated_at'  => '2017-04-21 18:37:09',
            ],
            [
                'id'          => 32,
                'name'        => '400Objave',
                'description' => 'Čestitamo! Naredili ste že 400 objav!',
                'points'      => 400,
                'secret'      => 0,
                'class_name'  => \App\Achievements\UserMade400Posts::class,
                'created_at'  => '2017-04-21 18:37:09',
                'updated_at'  => '2017-04-21 18:37:09',
            ],
            [
                'id'          => 33,
                'name'        => '500Objave',
                'description' => 'Čestitamo! Naredili ste že 500 objav!',
                'points'      => 500,
                'secret'      => 0,
                'class_name'  => \App\Achievements\UserMade500Posts::class,
                'created_at'  => '2017-04-21 18:37:09',
                'updated_at'  => '2017-04-21 18:37:09',
            ],
            [
                'id'          => 34,
                'name'        => '600Objave',
                'description' => 'Čestitamo! Naredili ste že 600 objav!',
                'points'      => 600,
                'secret'      => 0,
                'class_name'  => \App\Achievements\UserMade600Posts::class,
                'created_at'  => '2017-04-21 18:37:09',
                'updated_at'  => '2017-04-21 18:37:09',
            ],
            [
                'id'          => 35,
                'name'        => '700Objave',
                'description' => 'Čestitamo! Naredili ste že 700 objav!',
                'points'      => 700,
                'secret'      => 0,
                'class_name'  => \App\Achievements\UserMade700Posts::class,
                'created_at'  => '2017-04-21 18:37:09',
                'updated_at'  => '2017-04-21 18:37:09',
            ],
            [
                'id'          => 36,
                'name'        => '800Objave',
                'description' => 'Čestitamo! Naredili ste že 800 objav!',
                'points'      => 800,
                'secret'      => 0,
                'class_name'  => \App\Achievements\UserMade800Posts::class,
                'created_at'  => '2017-04-21 18:37:09',
                'updated_at'  => '2017-04-21 18:37:09',
            ],
            [
                'id'          => 37,
                'name'        => '900Objave',
                'description' => 'Čestitamo! Naredili ste že 900 objav!',
                'points'      => 900,
                'secret'      => 0,
                'class_name'  => \App\Achievements\UserMade900Posts::class,
                'created_at'  => '2017-04-21 18:37:09',
                'updated_at'  => '2017-04-21 18:37:09',
            ],
            [
                'id'          => 38,
                'name'        => 'Izpolnjenih25Zahtev',
                'description' => 'Čestitamo! Izpolnili ste že 25 zahtev!',
                'points'      => 25,
                'secret'      => 0,
                'class_name'  => \App\Achievements\UserFilled25Requests::class,
                'created_at'  => '2017-08-28 23:55:56',
                'updated_at'  => '2017-08-28 23:55:56',
            ],
            [
                'id'          => 39,
                'name'        => 'Izpolnjenih50Zahtev',
                'description' => 'Čestitamo! Izpolnili ste že 50 zahtev!',
                'points'      => 50,
                'secret'      => 0,
                'class_name'  => \App\Achievements\UserFilled50Requests::class,
                'created_at'  => '2017-08-28 23:55:56',
                'updated_at'  => '2017-08-28 23:55:56',
            ],
            [
                'id'          => 40,
                'name'        => 'Izpolnjenih75Zahtev',
                'description' => 'Čestitamo! Izpolnili ste že 75 zahtev!',
                'points'      => 75,
                'secret'      => 0,
                'class_name'  => \App\Achievements\UserFilled75Requests::class,
                'created_at'  => '2017-08-28 23:55:56',
                'updated_at'  => '2017-08-28 23:55:56',
            ],
            [
                'id'          => 41,
                'name'        => 'Izpolnjenih100Zahtev',
                'description' => 'Čestitamo! Izpolnili ste že 100 zahtev!',
                'points'      => 100,
                'secret'      => 0,
                'class_name'  => \App\Achievements\UserFilled100Requests::class,
                'created_at'  => '2017-08-28 23:55:56',
                'updated_at'  => '2017-08-28 23:55:56',
            ],
        ];
    }
}
