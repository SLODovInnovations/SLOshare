<?php

namespace App\Http\Controllers;

//use App\Achievements\UserMade100Comments;
//use App\Achievements\UserMade200Comments;
//use App\Achievements\UserMade300Comments;
//use App\Achievements\UserMade400Comments;
//use App\Achievements\UserMade500Comments;
//use App\Achievements\UserMade50Comments;
//use App\Achievements\UserMade600Comments;
//use App\Achievements\UserMade700Comments;
//use App\Achievements\UserMade800Comments;
//use App\Achievements\UserMade900Comments;
//use App\Achievements\UserMadeComment;
//use App\Achievements\UserMadeTenComments;
use App\Models\Article;
use App\Models\Collection;
use App\Models\Comment;
use App\Models\Playlist;
use App\Models\Ticket;
use App\Models\Torrent;
use App\Models\TorrentRequest;
use App\Models\User;
use App\Notifications\NewComment;
use App\Repositories\ChatRepository;
use App\Repositories\TaggedUserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;

/**
 * @see \Tests\Feature\Http\Controllers\CommentControllerTest
 */
class CommentController extends Controller
{
    public $tag;

    /**
     * CommentController Constructor.
     */
    public function __construct(private readonly TaggedUserRepository $taggedUserRepository, private readonly ChatRepository $chatRepository)
    {
    }

    /**
     * Add A Comment To A Collection.
     */
    public function collection(Request $request, int $id): \Illuminate\Http\RedirectResponse
    {
        $collection = Collection::findOrFail($id);
        $user = $request->user();

        if (RateLimiter::tooManyAttempts('collection-comment:'.$user->id, \config('sloshare.comment-rate-limit'))) {
            return \to_route('collection.show', ['id' => $id])
                ->withErrors(\trans('comment.slow-down'));
        }

        RateLimiter::hit('collection-comment:'.$user->id);

        if ($user->can_comment == 0) {
            return \to_route('collection.show', ['id' => $collection->id])
                ->withErrors(\trans('comment.rights-revoked'));
        }

        $comment = new Comment();
        $comment->content = $request->input('content');
        $comment->anon = $request->input('anonymous');
        $comment->user_id = $user->id;
        $comment->collection_id = $collection->id;

        $v = \validator($comment->toArray(), [
            'content'       => 'required',
            'user_id'       => 'required',
            'collection_id' => 'required',
            'anon'          => 'required',
        ]);

        if ($v->fails()) {
            return \to_route('collection.show', ['id' => $collection->id])
                ->withErrors($v->errors());
        }

        $comment->save();

        $collectionUrl = \href_collection($collection);
        $profileUrl = \href_profile($user);

        // Auto Shout
        if ($comment->anon == 0) {
            $this->chatRepository->systemMessage(
                \sprintf('[url=%s]%s[/url] je pustil komentar o zbirki [url=%s]%s[/url]', $profileUrl, $user->username, $collectionUrl, $collection->name)
            );
        } else {
            $this->chatRepository->systemMessage(
                \sprintf('Anonimni uporabnik je pustil komentar o zbirki [url=%s]%s[/url]', $collectionUrl, $collection->name)
            );
        }

        if ($this->taggedUserRepository->hasTags($request->input('content'))) {
            if ($this->taggedUserRepository->contains($request->input('content'), '@here') && $user->group->is_modo) {
                $users = \collect([]);

                $collection->comments()->get()->each(function ($c, $v) use ($users) {
                    $users->push($c->user);
                });
                $this->tag->messageCommentUsers(
                    'collection',
                    $users,
                    $user,
                    'Staff',
                    $comment
                );
            } else {
                $sender = $comment->anon ? 'Anonymous' : $user->username;
                $this->taggedUserRepository->messageTaggedCommentUsers(
                    'collection',
                    $request->input('content'),
                    $user,
                    $sender,
                    $comment
                );
            }
        }

        // Achievements
//        if ($comment->anon == 0) {
//            $user->unlock(new UserMadeComment(), 1);
//            $user->addProgress(new UserMadeTenComments(), 1);
//            $user->addProgress(new UserMade50Comments(), 1);
//            $user->addProgress(new UserMade100Comments(), 1);
//            $user->addProgress(new UserMade200Comments(), 1);
//            $user->addProgress(new UserMade300Comments(), 1);
//            $user->addProgress(new UserMade400Comments(), 1);
//            $user->addProgress(new UserMade500Comments(), 1);
//            $user->addProgress(new UserMade600Comments(), 1);
//            $user->addProgress(new UserMade700Comments(), 1);
//            $user->addProgress(new UserMade800Comments(), 1);
//            $user->addProgress(new UserMade900Comments(), 1);
//        }

        return \to_route('mediahub.collections.show', ['id' => $collection->id, 'hash' => '#comments'])
                ->withSuccess(\trans('comment.added'));
    }

