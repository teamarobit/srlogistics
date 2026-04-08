<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class EGStateASTCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1166,
'name' => 'Abnūb'
],[
'state_id' => 1166,
'name' => 'Abū Tīj'
],[
'state_id' => 1166,
'name' => 'Al Badārī'
],[
'state_id' => 1166,
'name' => 'Al Qūşīyah'
],[
'state_id' => 1166,
'name' => 'Asyūţ'
],[
'state_id' => 1166,
'name' => 'Dayrūţ'
],[
'state_id' => 1166,
'name' => 'Manfalūţ'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
