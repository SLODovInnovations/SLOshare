<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('user_notifications', function (Blueprint $table): void {
            $table->integer('id', true)->signed();
            $table->integer('user_id')->signed()->unique();
            $table->boolean('show_bon_gift')->index()->default(1);
            $table->boolean('show_mention_forum_post')->index()->default(1);
            $table->boolean('show_mention_article_comment')->index()->default(1);
            $table->boolean('show_mention_request_comment')->index()->default(1);
            $table->boolean('show_mention_torrent_comment')->index()->default(1);
            $table->boolean('show_subscription_topic')->index()->default(1);
            $table->boolean('show_subscription_forum')->index()->default(1);
            $table->boolean('show_forum_topic')->index()->default(1);
            $table->boolean('show_following_upload')->index()->default(1);
            $table->boolean('show_request_bounty')->index()->default(1);
            $table->boolean('show_request_comment')->index()->default(1);
            $table->boolean('show_request_fill')->index()->default(1);
            $table->boolean('show_request_fill_approve')->index()->default(1);
            $table->boolean('show_request_fill_reject')->index()->default(1);
            $table->boolean('show_request_claim')->index()->default(1);
            $table->boolean('show_request_unclaim')->index()->default(1);
            $table->boolean('show_torrent_comment')->index()->default(1);
            $table->boolean('show_torrent_tip')->index()->default(1);
            $table->boolean('show_torrent_thank')->index()->default(1);
            $table->boolean('show_account_follow')->index()->default(1);
            $table->boolean('show_account_unfollow')->index()->default(1);
            $table->json('json_account_groups');
            $table->json('json_bon_groups');
            $table->json('json_mention_groups');
            $table->json('json_request_groups');
            $table->json('json_torrent_groups');
            $table->json('json_forum_groups');
            $table->json('json_following_groups');
            $table->json('json_subscription_groups');
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('RESTRICT')->onDelete('CASCADE');
        });
    }
};
