<?php

namespace App\Models;

use App\Helpers\Bbcode;
use App\Helpers\MarkdownExtra;
use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use Auditable;
    use HasFactory;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var string[]
     */
    protected $guarded = ['id', 'created_at', 'updated_at'];

    /**
     * Set The Pages Content After Its Been Purified.
     */
    public function setContentAttribute(?string $value): void
    {
        $this->attributes['content'] = $value;
    }

    /**
     * Parse Content And Return Valid HTML.
     */
    public function getContentHtml(): ?string
    {
        return (new MarkdownExtra())->text((new Bbcode())->parse($this->content, false));
    }
}
