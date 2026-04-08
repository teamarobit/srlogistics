<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class GAState5CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1397,
'name' => 'Mayumba'
],[
'state_id' => 1397,
'name' => 'Tchibanga'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
