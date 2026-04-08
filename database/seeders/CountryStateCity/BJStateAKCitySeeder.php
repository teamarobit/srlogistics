<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class BJStateAKCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 458,
'name' => 'Guilmaro'
],[
'state_id' => 458,
'name' => 'Natitingou'
],[
'state_id' => 458,
'name' => 'Tanguieta'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
