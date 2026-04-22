<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use SOSEventsBV\CrownCms\Enums\UserRole;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('role')->after('remember_token')->default(UserRole::Admin);
            $table->boolean('is_active')->after('role')->default(true);
        });
    }
};
