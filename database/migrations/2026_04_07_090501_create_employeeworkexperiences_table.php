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
        Schema::create('employeeworkexperiences', function (Blueprint $table) {
            $table->bigInteger('id', true);
            $table->unsignedBigInteger('contact_id')->comment('FK → contacts.id');
            $table->enum('experience_category', ['Line', 'Local'])->nullable();
            $table->string('previous_company_name')->nullable();
            $table->string('designation')->nullable();
            $table->date('employment_start_date')->nullable();
            $table->date('employment_end_date')->nullable();
            $table->longText('exit_reason')->nullable();
            $table->double('salary')->nullable()->default(0);
            $table->enum('any_legal_case', ['Yes', 'No'])->default('No');
            $table->longText('comment_about_case')->nullable();
            $table->bigInteger('city_id')->nullable()->comment('FK → cities.id');
            $table->string('police_station')->nullable();
            $table->longText('notes')->nullable();
            $table->bigInteger('created_by')->comment('FK → users.id');
            $table->bigInteger('updated_by')->nullable()->comment('FK → users.id');
            $table->timestamp('deleted_by')->nullable()->comment('FK → users.id');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employeeworkexperiences');
    }
};
