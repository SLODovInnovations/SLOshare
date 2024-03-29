<?php

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
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
     * Indicates If The Model Should Be Timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Has Many Users.
     */
    public function users(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(User::class);
    }

    /**
     * Has Many Permissions.
     */
    public function permissions(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Permission::class);
    }

    /**
     * Returns The Requested Row From The Permissions Table.
     */
    public function getPermissionsByForum($forum): ?object
    {
        return Permission::where('forum_id', '=', $forum->id)
            ->where('group_id', '=', $this->id)
            ->first();
    }

    /**
     * Get the Group allowed answer as bool.
     */
    public function isAllowed($object, int $groupId): bool
    {
        if (\is_array($object) && \is_array($object['default_groups']) && \array_key_exists($groupId, $object['default_groups'])) {
            return $object['default_groups'][$groupId] == 1;
        }

        return true;
    }
}
