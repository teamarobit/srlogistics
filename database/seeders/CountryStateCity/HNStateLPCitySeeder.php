<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class HNStateLPCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1610,
'name' => 'Aguanqueterique'
],[
'state_id' => 1610,
'name' => 'Cabañas'
],[
'state_id' => 1610,
'name' => 'Cane'
],[
'state_id' => 1610,
'name' => 'Chinacla'
],[
'state_id' => 1610,
'name' => 'Guajiquiro'
],[
'state_id' => 1610,
'name' => 'La Paz'
],[
'state_id' => 1610,
'name' => 'Lauterique'
],[
'state_id' => 1610,
'name' => 'Los Planes'
],[
'state_id' => 1610,
'name' => 'Marcala'
],[
'state_id' => 1610,
'name' => 'Mercedes de Oriente'
],[
'state_id' => 1610,
'name' => 'Opatoro'
],[
'state_id' => 1610,
'name' => 'San Antonio del Norte'
],[
'state_id' => 1610,
'name' => 'San José'
],[
'state_id' => 1610,
'name' => 'San Juan'
],[
'state_id' => 1610,
'name' => 'San Pedro de Tutule'
],[
'state_id' => 1610,
'name' => 'Santa Ana'
],[
'state_id' => 1610,
'name' => 'Santa Elena'
],[
'state_id' => 1610,
'name' => 'Santa María'
],[
'state_id' => 1610,
'name' => 'Santiago Puringla'
],[
'state_id' => 1610,
'name' => 'Tepanguare'
],[
'state_id' => 1610,
'name' => 'Yarula'
],[
'state_id' => 1610,
'name' => 'Yarumela'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
