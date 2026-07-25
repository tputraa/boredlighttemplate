<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mstmenu', function (Blueprint $table) {
            $table->id('menucode');
            $table->string('menuname', 255);
            $table->integer('menuparent')->default(0)->index();
            $table->integer('is_active')->default(1);
            $table->integer('idx')->default(0);
            $table->string('menutype', 50)->nullable();
            $table->string('menulink', 255)->nullable();
            $table->text('icon')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mstmenu');
    }
};
