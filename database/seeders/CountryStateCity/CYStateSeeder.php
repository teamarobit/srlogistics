<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\State;

class CYStateSeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'country_id' => 57,
'name' => 'Kyrenia District (Keryneia)',
'iso2' => '06'
],[
'country_id' => 57,
'name' => 'Nicosia District (Lefkoşa)',
'iso2' => '01'
],[
'country_id' => 57,
'name' => 'Paphos District (Pafos)',
'iso2' => '05'
],[
'country_id' => 57,
'name' => 'Larnaca District (Larnaka)',
'iso2' => '03'
],[
'country_id' => 57,
'name' => 'Limassol District (Leymasun)',
'iso2' => '02'
],[
'country_id' => 57,
'name' => 'Famagusta District (Mağusa)',
'iso2' => '04'
],
];
		foreach($jayParsedAry as $data){
			State::create($data);
		}
	}
}