    /**
     * Store A New Comment To A Article.
     */
    public function article(Request $request, int $id): \Illuminate\Http\RedirectResponse
    {
        $article = Article::findOrFail($id);
        $user = $request->user();

        if (RateLimiter::tooManyAttempts('article-comment:'.$user->id, \config('sloshare.comment-rate-limit'))) {
            return \to_route('articles.show', ['id' => $id])
                ->withErrors(\trans('comment.slow-down'));
        }

        RateLimiter::hit('article-comment:'.$user->id);

        if ($user->can_comment == 0) {
            return \to_route('articles.show', ['id' => $article->id])
                ->withErrors(\trans('comment.rights-revoked'));
        }

        $comment = new Comment();
        $comment->content = $request->input('content');
        $comment->anon = $request->input('anonymous');
        $comment->user_id = $user->id;
        $comment->article_id = $article->id;

        $v = \validator($comment->toArray(), [
            'content'    => 'required',
            'user_id'    => 'required',
            'article_id' => 'required',
            'anon'       => 'required',
        ]);

        if ($v->fails()) {
            return \to_route('articles.show', ['id' => $article->id])
                ->withErrors($v->errors());
        }

        $comment->save();
        $articleUrl = \href_article($article);
        $profileUrl = \href_profile($user);
        // Auto Shout
        if ($comment->anon == 0) {
            $this->chatRepository->systemMessage(
                \sprintf('[url=%s]%s[/url] je pustil komentar na članku [url=%s]%s[/url]', $profileUrl, $user->username, $articleUrl, $article->title)
            );
        } else {
            $this->chatRepository->systemMessage(
                \sprintf('Anonimni uporabnik je pustil komentar na članku [url=%s]%s[/url]', $articleUrl, $article->title)
            );
        }

        if ($this->taggedUserRepository->hasTags($request->input('content'))) {
            if ($this->taggedUserRepository->contains($request->input('content'), '@here') && $user->group->is_modo) {
                $users = \collect([]);

                $article->comments()->get()->each(function ($c) use ($users) {
                    $users->push($c->user);
                });
                $this->taggedUserRepository->messageCommentUsers(
                    'article',
                    $users,
                    $user,
                    'Staff',
                    $comment
                );
            } else {
                $sender = $comment->anon ? 'Anonymous' : $user->username;
                $this->taggedUserRepository->messageTaggedCommentUsers(
                    'article',
                    $request->input('content'),
                    $user,
                    $sender,
                    $comment
                );
            }
        }

        // Achievements
//        if ($comment->anon == 0) {
//            $user->unlock(new UserMadeComment(), 1);
//            $user->addProgress(new UserMadeTenComments(), 1);
//            $user->addProgress(new UserMade50Comments(), 1);
//            $user->addProgress(new UserMade100Comments(), 1);
//            $user->addProgress(new UserMade200Comments(), 1);
//            $user->addProgress(new UserMade300Comments(), 1);
//            $user->addProgress(new UserMade400Comments(), 1);
//            $user->addProgress(new UserMade500Comments(), 1);
//            $user->addProgress(new UserMade600Comments(), 1);
//            $user->addProgress(new UserMade700Comments(), 1);
//            $user->addProgress(new UserMade800Comments(), 1);
//            $user->addProgress(new UserMade900Comments(), 1);
//        }

        return \to_route('articles.show', ['id' => $article->id])
            ->withSuccess(\trans('comment.added'));
    }

