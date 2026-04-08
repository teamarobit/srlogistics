<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\State;

class XKStateSeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'country_id' => 248,
'name' => 'Prizren District',
'iso2' => 'XPR'
],[
'country_id' => 248,
'name' => 'Peć District',
'iso2' => 'XPE'
],[
'country_id' => 248,
'name' => 'Uroševac District (Ferizaj)',
'iso2' => 'XUF'
],[
'country_id' => 248,
'name' => 'Đakovica District (Gjakove)',
'iso2' => 'XDG'
],[
'country_id' => 248,
'name' => 'Gjilan District',
'iso2' => 'XGJ'
],[
'country_id' => 248,
'name' => 'Kosovska Mitrovica District',
'iso2' => 'XKM'
],[
'country_id' => 248,
'name' => 'Pristina (Priştine)',
'iso2' => 'XPI'
],
];
		foreach($jayParsedAry as $data){
			State::create($data);
		}
	}
}
