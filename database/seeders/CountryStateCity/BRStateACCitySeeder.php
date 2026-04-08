<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class BRStateACCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 539,
'name' => 'Acrelândia'
],[
'state_id' => 539,
'name' => 'Assis Brasil'
],[
'state_id' => 539,
'name' => 'Brasiléia'
],[
'state_id' => 539,
'name' => 'Bujari'
],[
'state_id' => 539,
'name' => 'Capixaba'
],[
'state_id' => 539,
'name' => 'Cruzeiro do Sul'
],[
'state_id' => 539,
'name' => 'Epitaciolândia'
],[
'state_id' => 539,
'name' => 'Feijó'
],[
'state_id' => 539,
'name' => 'Jordão'
],[
'state_id' => 539,
'name' => 'Manoel Urbano'
],[
'state_id' => 539,
'name' => 'Marechal Thaumaturgo'
],[
'state_id' => 539,
'name' => 'Mâncio Lima'
],[
'state_id' => 539,
'name' => 'Plácido de Castro'
],[
'state_id' => 539,
'name' => 'Porto Acre'
],[
'state_id' => 539,
'name' => 'Porto Walter'
],[
'state_id' => 539,
'name' => 'Rio Branco'
],[
'state_id' => 539,
'name' => 'Rodrigues Alves'
],[
'state_id' => 539,
'name' => 'Santa Rosa do Purus'
],[
'state_id' => 539,
'name' => 'Sena Madureira'
],[
'state_id' => 539,
'name' => 'Senador Guiomard'
],[
'state_id' => 539,
'name' => 'Tarauacá'
],[
'state_id' => 539,
'name' => 'Xapuri'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
