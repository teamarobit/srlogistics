<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\State;

class MXStateSeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'country_id' => 142,
'name' => 'Chihuahua',
'iso2' => 'CHH'
],[
'country_id' => 142,
'name' => 'Oaxaca',
'iso2' => 'OAX'
],[
'country_id' => 142,
'name' => 'Sinaloa',
'iso2' => 'SIN'
],[
'country_id' => 142,
'name' => 'Estado de México',
'iso2' => 'MEX'
],[
'country_id' => 142,
'name' => 'Chiapas',
'iso2' => 'CHP'
],[
'country_id' => 142,
'name' => 'Nuevo León',
'iso2' => 'NLE'
],[
'country_id' => 142,
'name' => 'Durango',
'iso2' => 'DUR'
],[
'country_id' => 142,
'name' => 'Tabasco',
'iso2' => 'TAB'
],[
'country_id' => 142,
'name' => 'Querétaro',
'iso2' => 'QUE'
],[
'country_id' => 142,
'name' => 'Aguascalientes',
'iso2' => 'AGU'
],[
'country_id' => 142,
'name' => 'Baja California',
'iso2' => 'BCN'
],[
'country_id' => 142,
'name' => 'Tlaxcala',
'iso2' => 'TLA'
],[
'country_id' => 142,
'name' => 'Guerrero',
'iso2' => 'GRO'
],[
'country_id' => 142,
'name' => 'Baja California Sur',
'iso2' => 'BCS'
],[
'country_id' => 142,
'name' => 'San Luis Potosí',
'iso2' => 'SLP'
],[
'country_id' => 142,
'name' => 'Zacatecas',
'iso2' => 'ZAC'
],[
'country_id' => 142,
'name' => 'Tamaulipas',
'iso2' => 'TAM'
],[
'country_id' => 142,
'name' => 'Veracruz de Ignacio de la Llave',
'iso2' => 'VER'
],[
'country_id' => 142,
'name' => 'Morelos',
'iso2' => 'MOR'
],[
'country_id' => 142,
'name' => 'Yucatán',
'iso2' => 'YUC'
],[
'country_id' => 142,
'name' => 'Quintana Roo',
'iso2' => 'ROO'
],[
'country_id' => 142,
'name' => 'Sonora',
'iso2' => 'SON'
],[
'country_id' => 142,
'name' => 'Guanajuato',
'iso2' => 'GUA'
],[
'country_id' => 142,
'name' => 'Hidalgo',
'iso2' => 'HID'
],[
'country_id' => 142,
'name' => 'Coahuila de Zaragoza',
'iso2' => 'COA'
],[
'country_id' => 142,
'name' => 'Colima',
'iso2' => 'COL'
],[
'country_id' => 142,
'name' => 'Ciudad de México',
'iso2' => 'CDMX'
],[
'country_id' => 142,
'name' => 'Michoacán de Ocampo',
'iso2' => 'MIC'
],[
'country_id' => 142,
'name' => 'Campeche',
'iso2' => 'CAM'
],[
'country_id' => 142,
'name' => 'Puebla',
'iso2' => 'PUE'
],[
'country_id' => 142,
'name' => 'Nayarit',
'iso2' => 'NAY'
],[
'country_id' => 142,
'name' => 'Jalisco',
'iso2' => 'JAL'
],
];
		foreach($jayParsedAry as $data){
			State::create($data);
		}
	}
}
