<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Bookmark;
use App\Models\FeaturedTorrent;
use App\Models\FreeleechToken;
use App\Models\Group;
use App\Models\PersonalFreeleech;
use App\Models\Poll;
use App\Models\Post;
use App\Models\Topic;
//SLOshare
use App\Models\Category;
use App\Models\History;
use App\Models\Language;
use App\Models\Peer;
use App\Models\TorrentRequest;
//SLOshare
use App\Models\Torrent;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * @see \Tests\Todo\Feature\Http\Controllers\Staff\HomeControllerTest
 */
class HomeController extends Controller
{
    /**
     * Display Home Page.
     *
     * @throws \Exception
     */
    public function index(Request $request): \Illuminate\Contracts\View\Factory|\Illuminate\View\View
    {
        // For Cache
        $current = Carbon::now();
        $expiresAt = $current->addMinutes(1);

        // Authorized User
        $user = $request->user();

        // Latest Articles/News Block
        $articles = \cache()->remember('latest_article', $expiresAt, fn () => Article::latest()->take(5)->get());

        // Latest Torrents Block
        $personalFreeleech = PersonalFreeleech::where('user_id', '=', $user->id)->first();

        $newest = \cache()->remember('newest_torrents', $expiresAt, fn () => Torrent::with(['user', 'category', 'type'])
            ->withCount(['thanks', 'comments'])
            ->latest()
            ->take(5)
            ->get());

        $video = \cache()->remember('video_torrents', $expiresAt, fn () => Torrent::with(['user', 'category', 'type'])
            ->withCount(['thanks', 'comments'])
            ->where('category_id', '=', 1)
            ->latest()
            ->take(9)
            ->get());

        $xxx = \cache()->remember('xxx_torrents', $expiresAt, fn () => Torrent::with(['user', 'category', 'type'])
            ->withCount(['thanks', 'comments'])
            ->where('category_id', '=', 13)
            ->latest()
            ->take(9)
            ->get());

        $tvserie = \cache()->remember('tvserie_torrents', $expiresAt, fn () => Torrent::with(['user', 'category', 'type'])
            ->withCount(['thanks', 'comments'])
            ->where('category_id', '=', 2)
            ->latest()
            ->take(9)
            ->get());

        $game = \cache()->remember('game_torrents', $expiresAt, fn () => Torrent::with(['user', 'category', 'type'])
            ->withCount(['thanks', 'comments'])
            ->where('category_id', '=', 8)
            ->latest()
            ->take(9)
            ->get());

        $applications = \cache()->remember('applications_torrents', $expiresAt, fn () => Torrent::with(['user', 'category', 'type'])
            ->withCount(['thanks', 'comments'])
            ->where('category_id', '=', 9)
            ->latest()
            ->take(9)
            ->get());

        $cartoons = \cache()->remember('cartoons_torrents', $expiresAt, fn () => Torrent::with(['user', 'category', 'type'])
            ->withCount(['thanks', 'comments'])
            ->where('category_id', '=', 3)
            ->latest()
            ->take(9)
            ->get());

        $newsloshare = \cache()->remember('newsloshare_torrents', $expiresAt, fn () => Torrent::with(['user', 'category', 'type'])
            ->withCount(['thanks', 'comments'])
            ->whereIn('category_id', [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12])
            ->latest()
            ->take(9)
            ->get());

        $slorecommended = \cache()->remember('slorecommended_torrents', $expiresAt, fn () => Torrent::with(['user', 'category', 'type'])
            ->withCount(['thanks', 'comments'])
            ->where('sticky', '=', 1)
            ->latest()
            ->take(5)
            ->get());

        $videorecommended = \cache()->remember('videorecommended_torrents', $expiresAt, fn () => Torrent::with(['user', 'category', 'type'])
            ->withCount(['thanks', 'comments'])
            ->where('category_id', '=', 1)
            ->where('sticky', '=', 1)
            ->latest()
            ->take(5)
            ->get());

        $seeded = \cache()->remember('seeded_torrents', $expiresAt, fn () => Torrent::with(['user', 'category', 'type'])
            ->withCount(['thanks', 'comments'])
            ->latest('seeders')
            ->take(9)
            ->get());

        $leeched = \cache()->remember('leeched_torrents', $expiresAt, fn () => Torrent::with(['user', 'category', 'type'])
            ->withCount(['thanks', 'comments'])
            ->latest('leechers')
            ->take(9)
            ->get());

        $dying = \cache()->remember('dying_torrents', $expiresAt, fn () => Torrent::with(['user', 'category', 'type'])
            ->withCount(['thanks', 'comments'])
            ->where('seeders', '=', 1)
            ->where('times_completed', '>=', 1)
            ->latest('leechers')
            ->take(5)
            ->get());

        $dead = \cache()->remember('dead_torrents', $expiresAt, fn () => Torrent::with(['user', 'category', 'type'])
            ->withCount(['thanks', 'comments'])
            ->where('seeders', '=', 0)
            ->latest('leechers')
            ->take(5)
            ->get());

        // Latest Topics Block
        $topics = \cache()->remember('latest_topics', $expiresAt, fn () => Topic::with('forum')->latest()->take(5)->get());

        // Latest Posts Block
        $posts = \cache()->remember('latest_posts', $expiresAt, fn () => Post::with('topic', 'user')->latest()->take(5)->get());

        // Online Block
        $users = \cache()->remember('online_users', $expiresAt, fn () => User::with('group', 'privacy')
            ->withCount([
                'warnings' => function (Builder $query) {
                    $query->whereNotNull('torrent')->where('active', '1');
                },
            ])
            ->where('last_action', '>', \now()->subMinutes(5))
            ->get());

        $groups = \cache()->remember('user-groups', $expiresAt, fn () => Group::select(['name', 'color', 'effect', 'icon'])->oldest('position')->get());

        // Featured Torrents Block
        $featured = \cache()->remember('latest_featured', $expiresAt, fn () => FeaturedTorrent::with('torrent')->get());

        // Latest Poll Block
        $poll = \cache()->remember('latest_poll', $expiresAt, fn () => Poll::latest()->first());

        // Top Uploaders Block
        $uploaders = \cache()->remember('top_uploaders', $expiresAt, fn () => Torrent::with('user')
            ->select(DB::raw('user_id, count(*) as value'))
            ->groupBy('user_id')
            ->latest('value')
            ->take(10)
            ->get());

        $pastUploaders = \cache()->remember('month_uploaders', $expiresAt, fn () => Torrent::with('user')
            ->where('created_at', '>', $current->copy()->subDays(30)->toDateTimeString())
            ->select(DB::raw('user_id, count(*) as value'))
            ->groupBy('user_id')
            ->latest('value')
            ->take(10)
            ->get());

        $freeleechTokens = FreeleechToken::where('user_id', $user->id)->get();
        $bookmarks = Bookmark::where('user_id', $user->id)->get();

//SLOshare
        // Total Members Count (All Groups)
        $allUser = \cache()->remember('all_user', $this->carbon, fn () => User::withTrashed()->count());

        // Total Active Members Count (Not Validating, Banned, Disabled, Pruned)
        $activeUser = \cache()->remember('active_user', $this->carbon, function () {
            $bannedGroup = \cache()->rememberForever('banned_group', fn () => Group::where('slug', '=', 'banned')->pluck('id'));
            $validatingGroup = \cache()->rememberForever('validating_group', fn () => Group::where('slug', '=', 'validating')->pluck('id'));
            $disabledGroup = \cache()->rememberForever('disabled_group', fn () => Group::where('slug', '=', 'disabled')->pluck('id'));
            $prunedGroup = \cache()->rememberForever('pruned_group', fn () => Group::where('slug', '=', 'pruned')->pluck('id'));

            return User::whereIntegerNotInRaw('group_id', [$validatingGroup[0], $bannedGroup[0], $disabledGroup[0], $prunedGroup[0]])->count();
        });

        // Total Disabled Members Count
        $disabledUser = \cache()->remember('disabled_user', $this->carbon, function () {
            $disabledGroup = \cache()->rememberForever('disabled_group', fn () => Group::where('slug', '=', 'disabled')->pluck('id'));

            return User::where('group_id', '=', $disabledGroup[0])->count();
        });

        // Total Pruned Members Count
        $prunedUser = \cache()->remember('pruned_user', $this->carbon, function () {
            $prunedGroup = \cache()->rememberForever('pruned_group', fn () => Group::where('slug', '=', 'pruned')->pluck('id'));

            return User::onlyTrashed()->where('group_id', '=', $prunedGroup[0])->count();
        });

        // Total Banned Members Count
        $bannedUser = \cache()->remember('banned_user', $this->carbon, function () {
            $bannedGroup = \cache()->rememberForever('banned_group', fn () => Group::where('slug', '=', 'banned')->pluck('id'));

            return User::where('group_id', '=', $bannedGroup[0])->count();
        });

        // Total Torrents Count
        $numTorrent = \cache()->remember('num_torrent', $this->carbon, fn () => Torrent::count());

        // Total Categories With Torrent Count
        $categories = Category::withCount('torrents')->get()->sortBy('position');

        // Total HD Count
        $numHd = \cache()->remember('num_hd', $this->carbon, fn () => Torrent::where('sd', '=', 0)->count());

        // Total SD Count
        $numSd = \cache()->remember('num_sd', $this->carbon, fn () => Torrent::where('sd', '=', 1)->count());

        // Total Torrent Size
        $torrentSize = \cache()->remember('torrent_size', $this->carbon, fn () => Torrent::sum('size'));

        // Total Seeders
        $numSeeders = \cache()->remember('num_seeders', $this->carbon, fn () => Peer::where('seeder', '=', 1)->count());

        // Total Leechers
        $numLeechers = \cache()->remember('num_leechers', $this->carbon, fn () => Peer::where('seeder', '=', 0)->count());

        // Total Peers
        $numPeers = \cache()->remember('num_peers', $this->carbon, fn () => Peer::count());

        //Total Upload Traffic Without Double Upload
        $actualUpload = \cache()->remember('actual_upload', $this->carbon, fn () => History::sum('actual_uploaded'));

        //Total Upload Traffic With Double Upload
        $creditedUpload = \cache()->remember('credited_upload', $this->carbon, fn () => History::sum('uploaded'));

        //Total Download Traffic Without Freeleech
        $actualDownload = \cache()->remember('actual_download', $this->carbon, fn () => History::sum('actual_downloaded'));

        //Total Download Traffic With Freeleech
        $creditedDownload = \cache()->remember('credited_download', $this->carbon, fn () => History::sum('downloaded'));

        //Total Up/Down Traffic without perks
        $actualUpDown = $actualUpload + $actualDownload;

        //Total Up/Down Traffic with perks
        $creditedUpDown = $creditedUpload + $creditedDownload;
//SLOshare

        return \view('home.index', [
            'user'               => $user,
            'personal_freeleech' => $personalFreeleech,
            'users'              => $users,
            'groups'             => $groups,
            'articles'           => $articles,
            'newest'             => $newest,
            'video'              => $video,
            'xxx'                => $xxx,
            'tvserie'            => $tvserie,
            'game'               => $game,
            'applications'       => $applications,
            'cartoons'           => $cartoons,
            'newsloshare'        => $newsloshare,
            'slorecommended'     => $slorecommended,
            'videorecommended'   => $videorecommended,
            'seeded'             => $seeded,
            'dying'              => $dying,
            'leeched'            => $leeched,
            'dead'               => $dead,
            'topics'             => $topics,
            'posts'              => $posts,
            'featured'           => $featured,
            'poll'               => $poll,
            'uploaders'          => $uploaders,
            'past_uploaders'     => $pastUploaders,
            'freeleech_tokens'   => $freeleechTokens,
            'bookmarks'          => $bookmarks,
//SLOshare
            'all_user'          => $allUser,
            'active_user'       => $activeUser,
            'disabled_user'     => $disabledUser,
            'pruned_user'       => $prunedUser,
            'banned_user'       => $bannedUser,
            'num_torrent'       => $numTorrent,
            'categories'        => $categories,
            'num_hd'            => $numHd,
            'num_sd'            => $numSd,
            'torrent_size'      => $torrentSize,
            'num_seeders'       => $numSeeders,
            'num_leechers'      => $numLeechers,
            'num_peers'         => $numPeers,
            'actual_upload'     => $actualUpload,
            'actual_download'   => $actualDownload,
            'actual_up_down'    => $actualUpDown,
            'credited_upload'   => $creditedUpload,
            'credited_download' => $creditedDownload,
            'credited_up_down'  => $creditedUpDown,
//SLOshare
        ]);
    }
}
