<?php

use App\Models\RefreshTokenModel;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create(table: RefreshTokenModel::TABLE, callback: function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->text('refresh_token');
            $table->timestamp('issued_at');
            $table->timestamp('expires_at');
            $table->boolean('is_revoked')->default(false);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists(table: RefreshTokenModel::TABLE);
    }
};
