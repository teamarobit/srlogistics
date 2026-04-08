<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class AUStateTASCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 211,
'name' => 'Acton Park'
],[
'state_id' => 211,
'name' => 'Austins Ferry'
],[
'state_id' => 211,
'name' => 'Bagdad'
],[
'state_id' => 211,
'name' => 'Battery Point'
],[
'state_id' => 211,
'name' => 'Beaconsfield'
],[
'state_id' => 211,
'name' => 'Beauty Point'
],[
'state_id' => 211,
'name' => 'Bellerive'
],[
'state_id' => 211,
'name' => 'Berriedale'
],[
'state_id' => 211,
'name' => 'Blackmans Bay'
],[
'state_id' => 211,
'name' => 'Blackstone Heights'
],[
'state_id' => 211,
'name' => 'Break O\'Day'
],[
'state_id' => 211,
'name' => 'Bridgewater'
],[
'state_id' => 211,
'name' => 'Bridport'
],[
'state_id' => 211,
'name' => 'Brighton'
],[
'state_id' => 211,
'name' => 'Burnie'
],[
'state_id' => 211,
'name' => 'Cambridge'
],[
'state_id' => 211,
'name' => 'Central Coast'
],[
'state_id' => 211,
'name' => 'Central Highlands'
],[
'state_id' => 211,
'name' => 'Chigwell'
],[
'state_id' => 211,
'name' => 'Circular Head'
],[
'state_id' => 211,
'name' => 'Claremont'
],[
'state_id' => 211,
'name' => 'Clarence'
],[
'state_id' => 211,
'name' => 'Clarendon Vale'
],[
'state_id' => 211,
'name' => 'Cressy'
],[
'state_id' => 211,
'name' => 'Currie'
],[
'state_id' => 211,
'name' => 'Cygnet'
],[
'state_id' => 211,
'name' => 'Deloraine'
],[
'state_id' => 211,
'name' => 'Derwent Valley'
],[
'state_id' => 211,
'name' => 'Devonport'
],[
'state_id' => 211,
'name' => 'Dodges Ferry'
],[
'state_id' => 211,
'name' => 'Dorset'
],[
'state_id' => 211,
'name' => 'Dynnyrne'
],[
'state_id' => 211,
'name' => 'East Devonport'
],[
'state_id' => 211,
'name' => 'East Launceston'
],[
'state_id' => 211,
'name' => 'Evandale'
],[
'state_id' => 211,
'name' => 'Flinders'
],[
'state_id' => 211,
'name' => 'Franklin'
],[
'state_id' => 211,
'name' => 'Gagebrook'
],[
'state_id' => 211,
'name' => 'Geeveston'
],[
'state_id' => 211,
'name' => 'Geilston Bay'
],[
'state_id' => 211,
'name' => 'George Town'
],[
'state_id' => 211,
'name' => 'Glamorgan/Spring Bay'
],[
'state_id' => 211,
'name' => 'Glenorchy'
],[
'state_id' => 211,
'name' => 'Goodwood'
],[
'state_id' => 211,
'name' => 'Granton'
],[
'state_id' => 211,
'name' => 'Hadspen'
],[
'state_id' => 211,
'name' => 'Herdsmans Cove'
],[
'state_id' => 211,
'name' => 'Hillcrest'
],[
'state_id' => 211,
'name' => 'Hobart'
],[
'state_id' => 211,
'name' => 'Hobart city centre'
],[
'state_id' => 211,
'name' => 'Howrah'
],[
'state_id' => 211,
'name' => 'Huon Valley'
],[
'state_id' => 211,
'name' => 'Huonville'
],[
'state_id' => 211,
'name' => 'Invermay'
],[
'state_id' => 211,
'name' => 'Kentish'
],[
'state_id' => 211,
'name' => 'King Island'
],[
'state_id' => 211,
'name' => 'Kingborough'
],[
'state_id' => 211,
'name' => 'Kings Meadows'
],[
'state_id' => 211,
'name' => 'Kingston'
],[
'state_id' => 211,
'name' => 'Kingston Beach'
],[
'state_id' => 211,
'name' => 'Latrobe'
],[
'state_id' => 211,
'name' => 'Lauderdale'
],[
'state_id' => 211,
'name' => 'Launceston'
],[
'state_id' => 211,
'name' => 'Launceston city centre'
],[
'state_id' => 211,
'name' => 'Legana'
],[
'state_id' => 211,
'name' => 'Lenah Valley'
],[
'state_id' => 211,
'name' => 'Lindisfarne'
],[
'state_id' => 211,
'name' => 'Longford'
],[
'state_id' => 211,
'name' => 'Lutana'
],[
'state_id' => 211,
'name' => 'Margate'
],[
'state_id' => 211,
'name' => 'Mayfield'
],[
'state_id' => 211,
'name' => 'Meander Valley'
],[
'state_id' => 211,
'name' => 'Miandetta'
],[
'state_id' => 211,
'name' => 'Midway Point'
],[
'state_id' => 211,
'name' => 'Montello'
],[
'state_id' => 211,
'name' => 'Montrose'
],[
'state_id' => 211,
'name' => 'Moonah'
],[
'state_id' => 211,
'name' => 'Mornington'
],[
'state_id' => 211,
'name' => 'Mount Nelson'
],[
'state_id' => 211,
'name' => 'Mount Stuart'
],[
'state_id' => 211,
'name' => 'Mowbray'
],[
'state_id' => 211,
'name' => 'New Norfolk'
],[
'state_id' => 211,
'name' => 'New Town'
],[
'state_id' => 211,
'name' => 'Newnham'
],[
'state_id' => 211,
'name' => 'Newstead'
],[
'state_id' => 211,
'name' => 'North Hobart'
],[
'state_id' => 211,
'name' => 'Northern Midlands'
],[
'state_id' => 211,
'name' => 'Norwood'
],[
'state_id' => 211,
'name' => 'Oakdowns'
],[
'state_id' => 211,
'name' => 'Old Beach'
],[
'state_id' => 211,
'name' => 'Park Grove'
],[
'state_id' => 211,
'name' => 'Penguin'
],[
'state_id' => 211,
'name' => 'Perth'
],[
'state_id' => 211,
'name' => 'Port Sorell'
],[
'state_id' => 211,
'name' => 'Prospect Vale'
],[
'state_id' => 211,
'name' => 'Queenstown'
],[
'state_id' => 211,
'name' => 'Ranelagh'
],[
'state_id' => 211,
'name' => 'Ravenswood'
],[
'state_id' => 211,
'name' => 'Richmond'
],[
'state_id' => 211,
'name' => 'Risdon Vale'
],[
'state_id' => 211,
'name' => 'Riverside'
],[
'state_id' => 211,
'name' => 'Rocherlea'
],[
'state_id' => 211,
'name' => 'Rokeby'
],[
'state_id' => 211,
'name' => 'Romaine'
],[
'state_id' => 211,
'name' => 'Rosetta'
],[
'state_id' => 211,
'name' => 'Saint Leonards'
],[
'state_id' => 211,
'name' => 'Sandford'
],[
'state_id' => 211,
'name' => 'Sandy Bay'
],[
'state_id' => 211,
'name' => 'Scottsdale'
],[
'state_id' => 211,
'name' => 'Seven Mile Beach'
],[
'state_id' => 211,
'name' => 'Shearwater'
],[
'state_id' => 211,
'name' => 'Sheffield'
],[
'state_id' => 211,
'name' => 'Shorewell Park'
],[
'state_id' => 211,
'name' => 'Smithton'
],[
'state_id' => 211,
'name' => 'Snug'
],[
'state_id' => 211,
'name' => 'Somerset'
],[
'state_id' => 211,
'name' => 'Sorell'
],[
'state_id' => 211,
'name' => 'South Hobart'
],[
'state_id' => 211,
'name' => 'South Launceston'
],[
'state_id' => 211,
'name' => 'Southern Midlands'
],[
'state_id' => 211,
'name' => 'Spreyton'
],[
'state_id' => 211,
'name' => 'St Helens'
],[
'state_id' => 211,
'name' => 'Summerhill'
],[
'state_id' => 211,
'name' => 'Taroona'
],[
'state_id' => 211,
'name' => 'Tasman Peninsula'
],[
'state_id' => 211,
'name' => 'Tranmere'
],[
'state_id' => 211,
'name' => 'Trevallyn'
],[
'state_id' => 211,
'name' => 'Turners Beach'
],[
'state_id' => 211,
'name' => 'Ulverstone'
],[
'state_id' => 211,
'name' => 'Upper Burnie'
],[
'state_id' => 211,
'name' => 'Waratah/Wynyard'
],[
'state_id' => 211,
'name' => 'Warrane'
],[
'state_id' => 211,
'name' => 'Waverley'
],[
'state_id' => 211,
'name' => 'West Coast'
],[
'state_id' => 211,
'name' => 'West Hobart'
],[
'state_id' => 211,
'name' => 'West Launceston'
],[
'state_id' => 211,
'name' => 'West Moonah'
],[
'state_id' => 211,
'name' => 'West Tamar'
],[
'state_id' => 211,
'name' => 'West Ulverstone'
],[
'state_id' => 211,
'name' => 'Westbury'
],[
'state_id' => 211,
'name' => 'Wynyard'
],[
'state_id' => 211,
'name' => 'Youngtown'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
