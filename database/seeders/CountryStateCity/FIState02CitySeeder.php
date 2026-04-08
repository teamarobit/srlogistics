<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class FIState02CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1257,
'name' => 'Imatra'
],[
'state_id' => 1257,
'name' => 'Joutseno'
],[
'state_id' => 1257,
'name' => 'Lappeenranta'
],[
'state_id' => 1257,
'name' => 'Lemi'
],[
'state_id' => 1257,
'name' => 'Luumäki'
],[
'state_id' => 1257,
'name' => 'Nuijamaa'
],[
'state_id' => 1257,
'name' => 'Parikkala'
],[
'state_id' => 1257,
'name' => 'Rautjärvi'
],[
'state_id' => 1257,
'name' => 'Ruokolahti'
],[
'state_id' => 1257,
'name' => 'Saari'
],[
'state_id' => 1257,
'name' => 'Savitaipale'
],[
'state_id' => 1257,
'name' => 'Taipalsaari'
],[
'state_id' => 1257,
'name' => 'Ylämaa'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
