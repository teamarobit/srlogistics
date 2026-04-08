<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class HNStateYOCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1609,
'name' => 'Agua Blanca Sur'
],[
'state_id' => 1609,
'name' => 'Arenal'
],[
'state_id' => 1609,
'name' => 'Armenia'
],[
'state_id' => 1609,
'name' => 'Ayapa'
],[
'state_id' => 1609,
'name' => 'Bálsamo Oriental'
],[
'state_id' => 1609,
'name' => 'Carbajales'
],[
'state_id' => 1609,
'name' => 'Coyoles Central'
],[
'state_id' => 1609,
'name' => 'El Bálsamo'
],[
'state_id' => 1609,
'name' => 'El Juncal'
],[
'state_id' => 1609,
'name' => 'El Negrito'
],[
'state_id' => 1609,
'name' => 'El Ocote'
],[
'state_id' => 1609,
'name' => 'El Progreso'
],[
'state_id' => 1609,
'name' => 'Guaimitas'
],[
'state_id' => 1609,
'name' => 'Jocón'
],[
'state_id' => 1609,
'name' => 'La Estancia'
],[
'state_id' => 1609,
'name' => 'La Guacamaya'
],[
'state_id' => 1609,
'name' => 'La Mina'
],[
'state_id' => 1609,
'name' => 'La Rosa'
],[
'state_id' => 1609,
'name' => 'La Sarrosa'
],[
'state_id' => 1609,
'name' => 'La Trinidad'
],[
'state_id' => 1609,
'name' => 'Las Vegas'
],[
'state_id' => 1609,
'name' => 'Lomitas'
],[
'state_id' => 1609,
'name' => 'Mojimán'
],[
'state_id' => 1609,
'name' => 'Morazán'
],[
'state_id' => 1609,
'name' => 'Nombre de Jesús'
],[
'state_id' => 1609,
'name' => 'Nueva Esperanza'
],[
'state_id' => 1609,
'name' => 'Ocote Paulino'
],[
'state_id' => 1609,
'name' => 'Olanchito'
],[
'state_id' => 1609,
'name' => 'Paujiles'
],[
'state_id' => 1609,
'name' => 'Punta Ocote'
],[
'state_id' => 1609,
'name' => 'San Antonio'
],[
'state_id' => 1609,
'name' => 'San José'
],[
'state_id' => 1609,
'name' => 'Santa Rita'
],[
'state_id' => 1609,
'name' => 'Subirana'
],[
'state_id' => 1609,
'name' => 'Sulaco'
],[
'state_id' => 1609,
'name' => 'Teguajinal'
],[
'state_id' => 1609,
'name' => 'Tepusteca'
],[
'state_id' => 1609,
'name' => 'Toyós'
],[
'state_id' => 1609,
'name' => 'Trojas'
],[
'state_id' => 1609,
'name' => 'Victoria'
],[
'state_id' => 1609,
'name' => 'Yorito'
],[
'state_id' => 1609,
'name' => 'Yoro'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