    /**
     * Store A New Comment To A Playlist.
     */
    public function playlist(Request $request, int $id): \Illuminate\Http\RedirectResponse
    {
        $playlist = Playlist::findOrFail($id);
        $user = $request->user();

        if (RateLimiter::tooManyAttempts('playlist-comment:'.$user->id, \config('sloshare.comment-rate-limit'))) {
            return \to_route('playlists.show', ['id' => $id])
                ->withErrors(\trans('comment.slow-down'));
        }

        RateLimiter::hit('playlist-comment:'.$user->id);

        if ($user->can_comment == 0) {
            return \to_route('playlists.show', ['id' => $playlist->id])
                ->withErrors(\trans('comment.rights-revoked'));
        }

        $comment = new Comment();
        $comment->content = $request->input('content');
        $comment->anon = $request->input('anonymous');
        $comment->user_id = $user->id;
        $comment->playlist_id = $playlist->id;

        $v = \validator($comment->toArray(), [
            'content'     => 'required',
            'user_id'     => 'required',
            'playlist_id' => 'required',
            'anon'        => 'required',
        ]);

        if ($v->fails()) {
            return \to_route('playlists.show', ['id' => $playlist->id])
                ->withErrors($v->errors());
        }

        $comment->save();
        $playlistUrl = \href_playlist($playlist);
        $profileUrl = \href_profile($user);
        // Auto Shout
        if ($comment->anon == 0) {
            $this->chatRepository->systemMessage(
                \sprintf('[url=%s]%s[/url] je pustil komentar na seznamu predvajan [url=%s]%s[/url]', $profileUrl, $user->username, $playlistUrl, $playlist->name)
            );
        } else {
            $this->chatRepository->systemMessage(
                \sprintf('Anonimni uporabnik je pustil komentar na seznamu predvajan [url=%s]%s[/url]', $playlistUrl, $playlist->name)
            );
        }

        if ($this->taggedUserRepository->hasTags($request->input('content'))) {
            if ($this->taggedUserRepository->contains($request->input('content'), '@here') && $user->group->is_modo) {
                $users = \collect([]);

                $playlist->comments()->get()->each(function ($c) use ($users) {
                    $users->push($c->user);
                });
                $this->taggedUserRepository->messageCommentUsers(
                    'playlist',
                    $users,
                    $user,
                    'Staff',
                    $comment
                );
            } else {
                $sender = $comment->anon ? 'Anonymous' : $user->username;
                $this->taggedUserRepository->messageTaggedCommentUsers(
                    'playlist',
                    $request->input('content'),
                    $user,
                    $sender,
                    $comment
                );
            }
        }

        // Achievements
//        if ($comment->anon == 0) {
//            $user->unlock(new UserMadeComment(), 1);
//            $user->addProgress(new UserMadeTenComments(), 1);
//            $user->addProgress(new UserMade50Comments(), 1);
//            $user->addProgress(new UserMade100Comments(), 1);
//            $user->addProgress(new UserMade200Comments(), 1);
//            $user->addProgress(new UserMade300Comments(), 1);
//            $user->addProgress(new UserMade400Comments(), 1);
//            $user->addProgress(new UserMade500Comments(), 1);
//            $user->addProgress(new UserMade600Comments(), 1);
//            $user->addProgress(new UserMade700Comments(), 1);
//            $user->addProgress(new UserMade800Comments(), 1);
//            $user->addProgress(new UserMade900Comments(), 1);
//        }

        return \to_route('playlists.show', ['id' => $playlist->id, 'hash' => '#comments'])
            ->withSuccess(\trans('comment.added'));
    }

