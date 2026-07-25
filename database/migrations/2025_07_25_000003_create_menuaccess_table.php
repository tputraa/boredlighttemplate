<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('menuaccess', function (Blueprint $table) {
            $table->unsignedBigInteger('user_group_id');
            $table->unsignedBigInteger('menucode');
            $table->integer('fview')->default(0);
            $table->integer('fadd')->default(0);
            $table->integer('fedit')->default(0);
            $table->integer('fdelete')->default(0);
            $table->timestamps();

            $table->primary(['user_group_id', 'menucode']);

            $table->foreign('menucode')
                ->references('menucode')
                ->on('mstmenu')
                ->onDelete('cascade');

            $table->foreign('user_group_id')
                ->references('roleid')
                ->on('user_group')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('menuaccess');
    }
};
