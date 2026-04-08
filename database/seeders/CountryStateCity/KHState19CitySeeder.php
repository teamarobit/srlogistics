<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class KHState19CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 679,
'name' => 'Srŏk Srêsén'
],[
'state_id' => 679,
'name' => 'Stueng Traeng'
],[
'state_id' => 679,
'name' => 'Stung Treng'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
