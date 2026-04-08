<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class DZState31CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 84,
'name' => 'Aïn el Bya'
],[
'state_id' => 84,
'name' => 'Bir el Djir'
],[
'state_id' => 84,
'name' => 'Bou Tlelis'
],[
'state_id' => 84,
'name' => 'Es Senia'
],[
'state_id' => 84,
'name' => 'Mers el Kebir'
],[
'state_id' => 84,
'name' => 'Oran'
],[
'state_id' => 84,
'name' => 'Sidi ech Chahmi'
],[
'state_id' => 84,
'name' => '’Aïn el Turk'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
