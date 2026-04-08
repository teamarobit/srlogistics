<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class ALState12CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 75,
'name' => 'Bashkia Finiq'
],[
'state_id' => 75,
'name' => 'Bashkia Himarë'
],[
'state_id' => 75,
'name' => 'Bashkia Konispol'
],[
'state_id' => 75,
'name' => 'Bashkia Selenicë'
],[
'state_id' => 75,
'name' => 'Bashkia Vlorë'
],[
'state_id' => 75,
'name' => 'Delvinë'
],[
'state_id' => 75,
'name' => 'Himarë'
],[
'state_id' => 75,
'name' => 'Konispol'
],[
'state_id' => 75,
'name' => 'Ksamil'
],[
'state_id' => 75,
'name' => 'Orikum'
],[
'state_id' => 75,
'name' => 'Rrethi i Delvinës'
],[
'state_id' => 75,
'name' => 'Sarandë'
],[
'state_id' => 75,
'name' => 'Selenicë'
],[
'state_id' => 75,
'name' => 'Vlorë'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
