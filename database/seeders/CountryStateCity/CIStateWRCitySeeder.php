<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class CIStateWRCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 925,
'name' => 'Bafing'
],[
'state_id' => 925,
'name' => 'Béré'
],[
'state_id' => 925,
'name' => 'Mankono'
],[
'state_id' => 925,
'name' => 'Séguéla'
],[
'state_id' => 925,
'name' => 'Touba'
],[
'state_id' => 925,
'name' => 'Worodougou'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
