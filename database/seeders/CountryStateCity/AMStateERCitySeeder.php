<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class AMStateERCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 202,
'name' => 'Arabkir'
],[
'state_id' => 202,
'name' => 'Argavand'
],[
'state_id' => 202,
'name' => 'Jrashen'
],[
'state_id' => 202,
'name' => 'K’anak’erravan'
],[
'state_id' => 202,
'name' => 'Vardadzor'
],[
'state_id' => 202,
'name' => 'Yerevan'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
