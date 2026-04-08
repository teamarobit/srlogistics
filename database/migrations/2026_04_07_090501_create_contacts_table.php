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
        Schema::create('contacts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('organisation_id')->nullable()->comment('FK → organisations.id'); 
            $table->string('contactno')->unique();
            $table->string('contact_name');
            $table->unsignedBigInteger('cotype_id'); 
            $table->string('contact_code')->nullable();
            $table->string('alias')->nullable();
            $table->string('ph_prefix', 10)->nullable();
            $table->string('phone', 50)->nullable();
            $table->string('whatsapp_prefix', 10)->nullable();
            $table->string('whatsapp', 50)->nullable();
            $table->string('email')->nullable();
            $table->enum('gender', ['Male', 'Female', 'Other'])->nullable();
            $table->date('dob')->nullable();
            $table->date('doj')->nullable();
            $table->enum('size', ['Small', 'Medium', 'Large'])->nullable();
            
            $table->longText('comment')->nullable();
            $table->string('company_name')->nullable();
            $table->string('full_company_name')->nullable();
            $table->unsignedBigInteger('vehicle_ownership_type_id')->nullable()->comment('FK → vehicleownerships.id'); 
            $table->string('company_owner')->nullable();
            $table->string('company_registration_no')->nullable();
            $table->date('company_registration_date')->nullable(); 
            $table->date('working_since')->nullable();
            $table->string('pan_no')->nullable();
            $table->unsignedBigInteger('pan_status_id')->nullable()->comment('FK → panstatuses.id'); 
            $table->enum('gst_treatment', ['Registered', 'Unregistered'])->nullable();
            $table->string('gst_number')->nullable();
            $table->string('tds_percentage')->nullable();
            $table->longText('additional_info')->nullable();
            $table->text('head_office_map_location')->nullable();
            $table->tinyInteger('is_deduction_chargeable')->default(0);
            $table->double('halting_charges_per_day', 20, 5)->default(0.00000);
            
            
            $table->unsignedBigInteger('gsttreat_id')->nullable();
            $table->string('gstin')->nullable();
            $table->string('pan')->nullable();
            $table->unsignedBigInteger('country_id')->nullable();
            $table->unsignedBigInteger('state_id')->nullable();
            $table->unsignedBigInteger('city_id')->nullable();
            $table->string('company_address')->nullable();
            $table->longText('activity_note')->nullable();
            $table->string('address1')->nullable();
            $table->string('address2')->nullable();
            $table->string('zipcode', 20)->nullable();
            $table->string('contact_image')->nullable();
            $table->unsignedBigInteger('religion_id')->nullable()->comment('FK → religions.id');
            $table->longText('skillset_ids')->nullable()->comment('FK → skillsets.id');
            $table->enum('blood_group', ['A+','A-','B+','B-','AB+','AB-','O+','O-'])->nullable();
            $table->string('reference_by', 255)->nullable();
            $table->enum('work_type', ['Office Work', 'Service Center'])->nullable();
            
            $table->unsignedBigInteger('office_branch_id')->nullable()->comment('FK → branches.id'); 
            $table->unsignedBigInteger('office_department_id')->nullable()->comment('FK → departments.id'); 
            $table->unsignedBigInteger('office_designation_id')->nullable()->comment('FK → designations.id');
            $table->unsignedBigInteger('office_jobrank_id')->nullable()->comment('FK → jobranks.id');
            
            $table->unsignedBigInteger('service_center_branch_id')->nullable()->comment('FK → branches.id'); 
            $table->unsignedBigInteger('service_center_department_id')->nullable()->comment('FK → departments.id'); 
            $table->unsignedBigInteger('service_center_designation_id')->nullable()->comment('FK → designations.id');
            $table->unsignedBigInteger('service_center_jobrank_id')->nullable()->comment('FK → jobranks.id');
            
            
            $table->enum('service_type', ['Administrative', 'Technical'])->nullable();
            
            
            $table->enum('tracking_group', ['Tracking A', 'Tracking B'])->nullable();
            $table->enum('provident_fund_registered', ['Yes', 'No'])->nullable();
            
            $table->enum('status', ['Active', 'Inactive', 'Blacklisted'])->default('Active'); 
            $table->enum('rag_status', ['Red', 'Yellow', 'Green'])->nullable();
            $table->enum('joining_letter_seen_status', ['Yes', 'No'])->default('No'); 
            $table->enum('exit_letter_seen_status', ['Yes', 'No'])->default('No'); 
            
            $table->longText('blacklist_reason')->nullable();
            $table->string('provident_fund_no')->nullable();
            $table->integer('no_of_vehicles')->nullable();
            
            
            $table->unsignedBigInteger('created_by')->nullable()->comment('FK → users.id'); 
            $table->unsignedBigInteger('updated_by')->nullable()->comment('FK → users.id'); 
            $table->unsignedBigInteger('deleted_by')->nullable()->comment('FK → users.id'); 
            
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable()->useCurrentOnUpdate();
            $table->timestamp('blacklisted_at')->nullable();
            
            $table->softDeletes(); // deleted_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contacts');
    }
};
