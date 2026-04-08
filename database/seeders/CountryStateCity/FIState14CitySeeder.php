<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class FIState14CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1264,
'name' => 'Alavieska'
],[
'state_id' => 1264,
'name' => 'Haapajärvi'
],[
'state_id' => 1264,
'name' => 'Haapavesi'
],[
'state_id' => 1264,
'name' => 'Hailuoto'
],[
'state_id' => 1264,
'name' => 'Haukipudas'
],[
'state_id' => 1264,
'name' => 'Himanka'
],[
'state_id' => 1264,
'name' => 'Ii'
],[
'state_id' => 1264,
'name' => 'Kalajoki'
],[
'state_id' => 1264,
'name' => 'Kempele'
],[
'state_id' => 1264,
'name' => 'Kestilä'
],[
'state_id' => 1264,
'name' => 'Kiiminki'
],[
'state_id' => 1264,
'name' => 'Kuivaniemi'
],[
'state_id' => 1264,
'name' => 'Kuusamo'
],[
'state_id' => 1264,
'name' => 'Kärsämäki'
],[
'state_id' => 1264,
'name' => 'Liminka'
],[
'state_id' => 1264,
'name' => 'Lumijoki'
],[
'state_id' => 1264,
'name' => 'Merijärvi'
],[
'state_id' => 1264,
'name' => 'Muhos'
],[
'state_id' => 1264,
'name' => 'Nivala'
],[
'state_id' => 1264,
'name' => 'Oulainen'
],[
'state_id' => 1264,
'name' => 'Oulu'
],[
'state_id' => 1264,
'name' => 'Oulunsalo'
],[
'state_id' => 1264,
'name' => 'Piippola'
],[
'state_id' => 1264,
'name' => 'Pudasjärvi'
],[
'state_id' => 1264,
'name' => 'Pulkkila'
],[
'state_id' => 1264,
'name' => 'Pyhäjoki'
],[
'state_id' => 1264,
'name' => 'Pyhäjärvi'
],[
'state_id' => 1264,
'name' => 'Pyhäntä'
],[
'state_id' => 1264,
'name' => 'Raahe'
],[
'state_id' => 1264,
'name' => 'Rantsila'
],[
'state_id' => 1264,
'name' => 'Reisjärvi'
],[
'state_id' => 1264,
'name' => 'Ruukki'
],[
'state_id' => 1264,
'name' => 'Sievi'
],[
'state_id' => 1264,
'name' => 'Siikajoki'
],[
'state_id' => 1264,
'name' => 'Taivalkoski'
],[
'state_id' => 1264,
'name' => 'Tyrnävä'
],[
'state_id' => 1264,
'name' => 'Utajärvi'
],[
'state_id' => 1264,
'name' => 'Vihanti'
],[
'state_id' => 1264,
'name' => 'Yli-Ii'
],[
'state_id' => 1264,
'name' => 'Ylikiiminki'
],[
'state_id' => 1264,
'name' => 'Ylivieska'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
