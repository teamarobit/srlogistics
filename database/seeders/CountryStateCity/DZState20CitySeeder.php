<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class DZState20CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 106,
'name' => 'Saïda'
],[
'state_id' => 106,
'name' => '’Aïn el Hadjar'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
