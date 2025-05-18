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
        Schema::create('pengajuan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rab_id')->constrained('rab')->onDelete('cascade');
            $table->date('tgl_kegiatan')->nullable();
            $table->string('proposal_file')->nullable();
            $table->enum('status_proposal', ['Pending', 'Approved', 'Rejected'])->default('Pending');
            $table->string('anggaran')->nullable();
            $table->string('lpj_file')->nullable();
            $table->enum('status_lpj', ['Pending', 'Approved', 'Rejected'])->default('Pending');
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengajuan');
    }
};
