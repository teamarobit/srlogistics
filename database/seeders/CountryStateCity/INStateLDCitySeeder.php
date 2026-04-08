<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class INStateLDCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1692,
'name' => 'Kavaratti'
],[
'state_id' => 1692,
'name' => 'Lakshadweep'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
