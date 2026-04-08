<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class BGState05CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 559,
'name' => 'Belogradchik'
],[
'state_id' => 559,
'name' => 'Boynitsa'
],[
'state_id' => 559,
'name' => 'Bregovo'
],[
'state_id' => 559,
'name' => 'Chuprene'
],[
'state_id' => 559,
'name' => 'Dimovo'
],[
'state_id' => 559,
'name' => 'Drenovets'
],[
'state_id' => 559,
'name' => 'Dunavtsi'
],[
'state_id' => 559,
'name' => 'Gramada'
],[
'state_id' => 559,
'name' => 'Kula'
],[
'state_id' => 559,
'name' => 'Makresh'
],[
'state_id' => 559,
'name' => 'Novo Selo'
],[
'state_id' => 559,
'name' => 'Obshtina Belogradchik'
],[
'state_id' => 559,
'name' => 'Obshtina Boynitsa'
],[
'state_id' => 559,
'name' => 'Obshtina Dimovo'
],[
'state_id' => 559,
'name' => 'Obshtina Gramada'
],[
'state_id' => 559,
'name' => 'Obshtina Kula'
],[
'state_id' => 559,
'name' => 'Obshtina Ruzhintsi'
],[
'state_id' => 559,
'name' => 'Obshtina Vidin'
],[
'state_id' => 559,
'name' => 'Ruzhintsi'
],[
'state_id' => 559,
'name' => 'Vidin'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
