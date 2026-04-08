<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\State;

class MZStateSeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'country_id' => 150,
'name' => 'Cabo Delgado Province',
'iso2' => 'P'
],[
'country_id' => 150,
'name' => 'Zambezia Province',
'iso2' => 'Q'
],[
'country_id' => 150,
'name' => 'Gaza Province',
'iso2' => 'G'
],[
'country_id' => 150,
'name' => 'Inhambane Province',
'iso2' => 'I'
],[
'country_id' => 150,
'name' => 'Sofala Province',
'iso2' => 'S'
],[
'country_id' => 150,
'name' => 'Maputo Province',
'iso2' => 'L'
],[
'country_id' => 150,
'name' => 'Niassa Province',
'iso2' => 'A'
],[
'country_id' => 150,
'name' => 'Tete Province',
'iso2' => 'T'
],[
'country_id' => 150,
'name' => 'Maputo',
'iso2' => 'MPM'
],[
'country_id' => 150,
'name' => 'Nampula Province',
'iso2' => 'N'
],[
'country_id' => 150,
'name' => 'Manica Province',
'iso2' => 'B'
],
];
		foreach($jayParsedAry as $data){
			State::create($data);
		}
	}
}
