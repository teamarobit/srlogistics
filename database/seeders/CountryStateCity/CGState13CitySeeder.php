<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class CGState13CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 864,
'name' => 'Ouésso'
],[
'state_id' => 864,
'name' => 'Sémbé'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
