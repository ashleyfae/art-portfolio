<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // This is because unit tests don't use Postgres and thus don't have the UUID ext.
        if (! App::runningUnitTests()) {
            DB::statement('CREATE EXTENSION IF NOT EXISTS "uuid-ossp";');
        }

        Schema::create('artworks', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\User::class)->constrained()->cascadeOnDelete()->index();
            $table->json('external_ids')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->dateTime('published_at');

            if (App::runningUnitTests()) {
                $table->uuid('uuid')->nullable()->unique();
            } else {
                $table->uuid('uuid')->default(DB::raw('uuid_generate_v4()'))->unique();
            }

            $table->timestamps();

            $table->index(['published_at', 'is_featured']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('artworks');
    }
};
