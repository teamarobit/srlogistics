<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class EEState74CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1214,
'name' => 'Kuressaare'
],[
'state_id' => 1214,
'name' => 'Liiva'
],[
'state_id' => 1214,
'name' => 'Muhu vald'
],[
'state_id' => 1214,
'name' => 'Orissaare'
],[
'state_id' => 1214,
'name' => 'Ruhnu'
],[
'state_id' => 1214,
'name' => 'Ruhnu vald'
],[
'state_id' => 1214,
'name' => 'Tehumardi'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
