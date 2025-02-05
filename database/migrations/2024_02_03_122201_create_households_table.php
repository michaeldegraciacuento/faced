<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('households', function (Blueprint $table) {
            $table->id();
            $table->string('region');
            $table->string('municipality');
            $table->string('province');
            $table->string('barangay');
            $table->string('district');
            $table->string('evacuation_center');
            $table->string('lastname');
            $table->string('firstname');
            $table->string('middlename')->nullable();
            $table->string('name_ext')->nullable(); // Name extension like Jr., Sr., etc.
            $table->date('birthdate');
            $table->integer('age');
            $table->string('birthplace')->nullable();
            $table->string('permanent_address');
            $table->enum('sex', ['Male', 'Female']);
            $table->string('civil_status');
            $table->string('mothers_maiden_name');
            $table->string('religion')->nullable();
            $table->string('occupation')->nullable();
            $table->decimal('monthly_family_income', 10, 2)->nullable();
            $table->string('id_card_presented')->nullable();
            $table->string('id_card_number')->nullable();
            $table->string('contact_number_primary');
            $table->string('contact_number_alternate')->nullable();
            $table->boolean('4ps_beneficiary')->nullable();
            $table->string('type_of_ethnicity')->nullable();
            $table->integer('older_person')->nullable();
            $table->integer('pregnant')->nullable();
            $table->integer('lactating')->nullable();
            $table->integer('pwds')->nullable();
            $table->string('ownership')->nullable();
            $table->string('shelter_damage_classification')->nullable();
            $table->string('signature_family_head')->nullable();
            $table->string('name_barangay_captain')->nullable();
            $table->string('signature_barangay_captain')->nullable();
            $table->date('date_registered');
            $table->string('name_of_lswdo')->nullable();
            $table->string('signature_of_lswdo')->nullable();
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by')->nullable();

            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('households');
    }
};
