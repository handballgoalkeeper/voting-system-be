<?php

use App\Models\ElectionModel;
use App\Models\ElectionStageModel;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create(table: ElectionStageModel::TABLE, callback: function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger(column: 'election_id');
            $table->float(column: 'census')->nullable();
            $table->float(column: 'coalition_census')->nullable();
            $table->float(column: 'stage_instant_win_threshold')->nullable();
            $table->boolean(column: 'is_final')->default(false);
            $table->timestamp(column: 'starts_at');
            $table->timestamp(column: 'ends_at');
            $table->timestamps();

            $table->foreign('election_id')->references('id')->on(table: ElectionModel::TABLE);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists(table: ElectionStageModel::TABLE);
    }
};
