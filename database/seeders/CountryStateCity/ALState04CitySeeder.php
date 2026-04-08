<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class ALState04CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 72,
'name' => 'Ballsh'
],[
'state_id' => 72,
'name' => 'Bashkia Divjakë'
],[
'state_id' => 72,
'name' => 'Bashkia Fier'
],[
'state_id' => 72,
'name' => 'Bashkia Mallakastër'
],[
'state_id' => 72,
'name' => 'Bashkia Patos'
],[
'state_id' => 72,
'name' => 'Divjakë'
],[
'state_id' => 72,
'name' => 'Fier'
],[
'state_id' => 72,
'name' => 'Fier-Çifçi'
],[
'state_id' => 72,
'name' => 'Lushnjë'
],[
'state_id' => 72,
'name' => 'Patos'
],[
'state_id' => 72,
'name' => 'Patos Fshat'
],[
'state_id' => 72,
'name' => 'Roskovec'
],[
'state_id' => 72,
'name' => 'Rrethi i Mallakastrës'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
