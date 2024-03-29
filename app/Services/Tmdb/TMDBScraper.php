<?php

namespace App\Services\Tmdb;

use App\Jobs\ProcessCollectionJob;
use App\Jobs\ProcessCompanyJob;
use App\Jobs\ProcessMovieJob;
use App\Jobs\ProcessCartoonJob;
use App\Jobs\ProcessTvJob;
use App\Jobs\ProcessCartoonTvJob;
use App\Models\Collection;
use App\Models\Company;
use App\Models\Movie;
use App\Models\Cartoon;
use App\Models\Tv;
use App\Models\CartoonTv;
use DateTime;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Http\Request;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Str;

class TMDBScraper implements ShouldQueue
{
    use SerializesModels;
    /**
     * @var mixed|array|string|null
     */
    public $id;

    public function __construct(Request $request = null)
    {
        if ($request != null) {
            $this->id = $request->query('id');
        }
    }

    public function tv($id = null): void
    {
        if ($id == null) {
            $id = $this->id;
        }

        $tmdb = new TMDB();
        $tv = (new Client\TV($id))->getData();
        if (isset($tv['id'])) {
            $array = [
                'backdrop'           => $tmdb->image('backdrop', $tv),
                'episode_run_time'   => $tmdb->ifHasItems('episode_run_time', $tv),
                'first_air_date'     => $tmdb->ifExists('first_air_date', $tv),
                'homepage'           => $tv['homepage'],
                'imdb_id'            => substr($tv['external_ids']['imdb_id'] ?? '', 2),
                'in_production'      => $tv['in_production'],
                'last_air_date'      => $tmdb->ifExists('last_air_date', $tv),
                'name'               => Str::limit($tv['name'], 200),
                'name_sort'          => addslashes(str_replace(['The ', 'An ', 'A ', '"'], [''], Str::limit($tv['name'], 100))),
                'number_of_episodes' => $tv['number_of_episodes'],
                'number_of_seasons'  => $tv['number_of_seasons'],
                'origin_country'     => $tmdb->ifHasItems('origin_country', $tv),
                'original_language'  => $tv['original_language'],
                'original_name'      => $tv['original_name'],
                'overview'           => $tv['overview'],
                'popularity'         => $tv['popularity'],
                'poster'             => $tmdb->image('poster', $tv),
                'status'             => $tv['status'],
                'vote_average'       => $tv['vote_average'],
                'vote_count'         => $tv['vote_count'],
            ];

            Tv::updateOrCreate(['id' => $id], $array);

            ProcessTvJob::dispatch($tv, $id);

            //return ['message' => 'Tv with id: ' . $id . ' Has been added  to the database, But episodes are loaded with the queue'];
        }
    }

    public function cartoontv($id = null): void
    {
        if ($id == null) {
            $id = $this->id;
        }

        $tmdb = new TMDB();
        $cartoontv = (new Client\CartoonTv($id))->getData();
        if (isset($cartoontv['id'])) {
            $array = [
                'backdrop'           => $tmdb->image('backdrop', $cartoontv),
                'episode_run_time'   => $tmdb->ifHasItems('episode_run_time', $cartoontv),
                'first_air_date'     => $tmdb->ifExists('first_air_date', $cartoontv),
                'homepage'           => $cartoontv['homepage'],
                'imdb_id'            => substr($cartoontv['external_ids']['imdb_id'] ?? '', 2),
                'in_production'      => $cartoontv['in_production'],
                'last_air_date'      => $tmdb->ifExists('last_air_date', $cartoontv),
                'name'               => Str::limit($cartoontv['name'], 200),
                'name_sort'          => addslashes(str_replace(['The ', 'An ', 'A ', '"'], [''], Str::limit($cartoontv['name'], 100))),
                'number_of_episodes' => $cartoontv['number_of_episodes'],
                'number_of_seasons'  => $cartoontv['number_of_seasons'],
                'origin_country'     => $tmdb->ifHasItems('origin_country', $cartoontv),
                'original_language'  => $cartoontv['original_language'],
                'original_name'      => $cartoontv['original_name'],
                'overview'           => $cartoontv['overview'],
                'popularity'         => $cartoontv['popularity'],
                'poster'             => $tmdb->image('poster', $cartoontv),
                'status'             => $cartoontv['status'],
                'vote_average'       => $cartoontv['vote_average'],
                'vote_count'         => $cartoontv['vote_count'],
            ];

            CartoonTv::updateOrCreate(['id' => $id], $array);

            ProcessCartoonTvJob::dispatch($cartoontv, $id);

            //return ['message' => 'CartoonTv with id: ' . $id . ' Has been added  to the database, But episodes are loaded with the queue'];
        }
    }

