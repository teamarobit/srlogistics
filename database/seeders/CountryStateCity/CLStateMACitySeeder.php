<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class CLStateMACitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 782,
'name' => 'Porvenir'
],[
'state_id' => 782,
'name' => 'Antártica'
],[
'state_id' => 782,
'name' => 'Punta Arenas'
],[
'state_id' => 782,
'name' => 'Cabo de Hornos'
],[
'state_id' => 782,
'name' => 'Laguna Blanca'
],[
'state_id' => 782,
'name' => 'Natales'
],[
'state_id' => 782,
'name' => 'Primavera'
],[
'state_id' => 782,
'name' => 'Río Verde'
],[
'state_id' => 782,
'name' => 'San Gregorio'
],[
'state_id' => 782,
'name' => 'Timaukel'
],[
'state_id' => 782,
'name' => 'Torres del Paine'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
