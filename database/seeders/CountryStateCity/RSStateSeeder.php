<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\State;

class RSStateSeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'country_id' => 196,
'name' => 'South Bačka District',
'iso2' => '06'
],[
'country_id' => 196,
'name' => 'Pirot District',
'iso2' => '22'
],[
'country_id' => 196,
'name' => 'South Banat District',
'iso2' => '04'
],[
'country_id' => 196,
'name' => 'North Bačka District',
'iso2' => '01'
],[
'country_id' => 196,
'name' => 'Jablanica District',
'iso2' => '23'
],[
'country_id' => 196,
'name' => 'Central Banat District',
'iso2' => '02'
],[
'country_id' => 196,
'name' => 'Bor District',
'iso2' => '14'
],[
'country_id' => 196,
'name' => 'Toplica District',
'iso2' => '21'
],[
'country_id' => 196,
'name' => 'Mačva District',
'iso2' => '08'
],[
'country_id' => 196,
'name' => 'Rasina District',
'iso2' => '19'
],[
'country_id' => 196,
'name' => 'Pčinja District',
'iso2' => '24'
],[
'country_id' => 196,
'name' => 'Nišava District',
'iso2' => '20'
],[
'country_id' => 196,
'name' => 'Kolubara District',
'iso2' => '09'
],[
'country_id' => 196,
'name' => 'Raška District',
'iso2' => '18'
],[
'country_id' => 196,
'name' => 'West Bačka District',
'iso2' => '05'
],[
'country_id' => 196,
'name' => 'Moravica District',
'iso2' => '17'
],[
'country_id' => 196,
'name' => 'Belgrade',
'iso2' => '00'
],[
'country_id' => 196,
'name' => 'Zlatibor District',
'iso2' => '16'
],[
'country_id' => 196,
'name' => 'Zaječar District',
'iso2' => '15'
],[
'country_id' => 196,
'name' => 'Braničevo District',
'iso2' => '11'
],[
'country_id' => 196,
'name' => 'Vojvodina',
'iso2' => 'VO'
],[
'country_id' => 196,
'name' => 'Šumadija District',
'iso2' => '12'
],[
'country_id' => 196,
'name' => 'North Banat District',
'iso2' => '03'
],[
'country_id' => 196,
'name' => 'Pomoravlje District',
'iso2' => '13'
],[
'country_id' => 196,
'name' => 'Srem District',
'iso2' => '07'
],[
'country_id' => 196,
'name' => 'Podunavlje District',
'iso2' => '10'
],
];
		foreach($jayParsedAry as $data){
			State::create($data);
		}
	}
}
