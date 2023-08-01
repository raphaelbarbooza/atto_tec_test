<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\AddressState;
use App\Models\User;
use App\Repositories\AddressRepository;
use App\Repositories\ProducerRepository;
use Faker\Factory as Faker;
use Guiliredu\BrazilianCityMigrationSeed\Models\City;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Faker
        $faker = Faker::create('pt_BR');
        /**
         * Create the master admin if doesn't exists
         */
        User::firstOrCreate([
            'email' => 'demo@admin.com'
        ],[
            'password' => Hash::make('123456'),
            'name' => 'Admin User',
        ]);


        // Check if exists any city
        if(!City::first()){
            $this->call(\Guiliredu\BrazilianCityMigrationSeed\Database\Seeds\DatabaseSeeder::class);
        }

        // Prepare Repositories
        $producerRepository = new ProducerRepository();
        // Address Repository
        $addressRepository = new AddressRepository();

        /**
         * Create a bunch of producers in MT and GO
         * Only runs if we have less than 50
         */
        if($producerRepository->getTotalCount() < 50){

            for($i = 0; $i <= 50; $i++){
                $isCompany = rand(0,2); // More probably create a company off a person

                // Generate a Social Number
                if($isCompany)
                    $socialNumber = $this->generateColletiveSocialNumber();
                else
                    $socialNumber = $this->generateIndividualSocialNumber();

                // Faker Name
                if($isCompany){
                    $companyName = join(' ',[$faker->company]);
                    $tradingName = explode(' ',$companyName)[0];
                }else{
                    $companyName = join(' ',[$faker->firstName,$faker->lastName]);
                    $tradingName = "Grupo ".explode(' ',$companyName)[0];
                }

                // State Registration (Without Validation)
                $stateRegistration = str_pad(rand(100000000,9999999999),'10','0',STR_PAD_LEFT)."-".rand(0,9);

                // Generated Phone
                $fakerDDD = [
                    '66',
                    '65',
                    '61'
                ];
                $fakePhonePre = [
                    '98114',
                    '99932',
                    '99665',
                    '99200',
                    '98155',
                    '99976'
                ];
                $phone = "(".$fakerDDD[rand(0,2)].") ".$fakePhonePre[rand(0,5)]."-".rand(1111,9999);

                // Get a random city from GO or MT
                if(rand(0,4))
                    $cities = $addressRepository->getStatesCitiesByStateLetter('MT');
                else
                    $cities = $addressRepository->getStatesCitiesByStateLetter('GO');

                $cityId = $cities[rand(0,count($cities) - 1)]['id'];

                // Create this Producer
                $producerRepository->create(
                    companyName: $companyName,
                    tradingName: $tradingName,
                    socialNumber: $socialNumber,
                    stateRegistration: $stateRegistration,
                    phone: $phone,
                    cityId: $cityId
                );

            }

        }

    }

    protected function generateColletiveSocialNumber() {
        $n1 = rand(0, 9);
        $n2 = rand(0, 9);
        $n3 = rand(0, 9);
        $n4 = rand(0, 9);
        $n5 = rand(0, 9);
        $n6 = rand(0, 9);
        $n7 = rand(0, 9);
        $n8 = rand(0, 9);
        $n9 = 0;
        $n10 = 0;
        $n11 = 0;
        $n12 = 1;
        $d1 = $n12 * 2 + $n11 * 3 + $n10 * 4 + $n9 * 5 + $n8 * 6 + $n7 * 7 + $n6 * 8 + $n5 * 9 + $n4 * 2 + $n3 * 3 + $n2 * 4 + $n1 * 5;
        $d1 = 11 - ($this->mod($d1, 11) );
        if ($d1 >= 10) {
            $d1 = 0;
        }
        $d2 = $d1 * 2 + $n12 * 3 + $n11 * 4 + $n10 * 5 + $n9 * 6 + $n8 * 7 + $n7 * 8 + $n6 * 9 + $n5 * 2 + $n4 * 3 + $n3 * 4 + $n2 * 5 + $n1 * 6;
        $d2 = 11 - ($this->mod($d2, 11) );
        if ($d2 >= 10) {
            $d2 = 0;
        }

        return '' . $n1 . $n2 . $n3 . $n4 . $n5 . $n6 . $n7 . $n8 . $n9 . $n10 . $n11 . $n12 . $d1 . $d2;
    }

    protected function generateIndividualSocialNumber() {
        $n1 = rand(0, 9);
        $n2 = rand(0, 9);
        $n3 = rand(0, 9);
        $n4 = rand(0, 9);
        $n5 = rand(0, 9);
        $n6 = rand(0, 9);
        $n7 = rand(0, 9);
        $n8 = rand(0, 9);
        $n9 = rand(0, 9);
        $d1 = $n9 * 2 + $n8 * 3 + $n7 * 4 + $n6 * 5 + $n5 * 6 + $n4 * 7 + $n3 * 8 + $n2 * 9 + $n1 * 10;
        $d1 = 11 - ($this->mod($d1, 11) );
        if ($d1 >= 10) {
            $d1 = 0;
        }
        $d2 = $d1 * 2 + $n9 * 3 + $n8 * 4 + $n7 * 5 + $n6 * 6 + $n5 * 7 + $n4 * 8 + $n3 * 9 + $n2 * 10 + $n1 * 11;
        $d2 = 11 - ($this->mod($d2, 11) );
        if ($d2 >= 10) {
            $d2 = 0;
        }
        return '' . $n1 . $n2 . $n3 . $n4 . $n5 . $n6 . $n7 . $n8 . $n9 . $d1 . $d2;
    }

    private function mod($dividend, $divisor) {
        return round($dividend - (floor($dividend / $divisor) * $divisor));
    }
}
