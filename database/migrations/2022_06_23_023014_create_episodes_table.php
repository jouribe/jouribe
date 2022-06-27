<?php

use App\Models\Serie;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('episodes', static function (Blueprint $table) {
            $table->id();

            $table->foreignIdFor(Serie::class)
                ->nullable()
                ->constrained()
                ->onDelete('set null')
                ->onUpdate('cascade');

            $table->string('title')->fulltext();
            $table->string('slug')->unique();
            $table->text('summary')->fulltext();
            $table->string('video');
            $table->text('topics')->nullable();
            $table->json('options')->nullable();
            $table->boolean('completed')->default(false);
            $table->dateTime('scheduled_at')->nullable();
            $table->dateTime('published_at')->nullable();
            $table->dateTime('archived_at')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('episodes');
    }
};
