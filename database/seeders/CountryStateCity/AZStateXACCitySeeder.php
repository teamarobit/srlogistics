<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class AZStateXACCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 295,
'name' => 'Xaçmaz'
],[
'state_id' => 295,
'name' => 'Xudat'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
