<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class GEStateRLCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1422,
'name' => 'Ambrolauri'
],[
'state_id' => 1422,
'name' => 'Ambrolauris Munitsip’alit’et’i'
],[
'state_id' => 1422,
'name' => 'Lent’ekhi'
],[
'state_id' => 1422,
'name' => 'Oni'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