    public function movie($id = null): void
    {
        if ($id == null) {
            $id = $this->id;
        }

        $tmdb = new TMDB();
        $movie = (new Client\Movie($id))->getData();

        if (\array_key_exists('title', $movie)) {
            $re = '/((?<namesort>.*)(?<seperator>\:|and)(?<remaining>.*)|(?<name>.*))/m';
            preg_match($re, (string) $movie['title'], $matches);

            $year = (new DateTime($movie['release_date']))->format('Y');
            $titleSort = addslashes(str_replace(
                ['The ', 'An ', 'A ', '"'],
                [''],
                Str::limit($matches['namesort'] ? $matches['namesort'].' '.$year : $movie['title'], 100)
            ));

            $array = [
                'adult'             => $movie['adult'] ?? 0,
                'backdrop'          => $tmdb->image('backdrop', $movie),
                'budget'            => $movie['budget'] ?? null,
                'homepage'          => $movie['homepage'] ?? null,
                'imdb_id'           => substr($movie['imdb_id'] ?? '', 2),
                'original_language' => $movie['original_language'] ?? null,
                'original_title'    => $movie['original_title'] ?? null,
                'overview'          => $movie['overview'] ?? null,
                'popularity'        => $movie['popularity'] ?? null,
                'poster'            => $tmdb->image('poster', $movie),
                'release_date'      => $tmdb->ifExists('release_date', $movie),
                'revenue'           => $movie['revenue'] ?? null,
                'runtime'           => $movie['runtime'] ?? null,
                'status'            => $movie['status'] ?? null,
                'tagline'           => $movie['tagline'] ?? null,
                'title'             => Str::limit($movie['title'], 200),
                'title_sort'        => $titleSort,
                'vote_average'      => $movie['vote_average'] ?? null,
                'vote_count'        => $movie['vote_count'] ?? null,
            ];

            Movie::updateOrCreate(['id' => $movie['id']], $array);

            ProcessMovieJob::dispatch($movie, $id);

            //return ['message' => 'Movies with id: ' . $id . ' Has been added  to the database, But relations are loaded with the queue'];
        }
    }

    public function cartoon($id = null): void
    {
        if ($id == null) {
            $id = $this->id;
        }

        $tmdb = new TMDB();
        $cartoon = (new Client\Cartoon($id))->getData();

        if (\array_key_exists('title', $cartoon)) {
            $re = '/((?<namesort>.*)(?<seperator>\:|and)(?<remaining>.*)|(?<name>.*))/m';
            preg_match($re, (string) $cartoon['title'], $matches);

            $year = (new DateTime($cartoon['release_date']))->format('Y');
            $titleSort = addslashes(str_replace(
                ['The ', 'An ', 'A ', '"'],
                [''],
                Str::limit($matches['namesort'] ? $matches['namesort'].' '.$year : $cartoon['title'], 100)
            ));

            $array = [
                'adult'             => $cartoon['adult'] ?? 0,
                'backdrop'          => $tmdb->image('backdrop', $cartoon),
                'budget'            => $cartoon['budget'] ?? null,
                'homepage'          => $cartoon['homepage'] ?? null,
                'imdb_id'           => substr($cartoon['imdb_id'] ?? '', 2),
                'original_language' => $cartoon['original_language'] ?? null,
                'original_title'    => $cartoon['original_title'] ?? null,
                'overview'          => $cartoon['overview'] ?? null,
                'popularity'        => $cartoon['popularity'] ?? null,
                'poster'            => $tmdb->image('poster', $cartoon),
                'release_date'      => $tmdb->ifExists('release_date', $cartoon),
                'revenue'           => $cartoon['revenue'] ?? null,
                'runtime'           => $cartoon['runtime'] ?? null,
                'status'            => $cartoon['status'] ?? null,
                'tagline'           => $cartoon['tagline'] ?? null,
                'title'             => Str::limit($cartoon['title'], 200),
                'title_sort'        => $titleSort,
                'vote_average'      => $cartoon['vote_average'] ?? null,
                'vote_count'        => $cartoon['vote_count'] ?? null,
            ];

            Cartoon::updateOrCreate(['id' => $cartoon['id']], $array);

            ProcessCartoonJob::dispatch($cartoon, $id);

            //return ['message' => 'Cartoons with id: ' . $id . ' Has been added  to the database, But relations are loaded with the queue'];
        }
    }

    public function collection($id = null): void
    {
        if ($id == null) {
            $id = $this->id;
        }

        $tmdb = new TMDB();
        $collection = (new Client\Collection($id))->getData();

        $array = [
            'name'     => $collection['name'],
            'overview' => $collection['overview'],
            'backdrop' => $tmdb->image('backdrop', $collection),
            'poster'   => $tmdb->image('poster', $collection),
        ];
        Collection::updateOrCreate(['id' => $collection['id']], $array);

        ProcessCollectionJob::dispatch($collection);

        //return ['message' => 'Collection with id: ' . $id . ' Has been added  to the database, But movies are loaded with the queue'];
    }

    public function company($id = null): void
    {
        if ($id == null) {
            $id = $this->id;
        }

        $tmdb = new TMDB();
        $company = (new Client\Company($id))->getData();

        $array = [
            'name'     => $company['name'],
            'overview' => $company['overview'],
            'backdrop' => $tmdb->image('backdrop', $company),
            'poster'   => $tmdb->image('poster', $company),
        ];
        Company::updateOrCreate(['id' => $company['id']], $array);

        ProcessCompanyJob::dispatch($company);

        //return ['message' => 'Company with id: ' . $id . ' Has been added  to the database, But movies are loaded with the queue'];
    }
}
