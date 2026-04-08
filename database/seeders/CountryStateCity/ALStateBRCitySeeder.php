<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class ALStateBRCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 70,
'name' => 'Banaj'
],[
'state_id' => 70,
'name' => 'Bashkia Berat'
],[
'state_id' => 70,
'name' => 'Bashkia Kuçovë'
],[
'state_id' => 70,
'name' => 'Bashkia Poliçan'
],[
'state_id' => 70,
'name' => 'Bashkia Skrapar'
],[
'state_id' => 70,
'name' => 'Berat'
],[
'state_id' => 70,
'name' => 'Kuçovë'
],[
'state_id' => 70,
'name' => 'Poliçan'
],[
'state_id' => 70,
'name' => 'Rrethi i Beratit'
],[
'state_id' => 70,
'name' => 'Rrethi i Kuçovës'
],[
'state_id' => 70,
'name' => 'Rrethi i Skraparit'
],[
'state_id' => 70,
'name' => 'Ura Vajgurore'
],[
'state_id' => 70,
'name' => 'Çorovodë'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
