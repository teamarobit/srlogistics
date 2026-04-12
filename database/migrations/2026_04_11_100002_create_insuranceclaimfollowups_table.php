<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('insuranceclaimfollowups', function (Blueprint $table) {
            $table->bigInteger('id', true);
            $table->bigInteger('insuranceclaim_id')->comment('FK → insuranceclaims.id');
            $table->string('event_type')->comment('e.g. Called Insurer, Email Sent, Surveyor Visit, Internal Note');
            $table->date('event_date');
            $table->text('note')->nullable();
            $table->bigInteger('created_by')->comment('FK → users.id');
            $table->bigInteger('updated_by')->nullable()->comment('FK → users.id');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('insuranceclaimfollowups');
    }
};
