<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\State;

class KEStateSeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'country_id' => 113,
'name' => 'Kakamega',
'iso2' => '11'
],[
'country_id' => 113,
'name' => 'Kisii',
'iso2' => '16'
],[
'country_id' => 113,
'name' => 'Busia',
'iso2' => '04'
],[
'country_id' => 113,
'name' => 'Embu',
'iso2' => '06'
],[
'country_id' => 113,
'name' => 'Laikipia',
'iso2' => '20'
],[
'country_id' => 113,
'name' => 'Nandi',
'iso2' => '32'
],[
'country_id' => 113,
'name' => 'Lamu',
'iso2' => '21'
],[
'country_id' => 113,
'name' => 'Kirinyaga',
'iso2' => '15'
],[
'country_id' => 113,
'name' => 'Bungoma',
'iso2' => '03'
],[
'country_id' => 113,
'name' => 'Uasin Gishu',
'iso2' => '44'
],[
'country_id' => 113,
'name' => 'Isiolo',
'iso2' => '09'
],[
'country_id' => 113,
'name' => 'Kisumu',
'iso2' => '17'
],[
'country_id' => 113,
'name' => 'Kwale',
'iso2' => '19'
],[
'country_id' => 113,
'name' => 'Kilifi',
'iso2' => '14'
],[
'country_id' => 113,
'name' => 'Narok',
'iso2' => '33'
],[
'country_id' => 113,
'name' => 'Taita–Taveta',
'iso2' => '39'
],[
'country_id' => 113,
'name' => 'Murang\'a',
'iso2' => '29'
],[
'country_id' => 113,
'name' => 'Nyeri',
'iso2' => '36'
],[
'country_id' => 113,
'name' => 'Baringo',
'iso2' => '01'
],[
'country_id' => 113,
'name' => 'Wajir',
'iso2' => '46'
],[
'country_id' => 113,
'name' => 'Trans Nzoia',
'iso2' => '42'
],[
'country_id' => 113,
'name' => 'Machakos',
'iso2' => '22'
],[
'country_id' => 113,
'name' => 'Tharaka-Nithi',
'iso2' => '41'
],[
'country_id' => 113,
'name' => 'Siaya',
'iso2' => '38'
],[
'country_id' => 113,
'name' => 'Mandera',
'iso2' => '24'
],[
'country_id' => 113,
'name' => 'Makueni',
'iso2' => '23'
],[
'country_id' => 113,
'name' => 'Migori',
'iso2' => '27'
],[
'country_id' => 113,
'name' => 'Nairobi City',
'iso2' => '30'
],[
'country_id' => 113,
'name' => 'Nyandarua',
'iso2' => '35'
],[
'country_id' => 113,
'name' => 'Kericho',
'iso2' => '12'
],[
'country_id' => 113,
'name' => 'Marsabit',
'iso2' => '25'
],[
'country_id' => 113,
'name' => 'Homa Bay',
'iso2' => '08'
],[
'country_id' => 113,
'name' => 'Garissa',
'iso2' => '07'
],[
'country_id' => 113,
'name' => 'Kajiado',
'iso2' => '10'
],[
'country_id' => 113,
'name' => 'Meru',
'iso2' => '26'
],[
'country_id' => 113,
'name' => 'Kiambu',
'iso2' => '13'
],[
'country_id' => 113,
'name' => 'Mombasa',
'iso2' => '28'
],[
'country_id' => 113,
'name' => 'Elgeyo-Marakwet',
'iso2' => '05'
],[
'country_id' => 113,
'name' => 'Vihiga',
'iso2' => '45'
],[
'country_id' => 113,
'name' => 'Nakuru',
'iso2' => '31'
],[
'country_id' => 113,
'name' => 'Tana River',
'iso2' => '40'
],[
'country_id' => 113,
'name' => 'Turkana',
'iso2' => '43'
],[
'country_id' => 113,
'name' => 'Samburu',
'iso2' => '37'
],[
'country_id' => 113,
'name' => 'West Pokot',
'iso2' => '47'
],[
'country_id' => 113,
'name' => 'Nyamira',
'iso2' => '34'
],[
'country_id' => 113,
'name' => 'Bomet',
'iso2' => '02'
],[
'country_id' => 113,
'name' => 'Kitui',
'iso2' => '18'
],
];
		foreach($jayParsedAry as $data){
			State::create($data);
		}
	}
}
