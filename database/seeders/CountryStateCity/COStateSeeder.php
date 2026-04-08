<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\State;

class COStateSeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'country_id' => 48,
'name' => 'Quindío',
'iso2' => 'QUI'
],[
'country_id' => 48,
'name' => 'Cundinamarca',
'iso2' => 'CUN'
],[
'country_id' => 48,
'name' => 'Chocó',
'iso2' => 'CHO'
],[
'country_id' => 48,
'name' => 'Norte de Santander',
'iso2' => 'NSA'
],[
'country_id' => 48,
'name' => 'Meta',
'iso2' => 'MET'
],[
'country_id' => 48,
'name' => 'Risaralda',
'iso2' => 'RIS'
],[
'country_id' => 48,
'name' => 'Atlántico',
'iso2' => 'ATL'
],[
'country_id' => 48,
'name' => 'Arauca',
'iso2' => 'ARA'
],[
'country_id' => 48,
'name' => 'Guainía',
'iso2' => 'GUA'
],[
'country_id' => 48,
'name' => 'Tolima',
'iso2' => 'TOL'
],[
'country_id' => 48,
'name' => 'Cauca',
'iso2' => 'CAU'
],[
'country_id' => 48,
'name' => 'Vaupés',
'iso2' => 'VAU'
],[
'country_id' => 48,
'name' => 'Magdalena',
'iso2' => 'MAG'
],[
'country_id' => 48,
'name' => 'Caldas',
'iso2' => 'CAL'
],[
'country_id' => 48,
'name' => 'Guaviare',
'iso2' => 'GUV'
],[
'country_id' => 48,
'name' => 'La Guajira',
'iso2' => 'LAG'
],[
'country_id' => 48,
'name' => 'Antioquia',
'iso2' => 'ANT'
],[
'country_id' => 48,
'name' => 'Caquetá',
'iso2' => 'CAQ'
],[
'country_id' => 48,
'name' => 'Casanare',
'iso2' => 'CAS'
],[
'country_id' => 48,
'name' => 'Bolívar',
'iso2' => 'BOL'
],[
'country_id' => 48,
'name' => 'Vichada',
'iso2' => 'VID'
],[
'country_id' => 48,
'name' => 'Amazonas',
'iso2' => 'AMA'
],[
'country_id' => 48,
'name' => 'Putumayo',
'iso2' => 'PUT'
],[
'country_id' => 48,
'name' => 'Nariño',
'iso2' => 'NAR'
],[
'country_id' => 48,
'name' => 'Córdoba',
'iso2' => 'COR'
],[
'country_id' => 48,
'name' => 'Cesar',
'iso2' => 'CES'
],[
'country_id' => 48,
'name' => 'Archipiélago de San Andrés, Providencia y Santa Catalina',
'iso2' => 'SAP'
],[
'country_id' => 48,
'name' => 'Santander',
'iso2' => 'SAN'
],[
'country_id' => 48,
'name' => 'Sucre',
'iso2' => 'SUC'
],[
'country_id' => 48,
'name' => 'Boyacá',
'iso2' => 'BOY'
],[
'country_id' => 48,
'name' => 'Valle del Cauca',
'iso2' => 'VAC'
],[
'country_id' => 48,
'name' => 'Huila',
'iso2' => 'HUI'
],[
'country_id' => 48,
'name' => 'Bogotá D.C.',
'iso2' => 'DC'
],
];
		foreach($jayParsedAry as $data){
			State::create($data);
		}
	}
}
