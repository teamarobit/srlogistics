<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class BRStatePICitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 535,
'name' => 'Acauã'
],[
'state_id' => 535,
'name' => 'Agricolândia'
],[
'state_id' => 535,
'name' => 'Alagoinha do Piauí'
],[
'state_id' => 535,
'name' => 'Alegrete do Piauí'
],[
'state_id' => 535,
'name' => 'Alto Longá'
],[
'state_id' => 535,
'name' => 'Altos'
],[
'state_id' => 535,
'name' => 'Alvorada do Gurguéia'
],[
'state_id' => 535,
'name' => 'Amarante'
],[
'state_id' => 535,
'name' => 'Angical do Piauí'
],[
'state_id' => 535,
'name' => 'Antônio Almeida'
],[
'state_id' => 535,
'name' => 'Anísio de Abreu'
],[
'state_id' => 535,
'name' => 'Aroazes'
],[
'state_id' => 535,
'name' => 'Aroeiras do Itaim'
],[
'state_id' => 535,
'name' => 'Arraial'
],[
'state_id' => 535,
'name' => 'Assunção do Piauí'
],[
'state_id' => 535,
'name' => 'Avelino Lopes'
],[
'state_id' => 535,
'name' => 'Baixa Grande do Ribeiro'
],[
'state_id' => 535,
'name' => 'Barra d\'Alcântara'
],[
'state_id' => 535,
'name' => 'Barras'
],[
'state_id' => 535,
'name' => 'Barreiras do Piauí'
],[
'state_id' => 535,
'name' => 'Barro Duro'
],[
'state_id' => 535,
'name' => 'Batalha'
],[
'state_id' => 535,
'name' => 'Bela Vista do Piauí'
],[
'state_id' => 535,
'name' => 'Belém do Piauí'
],[
'state_id' => 535,
'name' => 'Beneditinos'
],[
'state_id' => 535,
'name' => 'Bertolínia'
],[
'state_id' => 535,
'name' => 'Betânia do Piauí'
],[
'state_id' => 535,
'name' => 'Boa Hora'
],[
'state_id' => 535,
'name' => 'Bocaina'
],[
'state_id' => 535,
'name' => 'Bom Jesus'
],[
'state_id' => 535,
'name' => 'Bom Princípio do Piauí'
],[
'state_id' => 535,
'name' => 'Bonfim do Piauí'
],[
'state_id' => 535,
'name' => 'Boqueirão do Piauí'
],[
'state_id' => 535,
'name' => 'Brasileira'
],[
'state_id' => 535,
'name' => 'Brejo do Piauí'
],[
'state_id' => 535,
'name' => 'Buriti dos Lopes'
],[
'state_id' => 535,
'name' => 'Buriti dos Montes'
],[
'state_id' => 535,
'name' => 'Cabeceiras do Piauí'
],[
'state_id' => 535,
'name' => 'Cajazeiras do Piauí'
],[
'state_id' => 535,
'name' => 'Cajueiro da Praia'
],[
'state_id' => 535,
'name' => 'Caldeirão Grande do Piauí'
],[
'state_id' => 535,
'name' => 'Campinas do Piauí'
],[
'state_id' => 535,
'name' => 'Campo Alegre do Fidalgo'
],[
'state_id' => 535,
'name' => 'Campo Grande do Piauí'
],[
'state_id' => 535,
'name' => 'Campo Largo do Piauí'
],[
'state_id' => 535,
'name' => 'Campo Maior'
],[
'state_id' => 535,
'name' => 'Canavieira'
],[
'state_id' => 535,
'name' => 'Canto do Buriti'
],[
'state_id' => 535,
'name' => 'Capitão Gervásio Oliveira'
],[
'state_id' => 535,
'name' => 'Capitão de Campos'
],[
'state_id' => 535,
'name' => 'Caracol'
],[
'state_id' => 535,
'name' => 'Caraúbas do Piauí'
],[
'state_id' => 535,
'name' => 'Caridade do Piauí'
],[
'state_id' => 535,
'name' => 'Castelo do Piauí'
],[
'state_id' => 535,
'name' => 'Caxingó'
],[
'state_id' => 535,
'name' => 'Cocal'
],[
'state_id' => 535,
'name' => 'Cocal de Telha'
],[
'state_id' => 535,
'name' => 'Cocal dos Alves'
],[
'state_id' => 535,
'name' => 'Coivaras'
],[
'state_id' => 535,
'name' => 'Colônia do Gurguéia'
],[
'state_id' => 535,
'name' => 'Colônia do Piauí'
],[
'state_id' => 535,
'name' => 'Conceição do Canindé'
],[
'state_id' => 535,
'name' => 'Coronel José Dias'
],[
'state_id' => 535,
'name' => 'Corrente'
],[
'state_id' => 535,
'name' => 'Cristalândia do Piauí'
],[
'state_id' => 535,
'name' => 'Cristino Castro'
],[
'state_id' => 535,
'name' => 'Curimatá'
],[
'state_id' => 535,
'name' => 'Currais'
],[
'state_id' => 535,
'name' => 'Curral Novo do Piauí'
],[
'state_id' => 535,
'name' => 'Curralinhos'
],[
'state_id' => 535,
'name' => 'Demerval Lobão'
],[
'state_id' => 535,
'name' => 'Dirceu Arcoverde'
],[
'state_id' => 535,
'name' => 'Dom Expedito Lopes'
],[
'state_id' => 535,
'name' => 'Dom Inocêncio'
],[
'state_id' => 535,
'name' => 'Domingos Mourão'
],[
'state_id' => 535,
'name' => 'Elesbão Veloso'
],[
'state_id' => 535,
'name' => 'Eliseu Martins'
],[
'state_id' => 535,
'name' => 'Esperantina'
],[
'state_id' => 535,
'name' => 'Fartura do Piauí'
],[
'state_id' => 535,
'name' => 'Flores do Piauí'
],[
'state_id' => 535,
'name' => 'Floresta do Piauí'
],[
'state_id' => 535,
'name' => 'Floriano'
],[
'state_id' => 535,
'name' => 'Francinópolis'
],[
'state_id' => 535,
'name' => 'Francisco Ayres'
],[
'state_id' => 535,
'name' => 'Francisco Macedo'
],[
'state_id' => 535,
'name' => 'Francisco Santos'
],[
'state_id' => 535,
'name' => 'Fronteiras'
],[
'state_id' => 535,
'name' => 'Geminiano'
],[
'state_id' => 535,
'name' => 'Gilbués'
],[
'state_id' => 535,
'name' => 'Guadalupe'
],[
'state_id' => 535,
'name' => 'Guaribas'
],[
'state_id' => 535,
'name' => 'Hugo Napoleão'
],[
'state_id' => 535,
'name' => 'Ilha Grande'
],[
'state_id' => 535,
'name' => 'Inhuma'
],[
'state_id' => 535,
'name' => 'Ipiranga do Piauí'
],[
'state_id' => 535,
'name' => 'Ipueiras'
],[
'state_id' => 535,
'name' => 'Isaías Coelho'
],[
'state_id' => 535,
'name' => 'Itainópolis'
],[
'state_id' => 535,
'name' => 'Itaueira'
],[
'state_id' => 535,
'name' => 'Jacobina do Piauí'
],[
'state_id' => 535,
'name' => 'Jaicós'
],[
'state_id' => 535,
'name' => 'Jardim do Mulato'
],[
'state_id' => 535,
'name' => 'Jatobá do Piauí'
],[
'state_id' => 535,
'name' => 'Jerumenha'
],[
'state_id' => 535,
'name' => 'Joaquim Pires'
],[
'state_id' => 535,
'name' => 'Joca Marques'
],[
'state_id' => 535,
'name' => 'José de Freitas'
],[
'state_id' => 535,
'name' => 'João Costa'
],[
'state_id' => 535,
'name' => 'Juazeiro do Piauí'
],[
'state_id' => 535,
'name' => 'Jurema'
],[
'state_id' => 535,
'name' => 'Júlio Borges'
],[
'state_id' => 535,
'name' => 'Lagoa Alegre'
],[
'state_id' => 535,
'name' => 'Lagoa de São Francisco'
],[
'state_id' => 535,
'name' => 'Lagoa do Barro do Piauí'
],[
'state_id' => 535,
'name' => 'Lagoa do Piauí'
],[
'state_id' => 535,
'name' => 'Lagoa do Sítio'
],[
'state_id' => 535,
'name' => 'Lagoinha do Piauí'
],[
'state_id' => 535,
'name' => 'Landri Sales'
],[
'state_id' => 535,
'name' => 'Luzilândia'
],[
'state_id' => 535,
'name' => 'Luís Correia'
],[
'state_id' => 535,
'name' => 'Madeiro'
],[
'state_id' => 535,
'name' => 'Manoel Emídio'
],[
'state_id' => 535,
'name' => 'Marcolândia'
],[
'state_id' => 535,
'name' => 'Marcos Parente'
],[
'state_id' => 535,
'name' => 'Massapê do Piauí'
],[
'state_id' => 535,
'name' => 'Matias Olímpio'
],[
'state_id' => 535,
'name' => 'Miguel Alves'
],[
'state_id' => 535,
'name' => 'Miguel Leão'
],[
'state_id' => 535,
'name' => 'Milton Brandão'
],[
'state_id' => 535,
'name' => 'Monsenhor Gil'
],[
'state_id' => 535,
'name' => 'Monsenhor Hipólito'
],[
'state_id' => 535,
'name' => 'Monte Alegre do Piauí'
],[
'state_id' => 535,
'name' => 'Morro Cabeça no Tempo'
],[
'state_id' => 535,
'name' => 'Morro do Chapéu do Piauí'
],[
'state_id' => 535,
'name' => 'Murici dos Portelas'
],[
'state_id' => 535,
'name' => 'Nazaré do Piauí'
],[
'state_id' => 535,
'name' => 'Nazária'
],[
'state_id' => 535,
'name' => 'Nossa Senhora de Nazaré'
],[
'state_id' => 535,
'name' => 'Nossa Senhora dos Remédios'
],[
'state_id' => 535,
'name' => 'Nova Santa Rita'
],[
'state_id' => 535,
'name' => 'Novo Oriente do Piauí'
],[
'state_id' => 535,
'name' => 'Novo Santo Antônio'
],[
'state_id' => 535,
'name' => 'Oeiras'
],[
'state_id' => 535,
'name' => 'Olho d\'Água do Piauí'
],[
'state_id' => 535,
'name' => 'Padre Marcos'
],[
'state_id' => 535,
'name' => 'Paes Landim'
],[
'state_id' => 535,
'name' => 'Pajeú do Piauí'
],[
'state_id' => 535,
'name' => 'Palmeira do Piauí'
],[
'state_id' => 535,
'name' => 'Palmeirais'
],[
'state_id' => 535,
'name' => 'Paquetá'
],[
'state_id' => 535,
'name' => 'Parnaguá'
],[
'state_id' => 535,
'name' => 'Parnaíba'
],[
'state_id' => 535,
'name' => 'Passagem Franca do Piauí'
],[
'state_id' => 535,
'name' => 'Patos do Piauí'
],[
'state_id' => 535,
'name' => 'Pau D\'arco do Piauí'
],[
'state_id' => 535,
'name' => 'Paulistana'
],[
'state_id' => 535,
'name' => 'Pavussu'
],[
'state_id' => 535,
'name' => 'Pedro II'
],[
'state_id' => 535,
'name' => 'Pedro Laurentino'
],[
'state_id' => 535,
'name' => 'Picos'
],[
'state_id' => 535,
'name' => 'Pimenteiras'
],[
'state_id' => 535,
'name' => 'Pio IX'
],[
'state_id' => 535,
'name' => 'Piracuruca'
],[
'state_id' => 535,
'name' => 'Piripiri'
],[
'state_id' => 535,
'name' => 'Porto'
],[
'state_id' => 535,
'name' => 'Porto Alegre do Piauí'
],[
'state_id' => 535,
'name' => 'Prata do Piauí'
],[
'state_id' => 535,
'name' => 'Queimada Nova'
],[
'state_id' => 535,
'name' => 'Redenção do Gurguéia'
],[
'state_id' => 535,
'name' => 'Regeneração'
],[
'state_id' => 535,
'name' => 'Riacho Frio'
],[
'state_id' => 535,
'name' => 'Ribeira do Piauí'
],[
'state_id' => 535,
'name' => 'Ribeiro Gonçalves'
],[
'state_id' => 535,
'name' => 'Rio Grande do Piauí'
],[
'state_id' => 535,
'name' => 'Santa Cruz do Piauí'
],[
'state_id' => 535,
'name' => 'Santa Cruz dos Milagres'
],[
'state_id' => 535,
'name' => 'Santa Filomena'
],[
'state_id' => 535,
'name' => 'Santa Luz'
],[
'state_id' => 535,
'name' => 'Santa Rosa do Piauí'
],[
'state_id' => 535,
'name' => 'Santana do Piauí'
],[
'state_id' => 535,
'name' => 'Santo Antônio de Lisboa'
],[
'state_id' => 535,
'name' => 'Santo Antônio dos Milagres'
],[
'state_id' => 535,
'name' => 'Santo Inácio do Piauí'
],[
'state_id' => 535,
'name' => 'Sebastião Barros'
],[
'state_id' => 535,
'name' => 'Sebastião Leal'
],[
'state_id' => 535,
'name' => 'Sigefredo Pacheco'
],[
'state_id' => 535,
'name' => 'Simplício Mendes'
],[
'state_id' => 535,
'name' => 'Simões'
],[
'state_id' => 535,
'name' => 'Socorro do Piauí'
],[
'state_id' => 535,
'name' => 'Sussuapara'
],[
'state_id' => 535,
'name' => 'São Braz do Piauí'
],[
'state_id' => 535,
'name' => 'São Francisco de Assis do Piauí'
],[
'state_id' => 535,
'name' => 'São Francisco do Piauí'
],[
'state_id' => 535,
'name' => 'São Félix do Piauí'
],[
'state_id' => 535,
'name' => 'São Gonçalo do Gurguéia'
],[
'state_id' => 535,
'name' => 'São Gonçalo do Piauí'
],[
'state_id' => 535,
'name' => 'São José do Divino'
],[
'state_id' => 535,
'name' => 'São José do Peixe'
],[
'state_id' => 535,
'name' => 'São José do Piauí'
],[
'state_id' => 535,
'name' => 'São João da Canabrava'
],[
'state_id' => 535,
'name' => 'São João da Fronteira'
],[
'state_id' => 535,
'name' => 'São João da Serra'
],[
'state_id' => 535,
'name' => 'São João da Varjota'
],[
'state_id' => 535,
'name' => 'São João do Arraial'
],[
'state_id' => 535,
'name' => 'São João do Piauí'
],[
'state_id' => 535,
'name' => 'São Julião'
],[
'state_id' => 535,
'name' => 'São Lourenço do Piauí'
],[
'state_id' => 535,
'name' => 'São Luis do Piauí'
],[
'state_id' => 535,
'name' => 'São Miguel da Baixa Grande'
],[
'state_id' => 535,
'name' => 'São Miguel do Fidalgo'
],[
'state_id' => 535,
'name' => 'São Miguel do Tapuio'
],[
'state_id' => 535,
'name' => 'São Pedro do Piauí'
],[
'state_id' => 535,
'name' => 'São Raimundo Nonato'
],[
'state_id' => 535,
'name' => 'Tamboril do Piauí'
],[
'state_id' => 535,
'name' => 'Tanque do Piauí'
],[
'state_id' => 535,
'name' => 'Teresina'
],[
'state_id' => 535,
'name' => 'União'
],[
'state_id' => 535,
'name' => 'Uruçuí'
],[
'state_id' => 535,
'name' => 'Valença do Piauí'
],[
'state_id' => 535,
'name' => 'Vera Mendes'
],[
'state_id' => 535,
'name' => 'Vila Nova do Piauí'
],[
'state_id' => 535,
'name' => 'Várzea Branca'
],[
'state_id' => 535,
'name' => 'Várzea Grande'
],[
'state_id' => 535,
'name' => 'Wall Ferraz'
],[
'state_id' => 535,
'name' => 'Água Branca'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
