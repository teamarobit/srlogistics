<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class GHStateAFCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1445,
'name' => 'Tano South'
],[
'state_id' => 1445,
'name' => 'Tano North'
],[
'state_id' => 1445,
'name' => 'Asunafo North'
],[
'state_id' => 1445,
'name' => 'Asunafo South'
],[
'state_id' => 1445,
'name' => 'Asutifi North'
],[
'state_id' => 1445,
'name' => 'Asutifi South'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
