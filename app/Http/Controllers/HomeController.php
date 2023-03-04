<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Bookmark;
use App\Models\FeaturedTorrent;
use App\Models\FreeleechToken;
use App\Models\Group;
use App\Models\Movie;
use App\Models\Cartoon;
use App\Models\Poll;
use App\Models\Post;
use App\Models\Topic;
use App\Models\Torrent;
use App\Models\Tv;
use App\Models\CartoonTv;
use App\Models\User;
//SLOshare
use App\Models\Peer;
use App\Models\History;
use App\Models\HomeVideo;
//SLOshare
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Exception;

/**
 * @see \Tests\Todo\Feature\Http\Controllers\Staff\HomeControllerTest
 */
class HomeController extends Controller
{
    /**
     * Display Home Page.
     *
     * @throws Exception
     */
    public function index(Request $request): \Illuminate\Contracts\View\Factory|\Illuminate\View\View
    {
        // For Cache
        $current = Carbon::now();
        $expiresAt = $current->addMinutes(1);

        // Authorized User
        $user = $request->user();

        // Latest Articles/News Block
        $articles = cache()->remember('latest_article', $expiresAt, fn () => Article::latest()->take(5)->get());
        foreach ($articles as $article) {
            $article->newNews = ($user->last_login->subDays(3)->getTimestamp() < $article->created_at->getTimestamp()) ? 1 : 0;
        }

        // Latest Torrents Block
        $personalFreeleech = cache()->get('personal_freeleech:'.$user->id);

        $newest = cache()->remember('newest_torrents', $expiresAt, function () {
            $newest = Torrent::with(['user', 'category', 'type', 'resolution'])
                ->withExists([
                    'bookmarks'       => fn ($query) => $query->where('user_id', '=', auth()->id()),
                    'freeleechTokens' => fn ($query) => $query->where('user_id', '=', auth()->id()),
                ])
                ->selectRaw("
                    CASE
                        WHEN category_id IN (SELECT `id` from `categories` where `movie_meta` = 1) THEN 'movie'
                        WHEN category_id IN (SELECT `id` from `categories` where `cartoon_meta` = 1) THEN 'cartoon'
                        WHEN category_id IN (SELECT `id` from `categories` where `tv_meta` = 1) THEN 'tv'
                        WHEN category_id IN (SELECT `id` from `categories` where `cartoontv_meta` = 1) THEN 'cartoontv'
                        WHEN category_id IN (SELECT `id` from `categories` where `game_meta` = 1) THEN 'game'
                        WHEN category_id IN (SELECT `id` from `categories` where `music_meta` = 1) THEN 'music'
                        WHEN category_id IN (SELECT `id` from `categories` where `no_meta` = 1) THEN 'no'
                    END as meta
                ")
                ->withCount(['thanks', 'comments'])
                ->latest()
                ->take(5)
                ->get();

            $movieIds = $newest->where('meta', '=', 'movie')->pluck('tmdb');
            $cartoonIds = $newest->where('meta', '=', 'cartoon')->pluck('tmdb');
            $tvIds = $newest->where('meta', '=', 'tv')->pluck('tmdb');
            $cartoontvIds = $newest->where('meta', '=', 'cartoontv')->pluck('tmdb');
            $gameIds = $newest->where('meta', '=', 'game')->pluck('igdb');

            $movies = Movie::with('genres')->whereIntegerInRaw('id', $movieIds)->get()->keyBy('id');
            $cartoons = Cartoon::with('genres')->whereIntegerInRaw('id', $cartoonIds)->get()->keyBy('id');
            $tv = Tv::with('genres')->whereIntegerInRaw('id', $tvIds)->get()->keyBy('id');
            $cartoontv = CartoonTv::with('genres')->whereIntegerInRaw('id', $cartoontvIds)->get()->keyBy('id');
            if ($gameIds->isNotEmpty()) {
                $games = \MarcReichel\IGDBLaravel\Models\Game::with(['cover' => ['url', 'image_id']])->whereIntegerInRaw('id', $gameIds);
            }

            $newest = $newest->map(function ($torrent) use ($movies, $cartoons, $tv, $cartoontv) {
                $torrent->meta = match ($torrent->meta) {
                    'movie'     => $movies[$torrent->tmdb] ?? null,
                    'cartoon'   => $cartoons[$torrent->tmdb] ?? null,
                    'tv'        => $tv[$torrent->tmdb] ?? null,
                    'cartoontv' => $cartoontv[$torrent->tmdb] ?? null,
                    'game'      => $games[$torrent->igdb] ?? null,
                    default     => null,
                };

                return $torrent;
            });

            return $newest;
        });

        $video = cache()->remember('video_torrents', $expiresAt, function () {
            $video = Torrent::with(['user', 'category', 'type', 'resolution'])
                ->withExists([
                    'bookmarks'       => fn ($query) => $query->where('user_id', '=', auth()->id()),
                    'freeleechTokens' => fn ($query) => $query->where('user_id', '=', auth()->id()),
                ])
                ->selectRaw("
                    CASE
                        WHEN category_id IN (SELECT `id` from `categories` where `movie_meta` = 1) THEN 'movie'
                    END as meta
                ")
                ->withCount(['thanks', 'comments'])
                ->where('category_id', '=', 1)
                ->latest()
                ->take(20)
                ->get();

            $movieIds = $video->where('meta', '=', 'movie')->pluck('tmdb');

            $movies = Movie::with('genres')->whereIntegerInRaw('id', $movieIds)->get()->keyBy('id');

            $video = $video->map(function ($torrent) use ($movies) {
                $torrent->meta = match ($torrent->meta) {
                    'movie' => $movies[$torrent->tmdb] ?? null,
                    default => null,
                };

                return $torrent;
            });

            return $video;
        });

        $xxx = cache()->remember('xxx_torrents', $expiresAt, function () {
            $xxx = Torrent::with(['user', 'category', 'type', 'resolution'])
                ->withExists([
                    'bookmarks'       => fn ($query) => $query->where('user_id', '=', auth()->id()),
                    'freeleechTokens' => fn ($query) => $query->where('user_id', '=', auth()->id()),
                ])
                ->selectRaw("
                    CASE
                        WHEN category_id IN (SELECT `id` from `categories` where `no_meta` = 1) THEN 'no'
                    END as meta
                ")
                ->withCount(['thanks', 'comments'])
                ->where('category_id', '=', 14)
                ->latest()
                ->take(20)
                ->get();

            return $video;
        });

        $tvserie = cache()->remember('tvserie_torrents', $expiresAt, fn () => Torrent::with(['user', 'category', 'type', 'resolution'])
            ->withCount(['thanks', 'comments'])
            ->where('category_id', '=', 2)
            ->latest()
            ->take(20)
            ->get());

        $game = cache()->remember('game_torrents', $expiresAt, fn () => Torrent::with(['user', 'category', 'type'])
            ->withCount(['thanks', 'comments'])
            ->where('category_id', '=', 9)
            ->latest()
            ->take(20)
            ->get());

        $applications = cache()->remember('applications_torrents', $expiresAt, fn () => Torrent::with(['user', 'category', 'type'])
            ->withCount(['thanks', 'comments'])
            ->where('category_id', '=', 10)
            ->latest()
            ->take(20)
            ->get());

        $cartoones = cache()->remember('cartoones_torrents', $expiresAt, fn () => Torrent::with(['user', 'category', 'type', 'resolution'])
            ->withCount(['thanks', 'comments'])
            ->whereIn('category_id', [3, 4])
            ->latest()
            ->take(20)
            ->get());

        $newsloshare = cache()->remember('newsloshare_torrents', $expiresAt, fn () => Torrent::with(['user', 'category', 'type', 'resolution'])
            ->withCount(['thanks', 'comments'])
            ->whereIn('category_id', [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12,14])
            ->latest()
            ->take(20)
            ->get());

        $slorecommended = cache()->remember('slorecommended_torrents', $expiresAt, fn () => Torrent::with(['user', 'category', 'type', 'resolution'])
            ->withCount(['thanks', 'comments'])
            ->where('sticky', '=', 1)
            ->latest()
            ->take(5)
            ->get());

        $videorecommended = cache()->remember('videorecommended_torrents', $expiresAt, fn () => Torrent::with(['user', 'category', 'type', 'resolution'])
            ->withCount(['thanks', 'comments'])
            ->where('category_id', '=', 1)
            ->where('sticky', '=', 1)
            ->latest()
            ->take(5)
            ->get());

        $cartoonrecommended = cache()->remember('cartoonrecommended_torrents', $expiresAt, fn () => Torrent::with(['user', 'category', 'type', 'resolution'])
            ->withCount(['thanks', 'comments'])
            ->whereIn('category_id', [3, 4])
            ->where('sticky', '=', 1)
            ->latest()
            ->take(5)
            ->get());

        $flrecommended = cache()->remember('flrecommended_torrents', $expiresAt, fn () => Torrent::with(['user', 'category', 'type', 'resolution'])
            ->withCount(['thanks', 'comments'])
            ->where('free', '=', 1)
            ->latest()
            ->take(5)
            ->get());

        $seeded = cache()->remember('seeded_torrents', $expiresAt, function () {
            $seeded = Torrent::with(['user', 'category', 'type', 'resolution'])
                ->withExists([
                    'bookmarks'       => fn ($query) => $query->where('user_id', '=', auth()->id()),
                    'freeleechTokens' => fn ($query) => $query->where('user_id', '=', auth()->id()),
                ])
                ->selectRaw("
                    CASE
                        WHEN category_id IN (SELECT `id` from `categories` where `movie_meta` = 1) THEN 'movie'
                        WHEN category_id IN (SELECT `id` from `categories` where `cartoon_meta` = 1) THEN 'cartoon'
                        WHEN category_id IN (SELECT `id` from `categories` where `tv_meta` = 1) THEN 'tv'
                        WHEN category_id IN (SELECT `id` from `categories` where `cartoontv_meta` = 1) THEN 'cartoontv'
                        WHEN category_id IN (SELECT `id` from `categories` where `game_meta` = 1) THEN 'game'
                        WHEN category_id IN (SELECT `id` from `categories` where `music_meta` = 1) THEN 'music'
                        WHEN category_id IN (SELECT `id` from `categories` where `no_meta` = 1) THEN 'no'
                    END as meta
                ")
                ->withCount(['thanks', 'comments'])
                ->latest('seeders')
                ->take(20)
                ->get();

            $movieIds = $seeded->where('meta', '=', 'movie')->pluck('tmdb');
            $cartoonIds = $seeded->where('meta', '=', 'cartoon')->pluck('tmdb');
            $tvIds = $seeded->where('meta', '=', 'tv')->pluck('tmdb');
            $cartoontvIds = $seeded->where('meta', '=', 'cartoontv')->pluck('tmdb');
            $gameIds = $seeded->where('meta', '=', 'game')->pluck('igdb');

            $movies = Movie::with('genres')->whereIntegerInRaw('id', $movieIds)->get()->keyBy('id');
            $cartoons = Cartoon::with('genres')->whereIntegerInRaw('id', $cartoonIds)->get()->keyBy('id');
            $tv = Tv::with('genres')->whereIntegerInRaw('id', $tvIds)->get()->keyBy('id');
            $cartoontv = CartoonTv::with('genres')->whereIntegerInRaw('id', $cartoontvIds)->get()->keyBy('id');
            if ($gameIds->isNotEmpty()) {
                $games = \MarcReichel\IGDBLaravel\Models\Game::with(['cover' => ['url', 'image_id']])->whereIntegerInRaw('id', $gameIds);
            }

            $seeded = $seeded->map(function ($torrent) use ($movies, $cartoons, $tv, $cartoontv) {
                $torrent->meta = match ($torrent->meta) {
                    'movie'     => $movies[$torrent->tmdb] ?? null,
                    'cartoon'   => $cartoons[$torrent->tmdb] ?? null,
                    'tv'        => $tv[$torrent->tmdb] ?? null,
                    'cartoontv' => $cartoontv[$torrent->tmdb] ?? null,
                    'game'      => $games[$torrent->igdb] ?? null,
                    default     => null,
                };

                return $torrent;
            });

            return $seeded;
        });

        $leeched = cache()->remember('leeched_torrents', $expiresAt, function () {
            $leeched = Torrent::with(['user', 'category', 'type', 'resolution'])
                ->withExists([
                    'bookmarks'       => fn ($query) => $query->where('user_id', '=', auth()->id()),
                    'freeleechTokens' => fn ($query) => $query->where('user_id', '=', auth()->id()),
                ])
                ->selectRaw("
                    CASE
                        WHEN category_id IN (SELECT `id` from `categories` where `movie_meta` = 1) THEN 'movie'
                        WHEN category_id IN (SELECT `id` from `categories` where `cartoon_meta` = 1) THEN 'cartoon'
                        WHEN category_id IN (SELECT `id` from `categories` where `tv_meta` = 1) THEN 'tv'
                        WHEN category_id IN (SELECT `id` from `categories` where `cartoontv_meta` = 1) THEN 'cartoontv'
                        WHEN category_id IN (SELECT `id` from `categories` where `game_meta` = 1) THEN 'game'
                        WHEN category_id IN (SELECT `id` from `categories` where `music_meta` = 1) THEN 'music'
                        WHEN category_id IN (SELECT `id` from `categories` where `no_meta` = 1) THEN 'no'
                    END as meta
                ")
                ->withCount(['thanks', 'comments'])
                ->latest('leechers')
                ->take(20)
                ->get();

            $movieIds = $leeched->where('meta', '=', 'movie')->pluck('tmdb');
            $cartoonIds = $leeched->where('meta', '=', 'cartoon')->pluck('tmdb');
            $tvIds = $leeched->where('meta', '=', 'tv')->pluck('tmdb');
            $cartoontvIds = $leeched->where('meta', '=', 'cartoontv')->pluck('tmdb');
            $gameIds = $leeched->where('meta', '=', 'game')->pluck('igdb');

            $movies = Movie::with('genres')->whereIntegerInRaw('id', $movieIds)->get()->keyBy('id');
            $cartoons = Cartoon::with('genres')->whereIntegerInRaw('id', $cartoonIds)->get()->keyBy('id');
            $tv = Tv::with('genres')->whereIntegerInRaw('id', $tvIds)->get()->keyBy('id');
            $cartoontv = CartoonTv::with('genres')->whereIntegerInRaw('id', $cartoontvIds)->get()->keyBy('id');
            if ($gameIds->isNotEmpty()) {
                $games = \MarcReichel\IGDBLaravel\Models\Game::with(['cover' => ['url', 'image_id']])->whereIntegerInRaw('id', $gameIds);
            }

            $leeched = $leeched->map(function ($torrent) use ($movies, $cartoons, $tv, $cartoontv) {
                $torrent->meta = match ($torrent->meta) {
                    'movie'     => $movies[$torrent->tmdb] ?? null,
                    'cartoon'   => $cartoons[$torrent->tmdb] ?? null,
                    'tv'        => $tv[$torrent->tmdb] ?? null,
                    'cartoontv' => $cartoontv[$torrent->tmdb] ?? null,
                    'game'      => $games[$torrent->igdb] ?? null,
                    default     => null,
                };

                return $torrent;
            });

            return $leeched;
        });

        $dying = cache()->remember('dying_torrents', $expiresAt, function () {
            $dying = Torrent::with(['user', 'category', 'type', 'resolution'])
                ->withExists([
                    'bookmarks'       => fn ($query) => $query->where('user_id', '=', auth()->id()),
                    'freeleechTokens' => fn ($query) => $query->where('user_id', '=', auth()->id()),
                ])
                ->selectRaw("
                    CASE
                        WHEN category_id IN (SELECT `id` from `categories` where `movie_meta` = 1) THEN 'movie'
                        WHEN category_id IN (SELECT `id` from `categories` where `cartoon_meta` = 1) THEN 'cartoon'
                        WHEN category_id IN (SELECT `id` from `categories` where `tv_meta` = 1) THEN 'tv'
                        WHEN category_id IN (SELECT `id` from `categories` where `cartoontv_meta` = 1) THEN 'cartoontv'
                        WHEN category_id IN (SELECT `id` from `categories` where `game_meta` = 1) THEN 'game'
                        WHEN category_id IN (SELECT `id` from `categories` where `music_meta` = 1) THEN 'music'
                        WHEN category_id IN (SELECT `id` from `categories` where `no_meta` = 1) THEN 'no'
                    END as meta
                ")
                ->withCount(['thanks', 'comments'])
                ->where('seeders', '=', 1)
                ->where('times_completed', '>=', 1)
                ->latest('leechers')
                ->take(5)
                ->get();

            $movieIds = $dying->where('meta', '=', 'movie')->pluck('tmdb');
            $cartoonIds = $dying->where('meta', '=', 'cartoon')->pluck('tmdb');
            $tvIds = $dying->where('meta', '=', 'tv')->pluck('tmdb');
            $cartoontvIds = $dying->where('meta', '=', 'cartoontv')->pluck('tmdb');
            $gameIds = $dying->where('meta', '=', 'game')->pluck('igdb');

            $movies = Movie::with('genres')->whereIntegerInRaw('id', $movieIds)->get()->keyBy('id');
            $cartoons = Cartoon::with('genres')->whereIntegerInRaw('id', $cartoonIds)->get()->keyBy('id');
            $tv = Tv::with('genres')->whereIntegerInRaw('id', $tvIds)->get()->keyBy('id');
            $cartoontv = CartoonTv::with('genres')->whereIntegerInRaw('id', $cartoontvIds)->get()->keyBy('id');
            if ($gameIds->isNotEmpty()) {
                $games = \MarcReichel\IGDBLaravel\Models\Game::with(['cover' => ['url', 'image_id']])->whereIntegerInRaw('id', $gameIds);
            }

            $dying = $dying->map(function ($torrent) use ($movies, $cartoons, $tv, $cartoontv) {
                $torrent->meta = match ($torrent->meta) {
                    'movie'     => $movies[$torrent->tmdb] ?? null,
                    'cartoon'   => $cartoons[$torrent->tmdb] ?? null,
                    'tv'        => $tv[$torrent->tmdb] ?? null,
                    'cartoontv' => $cartoontv[$torrent->tmdb] ?? null,
                    'game'      => $games[$torrent->igdb] ?? null,
                    default     => null,
                };

                return $torrent;
            });

            return $dying;
        });

        $dead = cache()->remember('dead_torrents', $expiresAt, function () {
            $dead = Torrent::with(['user', 'category', 'type', 'resolution'])
                ->withExists([
                    'bookmarks'       => fn ($query) => $query->where('user_id', '=', auth()->id()),
                    'freeleechTokens' => fn ($query) => $query->where('user_id', '=', auth()->id()),
                ])
                ->selectRaw("
                    CASE
                        WHEN category_id IN (SELECT `id` from `categories` where `movie_meta` = 1) THEN 'movie'
                        WHEN category_id IN (SELECT `id` from `categories` where `cartoon_meta` = 1) THEN 'cartoon'
                        WHEN category_id IN (SELECT `id` from `categories` where `tv_meta` = 1) THEN 'tv'
                        WHEN category_id IN (SELECT `id` from `categories` where `cartoontv_meta` = 1) THEN 'cartoontv'
                        WHEN category_id IN (SELECT `id` from `categories` where `game_meta` = 1) THEN 'game'
                        WHEN category_id IN (SELECT `id` from `categories` where `music_meta` = 1) THEN 'music'
                        WHEN category_id IN (SELECT `id` from `categories` where `no_meta` = 1) THEN 'no'
                    END as meta
                ")
                ->withCount(['thanks', 'comments'])
                ->where('seeders', '=', 0)
                ->latest('leechers')
                ->take(5)
                ->get();

            $movieIds = $dead->where('meta', '=', 'movie')->pluck('tmdb');
            $cartoonIds = $dead->where('meta', '=', 'cartoon')->pluck('tmdb');
            $tvIds = $dead->where('meta', '=', 'tv')->pluck('tmdb');
            $cartoontvIds = $dead->where('meta', '=', 'cartoontv')->pluck('tmdb');
            $gameIds = $dead->where('meta', '=', 'game')->pluck('igdb');

            $movies = Movie::with('genres')->whereIntegerInRaw('id', $movieIds)->get()->keyBy('id');
            $cartoons = Cartoon::with('genres')->whereIntegerInRaw('id', $cartoonIds)->get()->keyBy('id');
            $tv = Tv::with('genres')->whereIntegerInRaw('id', $tvIds)->get()->keyBy('id');
            $cartoontv = CartoonTv::with('genres')->whereIntegerInRaw('id', $cartoontvIds)->get()->keyBy('id');
            if ($gameIds->isNotEmpty()) {
                $games = \MarcReichel\IGDBLaravel\Models\Game::with(['cover' => ['url', 'image_id']])->whereIntegerInRaw('id', $gameIds);
            }

            $dead = $dead->map(function ($torrent) use ($movies, $cartoons, $tv, $cartoontv) {
                $torrent->meta = match ($torrent->meta) {
                    'movie'     => $movies[$torrent->tmdb] ?? null,
                    'cartoon'   => $cartoons[$torrent->tmdb] ?? null,
                    'tv'        => $tv[$torrent->tmdb] ?? null,
                    'cartoontv' => $cartoontv[$torrent->tmdb] ?? null,
                    'game'      => $games[$torrent->igdb] ?? null,
                    default     => null,
                };

                return $torrent;
            });

            return $dead;
        });

        // Latest Topics Block
        $topics = cache()->remember('latest_topics', $expiresAt, fn () => Topic::with('forum')->latest()->take(5)->get());

        // Latest Posts Block
        $posts = cache()->remember('latest_posts', $expiresAt, fn () => Post::with('topic', 'user')->latest()->take(5)->get());

        // Online Block
        $users = cache()->remember('online_users', $expiresAt, fn () => User::with('group', 'privacy')
            ->withCount([
                'warnings' => function (Builder $query): void {
                    $query->whereNotNull('torrent')->where('active', '1');
                },
            ])
            ->where('last_action', '>', now()->subMinutes(5))
            ->get());

        $groups = cache()->remember('user-groups', $expiresAt, fn () => Group::select(['name', 'color', 'effect', 'icon'])->oldest('position')->get());

        // Featured Torrents Block
        $featured = cache()->remember('latest_featured', $expiresAt, fn () => FeaturedTorrent::with('torrent', 'torrent.resolution', 'torrent.type', 'torrent.category', 'user', 'user.group')->get());

        // Latest Poll Block
        $poll = cache()->remember('latest_poll', $expiresAt, fn () => Poll::latest()->first());

        // Top Uploaders Block
        $uploaders = cache()->remember('top_uploaders', $expiresAt, fn () => Torrent::with(['user', 'user.group'])
            ->select(DB::raw('user_id, count(*) as value'))
            ->groupBy('user_id')
            ->latest('value')
            ->take(10)
            ->get());

        $pastUploaders = cache()->remember('month_uploaders', $expiresAt, fn () => Torrent::with(['user', 'user.group'])
            ->where('created_at', '>', $current->copy()->subDays(30)->toDateTimeString())
            ->select(DB::raw('user_id, count(*) as value'))
            ->groupBy('user_id')
            ->latest('value')
            ->take(10)
            ->get());

        //SLOshare
        // Total Members Count (All Groups)
        $allUser = cache()->remember('all_user', $current, fn () => User::withTrashed()->count());
        // Total Torrents Count
        $numTorrent = cache()->remember('num_torrent', $current, fn () => Torrent::count());
        // Total Seeders
        $numSeeders = cache()->remember('num_seeders', $current, fn () => Peer::where('seeder', '=', 1)->count());
        // Total Leechers
        $numLeechers = cache()->remember('num_leechers', $current, fn () => Peer::where('seeder', '=', 0)->count());
        //Total Upload Traffic With Double Upload
        $creditedUpload = cache()->remember('credited_upload', $current, fn () => History::sum('uploaded'));
        //Total Download Traffic With Freeleech
        $creditedDownload = cache()->remember('credited_download', $current, fn () => History::sum('downloaded'));
        //Home Video
        $clients = cache()->remember('link', $expiresAt, fn () => HomeVideo::latest()->take(1)->get());
        //SLOshare

        $freeleechTokens = FreeleechToken::where('user_id', $user->id)->get();
        $bookmarks = Bookmark::where('user_id', $user->id)->get();

        return view('home.index', [
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
            'cartoones'          => $cartoones,
            'newsloshare'        => $newsloshare,
            'slorecommended'     => $slorecommended,
            'videorecommended'   => $videorecommended,
            'cartoonrecommended' => $cartoonrecommended,
            'flrecommended'      => $flrecommended,
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
            'num_torrent'       => $numTorrent,
            'num_seeders'       => $numSeeders,
            'num_leechers'      => $numLeechers,
            'credited_upload'   => $creditedUpload,
            'credited_download' => $creditedDownload,
            'clients'           => $clients,
            //SLOshare
        ]);
    }
}
