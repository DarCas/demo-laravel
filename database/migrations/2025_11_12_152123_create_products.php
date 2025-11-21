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
        Schema::create('products', function (Blueprint $table) {
            $table->id();

            $table->string('name', 150)
                ->index('name');

            $table->text('description');

            $table->decimal('price', 10, 2)
                ->index('price')
                ->default(0.00);

            $table->smallInteger('qty')
                ->unsigned()
                ->index('qty')
                ->default(0);

            $table->boolean('active')
                ->index('active')
                ->default(true);

            $table->dateTime('created_at')
                ->index('created_at');

            $table->dateTime('updated_at')
                ->index('updated_at')
                ->default(null);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