    /**
     * Store A New Comment To A Torrent.
     */
    public function torrent(Request $request, int $id): \Illuminate\Http\RedirectResponse
    {
        $torrent = Torrent::findOrFail($id);
        $user = $request->user();

        if (RateLimiter::tooManyAttempts('torrent-comment:'.$user->id, \config('sloshare.comment-rate-limit'))) {
            return \to_route('torrent', ['id' => $torrent->id])
                ->withErrors(\trans('comment.slow-down'));
        }

        RateLimiter::hit('torrent-comment:'.$user->id);

        if ($user->can_comment == 0) {
            return \to_route('torrent', ['id' => $torrent->id])
                ->withErrors(\trans('comment.rights-revoked'));
        }

        $comment = new Comment();
        $comment->content = $request->input('content');
        $comment->anon = $request->input('anonymous');
        $comment->user_id = $user->id;
        $comment->torrent_id = $torrent->id;

        $v = \validator($comment->toArray(), [
            'content'    => 'required',
            'user_id'    => 'required',
            'torrent_id' => 'required',
            'anon'       => 'required',
        ]);

        if ($v->fails()) {
            return \to_route('torrent', ['id' => $torrent->id])
                ->withErrors($v->errors());
        }

        $comment->save();
        //Notification
        if ($user->id != $torrent->user_id) {
            $torrent->notifyUploader('comment', $comment);
        }

        $torrentUrl = \href_torrent($torrent);
        $profileUrl = \href_profile($user);
        // Auto Shout
        if ($comment->anon == 0) {
            $this->chatRepository->systemMessage(
                \sprintf('[url=%s]%s[/url] je pustil komentar na Torrentu [url=%s]%s[/url]', $profileUrl, $user->username, $torrentUrl, $torrent->name)
            );
        } else {
            $this->chatRepository->systemMessage(
                \sprintf('Anonimni uporabnik je pustil komentar na Torrentu [url=%s]%s[/url]', $torrentUrl, $torrent->name)
            );
        }

        if ($this->taggedUserRepository->hasTags($request->input('content'))) {
            if ($this->taggedUserRepository->contains($request->input('content'), '@here') && $user->group->is_modo) {
                $users = \collect([]);

                $torrent->comments()->get()->each(function ($c) use ($users) {
                    $users->push($c->user);
                });
                $this->taggedUserRepository->messageCommentUsers(
                    'torrent',
                    $users,
                    $user,
                    'Staff',
                    $comment
                );
            } else {
                $sender = $comment->anon ? 'Anonymous' : $user->username;
                $this->taggedUserRepository->messageTaggedCommentUsers(
                    'torrent',
                    $request->input('content'),
                    $user,
                    $sender,
                    $comment
                );
            }
        }

        // Achievements
//        if ($comment->anon == 0) {
//            $user->unlock(new UserMadeComment(), 1);
//            $user->addProgress(new UserMadeTenComments(), 1);
//            $user->addProgress(new UserMade50Comments(), 1);
//            $user->addProgress(new UserMade100Comments(), 1);
//            $user->addProgress(new UserMade200Comments(), 1);
//            $user->addProgress(new UserMade300Comments(), 1);
//            $user->addProgress(new UserMade400Comments(), 1);
//            $user->addProgress(new UserMade500Comments(), 1);
//            $user->addProgress(new UserMade600Comments(), 1);
//            $user->addProgress(new UserMade700Comments(), 1);
//            $user->addProgress(new UserMade800Comments(), 1);
//            $user->addProgress(new UserMade900Comments(), 1);
//        }

        return \to_route('torrent', ['id' => $torrent->id, 'hash' => '#comments'])
            ->withSuccess(\trans('comment.added'));
    }

