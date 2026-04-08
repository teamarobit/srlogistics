<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class KHState11CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 671,
'name' => 'Krŏng Sênmônoŭrôm'
],[
'state_id' => 671,
'name' => 'Sen Monorom'
],[
'state_id' => 671,
'name' => 'Srŏk Kaev Seima'
],[
'state_id' => 671,
'name' => 'Srŏk Pech Chreada'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
