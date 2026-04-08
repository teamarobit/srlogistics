<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class COStateNSACitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 822,
'name' => 'Abrego'
],[
'state_id' => 822,
'name' => 'Arboledas'
],[
'state_id' => 822,
'name' => 'Bochalema'
],[
'state_id' => 822,
'name' => 'Bucarasica'
],[
'state_id' => 822,
'name' => 'Cachirá'
],[
'state_id' => 822,
'name' => 'Chinácota'
],[
'state_id' => 822,
'name' => 'Chitagá'
],[
'state_id' => 822,
'name' => 'Convención'
],[
'state_id' => 822,
'name' => 'Cucutilla'
],[
'state_id' => 822,
'name' => 'Cácota'
],[
'state_id' => 822,
'name' => 'Cúcuta'
],[
'state_id' => 822,
'name' => 'Durania'
],[
'state_id' => 822,
'name' => 'El Carmen'
],[
'state_id' => 822,
'name' => 'El Tarra'
],[
'state_id' => 822,
'name' => 'El Zulia'
],[
'state_id' => 822,
'name' => 'Gramalote'
],[
'state_id' => 822,
'name' => 'Hacarí'
],[
'state_id' => 822,
'name' => 'Herrán'
],[
'state_id' => 822,
'name' => 'La Esperanza'
],[
'state_id' => 822,
'name' => 'La Playa'
],[
'state_id' => 822,
'name' => 'Labateca'
],[
'state_id' => 822,
'name' => 'Los Patios'
],[
'state_id' => 822,
'name' => 'Lourdes'
],[
'state_id' => 822,
'name' => 'Mutiscua'
],[
'state_id' => 822,
'name' => 'Ocaña'
],[
'state_id' => 822,
'name' => 'Pamplona'
],[
'state_id' => 822,
'name' => 'Pamplonita'
],[
'state_id' => 822,
'name' => 'Puerto Santander'
],[
'state_id' => 822,
'name' => 'Ragonvalia'
],[
'state_id' => 822,
'name' => 'Salazar'
],[
'state_id' => 822,
'name' => 'San Calixto'
],[
'state_id' => 822,
'name' => 'San Cayetano'
],[
'state_id' => 822,
'name' => 'Santiago'
],[
'state_id' => 822,
'name' => 'Sardinata'
],[
'state_id' => 822,
'name' => 'Silos'
],[
'state_id' => 822,
'name' => 'Tibú'
],[
'state_id' => 822,
'name' => 'Toledo'
],[
'state_id' => 822,
'name' => 'Villa del Rosario'
],[
'state_id' => 822,
'name' => 'Teorama'
],[
'state_id' => 822,
'name' => 'Villa Caro'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
