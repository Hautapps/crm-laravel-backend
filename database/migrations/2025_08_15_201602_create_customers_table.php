<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void {
        Schema::create('customers', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->string('email')->unique();
            $table->softDeletes(); // adds deleted_at
            $table->timestamps();
        });
        DB::statement('
            ALTER TABLE customers 
            ADD COLUMN search_vector tsvector
                GENERATED ALWAYS AS (
                    to_tsvector(\'english\', coalesce(name, \'\') || \' \' || coalesce(email, \'\'))
                ) STORED;
        ');

        DB::statement('CREATE INDEX customers_search_vector_index ON customers USING GIN (search_vector);');
    }

    public function down(): void {
        Schema::dropIfExists('customers');
    }
};

