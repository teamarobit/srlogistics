<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\State;

class CVStateSeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'country_id' => 40,
'name' => 'Ribeira Brava Municipality',
'iso2' => 'RB'
],[
'country_id' => 40,
'name' => 'Tarrafal',
'iso2' => 'TA'
],[
'country_id' => 40,
'name' => 'Ribeira Grande de Santiago',
'iso2' => 'RS'
],[
'country_id' => 40,
'name' => 'Santa Catarina',
'iso2' => 'CA'
],[
'country_id' => 40,
'name' => 'São Domingos',
'iso2' => 'SD'
],[
'country_id' => 40,
'name' => 'Mosteiros',
'iso2' => 'MO'
],[
'country_id' => 40,
'name' => 'Praia',
'iso2' => 'PR'
],[
'country_id' => 40,
'name' => 'Porto Novo',
'iso2' => 'PN'
],[
'country_id' => 40,
'name' => 'São Miguel',
'iso2' => 'SM'
],[
'country_id' => 40,
'name' => 'Maio Municipality',
'iso2' => 'MA'
],[
'country_id' => 40,
'name' => 'Sotavento Islands',
'iso2' => 'S'
],[
'country_id' => 40,
'name' => 'São Lourenço dos Órgãos',
'iso2' => 'SO'
],[
'country_id' => 40,
'name' => 'Barlavento Islands',
'iso2' => 'B'
],[
'country_id' => 40,
'name' => 'Santa Catarina do Fogo',
'iso2' => 'CF'
],[
'country_id' => 40,
'name' => 'Brava',
'iso2' => 'BR'
],[
'country_id' => 40,
'name' => 'Paul',
'iso2' => 'PA'
],[
'country_id' => 40,
'name' => 'Sal',
'iso2' => 'SL'
],[
'country_id' => 40,
'name' => 'Boa Vista',
'iso2' => 'BV'
],[
'country_id' => 40,
'name' => 'São Filipe',
'iso2' => 'SF'
],[
'country_id' => 40,
'name' => 'São Vicente',
'iso2' => 'SV'
],[
'country_id' => 40,
'name' => 'Ribeira Grande',
'iso2' => 'RG'
],[
'country_id' => 40,
'name' => 'Tarrafal de São Nicolau',
'iso2' => 'TS'
],[
'country_id' => 40,
'name' => 'Santa Cruz',
'iso2' => 'CR'
],
];
		foreach($jayParsedAry as $data){
			State::create($data);
		}
	}
}
