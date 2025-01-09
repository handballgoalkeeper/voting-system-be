<?php

use App\Models\CountryModel;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create(table: CountryModel::TABLE_NAME, callback: function (Blueprint $table) {
            $table->id();
            $table->string(column: 'name', length: 255)->unique();
            $table->unsignedBigInteger(column: 'total_voters');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists(table: CountryModel::TABLE_NAME);
    }
};
