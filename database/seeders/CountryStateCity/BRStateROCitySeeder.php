<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class BRStateROCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 540,
'name' => 'Alta Floresta d\'Oeste'
],[
'state_id' => 540,
'name' => 'Alto Alegre dos Parecis'
],[
'state_id' => 540,
'name' => 'Alto Paraíso'
],[
'state_id' => 540,
'name' => 'Alvorada d\'Oeste'
],[
'state_id' => 540,
'name' => 'Ariquemes'
],[
'state_id' => 540,
'name' => 'Buritis'
],[
'state_id' => 540,
'name' => 'Cabixi'
],[
'state_id' => 540,
'name' => 'Cacaulândia'
],[
'state_id' => 540,
'name' => 'Cacoal'
],[
'state_id' => 540,
'name' => 'Campo Novo de Rondônia'
],[
'state_id' => 540,
'name' => 'Candeias do Jamari'
],[
'state_id' => 540,
'name' => 'Castanheiras'
],[
'state_id' => 540,
'name' => 'Cerejeiras'
],[
'state_id' => 540,
'name' => 'Chupinguaia'
],[
'state_id' => 540,
'name' => 'Colorado do Oeste'
],[
'state_id' => 540,
'name' => 'Corumbiara'
],[
'state_id' => 540,
'name' => 'Costa Marques'
],[
'state_id' => 540,
'name' => 'Cujubim'
],[
'state_id' => 540,
'name' => 'Espigão d\'Oeste'
],[
'state_id' => 540,
'name' => 'Extrema'
],[
'state_id' => 540,
'name' => 'Governador Jorge Teixeira'
],[
'state_id' => 540,
'name' => 'Guajará Mirim'
],[
'state_id' => 540,
'name' => 'Guajará-Mirim'
],[
'state_id' => 540,
'name' => 'Itapuã do Oeste'
],[
'state_id' => 540,
'name' => 'Jaru'
],[
'state_id' => 540,
'name' => 'Ji Paraná'
],[
'state_id' => 540,
'name' => 'Ji-Paraná'
],[
'state_id' => 540,
'name' => 'Machadinho d\'Oeste'
],[
'state_id' => 540,
'name' => 'Ministro Andreazza'
],[
'state_id' => 540,
'name' => 'Mirante da Serra'
],[
'state_id' => 540,
'name' => 'Monte Negro'
],[
'state_id' => 540,
'name' => 'Nova Brasilândia d\'Oeste'
],[
'state_id' => 540,
'name' => 'Nova Mamoré'
],[
'state_id' => 540,
'name' => 'Nova União'
],[
'state_id' => 540,
'name' => 'Novo Horizonte do Oeste'
],[
'state_id' => 540,
'name' => 'Ouro Preto do Oeste'
],[
'state_id' => 540,
'name' => 'Parecis'
],[
'state_id' => 540,
'name' => 'Pimenta Bueno'
],[
'state_id' => 540,
'name' => 'Pimenteiras do Oeste'
],[
'state_id' => 540,
'name' => 'Porto Velho'
],[
'state_id' => 540,
'name' => 'Presidente Médici'
],[
'state_id' => 540,
'name' => 'Primavera de Rondônia'
],[
'state_id' => 540,
'name' => 'Pôsto Fiscal Rolim de Moura'
],[
'state_id' => 540,
'name' => 'Rio Crespo'
],[
'state_id' => 540,
'name' => 'Rolim de Moura'
],[
'state_id' => 540,
'name' => 'Santa Luzia d\'Oeste'
],[
'state_id' => 540,
'name' => 'Seringueiras'
],[
'state_id' => 540,
'name' => 'São Felipe d\'Oeste'
],[
'state_id' => 540,
'name' => 'São Francisco do Guaporé'
],[
'state_id' => 540,
'name' => 'São Miguel do Guaporé'
],[
'state_id' => 540,
'name' => 'Teixeirópolis'
],[
'state_id' => 540,
'name' => 'Theobroma'
],[
'state_id' => 540,
'name' => 'Urupá'
],[
'state_id' => 540,
'name' => 'Vale do Anari'
],[
'state_id' => 540,
'name' => 'Vale do Paraíso'
],[
'state_id' => 540,
'name' => 'Vilhena'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
