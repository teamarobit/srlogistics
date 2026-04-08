<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class CLStateARCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 772,
'name' => 'Angol'
],[
'state_id' => 772,
'name' => 'Carahue'
],[
'state_id' => 772,
'name' => 'Collipulli'
],[
'state_id' => 772,
'name' => 'Freire'
],[
'state_id' => 772,
'name' => 'Lautaro'
],[
'state_id' => 772,
'name' => 'Loncoche'
],[
'state_id' => 772,
'name' => 'Nueva Imperial'
],[
'state_id' => 772,
'name' => 'Pitrufquén'
],[
'state_id' => 772,
'name' => 'Pucón'
],[
'state_id' => 772,
'name' => 'Temuco'
],[
'state_id' => 772,
'name' => 'Traiguén'
],[
'state_id' => 772,
'name' => 'Victoria'
],[
'state_id' => 772,
'name' => 'Vilcún'
],[
'state_id' => 772,
'name' => 'Villarrica'
],[
'state_id' => 772,
'name' => 'Cholchol'
],[
'state_id' => 772,
'name' => 'Cunco'
],[
'state_id' => 772,
'name' => 'Curacautín'
],[
'state_id' => 772,
'name' => 'Curarrehue'
],[
'state_id' => 772,
'name' => 'Ercilla'
],[
'state_id' => 772,
'name' => 'Galvarino'
],[
'state_id' => 772,
'name' => 'Gorbea'
],[
'state_id' => 772,
'name' => 'Lonquimay'
],[
'state_id' => 772,
'name' => 'Los Sauces'
],[
'state_id' => 772,
'name' => 'Lumaco'
],[
'state_id' => 772,
'name' => 'Melipeuco'
],[
'state_id' => 772,
'name' => 'Padre Las Casas'
],[
'state_id' => 772,
'name' => 'Perquenco'
],[
'state_id' => 772,
'name' => 'Purén'
],[
'state_id' => 772,
'name' => 'Renaico'
],[
'state_id' => 772,
'name' => 'Saavedra'
],[
'state_id' => 772,
'name' => 'Teodoro Schmidt'
],[
'state_id' => 772,
'name' => 'Toltén'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
