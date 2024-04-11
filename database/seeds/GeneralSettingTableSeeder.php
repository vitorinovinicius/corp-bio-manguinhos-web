<?php

use Illuminate\Database\Seeder;
    use Webpatser\Uuid\Uuid;

    class GeneralSettingTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('general_settings')->insert([
            [
                'uuid' => Uuid::generate(),
                's3_key' => 'AKIAYIIPK6JHOW3JWXXU',
                's3_secret' => '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',
                's3_region' => 'sa-east-1',
                's3_bucket' => 'centralsystem2',
                's3_path' => 'centralmob/trial_staging/',
                'google_maps_key' => 'AIzaSyBKUHlVh1gJHr6Ni2mmBoY7FC83nNR3B60',
                'zenvia_account' => 'systemaut.smsonline',
                'zenvia_password' => '0H8pOUwHGg',
                'zenvia_from' => 'Bio-Manguinhos',
                'bitly_access_token' => '361fb5a0dc57e7a1912a5e64d49860b1b258114d',
                'redirect' => 'http://cs6.co/th/',
                'dynamodb_key' => 'AKIAJFSFBYP2L26XTSRA',
                'dynamodb_secret' => '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',
                'dynamodb_region' => 'us-west-2',
                'dynamodb_local_endpoint' => 'arn:aws:dynamodb:us-west-2:652723540430:table/trial_occurrences',
            ]
        ]);
    }
}
