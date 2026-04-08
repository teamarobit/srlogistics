<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\State;

class BGStateSeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'country_id' => 34,
'name' => 'Gabrovo Province',
'iso2' => '07'
],[
'country_id' => 34,
'name' => 'Smolyan Province',
'iso2' => '21'
],[
'country_id' => 34,
'name' => 'Pernik Province',
'iso2' => '14'
],[
'country_id' => 34,
'name' => 'Montana Province',
'iso2' => '12'
],[
'country_id' => 34,
'name' => 'Vidin Province',
'iso2' => '05'
],[
'country_id' => 34,
'name' => 'Razgrad Province',
'iso2' => '17'
],[
'country_id' => 34,
'name' => 'Blagoevgrad Province',
'iso2' => '01'
],[
'country_id' => 34,
'name' => 'Sliven Province',
'iso2' => '20'
],[
'country_id' => 34,
'name' => 'Plovdiv Province',
'iso2' => '16'
],[
'country_id' => 34,
'name' => 'Kardzhali Province',
'iso2' => '09'
],[
'country_id' => 34,
'name' => 'Kyustendil Province',
'iso2' => '10'
],[
'country_id' => 34,
'name' => 'Haskovo Province',
'iso2' => '26'
],[
'country_id' => 34,
'name' => 'Sofia City Province',
'iso2' => '22'
],[
'country_id' => 34,
'name' => 'Pleven Province',
'iso2' => '15'
],[
'country_id' => 34,
'name' => 'Stara Zagora Province',
'iso2' => '24'
],[
'country_id' => 34,
'name' => 'Silistra Province',
'iso2' => '19'
],[
'country_id' => 34,
'name' => 'Veliko Tarnovo Province',
'iso2' => '04'
],[
'country_id' => 34,
'name' => 'Lovech Province',
'iso2' => '11'
],[
'country_id' => 34,
'name' => 'Vratsa Province',
'iso2' => '06'
],[
'country_id' => 34,
'name' => 'Pazardzhik Province',
'iso2' => '13'
],[
'country_id' => 34,
'name' => 'Ruse Province',
'iso2' => '18'
],[
'country_id' => 34,
'name' => 'Targovishte Province',
'iso2' => '25'
],[
'country_id' => 34,
'name' => 'Burgas Province',
'iso2' => '02'
],[
'country_id' => 34,
'name' => 'Yambol Province',
'iso2' => '28'
],[
'country_id' => 34,
'name' => 'Varna Province',
'iso2' => '03'
],[
'country_id' => 34,
'name' => 'Dobrich Province',
'iso2' => '08'
],[
'country_id' => 34,
'name' => 'Sofia Province',
'iso2' => '23'
],[
'country_id' => 34,
'name' => 'Shumen',
'iso2' => '27'
],
];
		foreach($jayParsedAry as $data){
			State::create($data);
		}
	}
}
