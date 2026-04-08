<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class ALStateDRCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 80,
'name' => 'Bashkia Durrës'
],[
'state_id' => 80,
'name' => 'Bashkia Krujë'
],[
'state_id' => 80,
'name' => 'Bashkia Shijak'
],[
'state_id' => 80,
'name' => 'Durrës'
],[
'state_id' => 80,
'name' => 'Durrës District'
],[
'state_id' => 80,
'name' => 'Fushë-Krujë'
],[
'state_id' => 80,
'name' => 'Krujë'
],[
'state_id' => 80,
'name' => 'Rrethi i Krujës'
],[
'state_id' => 80,
'name' => 'Shijak'
],[
'state_id' => 80,
'name' => 'Sukth'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
