<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\State;

class ROStateSeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'country_id' => 181,
'name' => 'Suceava County',
'iso2' => 'SV'
],[
'country_id' => 181,
'name' => 'Hunedoara County',
'iso2' => 'HD'
],[
'country_id' => 181,
'name' => 'Arges',
'iso2' => 'AG'
],[
'country_id' => 181,
'name' => 'Bihor County',
'iso2' => 'BH'
],[
'country_id' => 181,
'name' => 'Alba',
'iso2' => 'AB'
],[
'country_id' => 181,
'name' => 'Ilfov County',
'iso2' => 'IF'
],[
'country_id' => 181,
'name' => 'Giurgiu County',
'iso2' => 'GR'
],[
'country_id' => 181,
'name' => 'Tulcea County',
'iso2' => 'TL'
],[
'country_id' => 181,
'name' => 'Teleorman County',
'iso2' => 'TR'
],[
'country_id' => 181,
'name' => 'Prahova County',
'iso2' => 'PH'
],[
'country_id' => 181,
'name' => 'Bucharest',
'iso2' => 'B'
],[
'country_id' => 181,
'name' => 'Neamț County',
'iso2' => 'NT'
],[
'country_id' => 181,
'name' => 'Călărași County',
'iso2' => 'CL'
],[
'country_id' => 181,
'name' => 'Bistrița-Năsăud County',
'iso2' => 'BN'
],[
'country_id' => 181,
'name' => 'Cluj County',
'iso2' => 'CJ'
],[
'country_id' => 181,
'name' => 'Iași County',
'iso2' => 'IS'
],[
'country_id' => 181,
'name' => 'Braila',
'iso2' => 'BR'
],[
'country_id' => 181,
'name' => 'Constanța County',
'iso2' => 'CT'
],[
'country_id' => 181,
'name' => 'Olt County',
'iso2' => 'OT'
],[
'country_id' => 181,
'name' => 'Arad County',
'iso2' => 'AR'
],[
'country_id' => 181,
'name' => 'Botoșani County',
'iso2' => 'BT'
],[
'country_id' => 181,
'name' => 'Sălaj County',
'iso2' => 'SJ'
],[
'country_id' => 181,
'name' => 'Dolj County',
'iso2' => 'DJ'
],[
'country_id' => 181,
'name' => 'Ialomița County',
'iso2' => 'IL'
],[
'country_id' => 181,
'name' => 'Bacău County',
'iso2' => 'BC'
],[
'country_id' => 181,
'name' => 'Dâmbovița County',
'iso2' => 'DB'
],[
'country_id' => 181,
'name' => 'Satu Mare County',
'iso2' => 'SM'
],[
'country_id' => 181,
'name' => 'Galați County',
'iso2' => 'GL'
],[
'country_id' => 181,
'name' => 'Timiș County',
'iso2' => 'TM'
],[
'country_id' => 181,
'name' => 'Harghita County',
'iso2' => 'HR'
],[
'country_id' => 181,
'name' => 'Gorj County',
'iso2' => 'GJ'
],[
'country_id' => 181,
'name' => 'Mehedinți County',
'iso2' => 'MH'
],[
'country_id' => 181,
'name' => 'Vaslui County',
'iso2' => 'VS'
],[
'country_id' => 181,
'name' => 'Caraș-Severin County',
'iso2' => 'CS'
],[
'country_id' => 181,
'name' => 'Covasna County',
'iso2' => 'CV'
],[
'country_id' => 181,
'name' => 'Sibiu County',
'iso2' => 'SB'
],[
'country_id' => 181,
'name' => 'Buzău County',
'iso2' => 'BZ'
],[
'country_id' => 181,
'name' => 'Vâlcea County',
'iso2' => 'VL'
],[
'country_id' => 181,
'name' => 'Vrancea County',
'iso2' => 'VN'
],[
'country_id' => 181,
'name' => 'Brașov County',
'iso2' => 'BV'
],[
'country_id' => 181,
'name' => 'Maramureș County',
'iso2' => 'MM'
],[
'country_id' => 181,
'name' => 'Mureș County',
'iso2' => 'MS'
],
];
		foreach($jayParsedAry as $data){
			State::create($data);
		}
	}
}
