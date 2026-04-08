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
        Schema::create('skillsets', function (Blueprint $table) {
            $table->bigInteger('id', true);
            $table->bigInteger('organisation_id')->nullable()->comment('FK → organisations.id');
            $table->string('name');
            $table->longText('pre_requisite_notes')->nullable();
            $table->enum('status', ['Active', 'Inactive'])->default('Active');
            $table->unsignedBigInteger('created_by')->comment('FK → users.id');
            $table->unsignedBigInteger('updated_by')->nullable()->comment('FK → users.id');
            $table->bigInteger('deleted_by')->nullable()->comment('FK → users.id');
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
        Schema::dropIfExists('skillsets');
    }
};
