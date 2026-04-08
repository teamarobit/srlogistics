<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class BJStateDOCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 454,
'name' => 'Bassila'
],[
'state_id' => 454,
'name' => 'Commune of Djougou'
],[
'state_id' => 454,
'name' => 'Djougou'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
