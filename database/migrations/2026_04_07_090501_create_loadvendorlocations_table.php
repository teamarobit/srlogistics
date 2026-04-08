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
        Schema::create('loadvendorlocations', function (Blueprint $table) {
            $table->bigInteger('id', true);
            $table->unsignedBigInteger('contact_id')->comment('FK → contacts.id');
            $table->string('company_name');
            $table->enum('company_role', ['Consignor', 'Consignee'])->nullable();
            $table->enum('route_type', ['Source', 'Destination', 'Midpoint'])->nullable();
            $table->string('location_name');
            $table->enum('location_type', ['Loading', 'Unloading', 'Both'])->default('Loading');
            $table->enum('loading_charge_type', ['Fixed', 'Variable'])->nullable();
            $table->double('loading_charge')->default(0);
            $table->enum('unloading_charge_type', ['Fixed', 'Variable'])->nullable();
            $table->double('unloading_charge')->default(0);
            $table->longText('address')->nullable();
            $table->unsignedBigInteger('source_city_id')->nullable()->comment('FK → cities.id');
            $table->unsignedBigInteger('destination_city_id')->nullable()->comment('FK → cities.id');
            $table->unsignedBigInteger('midpoint_city_id')->nullable()->comment('FK → cities.id');
            $table->string('zipcode', 20)->nullable();
            $table->enum('charges_paid_by', ['Load Vendor', 'SRL', 'Mixed'])->nullable();
            $table->double('capping_amount')->default(0);
            $table->string('onsite_contact_person')->nullable();
            $table->string('onsite_contact_person_phone_code', 10)->nullable();
            $table->string('onsite_contact_person_phone')->nullable();
            $table->string('onsite_contact_person_whatsapp_code', 10)->nullable();
            $table->string('onsite_contact_person_whatsapp')->nullable();
            $table->longText('map_location')->nullable();
            $table->longText('additional_info')->nullable();
            $table->unsignedBigInteger('created_by')->nullable()->comment('FK → users.id');
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
        Schema::dropIfExists('loadvendorlocations');
    }
};
