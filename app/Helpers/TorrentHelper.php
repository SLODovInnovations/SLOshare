<?php

namespace App\Helpers;

//use App\Achievements\UserMade100Uploads;
//use App\Achievements\UserMade200Uploads;
//use App\Achievements\UserMade25Uploads;
//use App\Achievements\UserMade300Uploads;
//use App\Achievements\UserMade400Uploads;
//use App\Achievements\UserMade500Uploads;
//use App\Achievements\UserMade50Uploads;
//use App\Achievements\UserMade600Uploads;
//use App\Achievements\UserMade700Uploads;
//use App\Achievements\UserMade800Uploads;
//use App\Achievements\UserMade900Uploads;
//use App\Achievements\UserMadeUpload;
use App\Bots\IRCAnnounceBot;
use App\Models\PrivateMessage;
use App\Models\Torrent;
use App\Models\Wish;
use App\Notifications\NewUpload;
use Illuminate\Support\Carbon;

class TorrentHelper
{
    public static function approveHelper($id): void
    {
        $appurl = config('app.url');
        $appname = config('app.name');

        Torrent::approve($id);
        $torrent = Torrent::with('user')->withAnyStatus()->where('id', '=', $id)->first();
        $torrent->created_at = Carbon::now();
        $torrent->bumped_at = Carbon::now();
        $torrent->save();

        $uploader = $torrent->user;

        $wishes = Wish::where('tmdb', '=', $torrent->tmdb)->whereNull('source')->get();
        if ($wishes) {
            foreach ($wishes as $wish) {
                $wish->source = sprintf('%s/torrents/%s', $appurl, $torrent->id);
                $wish->save();

                // Send Private Message
                $pm = new PrivateMessage();
                $pm->sender_id = 1;
                $pm->receiver_id = $wish->user_id;
                $pm->subject = 'Obvestilo o seznamu želja!';
                $pm->message = sprintf('Naslednji element, %s, seznama želja je bil naložen na %s! Lahko si ga ogledate [url=%s/torrents/', $wish->title, $appname, $appurl).$torrent->id.'] TUKAJ [/url]
                                [color=red][b]TO JE AVTOMATIZOVANO SISTEMSKO SPOROČILO, PROSIMO, NE ODGOVARAJTE![/b][/color]';
                $pm->save();
            }
        }

        if ($torrent->anon == 0) {
            foreach ($uploader->followers()->get() as $follower) {
                if ($follower->acceptsNotification($uploader, $follower, 'following', 'show_following_upload')) {
                    $follower->notify(new NewUpload('follower', $torrent));
                }
            }
        }

        $user = $torrent->user;
        $username = $user->username;
        $anon = $torrent->anon;

//        if ($anon == 0) {
        // Achievements
//            $user->unlock(new UserMadeUpload(), 1);
//            $user->addProgress(new UserMade25Uploads(), 1);
//            $user->addProgress(new UserMade50Uploads(), 1);
//            $user->addProgress(new UserMade100Uploads(), 1);
//            $user->addProgress(new UserMade200Uploads(), 1);
//            $user->addProgress(new UserMade300Uploads(), 1);
//            $user->addProgress(new UserMade400Uploads(), 1);
//            $user->addProgress(new UserMade500Uploads(), 1);
//            $user->addProgress(new UserMade600Uploads(), 1);
//            $user->addProgress(new UserMade700Uploads(), 1);
//            $user->addProgress(new UserMade800Uploads(), 1);
//            $user->addProgress(new UserMade900Uploads(), 1);
//        }

        // Announce To IRC
        if (config('irc-bot.enabled')) {
            $appname = config('app.name');
            $ircAnnounceBot = new IRCAnnounceBot();
            if ($anon == 0) {
                $ircAnnounceBot->message(config('irc-bot.channel'), '['.$appname.'] Uporabnik '.$username.' je naložilo '.$torrent->name.' zgrabi ga zdaj!');
                $ircAnnounceBot->message(config('irc-bot.channel'), '[Kategorija: '.$torrent->category->name.'] [Vrsta: '.$torrent->type->name.'] [Velikost:'.$torrent->getSize().']');
            } else {
                $ircAnnounceBot->message(config('irc-bot.channel'), '['.$appname.'] Anonimni uporabnik je naložil '.$torrent->name.' prenesite ga zdaj!');
                $ircAnnounceBot->message(config('irc-bot.channel'), '[Kategorija: '.$torrent->category->name.'] [Vrsta: '.$torrent->type->name.'] [Velikost: '.$torrent->getSize().']');
            }
            $ircAnnounceBot->message(config('irc-bot.channel'), sprintf('[Povezava: %s/torrents/', $appurl).$id.']');
        }
    }
}
