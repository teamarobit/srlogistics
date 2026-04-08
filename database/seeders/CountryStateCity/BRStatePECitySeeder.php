<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class BRStatePECitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 533,
'name' => 'Abreu e Lima'
],[
'state_id' => 533,
'name' => 'Afogados da Ingazeira'
],[
'state_id' => 533,
'name' => 'Afrânio'
],[
'state_id' => 533,
'name' => 'Agrestina'
],[
'state_id' => 533,
'name' => 'Alagoinha'
],[
'state_id' => 533,
'name' => 'Aliança'
],[
'state_id' => 533,
'name' => 'Altinho'
],[
'state_id' => 533,
'name' => 'Amaraji'
],[
'state_id' => 533,
'name' => 'Angelim'
],[
'state_id' => 533,
'name' => 'Araripina'
],[
'state_id' => 533,
'name' => 'Araçoiaba'
],[
'state_id' => 533,
'name' => 'Arcoverde'
],[
'state_id' => 533,
'name' => 'Barra de Guabiraba'
],[
'state_id' => 533,
'name' => 'Barreiros'
],[
'state_id' => 533,
'name' => 'Belo Jardim'
],[
'state_id' => 533,
'name' => 'Belém de Maria'
],[
'state_id' => 533,
'name' => 'Belém de São Francisco'
],[
'state_id' => 533,
'name' => 'Belém do São Francisco'
],[
'state_id' => 533,
'name' => 'Betânia'
],[
'state_id' => 533,
'name' => 'Bezerros'
],[
'state_id' => 533,
'name' => 'Bodocó'
],[
'state_id' => 533,
'name' => 'Bom Conselho'
],[
'state_id' => 533,
'name' => 'Bom Jardim'
],[
'state_id' => 533,
'name' => 'Bonito'
],[
'state_id' => 533,
'name' => 'Brejinho'
],[
'state_id' => 533,
'name' => 'Brejo da Madre de Deus'
],[
'state_id' => 533,
'name' => 'Brejão'
],[
'state_id' => 533,
'name' => 'Buenos Aires'
],[
'state_id' => 533,
'name' => 'Buíque'
],[
'state_id' => 533,
'name' => 'Cabo'
],[
'state_id' => 533,
'name' => 'Cabo de Santo Agostinho'
],[
'state_id' => 533,
'name' => 'Cabrobó'
],[
'state_id' => 533,
'name' => 'Cachoeirinha'
],[
'state_id' => 533,
'name' => 'Caetés'
],[
'state_id' => 533,
'name' => 'Calumbi'
],[
'state_id' => 533,
'name' => 'Calçado'
],[
'state_id' => 533,
'name' => 'Camaragibe'
],[
'state_id' => 533,
'name' => 'Camocim de São Félix'
],[
'state_id' => 533,
'name' => 'Camutanga'
],[
'state_id' => 533,
'name' => 'Canhotinho'
],[
'state_id' => 533,
'name' => 'Capoeiras'
],[
'state_id' => 533,
'name' => 'Carnaubeira da Penha'
],[
'state_id' => 533,
'name' => 'Carnaíba'
],[
'state_id' => 533,
'name' => 'Carpina'
],[
'state_id' => 533,
'name' => 'Caruaru'
],[
'state_id' => 533,
'name' => 'Casinhas'
],[
'state_id' => 533,
'name' => 'Catende'
],[
'state_id' => 533,
'name' => 'Cedro'
],[
'state_id' => 533,
'name' => 'Chã Grande'
],[
'state_id' => 533,
'name' => 'Chã de Alegria'
],[
'state_id' => 533,
'name' => 'Colônia Leopoldina'
],[
'state_id' => 533,
'name' => 'Condado'
],[
'state_id' => 533,
'name' => 'Correntes'
],[
'state_id' => 533,
'name' => 'Cortês'
],[
'state_id' => 533,
'name' => 'Cumaru'
],[
'state_id' => 533,
'name' => 'Cupira'
],[
'state_id' => 533,
'name' => 'Custódia'
],[
'state_id' => 533,
'name' => 'Dormentes'
],[
'state_id' => 533,
'name' => 'Escada'
],[
'state_id' => 533,
'name' => 'Exu'
],[
'state_id' => 533,
'name' => 'Feira Nova'
],[
'state_id' => 533,
'name' => 'Fernando de Noronha'
],[
'state_id' => 533,
'name' => 'Fernando de Noronha (Distrito Estadual)'
],[
'state_id' => 533,
'name' => 'Ferreiros'
],[
'state_id' => 533,
'name' => 'Flores'
],[
'state_id' => 533,
'name' => 'Floresta'
],[
'state_id' => 533,
'name' => 'Frei Miguelinho'
],[
'state_id' => 533,
'name' => 'Gameleira'
],[
'state_id' => 533,
'name' => 'Garanhuns'
],[
'state_id' => 533,
'name' => 'Glória do Goitá'
],[
'state_id' => 533,
'name' => 'Goiana'
],[
'state_id' => 533,
'name' => 'Granito'
],[
'state_id' => 533,
'name' => 'Gravatá'
],[
'state_id' => 533,
'name' => 'Guabiraba'
],[
'state_id' => 533,
'name' => 'Iati'
],[
'state_id' => 533,
'name' => 'Ibimirim'
],[
'state_id' => 533,
'name' => 'Ibirajuba'
],[
'state_id' => 533,
'name' => 'Igarassu'
],[
'state_id' => 533,
'name' => 'Iguaracy'
],[
'state_id' => 533,
'name' => 'Ilha de Itamaracá'
],[
'state_id' => 533,
'name' => 'Inajá'
],[
'state_id' => 533,
'name' => 'Ingazeira'
],[
'state_id' => 533,
'name' => 'Ipojuca'
],[
'state_id' => 533,
'name' => 'Ipubi'
],[
'state_id' => 533,
'name' => 'Itacuruba'
],[
'state_id' => 533,
'name' => 'Itamaracá'
],[
'state_id' => 533,
'name' => 'Itambé'
],[
'state_id' => 533,
'name' => 'Itapetim'
],[
'state_id' => 533,
'name' => 'Itapissuma'
],[
'state_id' => 533,
'name' => 'Itaquitinga'
],[
'state_id' => 533,
'name' => 'Itaíba'
],[
'state_id' => 533,
'name' => 'Jaboatão'
],[
'state_id' => 533,
'name' => 'Jaboatão dos Guararapes'
],[
'state_id' => 533,
'name' => 'Jaqueira'
],[
'state_id' => 533,
'name' => 'Jataúba'
],[
'state_id' => 533,
'name' => 'Jatobá'
],[
'state_id' => 533,
'name' => 'Joaquim Nabuco'
],[
'state_id' => 533,
'name' => 'João Alfredo'
],[
'state_id' => 533,
'name' => 'Jucati'
],[
'state_id' => 533,
'name' => 'Jupi'
],[
'state_id' => 533,
'name' => 'Jurema'
],[
'state_id' => 533,
'name' => 'Lagoa Grande'
],[
'state_id' => 533,
'name' => 'Lagoa de Itaenga'
],[
'state_id' => 533,
'name' => 'Lagoa do Carro'
],[
'state_id' => 533,
'name' => 'Lagoa do Itaenga'
],[
'state_id' => 533,
'name' => 'Lagoa do Ouro'
],[
'state_id' => 533,
'name' => 'Lagoa dos Gatos'
],[
'state_id' => 533,
'name' => 'Lajedo'
],[
'state_id' => 533,
'name' => 'Limoeiro'
],[
'state_id' => 533,
'name' => 'Macaparana'
],[
'state_id' => 533,
'name' => 'Machados'
],[
'state_id' => 533,
'name' => 'Manari'
],[
'state_id' => 533,
'name' => 'Maraial'
],[
'state_id' => 533,
'name' => 'Mirandiba'
],[
'state_id' => 533,
'name' => 'Moreilândia'
],[
'state_id' => 533,
'name' => 'Moreno'
],[
'state_id' => 533,
'name' => 'Nazaré da Mata'
],[
'state_id' => 533,
'name' => 'Olinda'
],[
'state_id' => 533,
'name' => 'Orobó'
],[
'state_id' => 533,
'name' => 'Orocó'
],[
'state_id' => 533,
'name' => 'Ouricuri'
],[
'state_id' => 533,
'name' => 'Palmares'
],[
'state_id' => 533,
'name' => 'Palmeirina'
],[
'state_id' => 533,
'name' => 'Panelas'
],[
'state_id' => 533,
'name' => 'Paranatama'
],[
'state_id' => 533,
'name' => 'Parnamirim'
],[
'state_id' => 533,
'name' => 'Passira'
],[
'state_id' => 533,
'name' => 'Paudalho'
],[
'state_id' => 533,
'name' => 'Paulista'
],[
'state_id' => 533,
'name' => 'Pedra'
],[
'state_id' => 533,
'name' => 'Pesqueira'
],[
'state_id' => 533,
'name' => 'Petrolina'
],[
'state_id' => 533,
'name' => 'Petrolândia'
],[
'state_id' => 533,
'name' => 'Pombos'
],[
'state_id' => 533,
'name' => 'Poção'
],[
'state_id' => 533,
'name' => 'Primavera'
],[
'state_id' => 533,
'name' => 'Quipapá'
],[
'state_id' => 533,
'name' => 'Quixaba'
],[
'state_id' => 533,
'name' => 'Recife'
],[
'state_id' => 533,
'name' => 'Riacho das Almas'
],[
'state_id' => 533,
'name' => 'Ribeirão'
],[
'state_id' => 533,
'name' => 'Rio Formoso'
],[
'state_id' => 533,
'name' => 'Sairé'
],[
'state_id' => 533,
'name' => 'Salgadinho'
],[
'state_id' => 533,
'name' => 'Salgueiro'
],[
'state_id' => 533,
'name' => 'Saloá'
],[
'state_id' => 533,
'name' => 'Sanharó'
],[
'state_id' => 533,
'name' => 'Santa Cruz'
],[
'state_id' => 533,
'name' => 'Santa Cruz da Baixa Verde'
],[
'state_id' => 533,
'name' => 'Santa Cruz do Capibaribe'
],[
'state_id' => 533,
'name' => 'Santa Filomena'
],[
'state_id' => 533,
'name' => 'Santa Maria da Boa Vista'
],[
'state_id' => 533,
'name' => 'Santa Maria do Cambucá'
],[
'state_id' => 533,
'name' => 'Santa Terezinha'
],[
'state_id' => 533,
'name' => 'Serra Talhada'
],[
'state_id' => 533,
'name' => 'Serrita'
],[
'state_id' => 533,
'name' => 'Sertânia'
],[
'state_id' => 533,
'name' => 'Sirinhaém'
],[
'state_id' => 533,
'name' => 'Solidão'
],[
'state_id' => 533,
'name' => 'Surubim'
],[
'state_id' => 533,
'name' => 'São Benedito do Sul'
],[
'state_id' => 533,
'name' => 'São Bento do Una'
],[
'state_id' => 533,
'name' => 'São Caitano'
],[
'state_id' => 533,
'name' => 'São Joaquim do Monte'
],[
'state_id' => 533,
'name' => 'São José da Coroa Grande'
],[
'state_id' => 533,
'name' => 'São José do Belmonte'
],[
'state_id' => 533,
'name' => 'São José do Egito'
],[
'state_id' => 533,
'name' => 'São João'
],[
'state_id' => 533,
'name' => 'São Lourenço da Mata'
],[
'state_id' => 533,
'name' => 'São Vicente Férrer'
],[
'state_id' => 533,
'name' => 'Tabira'
],[
'state_id' => 533,
'name' => 'Tacaimbó'
],[
'state_id' => 533,
'name' => 'Tacaratu'
],[
'state_id' => 533,
'name' => 'Tamandaré'
],[
'state_id' => 533,
'name' => 'Taquaritinga do Norte'
],[
'state_id' => 533,
'name' => 'Terezinha'
],[
'state_id' => 533,
'name' => 'Terra Nova'
],[
'state_id' => 533,
'name' => 'Timbaúba'
],[
'state_id' => 533,
'name' => 'Toritama'
],[
'state_id' => 533,
'name' => 'Tracunhaém'
],[
'state_id' => 533,
'name' => 'Trindade'
],[
'state_id' => 533,
'name' => 'Triunfo'
],[
'state_id' => 533,
'name' => 'Tupanatinga'
],[
'state_id' => 533,
'name' => 'Tuparetama'
],[
'state_id' => 533,
'name' => 'Venturosa'
],[
'state_id' => 533,
'name' => 'Verdejante'
],[
'state_id' => 533,
'name' => 'Vertente do Lério'
],[
'state_id' => 533,
'name' => 'Vertentes'
],[
'state_id' => 533,
'name' => 'Vicência'
],[
'state_id' => 533,
'name' => 'Vitória de Santo Antão'
],[
'state_id' => 533,
'name' => 'Xexéu'
],[
'state_id' => 533,
'name' => 'Água Preta'
],[
'state_id' => 533,
'name' => 'Águas Belas'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
