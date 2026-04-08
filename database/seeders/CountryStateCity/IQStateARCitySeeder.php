<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class IQStateARCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1794,
'name' => 'Arbil'
],[
'state_id' => 1794,
'name' => 'Erbil'
],[
'state_id' => 1794,
'name' => 'Koysinceq'
],[
'state_id' => 1794,
'name' => 'Ruwāndiz'
],[
'state_id' => 1794,
'name' => 'Shaqlāwah'
],[
'state_id' => 1794,
'name' => 'Soran'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
