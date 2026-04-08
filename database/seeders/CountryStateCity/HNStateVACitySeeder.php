<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class HNStateVACitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1607,
'name' => 'Agua Fría'
],[
'state_id' => 1607,
'name' => 'Alianza'
],[
'state_id' => 1607,
'name' => 'Amapala'
],[
'state_id' => 1607,
'name' => 'Aramecina'
],[
'state_id' => 1607,
'name' => 'Caridad'
],[
'state_id' => 1607,
'name' => 'El Cubolero'
],[
'state_id' => 1607,
'name' => 'El Tular'
],[
'state_id' => 1607,
'name' => 'Goascorán'
],[
'state_id' => 1607,
'name' => 'Jícaro Galán'
],[
'state_id' => 1607,
'name' => 'La Alianza'
],[
'state_id' => 1607,
'name' => 'La Criba'
],[
'state_id' => 1607,
'name' => 'Langue'
],[
'state_id' => 1607,
'name' => 'Nacaome'
],[
'state_id' => 1607,
'name' => 'San Francisco de Coray'
],[
'state_id' => 1607,
'name' => 'San Lorenzo'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
