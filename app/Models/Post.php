<?php

namespace App\Models;

use App\Helpers\Bbcode;
use App\Helpers\Linkify;
use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use voku\helper\AntiXSS;

class Post extends Model
{
    use Auditable;
    use HasFactory;

    /**
     * Belongs To A Topic.
     */
    public function topic(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Topic::class);
    }

    /**
     * Belongs To A User.
     */
    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class)->withDefault([
            'username' => 'System',
            'id'       => '1',
        ]);
    }

    /**
     * A Post Has Many Likes.
     */
    public function likes(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Like::class)->where('like', '=', 1);
    }

    /**
     * A Post Has Many Dislikes.
     */
    public function dislikes(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Like::class)->where('dislike', '=', 1);
    }

    /**
     * A Post Has Many Tips.
     */
    public function tips(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(BonTransactions::class);
    }

    /**
     * A Post Author Has Many Posts.
     */
    public function authorPosts(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Post::class, 'user_id', 'user_id');
    }

    /**
     * A Post Author Has Many Topics.
     */
    public function authorTopics(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Topic::class, 'first_post_user_id', 'user_id');
    }

    /**
     * Set The Posts Content After Its Been Purified.
     */
    public function setContentAttribute(?string $value): void
    {
        $this->attributes['content'] = htmlspecialchars((new AntiXSS())->xss_clean($value), ENT_NOQUOTES);
    }

    /**
     * Parse Content And Return Valid HTML.
     */
    public function getContentHtml(): string
    {
        $bbcode = new Bbcode();

        return (new Linkify())->linky($bbcode->parse(htmlspecialchars_decode($this->content)));
    }

    /**
     * Post Trimming.t.
     */
    public function getBrief(int $length = 100, bool $ellipses = true, bool $stripHtml = false): string
    {
        $input = $this->content;
        //strip tags, if desired
        if ($stripHtml) {
            $input = strip_tags($input);
        }

        //no need to trim, already shorter than trim length
        if (\strlen((string) $input) <= $length) {
            return $input;
        }

        //find last space within length
        $lastSpace = strrpos(substr($input, 0, $length), ' ');
        $trimmedText = substr($input, 0, $lastSpace);

        //add ellipses (...)
        if ($ellipses) {
            $trimmedText .= '...';
        }

        return $trimmedText;
    }

    /**
     * Get A Post From A ID.
     */
    public function getPostNumber(): string
    {
        return $this->topic->postNumberFromId($this->id);
    }

    /**
     * Get A Posts Page Number.
     */
    public function getPageNumber(): float
    {
        $result = ($this->getPostNumber() - 1) / 25 + 1;

        return floor($result);
    }
}
