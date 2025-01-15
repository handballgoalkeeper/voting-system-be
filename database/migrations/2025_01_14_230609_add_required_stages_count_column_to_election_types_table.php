<?php

use App\Models\ElectionTypeModel;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table(table: ElectionTypeModel::TABLE, callback: function (Blueprint $table) {
            $table->smallInteger(column: 'required_stages_count')->after(column: 'description');
        });
    }

    public function down(): void
    {
        Schema::table(table: ElectionTypeModel::TABLE, callback: function (Blueprint $table) {
            $table->dropColumn(columns: 'required_stages_count');
        });
    }
};
