<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class BFState02CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 624,
'name' => 'Banfora'
],[
'state_id' => 624,
'name' => 'Province de la Comoé'
],[
'state_id' => 624,
'name' => 'Province de la Léraba'
],[
'state_id' => 624,
'name' => 'Sindou'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
