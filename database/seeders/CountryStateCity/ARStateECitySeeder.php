<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class ARStateECitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 191,
'name' => 'Aldea San Antonio'
],[
'state_id' => 191,
'name' => 'Aranguren'
],[
'state_id' => 191,
'name' => 'Bovril'
],[
'state_id' => 191,
'name' => 'Caseros'
],[
'state_id' => 191,
'name' => 'Ceibas'
],[
'state_id' => 191,
'name' => 'Chajarí'
],[
'state_id' => 191,
'name' => 'Colonia Elía'
],[
'state_id' => 191,
'name' => 'Colón'
],[
'state_id' => 191,
'name' => 'Concepción del Uruguay'
],[
'state_id' => 191,
'name' => 'Concordia'
],[
'state_id' => 191,
'name' => 'Conscripto Bernardi'
],[
'state_id' => 191,
'name' => 'Crespo'
],[
'state_id' => 191,
'name' => 'Departamento de Gualeguaychú'
],[
'state_id' => 191,
'name' => 'Departamento de Paraná'
],[
'state_id' => 191,
'name' => 'Diamante'
],[
'state_id' => 191,
'name' => 'Domínguez'
],[
'state_id' => 191,
'name' => 'Federación'
],[
'state_id' => 191,
'name' => 'Federal'
],[
'state_id' => 191,
'name' => 'General Campos'
],[
'state_id' => 191,
'name' => 'General Galarza'
],[
'state_id' => 191,
'name' => 'General Ramírez'
],[
'state_id' => 191,
'name' => 'Gobernador Mansilla'
],[
'state_id' => 191,
'name' => 'Gualeguay'
],[
'state_id' => 191,
'name' => 'Gualeguaychú'
],[
'state_id' => 191,
'name' => 'Hasenkamp'
],[
'state_id' => 191,
'name' => 'Hernández'
],[
'state_id' => 191,
'name' => 'Herrera'
],[
'state_id' => 191,
'name' => 'La Criolla'
],[
'state_id' => 191,
'name' => 'La Paz'
],[
'state_id' => 191,
'name' => 'Larroque'
],[
'state_id' => 191,
'name' => 'Los Charrúas'
],[
'state_id' => 191,
'name' => 'Los Conquistadores'
],[
'state_id' => 191,
'name' => 'Lucas González'
],[
'state_id' => 191,
'name' => 'Maciá'
],[
'state_id' => 191,
'name' => 'Nogoyá'
],[
'state_id' => 191,
'name' => 'Oro Verde'
],[
'state_id' => 191,
'name' => 'Paraná'
],[
'state_id' => 191,
'name' => 'Piedras Blancas'
],[
'state_id' => 191,
'name' => 'Pronunciamiento'
],[
'state_id' => 191,
'name' => 'Puerto Ibicuy'
],[
'state_id' => 191,
'name' => 'Puerto Yeruá'
],[
'state_id' => 191,
'name' => 'Rosario del Tala'
],[
'state_id' => 191,
'name' => 'San Benito'
],[
'state_id' => 191,
'name' => 'San Gustavo'
],[
'state_id' => 191,
'name' => 'San José de Feliciano'
],[
'state_id' => 191,
'name' => 'San Justo'
],[
'state_id' => 191,
'name' => 'San Salvador'
],[
'state_id' => 191,
'name' => 'Santa Ana'
],[
'state_id' => 191,
'name' => 'Santa Anita'
],[
'state_id' => 191,
'name' => 'Santa Elena'
],[
'state_id' => 191,
'name' => 'Sauce de Luna'
],[
'state_id' => 191,
'name' => 'Seguí'
],[
'state_id' => 191,
'name' => 'Tabossi'
],[
'state_id' => 191,
'name' => 'Ubajay'
],[
'state_id' => 191,
'name' => 'Urdinarrain'
],[
'state_id' => 191,
'name' => 'Viale'
],[
'state_id' => 191,
'name' => 'Victoria'
],[
'state_id' => 191,
'name' => 'Villa Elisa'
],[
'state_id' => 191,
'name' => 'Villa Hernandarias'
],[
'state_id' => 191,
'name' => 'Villa Mantero'
],[
'state_id' => 191,
'name' => 'Villa María Grande'
],[
'state_id' => 191,
'name' => 'Villa Paranacito'
],[
'state_id' => 191,
'name' => 'Villa Urquiza'
],[
'state_id' => 191,
'name' => 'Villa del Rosario'
],[
'state_id' => 191,
'name' => 'Villaguay'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
