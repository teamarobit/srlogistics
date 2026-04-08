<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\State;

class CGStateSeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'country_id' => 50,
'name' => 'Plateaux Department',
'iso2' => '14'
],[
'country_id' => 50,
'name' => 'Pointe-Noire',
'iso2' => '16'
],[
'country_id' => 50,
'name' => 'Cuvette Department',
'iso2' => '8'
],[
'country_id' => 50,
'name' => 'Likouala Department',
'iso2' => '7'
],[
'country_id' => 50,
'name' => 'Bouenza Department',
'iso2' => '11'
],[
'country_id' => 50,
'name' => 'Kouilou Department',
'iso2' => '5'
],[
'country_id' => 50,
'name' => 'Lékoumou Department',
'iso2' => '2'
],[
'country_id' => 50,
'name' => 'Cuvette-Ouest Department',
'iso2' => '15'
],[
'country_id' => 50,
'name' => 'Brazzaville',
'iso2' => 'BZV'
],[
'country_id' => 50,
'name' => 'Sangha Department',
'iso2' => '13'
],[
'country_id' => 50,
'name' => 'Niari Department',
'iso2' => '9'
],[
'country_id' => 50,
'name' => 'Pool Department',
'iso2' => '12'
],
];
		foreach($jayParsedAry as $data){
			State::create($data);
		}
	}
}
