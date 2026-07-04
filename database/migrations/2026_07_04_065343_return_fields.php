<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('borrowings', function (Blueprint $table) {
            $table->date('due_date')->nullable()->after('borrow_date');
            $table->string('return_condition')->nullable()->after('return_date');
            $table->text('return_note')->nullable()->after('return_condition');
        });
    }

    public function down(): void
    {
        Schema::table('borrowings', function (Blueprint $table) {
            $table->dropColumn([
                'due_date',
                'return_condition',
                'return_note',
            ]);
        });
    }
};
