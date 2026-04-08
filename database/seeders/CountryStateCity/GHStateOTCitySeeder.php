<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class GHStateOTCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1453,
'name' => 'Biakoye'
],[
'state_id' => 1453,
'name' => 'Jasikan'
],[
'state_id' => 1453,
'name' => 'Kadjebi'
],[
'state_id' => 1453,
'name' => 'Krachi East'
],[
'state_id' => 1453,
'name' => 'Krachi Nchumuru'
],[
'state_id' => 1453,
'name' => 'Krachi West'
],[
'state_id' => 1453,
'name' => 'Nkwanta North'
],[
'state_id' => 1453,
'name' => 'Nkwanta South'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
