<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class HNStateINCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1596,
'name' => 'Camasca'
],[
'state_id' => 1596,
'name' => 'Colomoncagua'
],[
'state_id' => 1596,
'name' => 'Concepción'
],[
'state_id' => 1596,
'name' => 'Dolores'
],[
'state_id' => 1596,
'name' => 'Intibucá'
],[
'state_id' => 1596,
'name' => 'Jesús de Otoro'
],[
'state_id' => 1596,
'name' => 'Jiquinlaca'
],[
'state_id' => 1596,
'name' => 'La Esperanza'
],[
'state_id' => 1596,
'name' => 'Magdalena'
],[
'state_id' => 1596,
'name' => 'Masaguara'
],[
'state_id' => 1596,
'name' => 'San Antonio'
],[
'state_id' => 1596,
'name' => 'San Francisco de Opalaca'
],[
'state_id' => 1596,
'name' => 'San Isidro'
],[
'state_id' => 1596,
'name' => 'San Juan'
],[
'state_id' => 1596,
'name' => 'San Marcos de la Sierra'
],[
'state_id' => 1596,
'name' => 'San Miguelito'
],[
'state_id' => 1596,
'name' => 'Santa Lucía'
],[
'state_id' => 1596,
'name' => 'Yamaranguila'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
