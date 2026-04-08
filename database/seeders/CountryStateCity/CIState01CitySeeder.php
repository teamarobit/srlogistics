<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class CIState01CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 914,
'name' => 'Adzopé'
],[
'state_id' => 914,
'name' => 'Affery'
],[
'state_id' => 914,
'name' => 'Agboville'
],[
'state_id' => 914,
'name' => 'Agnéby-Tiassa'
],[
'state_id' => 914,
'name' => 'Akoupé'
],[
'state_id' => 914,
'name' => 'Dabou'
],[
'state_id' => 914,
'name' => 'Grand-Lahou'
],[
'state_id' => 914,
'name' => 'Grands-Ponts'
],[
'state_id' => 914,
'name' => 'Tiassalé'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
