<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class BDState54CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 408,
'name' => 'Bera'
],[
'state_id' => 408,
'name' => 'Bogra'
],[
'state_id' => 408,
'name' => 'Chapai Nababganj'
],[
'state_id' => 408,
'name' => 'Ishurdi'
],[
'state_id' => 408,
'name' => 'Joypur Hāt'
],[
'state_id' => 408,
'name' => 'Joypurhat'
],[
'state_id' => 408,
'name' => 'Mahasthangarh'
],[
'state_id' => 408,
'name' => 'Naogaon'
],[
'state_id' => 408,
'name' => 'Natore'
],[
'state_id' => 408,
'name' => 'Nawābganj'
],[
'state_id' => 408,
'name' => 'Pabna'
],[
'state_id' => 408,
'name' => 'Puthia'
],[
'state_id' => 408,
'name' => 'Pār Naogaon'
],[
'state_id' => 408,
'name' => 'Rajshahi'
],[
'state_id' => 408,
'name' => 'Saidpur'
],[
'state_id' => 408,
'name' => 'Shibganj'
],[
'state_id' => 408,
'name' => 'Shāhzādpur'
],[
'state_id' => 408,
'name' => 'Sirajganj'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
