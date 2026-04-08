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
        Schema::create('contractpricinglogs', function (Blueprint $table) {
            $table->bigInteger('id', true);
            $table->unsignedBigInteger('contractpricing_id')->comment('FK → contractpricings.id');
            $table->unsignedBigInteger('contact_id')->comment('FK → contacts.id');
            $table->unsignedBigInteger('customercontract_id')->comment('FK → customercontracts.id');
            $table->unsignedBigInteger('customercontract_route_id')->comment('FK → contractroutes.id');
            $table->date('applicable_start_date')->nullable();
            $table->date('applicable_end_date')->nullable();
            $table->date('retrospective_start_date')->nullable();
            $table->date('retrospective_end_date')->nullable();
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
        Schema::dropIfExists('contractpricinglogs');
    }
};
