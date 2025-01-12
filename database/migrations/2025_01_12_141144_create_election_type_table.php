<?php

use App\Models\CountryModel;
use App\Models\ElectionTypeModel;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create(table: ElectionTypeModel::TABLE, callback: function (Blueprint $table) {
            // Columns
            $table->id();
            $table->string(column: 'name', length: 255);
            $table->text(column: 'description')->nullable();
            $table->unsignedBigInteger(column: 'country_id');
            $table->timestamps();

            // Foreign keys
            $table->foreign(columns: 'country_id')->references(columns: 'id')->on(table: CountryModel::TABLE);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists(table: ElectionTypeModel::TABLE);
    }
};
