<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class GAState4CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1403,
'name' => 'Fougamou'
],[
'state_id' => 1403,
'name' => 'Mbigou'
],[
'state_id' => 1403,
'name' => 'Mimongo'
],[
'state_id' => 1403,
'name' => 'Mouila'
],[
'state_id' => 1403,
'name' => 'Ndendé'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
