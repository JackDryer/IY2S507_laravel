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
        Schema::create('devices', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string("name")->unique();
            $table->integer("ram_bytes");
            $table->integer("storage_bytes");
            $table->foreignId("cpu_id")->constrained()->onDelete("cascade");
            $table->foreignId("brand_id")->constrained()->onDelete("cascade");
            $table->foreignID("product_type_id")->constrained()->onDelete("cascade");
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('devices');
    }
};
