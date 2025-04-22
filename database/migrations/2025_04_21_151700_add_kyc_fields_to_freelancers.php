<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('freelancers', function (Blueprint $table) {
            $table->string('government_id_path');
            $table->string('address_proof_path');
            $table->string('biometric_photo_path');
            $table->string('signature_data');
            $table->boolean('kyc_verified')->default(false);
            $table->timestamp('kyc_verified_at')->nullable();
        });
    }

    public function down()
    {
        Schema::table('freelancers', function (Blueprint $table) {
            $table->dropColumn([
                'government_id_path',
                'address_proof_path',
                'biometric_photo_path',
                'signature_data',
                'kyc_verified',
                'kyc_verified_at'
            ]);
        });
    }
};