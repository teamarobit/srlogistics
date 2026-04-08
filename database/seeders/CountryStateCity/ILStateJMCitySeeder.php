<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class ILStateJMCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1831,
'name' => 'Abū Ghaush'
],[
'state_id' => 1831,
'name' => 'Bet Shemesh'
],[
'state_id' => 1831,
'name' => 'Har Adar'
],[
'state_id' => 1831,
'name' => 'Jerusalem'
],[
'state_id' => 1831,
'name' => 'Mevasseret Ẕiyyon'
],[
'state_id' => 1831,
'name' => 'Modiin Ilit'
],[
'state_id' => 1831,
'name' => 'West Jerusalem'
],[
'state_id' => 1831,
'name' => 'Ẕur Hadassa'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
