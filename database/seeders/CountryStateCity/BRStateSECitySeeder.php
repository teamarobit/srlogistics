<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class BRStateSECitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 530,
'name' => 'Amparo de São Francisco'
],[
'state_id' => 530,
'name' => 'Aquidabã'
],[
'state_id' => 530,
'name' => 'Aracaju'
],[
'state_id' => 530,
'name' => 'Arauá'
],[
'state_id' => 530,
'name' => 'Areia Branca'
],[
'state_id' => 530,
'name' => 'Barra dos Coqueiros'
],[
'state_id' => 530,
'name' => 'Boquim'
],[
'state_id' => 530,
'name' => 'Brejo Grande'
],[
'state_id' => 530,
'name' => 'Campo do Brito'
],[
'state_id' => 530,
'name' => 'Canhoba'
],[
'state_id' => 530,
'name' => 'Canindé de São Francisco'
],[
'state_id' => 530,
'name' => 'Capela'
],[
'state_id' => 530,
'name' => 'Carira'
],[
'state_id' => 530,
'name' => 'Carmópolis'
],[
'state_id' => 530,
'name' => 'Cedro de São João'
],[
'state_id' => 530,
'name' => 'Cristinápolis'
],[
'state_id' => 530,
'name' => 'Cumbe'
],[
'state_id' => 530,
'name' => 'Divina Pastora'
],[
'state_id' => 530,
'name' => 'Estância'
],[
'state_id' => 530,
'name' => 'Feira Nova'
],[
'state_id' => 530,
'name' => 'Frei Paulo'
],[
'state_id' => 530,
'name' => 'Gararu'
],[
'state_id' => 530,
'name' => 'General Maynard'
],[
'state_id' => 530,
'name' => 'Gracho Cardoso'
],[
'state_id' => 530,
'name' => 'Ilha das Flores'
],[
'state_id' => 530,
'name' => 'Indiaroba'
],[
'state_id' => 530,
'name' => 'Itabaiana'
],[
'state_id' => 530,
'name' => 'Itabaianinha'
],[
'state_id' => 530,
'name' => 'Itabi'
],[
'state_id' => 530,
'name' => 'Itaporanga d\'Ajuda'
],[
'state_id' => 530,
'name' => 'Japaratuba'
],[
'state_id' => 530,
'name' => 'Japoatã'
],[
'state_id' => 530,
'name' => 'Lagarto'
],[
'state_id' => 530,
'name' => 'Laranjeiras'
],[
'state_id' => 530,
'name' => 'Macambira'
],[
'state_id' => 530,
'name' => 'Malhada dos Bois'
],[
'state_id' => 530,
'name' => 'Malhador'
],[
'state_id' => 530,
'name' => 'Maruim'
],[
'state_id' => 530,
'name' => 'Moita Bonita'
],[
'state_id' => 530,
'name' => 'Monte Alegre de Sergipe'
],[
'state_id' => 530,
'name' => 'Muribeca'
],[
'state_id' => 530,
'name' => 'Neópolis'
],[
'state_id' => 530,
'name' => 'Nossa Senhora Aparecida'
],[
'state_id' => 530,
'name' => 'Nossa Senhora da Glória'
],[
'state_id' => 530,
'name' => 'Nossa Senhora das Dores'
],[
'state_id' => 530,
'name' => 'Nossa Senhora de Lourdes'
],[
'state_id' => 530,
'name' => 'Nossa Senhora do Socorro'
],[
'state_id' => 530,
'name' => 'Pacatuba'
],[
'state_id' => 530,
'name' => 'Pedra Mole'
],[
'state_id' => 530,
'name' => 'Pedrinhas'
],[
'state_id' => 530,
'name' => 'Pinhão'
],[
'state_id' => 530,
'name' => 'Pirambu'
],[
'state_id' => 530,
'name' => 'Porto da Folha'
],[
'state_id' => 530,
'name' => 'Poço Redondo'
],[
'state_id' => 530,
'name' => 'Poço Verde'
],[
'state_id' => 530,
'name' => 'Propriá'
],[
'state_id' => 530,
'name' => 'Riachuelo'
],[
'state_id' => 530,
'name' => 'Riachão do Dantas'
],[
'state_id' => 530,
'name' => 'Ribeirópolis'
],[
'state_id' => 530,
'name' => 'Rosário do Catete'
],[
'state_id' => 530,
'name' => 'Salgado'
],[
'state_id' => 530,
'name' => 'Santa Luzia do Itanhy'
],[
'state_id' => 530,
'name' => 'Santa Rosa de Lima'
],[
'state_id' => 530,
'name' => 'Santana do São Francisco'
],[
'state_id' => 530,
'name' => 'Santo Amaro das Brotas'
],[
'state_id' => 530,
'name' => 'Simão Dias'
],[
'state_id' => 530,
'name' => 'Siriri'
],[
'state_id' => 530,
'name' => 'São Cristóvão'
],[
'state_id' => 530,
'name' => 'São Domingos'
],[
'state_id' => 530,
'name' => 'São Francisco'
],[
'state_id' => 530,
'name' => 'São Miguel do Aleixo'
],[
'state_id' => 530,
'name' => 'Telha'
],[
'state_id' => 530,
'name' => 'Tobias Barreto'
],[
'state_id' => 530,
'name' => 'Tomar do Geru'
],[
'state_id' => 530,
'name' => 'Umbaúba'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
