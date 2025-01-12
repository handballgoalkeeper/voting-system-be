<?php

use App\Models\CountryModel;
use App\Models\ElectionModel;
use App\Models\ElectionTypeModel;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create(table: ElectionModel::TABLE, callback: function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger(column: 'country_id');
            $table->unsignedBigInteger(column: 'election_type_id');
            $table->boolean(column: 'is_published')->default(false);
            $table->timestamp(column: 'published_at')->nullable();
            $table->timestamps();

            $table->foreign(columns: 'country_id')->references('id')->on(table: CountryModel::TABLE);
            $table->foreign(columns: 'election_type_id')->references('id')->on(table: ElectionTypeModel::TABLE);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists(table: ElectionModel::TABLE);
    }
};
