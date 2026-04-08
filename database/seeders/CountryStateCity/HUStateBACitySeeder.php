<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class HUStateBACitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1656,
'name' => 'Beremend'
],[
'state_id' => 1656,
'name' => 'Bóly'
],[
'state_id' => 1656,
'name' => 'Bólyi Járás'
],[
'state_id' => 1656,
'name' => 'Bükkösd'
],[
'state_id' => 1656,
'name' => 'Dunaszekcső'
],[
'state_id' => 1656,
'name' => 'Harkány'
],[
'state_id' => 1656,
'name' => 'Hegyháti Járás'
],[
'state_id' => 1656,
'name' => 'Hidas'
],[
'state_id' => 1656,
'name' => 'Hosszúhetény'
],[
'state_id' => 1656,
'name' => 'Komló'
],[
'state_id' => 1656,
'name' => 'Komlói Járás'
],[
'state_id' => 1656,
'name' => 'Kozármisleny'
],[
'state_id' => 1656,
'name' => 'Lánycsók'
],[
'state_id' => 1656,
'name' => 'Mecseknádasd'
],[
'state_id' => 1656,
'name' => 'Mohács'
],[
'state_id' => 1656,
'name' => 'Mohácsi Járás'
],[
'state_id' => 1656,
'name' => 'Mágocs'
],[
'state_id' => 1656,
'name' => 'Pellérd'
],[
'state_id' => 1656,
'name' => 'Pécs'
],[
'state_id' => 1656,
'name' => 'Pécsi Járás'
],[
'state_id' => 1656,
'name' => 'Pécsvárad'
],[
'state_id' => 1656,
'name' => 'Pécsváradi Járás'
],[
'state_id' => 1656,
'name' => 'Sellye'
],[
'state_id' => 1656,
'name' => 'Sellyei Járás'
],[
'state_id' => 1656,
'name' => 'Siklós'
],[
'state_id' => 1656,
'name' => 'Siklósi Járás'
],[
'state_id' => 1656,
'name' => 'Szentlőrinc'
],[
'state_id' => 1656,
'name' => 'Szentlőrinci Járás'
],[
'state_id' => 1656,
'name' => 'Szigetvár'
],[
'state_id' => 1656,
'name' => 'Szigetvári Járás'
],[
'state_id' => 1656,
'name' => 'Szászvár'
],[
'state_id' => 1656,
'name' => 'Sásd'
],[
'state_id' => 1656,
'name' => 'Vajszló'
],[
'state_id' => 1656,
'name' => 'Villány'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
