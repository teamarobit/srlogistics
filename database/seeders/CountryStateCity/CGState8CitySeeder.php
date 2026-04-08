<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class CGState8CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 857,
'name' => 'Makoua'
],[
'state_id' => 857,
'name' => 'Owando'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
