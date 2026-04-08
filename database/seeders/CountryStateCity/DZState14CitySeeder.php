<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class DZState14CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 89,
'name' => 'Djebilet Rosfa'
],[
'state_id' => 89,
'name' => 'Frenda'
],[
'state_id' => 89,
'name' => 'Ksar Chellala'
],[
'state_id' => 89,
'name' => 'Mehdia daira de meghila'
],[
'state_id' => 89,
'name' => 'Sougueur'
],[
'state_id' => 89,
'name' => 'Tiaret'
],[
'state_id' => 89,
'name' => '’Aïn Deheb'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