    /**
     * Store A New Comment To A Request.
     */
    public function request(Request $request, int $id): \Illuminate\Http\RedirectResponse
    {
        $tr = TorrentRequest::findOrFail($id);
        $user = $request->user();

        if (RateLimiter::tooManyAttempts('request-comment:'.$user->id, \config('sloshare.comment-rate-limit'))) {
            return \to_route('request', ['id' => $id])
                ->withErrors(\trans('comment.slow-down'));
        }

        RateLimiter::hit('request-comment:'.$user->id);

        if ($user->can_comment == 0) {
            return \to_route('request', ['id' => $tr->id])
                ->withErrors(\trans('comment.rights-revoked'));
        }

        $comment = new Comment();
        $comment->content = $request->input('content');
        $comment->anon = $request->input('anonymous');
        $comment->user_id = $user->id;
        $comment->requests_id = $tr->id;

        $v = \validator($comment->toArray(), [
            'content'     => 'required',
            'user_id'     => 'required',
            'requests_id' => 'required',
            'anon'        => 'required',
        ]);

        if ($v->fails()) {
            return \to_route('request', ['id' => $tr->id])
                ->withErrors($v->errors());
        }

        $comment->save();
        $trUrl = \href_request($tr);
        $profileUrl = \href_profile($user);
        // Auto Shout
        if ($comment->anon == 0) {
            $this->chatRepository->systemMessage(
                \sprintf('[url=%s]%s[/url] je pustil komentar na zahtevo [url=%s]%s[/url]', $profileUrl, $user->username, $trUrl, $tr->name)
            );
        } else {
            $this->chatRepository->systemMessage(
                \sprintf('Anonimni uporabnik je pustil komentar na zahtevo [url=%s]%s[/url]', $trUrl, $tr->name)
            );
        }

        //Notification
        if ($user->id != $tr->user_id) {
            $tr->notifyRequester('comment', $comment);
        }

        if ($this->taggedUserRepository->hasTags($request->input('content'))) {
            if ($this->taggedUserRepository->contains($request->input('content'), '@here') && $user->group->is_modo) {
                $users = \collect([]);

                $tr->comments()->get()->each(function ($c) use ($users) {
                    $users->push($c->user);
                });
                $this->taggedUserRepository->messageCommentUsers(
                    'request',
                    $users,
                    $user,
                    'Staff',
                    $comment
                );
            } else {
                $sender = $comment->anon ? 'Anonymous' : $user->username;
                $this->taggedUserRepository->messageTaggedCommentUsers(
                    'request',
                    $request->input('content'),
                    $user,
                    $sender,
                    $comment
                );
            }
        }

        // Achievements
//        if ($comment->anon == 0) {
//            $user->unlock(new UserMadeComment(), 1);
//            $user->addProgress(new UserMadeTenComments(), 1);
//            $user->addProgress(new UserMade50Comments(), 1);
//            $user->addProgress(new UserMade100Comments(), 1);
//            $user->addProgress(new UserMade200Comments(), 1);
//            $user->addProgress(new UserMade300Comments(), 1);
//            $user->addProgress(new UserMade400Comments(), 1);
//            $user->addProgress(new UserMade500Comments(), 1);
//            $user->addProgress(new UserMade600Comments(), 1);
//            $user->addProgress(new UserMade700Comments(), 1);
//            $user->addProgress(new UserMade800Comments(), 1);
//            $user->addProgress(new UserMade900Comments(), 1);
//        }

        return \to_route('request', ['id' => $tr->id, 'hash' => '#comments'])
            ->withSuccess(\trans('comment.added'));
    }

    /**
     * Store A New Comment To A Request.
     */
    public function ticket(Request $request, int $id): \Illuminate\Http\RedirectResponse
    {
        $ticket = Ticket::findOrFail($id);
        $user = $request->user();

        if (RateLimiter::tooManyAttempts('ticket-comment:'.$user->id, \config('sloshare.comment-rate-limit'))) {
            return \to_route('tickets.show', ['id' => $id])
                ->withErrors(\trans('comment.slow-down'));
        }

        RateLimiter::hit('ticket-comment:'.$user->id);

        $comment = new Comment();
        $comment->content = $request->input('content');
        $comment->anon = 0;
        $comment->user_id = $user->id;
        $comment->ticket_id = $ticket->id;

        $v = \validator($comment->toArray(), [
            'content'   => 'required',
            'user_id'   => 'required',
            'ticket_id' => 'required',
            'anon'      => 'required',
        ]);

        if ($v->fails()) {
            return \to_route('tickets.show', ['id' => $id])
                ->withErrors($v->errors());
        }

        if ($user->id != $ticket->user_id) {
            $ticket->user_read = 0;
        }

        if ($user->id == $ticket->user_id) {
            $ticket->staff_read = 0;
        }

        $comment->save();
        $ticket->save();

        return \to_route('tickets.show', ['id' => $ticket->id])
            ->withSuccess(\trans('comment.added'));
    }

