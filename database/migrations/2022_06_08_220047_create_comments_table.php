<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('comments', static function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->constrained()
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->text('content');

            $table->morphs('commentable');

            $table->bigInteger('parent_id')->unsigned()->nullable();
            $table->enum('type', ['comment', 'reply'])->default('comment');
            $table->enum('status', ['pending', 'approved', 'spam'])->default('pending');

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
        Schema::dropIfExists('comments');
    }
};
