<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class AZStateKALCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 230,
'name' => 'Kerbakhiar'
],[
'state_id' => 230,
'name' => 'Vank'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
