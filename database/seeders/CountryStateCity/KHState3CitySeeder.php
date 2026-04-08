<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class KHState3CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 677,
'name' => 'Cheung Prey'
],[
'state_id' => 677,
'name' => 'Kampong Cham'
],[
'state_id' => 677,
'name' => 'Srŏk Bathéay'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
