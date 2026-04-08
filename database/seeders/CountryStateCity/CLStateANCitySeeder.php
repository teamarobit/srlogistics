<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class CLStateANCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 778,
'name' => 'Antofagasta'
],[
'state_id' => 778,
'name' => 'Calama'
],[
'state_id' => 778,
'name' => 'Mejillones'
],[
'state_id' => 778,
'name' => 'Sierra Gorda'
],[
'state_id' => 778,
'name' => 'Ollagüe'
],[
'state_id' => 778,
'name' => 'San Pedro de Atacama'
],[
'state_id' => 778,
'name' => 'Taltal'
],[
'state_id' => 778,
'name' => 'Tocopilla'
],[
'state_id' => 778,
'name' => 'María Elena'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
