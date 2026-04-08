<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class CLStateBICitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 773,
'name' => 'Arauco'
],[
'state_id' => 773,
'name' => 'Cabrero'
],[
'state_id' => 773,
'name' => 'Cañete'
],[
'state_id' => 773,
'name' => 'Chiguayante'
],[
'state_id' => 773,
'name' => 'Concepción'
],[
'state_id' => 773,
'name' => 'Coronel'
],[
'state_id' => 773,
'name' => 'Curanilahue'
],[
'state_id' => 773,
'name' => 'Laja'
],[
'state_id' => 773,
'name' => 'Lebu'
],[
'state_id' => 773,
'name' => 'Los Ángeles'
],[
'state_id' => 773,
'name' => 'Lota'
],[
'state_id' => 773,
'name' => 'Mulchén'
],[
'state_id' => 773,
'name' => 'Nacimiento'
],[
'state_id' => 773,
'name' => 'Penco'
],[
'state_id' => 773,
'name' => 'Alto Biobío'
],[
'state_id' => 773,
'name' => 'Talcahuano'
],[
'state_id' => 773,
'name' => 'Tomé'
],[
'state_id' => 773,
'name' => 'Yumbel'
],[
'state_id' => 773,
'name' => 'Antuco'
],[
'state_id' => 773,
'name' => 'Contulmo'
],[
'state_id' => 773,
'name' => 'Florida'
],[
'state_id' => 773,
'name' => 'Hualpén'
],[
'state_id' => 773,
'name' => 'Hualqui'
],[
'state_id' => 773,
'name' => 'Los Álamos'
],[
'state_id' => 773,
'name' => 'Negrete'
],[
'state_id' => 773,
'name' => 'Quilaco'
],[
'state_id' => 773,
'name' => 'Quilleco'
],[
'state_id' => 773,
'name' => 'San Pedro de la Paz'
],[
'state_id' => 773,
'name' => 'San Rosendo'
],[
'state_id' => 773,
'name' => 'Santa Bárbara'
],[
'state_id' => 773,
'name' => 'Santa Juana'
],[
'state_id' => 773,
'name' => 'Tirúa'
],[
'state_id' => 773,
'name' => 'Tucapel'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
