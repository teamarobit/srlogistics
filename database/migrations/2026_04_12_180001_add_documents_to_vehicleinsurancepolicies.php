<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Add policy_document + document_original_name columns to
 * vehicleinsurancepolicies table to support PDF/image attachments.
 *
 * Run: php artisan migrate
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('vehicleinsurancepolicies', function (Blueprint $table) {
            $table->string('policy_document')->nullable()->after('notes')
                  ->comment('Stored filename in public/media/insurance_policies/');
            $table->string('policy_document_name')->nullable()->after('policy_document')
                  ->comment('Original upload filename shown to user');
        });
    }

    public function down(): void
    {
        Schema::table('vehicleinsurancepolicies', function (Blueprint $table) {
            $table->dropColumn(['policy_document', 'policy_document_name']);
        });
    }
};
