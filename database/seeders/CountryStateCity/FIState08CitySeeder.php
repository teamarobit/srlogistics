<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class FIState08CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1270,
'name' => 'Hankasalmi'
],[
'state_id' => 1270,
'name' => 'Joutsa'
],[
'state_id' => 1270,
'name' => 'Jyväskylä'
],[
'state_id' => 1270,
'name' => 'Jämsä'
],[
'state_id' => 1270,
'name' => 'Jämsänkoski'
],[
'state_id' => 1270,
'name' => 'Kannonkoski'
],[
'state_id' => 1270,
'name' => 'Karstula'
],[
'state_id' => 1270,
'name' => 'Keuruu'
],[
'state_id' => 1270,
'name' => 'Kinnula'
],[
'state_id' => 1270,
'name' => 'Kivijärvi'
],[
'state_id' => 1270,
'name' => 'Konnevesi'
],[
'state_id' => 1270,
'name' => 'Korpilahti'
],[
'state_id' => 1270,
'name' => 'Kuhmoinen'
],[
'state_id' => 1270,
'name' => 'Kyyjärvi'
],[
'state_id' => 1270,
'name' => 'Laukaa'
],[
'state_id' => 1270,
'name' => 'Leivonmäki'
],[
'state_id' => 1270,
'name' => 'Luhanka'
],[
'state_id' => 1270,
'name' => 'Multia'
],[
'state_id' => 1270,
'name' => 'Muurame'
],[
'state_id' => 1270,
'name' => 'Petäjävesi'
],[
'state_id' => 1270,
'name' => 'Pihtipudas'
],[
'state_id' => 1270,
'name' => 'Pylkönmäki'
],[
'state_id' => 1270,
'name' => 'Saarijärvi'
],[
'state_id' => 1270,
'name' => 'Sumiainen'
],[
'state_id' => 1270,
'name' => 'Suolahti'
],[
'state_id' => 1270,
'name' => 'Säynätsalo'
],[
'state_id' => 1270,
'name' => 'Toivakka'
],[
'state_id' => 1270,
'name' => 'Uurainen'
],[
'state_id' => 1270,
'name' => 'Viitasaari'
],[
'state_id' => 1270,
'name' => 'Äänekoski'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
