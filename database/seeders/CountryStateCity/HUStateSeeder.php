<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\State;

class HUStateSeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'country_id' => 99,
'name' => 'Hódmezővásárhely',
'iso2' => 'HV'
],[
'country_id' => 99,
'name' => 'Érd',
'iso2' => 'ER'
],[
'country_id' => 99,
'name' => 'Szeged',
'iso2' => 'SD'
],[
'country_id' => 99,
'name' => 'Nagykanizsa',
'iso2' => 'NK'
],[
'country_id' => 99,
'name' => 'Csongrád County',
'iso2' => 'CS'
],[
'country_id' => 99,
'name' => 'Debrecen',
'iso2' => 'DE'
],[
'country_id' => 99,
'name' => 'Székesfehérvár',
'iso2' => 'SF'
],[
'country_id' => 99,
'name' => 'Nyíregyháza',
'iso2' => 'NY'
],[
'country_id' => 99,
'name' => 'Somogy County',
'iso2' => 'SO'
],[
'country_id' => 99,
'name' => 'Békéscsaba',
'iso2' => 'BC'
],[
'country_id' => 99,
'name' => 'Eger',
'iso2' => 'EG'
],[
'country_id' => 99,
'name' => 'Tolna County',
'iso2' => 'TO'
],[
'country_id' => 99,
'name' => 'Vas County',
'iso2' => 'VA'
],[
'country_id' => 99,
'name' => 'Heves County',
'iso2' => 'HE'
],[
'country_id' => 99,
'name' => 'Győr',
'iso2' => 'GY'
],[
'country_id' => 99,
'name' => 'Győr-Moson-Sopron County',
'iso2' => 'GS'
],[
'country_id' => 99,
'name' => 'Jász-Nagykun-Szolnok County',
'iso2' => 'JN'
],[
'country_id' => 99,
'name' => 'Fejér County',
'iso2' => 'FE'
],[
'country_id' => 99,
'name' => 'Szabolcs-Szatmár-Bereg County',
'iso2' => 'SZ'
],[
'country_id' => 99,
'name' => 'Zala County',
'iso2' => 'ZA'
],[
'country_id' => 99,
'name' => 'Szolnok',
'iso2' => 'SK'
],[
'country_id' => 99,
'name' => 'Bács-Kiskun',
'iso2' => 'BK'
],[
'country_id' => 99,
'name' => 'Dunaújváros',
'iso2' => 'DU'
],[
'country_id' => 99,
'name' => 'Zalaegerszeg',
'iso2' => 'ZE'
],[
'country_id' => 99,
'name' => 'Nógrád County',
'iso2' => 'NO'
],[
'country_id' => 99,
'name' => 'Szombathely',
'iso2' => 'SH'
],[
'country_id' => 99,
'name' => 'Pécs',
'iso2' => 'PS'
],[
'country_id' => 99,
'name' => 'Veszprém County',
'iso2' => 'VE'
],[
'country_id' => 99,
'name' => 'Baranya',
'iso2' => 'BA'
],[
'country_id' => 99,
'name' => 'Kecskemét',
'iso2' => 'KM'
],[
'country_id' => 99,
'name' => 'Sopron',
'iso2' => 'SN'
],[
'country_id' => 99,
'name' => 'Borsod-Abaúj-Zemplén',
'iso2' => 'BZ'
],[
'country_id' => 99,
'name' => 'Pest County',
'iso2' => 'PE'
],[
'country_id' => 99,
'name' => 'Békés',
'iso2' => 'BE'
],[
'country_id' => 99,
'name' => 'Szekszárd',
'iso2' => 'SS'
],[
'country_id' => 99,
'name' => 'Veszprém',
'iso2' => 'VM'
],[
'country_id' => 99,
'name' => 'Hajdú-Bihar County',
'iso2' => 'HB'
],[
'country_id' => 99,
'name' => 'Budapest',
'iso2' => 'BU'
],[
'country_id' => 99,
'name' => 'Miskolc',
'iso2' => 'MI'
],[
'country_id' => 99,
'name' => 'Tatabánya',
'iso2' => 'TB'
],[
'country_id' => 99,
'name' => 'Kaposvár',
'iso2' => 'KV'
],[
'country_id' => 99,
'name' => 'Salgótarján',
'iso2' => 'ST'
],[
'country_id' => 99,
'name' => 'Komárom-Esztergom',
'iso2' => 'KE'
],
];
		foreach($jayParsedAry as $data){
			State::create($data);
		}
	}
}
