<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class BOStateOCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 493,
'name' => 'Challapata'
],[
'state_id' => 493,
'name' => 'Huanuni'
],[
'state_id' => 493,
'name' => 'Litoral de Atacama'
],[
'state_id' => 493,
'name' => 'Machacamarca'
],[
'state_id' => 493,
'name' => 'Nor Carangas Province'
],[
'state_id' => 493,
'name' => 'Oruro'
],[
'state_id' => 493,
'name' => 'Poopó'
],[
'state_id' => 493,
'name' => 'Provincia Avaroa'
],[
'state_id' => 493,
'name' => 'Provincia Carangas'
],[
'state_id' => 493,
'name' => 'Provincia Cercado'
],[
'state_id' => 493,
'name' => 'Provincia Ladislao Cabrera'
],[
'state_id' => 493,
'name' => 'Provincia Pantaleón Dalence'
],[
'state_id' => 493,
'name' => 'Provincia Poopó'
],[
'state_id' => 493,
'name' => 'Provincia Sabaya'
],[
'state_id' => 493,
'name' => 'Provincia Sajama'
],[
'state_id' => 493,
'name' => 'Provincia San Pedro de Totora'
],[
'state_id' => 493,
'name' => 'Provincia Saucari'
],[
'state_id' => 493,
'name' => 'Provincia Tomás Barron'
],[
'state_id' => 493,
'name' => 'Puerto de Mejillones'
],[
'state_id' => 493,
'name' => 'Sebastian Pagador Province'
],[
'state_id' => 493,
'name' => 'Sud Carangas Province'
],[
'state_id' => 493,
'name' => 'Totoral'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
