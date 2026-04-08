<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class CAStateSKCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 697,
'name' => 'Assiniboia'
],[
'state_id' => 697,
'name' => 'Biggar'
],[
'state_id' => 697,
'name' => 'Canora'
],[
'state_id' => 697,
'name' => 'Carlyle'
],[
'state_id' => 697,
'name' => 'Dalmeny'
],[
'state_id' => 697,
'name' => 'Esterhazy'
],[
'state_id' => 697,
'name' => 'Estevan'
],[
'state_id' => 697,
'name' => 'Foam Lake'
],[
'state_id' => 697,
'name' => 'Gravelbourg'
],[
'state_id' => 697,
'name' => 'Hudson Bay'
],[
'state_id' => 697,
'name' => 'Humboldt'
],[
'state_id' => 697,
'name' => 'Indian Head'
],[
'state_id' => 697,
'name' => 'Kamsack'
],[
'state_id' => 697,
'name' => 'Kerrobert'
],[
'state_id' => 697,
'name' => 'Kindersley'
],[
'state_id' => 697,
'name' => 'La Ronge'
],[
'state_id' => 697,
'name' => 'Langenburg'
],[
'state_id' => 697,
'name' => 'Langham'
],[
'state_id' => 697,
'name' => 'Lanigan'
],[
'state_id' => 697,
'name' => 'Lumsden'
],[
'state_id' => 697,
'name' => 'Macklin'
],[
'state_id' => 697,
'name' => 'Maple Creek'
],[
'state_id' => 697,
'name' => 'Martensville'
],[
'state_id' => 697,
'name' => 'Meadow Lake'
],[
'state_id' => 697,
'name' => 'Melfort'
],[
'state_id' => 697,
'name' => 'Melville'
],[
'state_id' => 697,
'name' => 'Moose Jaw'
],[
'state_id' => 697,
'name' => 'Moosomin'
],[
'state_id' => 697,
'name' => 'Nipawin'
],[
'state_id' => 697,
'name' => 'North Battleford'
],[
'state_id' => 697,
'name' => 'Outlook'
],[
'state_id' => 697,
'name' => 'Oxbow'
],[
'state_id' => 697,
'name' => 'Pelican Narrows'
],[
'state_id' => 697,
'name' => 'Pilot Butte'
],[
'state_id' => 697,
'name' => 'Preeceville'
],[
'state_id' => 697,
'name' => 'Prince Albert'
],[
'state_id' => 697,
'name' => 'Regina'
],[
'state_id' => 697,
'name' => 'Regina Beach'
],[
'state_id' => 697,
'name' => 'Rosetown'
],[
'state_id' => 697,
'name' => 'Rosthern'
],[
'state_id' => 697,
'name' => 'Saskatoon'
],[
'state_id' => 697,
'name' => 'Shaunavon'
],[
'state_id' => 697,
'name' => 'Shellbrook'
],[
'state_id' => 697,
'name' => 'Swift Current'
],[
'state_id' => 697,
'name' => 'Tisdale'
],[
'state_id' => 697,
'name' => 'Unity'
],[
'state_id' => 697,
'name' => 'Wadena'
],[
'state_id' => 697,
'name' => 'Warman'
],[
'state_id' => 697,
'name' => 'Watrous'
],[
'state_id' => 697,
'name' => 'Weyburn'
],[
'state_id' => 697,
'name' => 'White City'
],[
'state_id' => 697,
'name' => 'Wilkie'
],[
'state_id' => 697,
'name' => 'Wynyard'
],[
'state_id' => 697,
'name' => 'Yorkton'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
