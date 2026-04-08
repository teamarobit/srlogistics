<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\State;

class NGStateSeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'country_id' => 161,
'name' => 'Jigawa',
'iso2' => 'JI'
],[
'country_id' => 161,
'name' => 'Enugu',
'iso2' => 'EN'
],[
'country_id' => 161,
'name' => 'Kebbi',
'iso2' => 'KE'
],[
'country_id' => 161,
'name' => 'Benue',
'iso2' => 'BE'
],[
'country_id' => 161,
'name' => 'Sokoto',
'iso2' => 'SO'
],[
'country_id' => 161,
'name' => 'Abuja Federal Capital Territory',
'iso2' => 'FC'
],[
'country_id' => 161,
'name' => 'Kaduna',
'iso2' => 'KD'
],[
'country_id' => 161,
'name' => 'Kwara',
'iso2' => 'KW'
],[
'country_id' => 161,
'name' => 'Oyo',
'iso2' => 'OY'
],[
'country_id' => 161,
'name' => 'Yobe',
'iso2' => 'YO'
],[
'country_id' => 161,
'name' => 'Kogi',
'iso2' => 'KO'
],[
'country_id' => 161,
'name' => 'Zamfara',
'iso2' => 'ZA'
],[
'country_id' => 161,
'name' => 'Kano',
'iso2' => 'KN'
],[
'country_id' => 161,
'name' => 'Nasarawa',
'iso2' => 'NA'
],[
'country_id' => 161,
'name' => 'Plateau',
'iso2' => 'PL'
],[
'country_id' => 161,
'name' => 'Abia',
'iso2' => 'AB'
],[
'country_id' => 161,
'name' => 'Akwa Ibom',
'iso2' => 'AK'
],[
'country_id' => 161,
'name' => 'Bayelsa',
'iso2' => 'BY'
],[
'country_id' => 161,
'name' => 'Lagos',
'iso2' => 'LA'
],[
'country_id' => 161,
'name' => 'Borno',
'iso2' => 'BO'
],[
'country_id' => 161,
'name' => 'Imo',
'iso2' => 'IM'
],[
'country_id' => 161,
'name' => 'Ekiti',
'iso2' => 'EK'
],[
'country_id' => 161,
'name' => 'Gombe',
'iso2' => 'GO'
],[
'country_id' => 161,
'name' => 'Ebonyi',
'iso2' => 'EB'
],[
'country_id' => 161,
'name' => 'Bauchi',
'iso2' => 'BA'
],[
'country_id' => 161,
'name' => 'Katsina',
'iso2' => 'KT'
],[
'country_id' => 161,
'name' => 'Cross River',
'iso2' => 'CR'
],[
'country_id' => 161,
'name' => 'Anambra',
'iso2' => 'AN'
],[
'country_id' => 161,
'name' => 'Delta',
'iso2' => 'DE'
],[
'country_id' => 161,
'name' => 'Niger',
'iso2' => 'NI'
],[
'country_id' => 161,
'name' => 'Edo',
'iso2' => 'ED'
],[
'country_id' => 161,
'name' => 'Taraba',
'iso2' => 'TA'
],[
'country_id' => 161,
'name' => 'Adamawa',
'iso2' => 'AD'
],[
'country_id' => 161,
'name' => 'Ondo',
'iso2' => 'ON'
],[
'country_id' => 161,
'name' => 'Osun',
'iso2' => 'OS'
],[
'country_id' => 161,
'name' => 'Ogun',
'iso2' => 'OG'
],[
'country_id' => 161,
'name' => 'Rivers',
'iso2' => 'RI'
],
];
		foreach($jayParsedAry as $data){
			State::create($data);
		}
	}
}
