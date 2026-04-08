<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class CGState16CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 856,
'name' => 'Loandjili'
],[
'state_id' => 856,
'name' => 'Pointe-Noire'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
