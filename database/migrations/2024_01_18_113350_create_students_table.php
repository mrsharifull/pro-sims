<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Http\Traits\commonColumnsTrait;

return new class extends Migration
{
    use CommonColumnsTrait;
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('class_id');
            $table->unsignedBigInteger('section_id');
            $table->unsignedBigInteger('ad_id');
            $table->unsignedBigInteger('bg_id');
            $table->string('name');
            $table->string('father_name');
            $table->string('mother_name');
            $table->string('roll')->unique();
            $table->string('registration')->nullable();
            $table->string('image')->nullable();
            $table->longText('address');
            $table->date('date_of_birth');
            $table->string('number');
            $table->string('parents_number');
            $table->string('age');
            $table->enum('gender',['male','famel','other']);
            $table->boolean('status')->default(1);
            $table->timestamps();
            $table->softDeletes();
            $this->addCommonColumns($table);


            $table->foreign('class_id')->references('id')->on('classes')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('section_id')->references('id')->on('sections')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('ad_id')->references('id')->on('academic_divisions')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('bg_id')->references('id')->on('bloodgroups')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('students', function (Blueprint $table) {
            $table->softDeletes();
            $this->dropCommonColumns($table);
        });
    }
};
