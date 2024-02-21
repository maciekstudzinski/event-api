<?php

use App\Models\Event;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


return new class extends Migration
{
    /**
     * Run the migrations. To attend to an event one needs to be a registered user - User one/many relationship
     */
    public function up(): void
    {
        Schema::create('atendees', function (Blueprint $table) {
            $table->id();

            $table->foreignIdFor(User::class);
            $table->foreignIdFor(Event::class);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('atendees');
    }
};
