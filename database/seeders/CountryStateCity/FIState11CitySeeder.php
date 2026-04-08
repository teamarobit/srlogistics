<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class FIState11CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1265,
'name' => 'Aimala'
],[
'state_id' => 1265,
'name' => 'Aitoo'
],[
'state_id' => 1265,
'name' => 'Akaa'
],[
'state_id' => 1265,
'name' => 'Amuri'
],[
'state_id' => 1265,
'name' => 'Haihara'
],[
'state_id' => 1265,
'name' => 'Hallila'
],[
'state_id' => 1265,
'name' => 'Hervanta'
],[
'state_id' => 1265,
'name' => 'Hämeenkyrö'
],[
'state_id' => 1265,
'name' => 'Ikaalinen'
],[
'state_id' => 1265,
'name' => 'Juupajoki'
],[
'state_id' => 1265,
'name' => 'Kangasala'
],[
'state_id' => 1265,
'name' => 'Kihniö'
],[
'state_id' => 1265,
'name' => 'Kiikka'
],[
'state_id' => 1265,
'name' => 'Kiikoinen'
],[
'state_id' => 1265,
'name' => 'Kolho'
],[
'state_id' => 1265,
'name' => 'Kuhmalahti'
],[
'state_id' => 1265,
'name' => 'Kuru'
],[
'state_id' => 1265,
'name' => 'Kylmäkoski'
],[
'state_id' => 1265,
'name' => 'Lempäälä'
],[
'state_id' => 1265,
'name' => 'Lentävänniemi'
],[
'state_id' => 1265,
'name' => 'Lielahti'
],[
'state_id' => 1265,
'name' => 'Luopioinen'
],[
'state_id' => 1265,
'name' => 'Längelmäki'
],[
'state_id' => 1265,
'name' => 'Messukylä'
],[
'state_id' => 1265,
'name' => 'Mouhijärvi'
],[
'state_id' => 1265,
'name' => 'Mänttä'
],[
'state_id' => 1265,
'name' => 'Naistenmatka'
],[
'state_id' => 1265,
'name' => 'Nekala'
],[
'state_id' => 1265,
'name' => 'Nokia'
],[
'state_id' => 1265,
'name' => 'Nurmi'
],[
'state_id' => 1265,
'name' => 'Nuutajärvi'
],[
'state_id' => 1265,
'name' => 'Orivesi'
],[
'state_id' => 1265,
'name' => 'Osara'
],[
'state_id' => 1265,
'name' => 'Parkano'
],[
'state_id' => 1265,
'name' => 'Pirkkala'
],[
'state_id' => 1265,
'name' => 'Pispala'
],[
'state_id' => 1265,
'name' => 'Pohjaslahti'
],[
'state_id' => 1265,
'name' => 'Punkalaidun'
],[
'state_id' => 1265,
'name' => 'Pälkäne'
],[
'state_id' => 1265,
'name' => 'Ruovesi'
],[
'state_id' => 1265,
'name' => 'Sahalahti'
],[
'state_id' => 1265,
'name' => 'Sastamala'
],[
'state_id' => 1265,
'name' => 'Suodenniemi'
],[
'state_id' => 1265,
'name' => 'Suoniemi'
],[
'state_id' => 1265,
'name' => 'Sääksmäki'
],[
'state_id' => 1265,
'name' => 'Tampere'
],[
'state_id' => 1265,
'name' => 'Teisko'
],[
'state_id' => 1265,
'name' => 'Toijala'
],[
'state_id' => 1265,
'name' => 'Tottijärvi'
],[
'state_id' => 1265,
'name' => 'Urjala'
],[
'state_id' => 1265,
'name' => 'Valkeakoski'
],[
'state_id' => 1265,
'name' => 'Vammala'
],[
'state_id' => 1265,
'name' => 'Vesilahti'
],[
'state_id' => 1265,
'name' => 'Viiala'
],[
'state_id' => 1265,
'name' => 'Viljakkala'
],[
'state_id' => 1265,
'name' => 'Vilppula'
],[
'state_id' => 1265,
'name' => 'Virrat'
],[
'state_id' => 1265,
'name' => 'Vuores'
],[
'state_id' => 1265,
'name' => 'Ylöjärvi'
],[
'state_id' => 1265,
'name' => 'Äetsä'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
