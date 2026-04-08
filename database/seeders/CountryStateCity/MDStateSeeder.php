<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\State;

class MDStateSeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'country_id' => 144,
'name' => 'Cimișlia District',
'iso2' => 'CM'
],[
'country_id' => 144,
'name' => 'Orhei District',
'iso2' => 'OR'
],[
'country_id' => 144,
'name' => 'Bender Municipality',
'iso2' => 'BD'
],[
'country_id' => 144,
'name' => 'Nisporeni District',
'iso2' => 'NI'
],[
'country_id' => 144,
'name' => 'Sîngerei District',
'iso2' => 'SI'
],[
'country_id' => 144,
'name' => 'Căușeni District',
'iso2' => 'CS'
],[
'country_id' => 144,
'name' => 'Călărași District',
'iso2' => 'CL'
],[
'country_id' => 144,
'name' => 'Glodeni District',
'iso2' => 'GL'
],[
'country_id' => 144,
'name' => 'Anenii Noi District',
'iso2' => 'AN'
],[
'country_id' => 144,
'name' => 'Ialoveni District',
'iso2' => 'IA'
],[
'country_id' => 144,
'name' => 'Florești District',
'iso2' => 'FL'
],[
'country_id' => 144,
'name' => 'Telenești District',
'iso2' => 'TE'
],[
'country_id' => 144,
'name' => 'Taraclia District',
'iso2' => 'TA'
],[
'country_id' => 144,
'name' => 'Chișinău Municipality',
'iso2' => 'CU'
],[
'country_id' => 144,
'name' => 'Soroca District',
'iso2' => 'SO'
],[
'country_id' => 144,
'name' => 'Briceni District',
'iso2' => 'BR'
],[
'country_id' => 144,
'name' => 'Rîșcani District',
'iso2' => 'RI'
],[
'country_id' => 144,
'name' => 'Strășeni District',
'iso2' => 'ST'
],[
'country_id' => 144,
'name' => 'Ștefan Vodă District',
'iso2' => 'SV'
],[
'country_id' => 144,
'name' => 'Basarabeasca District',
'iso2' => 'BS'
],[
'country_id' => 144,
'name' => 'Cantemir District',
'iso2' => 'CT'
],[
'country_id' => 144,
'name' => 'Fălești District',
'iso2' => 'FA'
],[
'country_id' => 144,
'name' => 'Hîncești District',
'iso2' => 'HI'
],[
'country_id' => 144,
'name' => 'Dubăsari District',
'iso2' => 'DU'
],[
'country_id' => 144,
'name' => 'Dondușeni District',
'iso2' => 'DO'
],[
'country_id' => 144,
'name' => 'Gagauzia',
'iso2' => 'GA'
],[
'country_id' => 144,
'name' => 'Ungheni District',
'iso2' => 'UN'
],[
'country_id' => 144,
'name' => 'Edineț District',
'iso2' => 'ED'
],[
'country_id' => 144,
'name' => 'Șoldănești District',
'iso2' => 'SD'
],[
'country_id' => 144,
'name' => 'Ocnița District',
'iso2' => 'OC'
],[
'country_id' => 144,
'name' => 'Criuleni District',
'iso2' => 'CR'
],[
'country_id' => 144,
'name' => 'Cahul District',
'iso2' => 'CA'
],[
'country_id' => 144,
'name' => 'Drochia District',
'iso2' => 'DR'
],[
'country_id' => 144,
'name' => 'Bălți Municipality',
'iso2' => 'BA'
],[
'country_id' => 144,
'name' => 'Rezina District',
'iso2' => 'RE'
],[
'country_id' => 144,
'name' => 'Transnistria autonomous territorial unit',
'iso2' => 'SN'
],
];
		foreach($jayParsedAry as $data){
			State::create($data);
		}
	}
}
