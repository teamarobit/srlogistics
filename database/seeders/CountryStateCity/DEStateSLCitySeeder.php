<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class DEStateSLCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1438,
'name' => 'Beckingen'
],[
'state_id' => 1438,
'name' => 'Bexbach'
],[
'state_id' => 1438,
'name' => 'Blieskastel'
],[
'state_id' => 1438,
'name' => 'Bous'
],[
'state_id' => 1438,
'name' => 'Britten'
],[
'state_id' => 1438,
'name' => 'Dillingen'
],[
'state_id' => 1438,
'name' => 'Ensdorf'
],[
'state_id' => 1438,
'name' => 'Eppelborn'
],[
'state_id' => 1438,
'name' => 'Freisen'
],[
'state_id' => 1438,
'name' => 'Friedrichsthal'
],[
'state_id' => 1438,
'name' => 'Fürstenhausen'
],[
'state_id' => 1438,
'name' => 'Gersheim'
],[
'state_id' => 1438,
'name' => 'Großrosseln'
],[
'state_id' => 1438,
'name' => 'Hangard'
],[
'state_id' => 1438,
'name' => 'Heidstock'
],[
'state_id' => 1438,
'name' => 'Heusweiler'
],[
'state_id' => 1438,
'name' => 'Homburg'
],[
'state_id' => 1438,
'name' => 'Illingen'
],[
'state_id' => 1438,
'name' => 'Kirkel'
],[
'state_id' => 1438,
'name' => 'Kleinblittersdorf'
],[
'state_id' => 1438,
'name' => 'Lebach'
],[
'state_id' => 1438,
'name' => 'Losheim'
],[
'state_id' => 1438,
'name' => 'Ludweiler-Warndt'
],[
'state_id' => 1438,
'name' => 'Luisenthal'
],[
'state_id' => 1438,
'name' => 'Mainzweiler'
],[
'state_id' => 1438,
'name' => 'Marpingen'
],[
'state_id' => 1438,
'name' => 'Merchweiler'
],[
'state_id' => 1438,
'name' => 'Merzig'
],[
'state_id' => 1438,
'name' => 'Mettlach'
],[
'state_id' => 1438,
'name' => 'Nalbach'
],[
'state_id' => 1438,
'name' => 'Namborn'
],[
'state_id' => 1438,
'name' => 'Neunkirchen'
],[
'state_id' => 1438,
'name' => 'Nohfelden'
],[
'state_id' => 1438,
'name' => 'Nonnweiler'
],[
'state_id' => 1438,
'name' => 'Oberthal'
],[
'state_id' => 1438,
'name' => 'Orscholz'
],[
'state_id' => 1438,
'name' => 'Ottweiler'
],[
'state_id' => 1438,
'name' => 'Püttlingen'
],[
'state_id' => 1438,
'name' => 'Quierschied'
],[
'state_id' => 1438,
'name' => 'Riegelsberg'
],[
'state_id' => 1438,
'name' => 'Röchling-Höhe'
],[
'state_id' => 1438,
'name' => 'Saarbrücken'
],[
'state_id' => 1438,
'name' => 'Saarhölzbach'
],[
'state_id' => 1438,
'name' => 'Saarlouis'
],[
'state_id' => 1438,
'name' => 'Saarwellingen'
],[
'state_id' => 1438,
'name' => 'Sankt Ingbert'
],[
'state_id' => 1438,
'name' => 'Sankt Wendel'
],[
'state_id' => 1438,
'name' => 'Schiffweiler'
],[
'state_id' => 1438,
'name' => 'Schmelz'
],[
'state_id' => 1438,
'name' => 'Schwalbach'
],[
'state_id' => 1438,
'name' => 'Spiesen-Elversberg'
],[
'state_id' => 1438,
'name' => 'Sulzbach'
],[
'state_id' => 1438,
'name' => 'Tholey'
],[
'state_id' => 1438,
'name' => 'Völklingen'
],[
'state_id' => 1438,
'name' => 'Wadern'
],[
'state_id' => 1438,
'name' => 'Wadgassen'
],[
'state_id' => 1438,
'name' => 'Wallerfangen'
],[
'state_id' => 1438,
'name' => 'Weiskirchen'
],[
'state_id' => 1438,
'name' => 'Weiten'
],[
'state_id' => 1438,
'name' => 'Überherrn'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
