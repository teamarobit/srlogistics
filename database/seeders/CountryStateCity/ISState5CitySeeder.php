<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class ISState5CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1676,
'name' => 'Akrahreppur'
],[
'state_id' => 1676,
'name' => 'Húnaþing Vestra'
],[
'state_id' => 1676,
'name' => 'Sauðárkrókur'
],[
'state_id' => 1676,
'name' => 'Skagabyggð'
],[
'state_id' => 1676,
'name' => 'Sveitarfélagið Skagafjörður'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
