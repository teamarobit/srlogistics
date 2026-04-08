<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class BRStateAMCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 531,
'name' => 'Alvarães'
],[
'state_id' => 531,
'name' => 'Amaturá'
],[
'state_id' => 531,
'name' => 'Anamã'
],[
'state_id' => 531,
'name' => 'Anori'
],[
'state_id' => 531,
'name' => 'Apuí'
],[
'state_id' => 531,
'name' => 'Atalaia do Norte'
],[
'state_id' => 531,
'name' => 'Autazes'
],[
'state_id' => 531,
'name' => 'Barcelos'
],[
'state_id' => 531,
'name' => 'Barreirinha'
],[
'state_id' => 531,
'name' => 'Benjamin Constant'
],[
'state_id' => 531,
'name' => 'Beruri'
],[
'state_id' => 531,
'name' => 'Boa Vista do Ramos'
],[
'state_id' => 531,
'name' => 'Boca do Acre'
],[
'state_id' => 531,
'name' => 'Borba'
],[
'state_id' => 531,
'name' => 'Caapiranga'
],[
'state_id' => 531,
'name' => 'Canutama'
],[
'state_id' => 531,
'name' => 'Carauari'
],[
'state_id' => 531,
'name' => 'Careiro'
],[
'state_id' => 531,
'name' => 'Careiro da Várzea'
],[
'state_id' => 531,
'name' => 'Coari'
],[
'state_id' => 531,
'name' => 'Codajás'
],[
'state_id' => 531,
'name' => 'Eirunepé'
],[
'state_id' => 531,
'name' => 'Envira'
],[
'state_id' => 531,
'name' => 'Fonte Boa'
],[
'state_id' => 531,
'name' => 'Guajará'
],[
'state_id' => 531,
'name' => 'Humaitá'
],[
'state_id' => 531,
'name' => 'Ipixuna'
],[
'state_id' => 531,
'name' => 'Iranduba'
],[
'state_id' => 531,
'name' => 'Itacoatiara'
],[
'state_id' => 531,
'name' => 'Itamarati'
],[
'state_id' => 531,
'name' => 'Itapiranga'
],[
'state_id' => 531,
'name' => 'Japurá'
],[
'state_id' => 531,
'name' => 'Juruá'
],[
'state_id' => 531,
'name' => 'Jutaí'
],[
'state_id' => 531,
'name' => 'Lábrea'
],[
'state_id' => 531,
'name' => 'Manacapuru'
],[
'state_id' => 531,
'name' => 'Manaquiri'
],[
'state_id' => 531,
'name' => 'Manaus'
],[
'state_id' => 531,
'name' => 'Manicoré'
],[
'state_id' => 531,
'name' => 'Maraã'
],[
'state_id' => 531,
'name' => 'Maués'
],[
'state_id' => 531,
'name' => 'Nhamundá'
],[
'state_id' => 531,
'name' => 'Nova Olinda do Norte'
],[
'state_id' => 531,
'name' => 'Novo Airão'
],[
'state_id' => 531,
'name' => 'Novo Aripuanã'
],[
'state_id' => 531,
'name' => 'Parintins'
],[
'state_id' => 531,
'name' => 'Pauini'
],[
'state_id' => 531,
'name' => 'Presidente Figueiredo'
],[
'state_id' => 531,
'name' => 'Rio Preto da Eva'
],[
'state_id' => 531,
'name' => 'Santa Isabel do Rio Negro'
],[
'state_id' => 531,
'name' => 'Santo Antônio do Içá'
],[
'state_id' => 531,
'name' => 'Silves'
],[
'state_id' => 531,
'name' => 'São Gabriel da Cachoeira'
],[
'state_id' => 531,
'name' => 'São Paulo de Olivença'
],[
'state_id' => 531,
'name' => 'São Sebastião do Uatumã'
],[
'state_id' => 531,
'name' => 'Tabatinga'
],[
'state_id' => 531,
'name' => 'Tapauá'
],[
'state_id' => 531,
'name' => 'Tefé'
],[
'state_id' => 531,
'name' => 'Tonantins'
],[
'state_id' => 531,
'name' => 'Uarini'
],[
'state_id' => 531,
'name' => 'Urucará'
],[
'state_id' => 531,
'name' => 'Urucurituba'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
