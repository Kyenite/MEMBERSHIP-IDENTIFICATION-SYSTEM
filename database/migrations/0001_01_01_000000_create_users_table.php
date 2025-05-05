<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('profile')->default('images/default_profile.png');
            $table->string('username')->unique();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });

        Schema::create('logos', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->string('value');
            $table->timestamps();
        });

        Schema::create('forum', function (Blueprint $table) {
            $table->id();
            $table->text('content');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('parishioners', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('last_name');
            $table->integer('age');
            $table->date('birthdate');
            $table->string('address');
            $table->string('contact_number');
            $table->string('email')->unique();
            $table->string('mother_name')->nullable();
            $table->string('father_name')->nullable();
            $table->timestamps();
        });

        Schema::create('folders', function (Blueprint $table) {
            $table->id();
            $table->string('folder_name')->unique();
            $table->timestamps();
        });
        
        Schema::create('fg_members', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('profile')->default('images/default_profile.png');
            $table->date('birthday')->nullable();
            $table->integer('age')->nullable();
            $table->string('gender')->nullable();
            $table->string('status')->nullable();
            $table->string('fathers_name')->nullable();
            $table->string('mothers_name')->nullable();
            $table->string('activity')->nullable();
            $table->unsignedBigInteger('folder_id');
        
            $table->boolean('baptism')->default(false);
            $table->boolean('communion')->default(false);
            $table->boolean('confirmation')->default(false);
            $table->boolean('marriage')->default(false);
            $table->string('family_code')->default('0000');
        
            $table->timestamps();
        
            $table->foreign('folder_id')->references('id')->on('folders')->onDelete('cascade');
        });

        Schema::create('donations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('fg_member_id');
            
            $table->string('month');
            $table->decimal('amount', 10, 2);
            
            $table->date('date');
            $table->string('year');
        
            $table->timestamps();
        
            $table->foreign('fg_member_id')->references('id')->on('fg_members')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('sessions');
        Schema::dropIfExists('logos');
        Schema::dropIfExists('forum');
        Schema::dropIfExists('parishioners');
        Schema::dropIfExists('folders');
        Schema::dropIfExists('fg_members');
        Schema::dropIfExists('donations');
    }
};
