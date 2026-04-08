<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class DZState38CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 116,
'name' => 'Lardjem'
],[
'state_id' => 116,
'name' => 'Tissemsilt'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
