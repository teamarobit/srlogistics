<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class COStateQUICitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 819,
'name' => 'Armenia'
],[
'state_id' => 819,
'name' => 'Buenavista'
],[
'state_id' => 819,
'name' => 'Calarca'
],[
'state_id' => 819,
'name' => 'Circasia'
],[
'state_id' => 819,
'name' => 'Córdoba'
],[
'state_id' => 819,
'name' => 'Filandia'
],[
'state_id' => 819,
'name' => 'Génova'
],[
'state_id' => 819,
'name' => 'La Tebaida'
],[
'state_id' => 819,
'name' => 'Montenegro'
],[
'state_id' => 819,
'name' => 'Pijao'
],[
'state_id' => 819,
'name' => 'Quimbaya'
],[
'state_id' => 819,
'name' => 'Salento'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
