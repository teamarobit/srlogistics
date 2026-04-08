<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class IEStateMCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1809,
'name' => 'Abbeyfeale'
],[
'state_id' => 1809,
'name' => 'Adare'
],[
'state_id' => 1809,
'name' => 'Aghada'
],[
'state_id' => 1809,
'name' => 'An Clár'
],[
'state_id' => 1809,
'name' => 'Annacotty'
],[
'state_id' => 1809,
'name' => 'Ardnacrusha'
],[
'state_id' => 1809,
'name' => 'Askeaton'
],[
'state_id' => 1809,
'name' => 'Ballina'
],[
'state_id' => 1809,
'name' => 'Ballybunnion'
],[
'state_id' => 1809,
'name' => 'Bandon'
],[
'state_id' => 1809,
'name' => 'Bantry'
],[
'state_id' => 1809,
'name' => 'Blarney'
],[
'state_id' => 1809,
'name' => 'Caherconlish'
],[
'state_id' => 1809,
'name' => 'Cahersiveen'
],[
'state_id' => 1809,
'name' => 'Cahir'
],[
'state_id' => 1809,
'name' => 'Carrick-on-Suir'
],[
'state_id' => 1809,
'name' => 'Carrigaline'
],[
'state_id' => 1809,
'name' => 'Carrigtwohill'
],[
'state_id' => 1809,
'name' => 'Cashel'
],[
'state_id' => 1809,
'name' => 'Castleconnell'
],[
'state_id' => 1809,
'name' => 'Castleisland'
],[
'state_id' => 1809,
'name' => 'Castlemartyr'
],[
'state_id' => 1809,
'name' => 'Ciarraí'
],[
'state_id' => 1809,
'name' => 'Cill Airne'
],[
'state_id' => 1809,
'name' => 'Clonakilty'
],[
'state_id' => 1809,
'name' => 'Cloyne'
],[
'state_id' => 1809,
'name' => 'Cluain Meala'
],[
'state_id' => 1809,
'name' => 'Cobh'
],[
'state_id' => 1809,
'name' => 'Cork'
],[
'state_id' => 1809,
'name' => 'Cork City'
],[
'state_id' => 1809,
'name' => 'County Cork'
],[
'state_id' => 1809,
'name' => 'County Tipperary'
],[
'state_id' => 1809,
'name' => 'Croom'
],[
'state_id' => 1809,
'name' => 'Crosshaven'
],[
'state_id' => 1809,
'name' => 'Derry'
],[
'state_id' => 1809,
'name' => 'Dingle'
],[
'state_id' => 1809,
'name' => 'Dungarvan'
],[
'state_id' => 1809,
'name' => 'Dunmanway'
],[
'state_id' => 1809,
'name' => 'Dunmore East'
],[
'state_id' => 1809,
'name' => 'Ennis'
],[
'state_id' => 1809,
'name' => 'Fermoy'
],[
'state_id' => 1809,
'name' => 'Fethard'
],[
'state_id' => 1809,
'name' => 'Kanturk'
],[
'state_id' => 1809,
'name' => 'Kenmare'
],[
'state_id' => 1809,
'name' => 'Killaloe'
],[
'state_id' => 1809,
'name' => 'Killorglin'
],[
'state_id' => 1809,
'name' => 'Killumney'
],[
'state_id' => 1809,
'name' => 'Kilmallock'
],[
'state_id' => 1809,
'name' => 'Kilrush'
],[
'state_id' => 1809,
'name' => 'Kinsale'
],[
'state_id' => 1809,
'name' => 'Listowel'
],[
'state_id' => 1809,
'name' => 'Luimneach'
],[
'state_id' => 1809,
'name' => 'Macroom'
],[
'state_id' => 1809,
'name' => 'Mallow'
],[
'state_id' => 1809,
'name' => 'Midleton'
],[
'state_id' => 1809,
'name' => 'Millstreet'
],[
'state_id' => 1809,
'name' => 'Mitchelstown'
],[
'state_id' => 1809,
'name' => 'Moroe'
],[
'state_id' => 1809,
'name' => 'Moyross'
],[
'state_id' => 1809,
'name' => 'Nenagh'
],[
'state_id' => 1809,
'name' => 'Nenagh Bridge'
],[
'state_id' => 1809,
'name' => 'Newcastle West'
],[
'state_id' => 1809,
'name' => 'Newmarket on Fergus'
],[
'state_id' => 1809,
'name' => 'Newport'
],[
'state_id' => 1809,
'name' => 'Passage West'
],[
'state_id' => 1809,
'name' => 'Portlaw'
],[
'state_id' => 1809,
'name' => 'Rathcormac'
],[
'state_id' => 1809,
'name' => 'Rathkeale'
],[
'state_id' => 1809,
'name' => 'Roscrea'
],[
'state_id' => 1809,
'name' => 'Ráth Luirc'
],[
'state_id' => 1809,
'name' => 'Shannon'
],[
'state_id' => 1809,
'name' => 'Sixmilebridge'
],[
'state_id' => 1809,
'name' => 'Skibbereen'
],[
'state_id' => 1809,
'name' => 'Templemore'
],[
'state_id' => 1809,
'name' => 'Thurles'
],[
'state_id' => 1809,
'name' => 'Tipperary'
],[
'state_id' => 1809,
'name' => 'Tower'
],[
'state_id' => 1809,
'name' => 'Tralee'
],[
'state_id' => 1809,
'name' => 'Trá Mhór'
],[
'state_id' => 1809,
'name' => 'Waterford'
],[
'state_id' => 1809,
'name' => 'Watergrasshill'
],[
'state_id' => 1809,
'name' => 'Whitegate'
],[
'state_id' => 1809,
'name' => 'Youghal'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