    /**
     * Store A New Comment To A Torrent Via Quick Thanks.
     */
    public function quickthanks(Request $request, int $id): \Illuminate\Http\RedirectResponse
    {
        $torrent = Torrent::findOrFail($id);
        $user = $request->user();

        if (RateLimiter::tooManyAttempts('torrent-comment:'.$user->id, \config('sloshare.comment-rate-limit'))) {
            return \to_route('torrent', ['id' => $torrent->id])
                ->withErrors(\trans('comment.slow-down'));
        }

        RateLimiter::hit('torrent-comment:'.$user->id);

        if ($user->can_comment == 0) {
            return \to_route('torrent', ['id' => $torrent->id])
                ->withErrors(\trans('comment.rights-revoked'));
        }

        $comment = new Comment();

        if ($torrent->anon === 1) {
            $thankArray = [
                'Hvala za nalaganje! :thumbsup_tone2:',
                'Čas in trud sta zelo cenjena :thumbsup_tone2:',
                'Super nalaganje! :fire:', 'Hvala vam :smiley:',
            ];
        } else {
            $uploader = User::where('id', '=', $torrent->user_id)->first();
            $uploaderUrl = \href_profile($uploader);

            $thankArray = [
                \sprintf('Hvala za nalaganje [url=%s][color=%s][b]%s[/b][/color][/url] :vulcan_tone2:', $uploaderUrl, $uploader->group->color, $uploader->username),
                \sprintf('Lepo nalaganje [url=%s][color=%s][b]%s[/b][/color][/url] :fire:', $uploaderUrl, $uploader->group->color, $uploader->username),
                \sprintf('Na zdravje [url=%s][color=%s][b]%s[/b][/color][/url] za nalaganje :beers:', $uploaderUrl, $uploader->group->color, $uploader->username),
            ];
        }

        $selected = random_int(0, (\is_countable($thankArray) ? \count($thankArray) : 0) - 1);
        $comment->content = $thankArray[$selected];
        $comment->user_id = $user->id;
        $comment->torrent_id = $torrent->id;

        $v = \validator($comment->toArray(), [
            'content'    => 'required',
            'user_id'    => 'required',
            'torrent_id' => 'required',
        ]);

        if ($v->fails()) {
            return \to_route('torrent', ['id' => $torrent->id])
                ->withErrors($v->errors());
        }

        $comment->save();

        // Achievements
//        if ($comment->anon == 0) {
//            $user->unlock(new UserMadeComment(), 1);
//            $user->addProgress(new UserMadeTenComments(), 1);
//            $user->addProgress(new UserMade50Comments(), 1);
//            $user->addProgress(new UserMade100Comments(), 1);
//            $user->addProgress(new UserMade200Comments(), 1);
//            $user->addProgress(new UserMade300Comments(), 1);
//            $user->addProgress(new UserMade400Comments(), 1);
//            $user->addProgress(new UserMade500Comments(), 1);
//            $user->addProgress(new UserMade600Comments(), 1);
//            $user->addProgress(new UserMade700Comments(), 1);
//            $user->addProgress(new UserMade800Comments(), 1);
//            $user->addProgress(new UserMade900Comments(), 1);
//        }

        //Notification
        if ($user->id != $torrent->user_id) {
            User::find($torrent->user_id)->notify(new NewComment('torrent', $comment));
        }

        // Auto Shout
        $torrentUrl = \href_torrent($torrent);
        $profileUrl = \href_profile($user);
        $this->chatRepository->systemMessage(
            \sprintf('[url=%s]%s[/url] je pustil komentar na Torrentu [url=%s]%s[/url]', $profileUrl, $user->username, $torrentUrl, $torrent->name)
        );

        return \to_route('torrent', ['id' => $torrent->id])
            ->withSuccess(\trans('comment.added'));
    }

    /**
     * Edit A Comment.
     */
    public function editComment(Request $request, int $commentId): \Illuminate\Http\RedirectResponse
    {
        $user = $request->user();
        $comment = Comment::findOrFail($commentId);

        \abort_unless($user->group->is_modo || $user->id == $comment->user_id, 403);
        $comment->content = $request->input('comment-edit');

        $v = \validator($comment->toArray(), [
            'content'    => 'required',
        ]);

        if ($v->fails()) {
            return \redirect()->back()
                ->withErrors($v->errors());
        }

        $comment->save();

        return \redirect()->back()->withSuccess(\trans('comment.edited'));
    }

    /**
     * Delete A Comment.
     */
    public function deleteComment(Request $request, int $commentId): \Illuminate\Http\RedirectResponse
    {
        $user = $request->user();
        $comment = Comment::findOrFail($commentId);

        \abort_unless($user->group->is_modo || $user->id == $comment->user_id, 403);
        $comment->delete();

        return \redirect()->back()->withSuccess(\trans('comment.deleted'));
    }
}
