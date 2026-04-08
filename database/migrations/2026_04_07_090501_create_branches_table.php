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
        Schema::create('branches', function (Blueprint $table) {
            $table->bigInteger('id', true);
            $table->bigInteger('organisation_id')->nullable()->comment('FK → organisations.id');
            $table->string('location');
            $table->text('type');
            $table->date('start_date')->nullable();
            $table->string('code')->nullable();
            $table->string('head_name')->nullable();
            $table->string('ph_prefix', 10)->nullable();
            $table->string('phone', 50)->nullable();
            $table->integer('no_of_employee')->default(0);
            $table->text('address')->nullable();
            $table->unsignedBigInteger('state_id')->nullable()->comment('FK → states.id');
            $table->unsignedBigInteger('city_id')->comment('FK → cities.id');
            $table->string('postal_code', 20)->nullable();
            $table->enum('branch_ownership', ['Owned', 'Rental'])->default('Owned');
            $table->string('branch_owner_name')->nullable();
            $table->string('branch_owner_phone_code', 10)->nullable();
            $table->string('branch_owner_phone', 50)->nullable();
            $table->decimal('rent_amount', 10)->default(0);
            $table->date('rent_due_date')->nullable();
            $table->string('electricity_service_provider')->nullable();
            $table->string('electricity_consumer_number')->nullable();
            $table->longText('notes')->nullable();
            $table->enum('status', ['Active', 'Inactive'])->default('Active');
            $table->unsignedBigInteger('created_by')->comment('FK → users.id');
            $table->unsignedBigInteger('updated_by')->nullable()->comment('FK → users.id');
            $table->unsignedBigInteger('deleted_by')->nullable()->comment('FK → users.id');
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
        Schema::dropIfExists('branches');
    }
};
