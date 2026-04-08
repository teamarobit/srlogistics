<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class GWStateOICitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1568,
'name' => 'Bissorã'
],[
'state_id' => 1568,
'name' => 'Farim'
],[
'state_id' => 1568,
'name' => 'Mansôa'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
