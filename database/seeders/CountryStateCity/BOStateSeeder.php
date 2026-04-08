<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\State;

class BOStateSeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'country_id' => 27,
'name' => 'Beni Department',
'iso2' => 'B'
],[
'country_id' => 27,
'name' => 'Oruro Department',
'iso2' => 'O'
],[
'country_id' => 27,
'name' => 'Santa Cruz Department',
'iso2' => 'S'
],[
'country_id' => 27,
'name' => 'Tarija Department',
'iso2' => 'T'
],[
'country_id' => 27,
'name' => 'Pando Department',
'iso2' => 'N'
],[
'country_id' => 27,
'name' => 'La Paz Department',
'iso2' => 'L'
],[
'country_id' => 27,
'name' => 'Cochabamba Department',
'iso2' => 'C'
],[
'country_id' => 27,
'name' => 'Chuquisaca Department',
'iso2' => 'H'
],[
'country_id' => 27,
'name' => 'Potosí Department',
'iso2' => 'P'
],
];
		foreach($jayParsedAry as $data){
			State::create($data);
		}
	}
}
