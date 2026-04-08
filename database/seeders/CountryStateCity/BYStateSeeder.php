<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\State;

class BYStateSeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'country_id' => 21,
'name' => 'Mogilev Region',
'iso2' => 'MA'
],[
'country_id' => 21,
'name' => 'Gomel Region',
'iso2' => 'HO'
],[
'country_id' => 21,
'name' => 'Grodno Region',
'iso2' => 'HR'
],[
'country_id' => 21,
'name' => 'Minsk Region',
'iso2' => 'MI'
],[
'country_id' => 21,
'name' => 'Minsk',
'iso2' => 'HM'
],[
'country_id' => 21,
'name' => 'Brest Region',
'iso2' => 'BR'
],[
'country_id' => 21,
'name' => 'Vitebsk Region',
'iso2' => 'VI'
],
];
		foreach($jayParsedAry as $data){
			State::create($data);
		}
	}
}
