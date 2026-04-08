<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class KHState8CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 669,
'name' => 'Krŏng Ta Khmau'
],[
'state_id' => 669,
'name' => 'Srŏk Khsăch Kândal'
],[
'state_id' => 669,
'name' => 'Ta Khmau'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
