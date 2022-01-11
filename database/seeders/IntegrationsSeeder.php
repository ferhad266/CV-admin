<?php

namespace Database\Seeders;

use App\Models\Integration;
use Illuminate\Database\Seeder;

class IntegrationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Integration::create(
            [
                'name' => 'Google Recaptcha',
                'status' => 1,
                'config' => json_encode([
                    'version' => 'v2',
                    'secret_key' => '6Lds9n0dAAAAAFYJFr5Oo7b7P9fj3wxBJnqAdWPX',
                    'site_key' => '6Lds9n0dAAAAAB0LNAtc1qagFcQ9X8iEeeytz5NP',
                    'min_score' => '0.3'
                ])
            ]
        );
    }
}
