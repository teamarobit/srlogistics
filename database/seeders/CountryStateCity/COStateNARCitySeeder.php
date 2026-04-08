<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class COStateNARCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 842,
'name' => 'Aldana'
],[
'state_id' => 842,
'name' => 'Ancuya'
],[
'state_id' => 842,
'name' => 'Arboleda'
],[
'state_id' => 842,
'name' => 'Barbacoas'
],[
'state_id' => 842,
'name' => 'Belén'
],[
'state_id' => 842,
'name' => 'Buesaco'
],[
'state_id' => 842,
'name' => 'Chachagüí'
],[
'state_id' => 842,
'name' => 'Colón'
],[
'state_id' => 842,
'name' => 'Consaca'
],[
'state_id' => 842,
'name' => 'Contadero'
],[
'state_id' => 842,
'name' => 'Cuaspud'
],[
'state_id' => 842,
'name' => 'Cumbal'
],[
'state_id' => 842,
'name' => 'Cumbitara'
],[
'state_id' => 842,
'name' => 'Córdoba'
],[
'state_id' => 842,
'name' => 'El Charco'
],[
'state_id' => 842,
'name' => 'El Peñol'
],[
'state_id' => 842,
'name' => 'El Rosario'
],[
'state_id' => 842,
'name' => 'El Tablón de Gómez'
],[
'state_id' => 842,
'name' => 'El Tambo'
],[
'state_id' => 842,
'name' => 'Francisco Pizarro'
],[
'state_id' => 842,
'name' => 'Funes'
],[
'state_id' => 842,
'name' => 'Guachucal'
],[
'state_id' => 842,
'name' => 'Guaitarilla'
],[
'state_id' => 842,
'name' => 'Gualmatán'
],[
'state_id' => 842,
'name' => 'Iles'
],[
'state_id' => 842,
'name' => 'Imués'
],[
'state_id' => 842,
'name' => 'Ipiales'
],[
'state_id' => 842,
'name' => 'La Cruz'
],[
'state_id' => 842,
'name' => 'La Florida'
],[
'state_id' => 842,
'name' => 'La Llanada'
],[
'state_id' => 842,
'name' => 'La Tola'
],[
'state_id' => 842,
'name' => 'La Unión'
],[
'state_id' => 842,
'name' => 'Leiva'
],[
'state_id' => 842,
'name' => 'Linares'
],[
'state_id' => 842,
'name' => 'Los Andes'
],[
'state_id' => 842,
'name' => 'Mallama'
],[
'state_id' => 842,
'name' => 'Mosquera'
],[
'state_id' => 842,
'name' => 'Nariño'
],[
'state_id' => 842,
'name' => 'Olaya Herrera'
],[
'state_id' => 842,
'name' => 'Ospina'
],[
'state_id' => 842,
'name' => 'Pasto'
],[
'state_id' => 842,
'name' => 'Magüí Payán'
],[
'state_id' => 842,
'name' => 'Policarpa'
],[
'state_id' => 842,
'name' => 'Potosí'
],[
'state_id' => 842,
'name' => 'Puerres'
],[
'state_id' => 842,
'name' => 'Pupiales'
],[
'state_id' => 842,
'name' => 'Ricaurte'
],[
'state_id' => 842,
'name' => 'Roberto Payán'
],[
'state_id' => 842,
'name' => 'Samaniego'
],[
'state_id' => 842,
'name' => 'San Bernardo'
],[
'state_id' => 842,
'name' => 'San José de Albán'
],[
'state_id' => 842,
'name' => 'San Lorenzo'
],[
'state_id' => 842,
'name' => 'San Pablo'
],[
'state_id' => 842,
'name' => 'San Pedro de Cartago'
],[
'state_id' => 842,
'name' => 'Sandoná'
],[
'state_id' => 842,
'name' => 'Santa Bárbara'
],[
'state_id' => 842,
'name' => 'Santacruz'
],[
'state_id' => 842,
'name' => 'Sapuyes'
],[
'state_id' => 842,
'name' => 'Taminango'
],[
'state_id' => 842,
'name' => 'Tangua'
],[
'state_id' => 842,
'name' => 'Tumaco'
],[
'state_id' => 842,
'name' => 'Túquerres'
],[
'state_id' => 842,
'name' => 'Yacuanquer'
],[
'state_id' => 842,
'name' => 'Providencia'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
