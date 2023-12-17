<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Http\Traits\commonColumnsTrait;

return new class extends Migration
{
    use commonColumnsTrait;
    public function up(): void
    {
        Schema::create('classes', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->integer('number')->unique();
            $table->timestamps();
            $table->softDeletes();
            $this->addCommonColumns($table);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('classes', function (Blueprint $table) {
            $this->dropCommonColumns($table);
            $table->softDeletes();
        });
    }
};
