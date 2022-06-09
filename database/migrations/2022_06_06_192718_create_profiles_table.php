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
        Schema::create('profiles', static function (Blueprint $table) {
            $table->foreignId('user_id')->constrained()
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->enum('gender', ['male', 'female', 'other'])->nullable();
            $table->date('birthday')->nullable();
            $table->json('socials')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('profiles');
    }
};
