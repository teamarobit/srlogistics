<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class IEStateCCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1816,
'name' => 'Athenry'
],[
'state_id' => 1816,
'name' => 'Ballaghaderreen'
],[
'state_id' => 1816,
'name' => 'Ballina'
],[
'state_id' => 1816,
'name' => 'Ballinasloe'
],[
'state_id' => 1816,
'name' => 'Ballinrobe'
],[
'state_id' => 1816,
'name' => 'Ballisodare'
],[
'state_id' => 1816,
'name' => 'Ballyhaunis'
],[
'state_id' => 1816,
'name' => 'Ballymote'
],[
'state_id' => 1816,
'name' => 'Bearna'
],[
'state_id' => 1816,
'name' => 'Belmullet'
],[
'state_id' => 1816,
'name' => 'Boyle'
],[
'state_id' => 1816,
'name' => 'Carrick-on-Shannon'
],[
'state_id' => 1816,
'name' => 'Castlebar'
],[
'state_id' => 1816,
'name' => 'Castlerea'
],[
'state_id' => 1816,
'name' => 'Claregalway'
],[
'state_id' => 1816,
'name' => 'Claremorris'
],[
'state_id' => 1816,
'name' => 'Clifden'
],[
'state_id' => 1816,
'name' => 'Collooney'
],[
'state_id' => 1816,
'name' => 'County Galway'
],[
'state_id' => 1816,
'name' => 'County Leitrim'
],[
'state_id' => 1816,
'name' => 'Crossmolina'
],[
'state_id' => 1816,
'name' => 'Foxford'
],[
'state_id' => 1816,
'name' => 'Gaillimh'
],[
'state_id' => 1816,
'name' => 'Galway City'
],[
'state_id' => 1816,
'name' => 'Gort'
],[
'state_id' => 1816,
'name' => 'Inishcrone'
],[
'state_id' => 1816,
'name' => 'Kiltamagh'
],[
'state_id' => 1816,
'name' => 'Kinlough'
],[
'state_id' => 1816,
'name' => 'Loughrea'
],[
'state_id' => 1816,
'name' => 'Manorhamilton'
],[
'state_id' => 1816,
'name' => 'Mayo County'
],[
'state_id' => 1816,
'name' => 'Moycullen'
],[
'state_id' => 1816,
'name' => 'Oranmore'
],[
'state_id' => 1816,
'name' => 'Oughterard'
],[
'state_id' => 1816,
'name' => 'Portumna'
],[
'state_id' => 1816,
'name' => 'Roscommon'
],[
'state_id' => 1816,
'name' => 'Sligo'
],[
'state_id' => 1816,
'name' => 'Strandhill'
],[
'state_id' => 1816,
'name' => 'Swinford'
],[
'state_id' => 1816,
'name' => 'Tobercurry'
],[
'state_id' => 1816,
'name' => 'Tuam'
],[
'state_id' => 1816,
'name' => 'Westport'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
