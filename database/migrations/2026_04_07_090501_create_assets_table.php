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
        Schema::create('assets', function (Blueprint $table) {
            $table->bigInteger('id', true);
            $table->bigInteger('organisation_id')->nullable()->comment('FK → organisations.id');
            $table->enum('type', ['Motor Vehicle', 'Electronics', 'Others'])->nullable();
            $table->string('asset_type_name')->nullable();
            $table->string('name')->nullable();
            $table->string('asset_no')->nullable();
            $table->string('vehicle_no')->nullable();
            $table->string('make')->nullable();
            $table->string('model')->nullable();
            $table->date('rc_date')->nullable();
            $table->integer('age')->nullable();
            $table->date('warranty_start_date')->nullable();
            $table->date('warranty_end_date')->nullable();
            $table->date('issue_date')->nullable();
            $table->date('assigned_on')->nullable();
            $table->bigInteger('assigned_by')->nullable()->comment('FK → users.id');
            $table->longText('comment')->nullable();
            $table->enum('status', ['Active', 'Inactive'])->default('Active');
            $table->bigInteger('created_by')->comment('FK → users.id');
            $table->bigInteger('updated_by')->nullable()->comment('FK → users.id');
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
        Schema::dropIfExists('assets');
    }
};
