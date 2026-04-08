<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\State;

class UAStateSeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'country_id' => 230,
'name' => 'Zhytomyrska oblast',
'iso2' => '18'
],[
'country_id' => 230,
'name' => 'Vinnytska oblast',
'iso2' => '05'
],[
'country_id' => 230,
'name' => 'Zakarpatska Oblast',
'iso2' => '21'
],[
'country_id' => 230,
'name' => 'Kyivska oblast',
'iso2' => '32'
],[
'country_id' => 230,
'name' => 'Lvivska oblast',
'iso2' => '46'
],[
'country_id' => 230,
'name' => 'Luhanska oblast',
'iso2' => '09'
],[
'country_id' => 230,
'name' => 'Ternopilska oblast',
'iso2' => '61'
],[
'country_id' => 230,
'name' => 'Dnipropetrovska oblast',
'iso2' => '12'
],[
'country_id' => 230,
'name' => 'Kyiv',
'iso2' => '30'
],[
'country_id' => 230,
'name' => 'Kirovohradska oblast',
'iso2' => '35'
],[
'country_id' => 230,
'name' => 'Chernivetska oblast',
'iso2' => '77'
],[
'country_id' => 230,
'name' => 'Mykolaivska oblast',
'iso2' => '48'
],[
'country_id' => 230,
'name' => 'Cherkaska oblast',
'iso2' => '71'
],[
'country_id' => 230,
'name' => 'Khmelnytska oblast',
'iso2' => '68'
],[
'country_id' => 230,
'name' => 'Ivano-Frankivska oblast',
'iso2' => '26'
],[
'country_id' => 230,
'name' => 'Rivnenska oblast',
'iso2' => '56'
],[
'country_id' => 230,
'name' => 'Khersonska oblast',
'iso2' => '65'
],[
'country_id' => 230,
'name' => 'Sumska oblast',
'iso2' => '59'
],[
'country_id' => 230,
'name' => 'Kharkivska oblast',
'iso2' => '63'
],[
'country_id' => 230,
'name' => 'Zaporizka oblast',
'iso2' => '23'
],[
'country_id' => 230,
'name' => 'Odeska oblast',
'iso2' => '51'
],[
'country_id' => 230,
'name' => 'Autonomous Republic of Crimea',
'iso2' => '43'
],[
'country_id' => 230,
'name' => 'Volynska oblast',
'iso2' => '07'
],[
'country_id' => 230,
'name' => 'Donetska oblast',
'iso2' => '14'
],[
'country_id' => 230,
'name' => 'Chernihivska oblast',
'iso2' => '74'
],[
'country_id' => 230,
'name' => 'Poltavska oblast',
'iso2' => '53'
],
];
		foreach($jayParsedAry as $data){
			State::create($data);
		}
	}
}
