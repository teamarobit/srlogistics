<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class ISState2CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1671,
'name' => 'Garður'
],[
'state_id' => 1671,
'name' => 'Grindavík'
],[
'state_id' => 1671,
'name' => 'Keflavík'
],[
'state_id' => 1671,
'name' => 'Reykjanesbær'
],[
'state_id' => 1671,
'name' => 'Sandgerði'
],[
'state_id' => 1671,
'name' => 'Vogar'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
