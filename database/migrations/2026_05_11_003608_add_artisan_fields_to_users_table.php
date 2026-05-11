<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {

            // rôle utilisateur
            $table->string('role')->default('artisan');

            // pending | approved | rejected
            $table->string('status')->default('pending');

            // infos personnelles
            $table->string('phone')->nullable();

            $table->string('country')->nullable();

            $table->string('city')->nullable();

            // organisation
            $table->string('organization_name')->nullable();

            $table->text('organization_description')->nullable();

            $table->integer('organization_members')->nullable();

            $table->string('organization_address')->nullable();

            $table->string('organization_website')->nullable();

            // artisan paix
            $table->string('specialization')->nullable();

            $table->text('motivation')->nullable();

            // abonnement
            $table->string('subscription_status')
                  ->default('inactive');

        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {

            $table->dropColumn([

                'role',
                'status',

                'phone',
                'country',
                'city',

                'organization_name',
                'organization_description',
                'organization_members',
                'organization_address',
                'organization_website',

                'specialization',
                'motivation',

                'subscription_status'

            ]);

        });
    }
};