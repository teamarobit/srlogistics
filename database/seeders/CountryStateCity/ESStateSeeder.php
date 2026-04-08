<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\State;

class ESStateSeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'country_id' => 207,
'name' => 'Burgos',
'iso2' => 'BU'
],[
'country_id' => 207,
'name' => 'Salamanca',
'iso2' => 'SA'
],[
'country_id' => 207,
'name' => 'Palencia',
'iso2' => 'P'
],[
'country_id' => 207,
'name' => 'Madrid',
'iso2' => 'M'
],[
'country_id' => 207,
'name' => 'Asturias',
'iso2' => 'O'
],[
'country_id' => 207,
'name' => 'Zamora',
'iso2' => 'ZA'
],[
'country_id' => 207,
'name' => 'Pontevedra',
'iso2' => 'PO'
],[
'country_id' => 207,
'name' => 'Cantabria',
'iso2' => 'S'
],[
'country_id' => 207,
'name' => 'La Rioja',
'iso2' => 'LO'
],[
'country_id' => 207,
'name' => 'Islas Baleares',
'iso2' => 'PM'
],[
'country_id' => 207,
'name' => 'Valencia',
'iso2' => 'V'
],[
'country_id' => 207,
'name' => 'Murcia',
'iso2' => 'MU'
],[
'country_id' => 207,
'name' => 'Huesca',
'iso2' => 'HU'
],[
'country_id' => 207,
'name' => 'Valladolid',
'iso2' => 'VA'
],[
'country_id' => 207,
'name' => 'Las Palmas',
'iso2' => 'GC'
],[
'country_id' => 207,
'name' => 'Ávila',
'iso2' => 'AV'
],[
'country_id' => 207,
'name' => 'Caceres',
'iso2' => 'CC'
],[
'country_id' => 207,
'name' => 'Gipuzkoa',
'iso2' => 'SS'
],[
'country_id' => 207,
'name' => 'Segovia',
'iso2' => 'SG'
],[
'country_id' => 207,
'name' => 'Sevilla',
'iso2' => 'SE'
],[
'country_id' => 207,
'name' => 'Léon',
'iso2' => 'LE'
],[
'country_id' => 207,
'name' => 'Tarragona',
'iso2' => 'T'
],[
'country_id' => 207,
'name' => 'Navarra',
'iso2' => 'NA'
],[
'country_id' => 207,
'name' => 'Toledo',
'iso2' => 'TO'
],[
'country_id' => 207,
'name' => 'Soria',
'iso2' => 'SO'
],[
'country_id' => 207,
'name' => 'A Coruña',
'iso2' => 'C'
],[
'country_id' => 207,
'name' => 'Lugo',
'iso2' => 'LU'
],[
'country_id' => 207,
'name' => 'Ourense',
'iso2' => 'OR'
],[
'country_id' => 207,
'name' => 'Badajoz',
'iso2' => 'BA'
],[
'country_id' => 207,
'name' => 'Araba',
'iso2' => 'VI'
],[
'country_id' => 207,
'name' => 'Bizkaia',
'iso2' => 'BI'
],[
'country_id' => 207,
'name' => 'Almeria',
'iso2' => 'AL'
],[
'country_id' => 207,
'name' => 'Cádiz',
'iso2' => 'CA'
],[
'country_id' => 207,
'name' => 'Córdoba',
'iso2' => 'CO'
],[
'country_id' => 207,
'name' => 'Granada',
'iso2' => 'GR'
],[
'country_id' => 207,
'name' => 'Huelva',
'iso2' => 'H'
],[
'country_id' => 207,
'name' => 'Jaén',
'iso2' => 'J'
],[
'country_id' => 207,
'name' => 'Málaga',
'iso2' => 'MA'
],[
'country_id' => 207,
'name' => 'Barcelona',
'iso2' => 'B'
],[
'country_id' => 207,
'name' => 'Girona',
'iso2' => 'GI'
],[
'country_id' => 207,
'name' => 'Lleida',
'iso2' => 'L'
],[
'country_id' => 207,
'name' => 'Ciudad Real',
'iso2' => 'CR'
],[
'country_id' => 207,
'name' => 'Cuenca',
'iso2' => 'CU'
],[
'country_id' => 207,
'name' => 'Guadalajara',
'iso2' => 'GU'
],[
'country_id' => 207,
'name' => 'Alicante',
'iso2' => 'A'
],[
'country_id' => 207,
'name' => 'Albacete',
'iso2' => 'AB'
],[
'country_id' => 207,
'name' => 'Castellón',
'iso2' => 'CS'
],[
'country_id' => 207,
'name' => 'Teruel',
'iso2' => 'TE'
],[
'country_id' => 207,
'name' => 'Santa Cruz de Tenerife',
'iso2' => 'TF'
],[
'country_id' => 207,
'name' => 'Zaragoza',
'iso2' => 'Z'
],
];
		foreach($jayParsedAry as $data){
			State::create($data);
		}
	}
}
