<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\State;

class BRStateSeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'country_id' => 31,
'name' => 'Rio de Janeiro',
'iso2' => 'RJ'
],[
'country_id' => 31,
'name' => 'Minas Gerais',
'iso2' => 'MG'
],[
'country_id' => 31,
'name' => 'Amapá',
'iso2' => 'AP'
],[
'country_id' => 31,
'name' => 'Goiás',
'iso2' => 'GO'
],[
'country_id' => 31,
'name' => 'Rio Grande do Sul',
'iso2' => 'RS'
],[
'country_id' => 31,
'name' => 'Bahia',
'iso2' => 'BA'
],[
'country_id' => 31,
'name' => 'Sergipe',
'iso2' => 'SE'
],[
'country_id' => 31,
'name' => 'Amazonas',
'iso2' => 'AM'
],[
'country_id' => 31,
'name' => 'Paraíba',
'iso2' => 'PB'
],[
'country_id' => 31,
'name' => 'Pernambuco',
'iso2' => 'PE'
],[
'country_id' => 31,
'name' => 'Alagoas',
'iso2' => 'AL'
],[
'country_id' => 31,
'name' => 'Piauí',
'iso2' => 'PI'
],[
'country_id' => 31,
'name' => 'Pará',
'iso2' => 'PA'
],[
'country_id' => 31,
'name' => 'Mato Grosso do Sul',
'iso2' => 'MS'
],[
'country_id' => 31,
'name' => 'Mato Grosso',
'iso2' => 'MT'
],[
'country_id' => 31,
'name' => 'Acre',
'iso2' => 'AC'
],[
'country_id' => 31,
'name' => 'Rondônia',
'iso2' => 'RO'
],[
'country_id' => 31,
'name' => 'Santa Catarina',
'iso2' => 'SC'
],[
'country_id' => 31,
'name' => 'Maranhão',
'iso2' => 'MA'
],[
'country_id' => 31,
'name' => 'Ceará',
'iso2' => 'CE'
],[
'country_id' => 31,
'name' => 'Distrito Federal',
'iso2' => 'DF'
],[
'country_id' => 31,
'name' => 'Espírito Santo',
'iso2' => 'ES'
],[
'country_id' => 31,
'name' => 'Rio Grande do Norte',
'iso2' => 'RN'
],[
'country_id' => 31,
'name' => 'Tocantins',
'iso2' => 'TO'
],[
'country_id' => 31,
'name' => 'São Paulo',
'iso2' => 'SP'
],[
'country_id' => 31,
'name' => 'Paraná',
'iso2' => 'PR'
],[
'country_id' => 31,
'name' => 'Roraima',
'iso2' => 'RR'
],
];
		foreach($jayParsedAry as $data){
			State::create($data);
		}
	}
}
