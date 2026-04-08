<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class AOStateBIECitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 146,
'name' => 'Camacupa'
],[
'state_id' => 146,
'name' => 'Catabola'
],[
'state_id' => 146,
'name' => 'Chissamba'
],[
'state_id' => 146,
'name' => 'Cuito'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
