<?php

use App\Models\TorrentRequest;
use App\Models\Type;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('requests', function (Blueprint $table): void {
            $table->integer('type_id')->index();
        });

        foreach (TorrentRequest::all() as $torrent_req) {
            $type_id = Type::where('name', '=', $torrent_req->type)->firstOrFail()->id;
            $torrent_req->type_id = $type_id;
            $torrent_req->save();
        }

        Schema::table('requests', function (Blueprint $table): void {
            $table->dropColumn('type');
        });
    }
};
