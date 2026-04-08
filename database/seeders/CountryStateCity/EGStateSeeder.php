<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\State;

class EGStateSeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'country_id' => 65,
'name' => 'Kafr el-Sheikh',
'iso2' => 'KFS'
],[
'country_id' => 65,
'name' => 'Cairo',
'iso2' => 'C'
],[
'country_id' => 65,
'name' => 'Damietta',
'iso2' => 'DT'
],[
'country_id' => 65,
'name' => 'Aswan',
'iso2' => 'ASN'
],[
'country_id' => 65,
'name' => 'Sohag',
'iso2' => 'SHG'
],[
'country_id' => 65,
'name' => 'North Sinai',
'iso2' => 'SIN'
],[
'country_id' => 65,
'name' => 'Monufia',
'iso2' => 'MNF'
],[
'country_id' => 65,
'name' => 'Port Said',
'iso2' => 'PTS'
],[
'country_id' => 65,
'name' => 'Beni Suef',
'iso2' => 'BNS'
],[
'country_id' => 65,
'name' => 'Matrouh',
'iso2' => 'MT'
],[
'country_id' => 65,
'name' => 'Qalyubia',
'iso2' => 'KB'
],[
'country_id' => 65,
'name' => 'Suez',
'iso2' => 'SUZ'
],[
'country_id' => 65,
'name' => 'Gharbia',
'iso2' => 'GH'
],[
'country_id' => 65,
'name' => 'Alexandria',
'iso2' => 'ALX'
],[
'country_id' => 65,
'name' => 'Asyut',
'iso2' => 'AST'
],[
'country_id' => 65,
'name' => 'South Sinai',
'iso2' => 'JS'
],[
'country_id' => 65,
'name' => 'Faiyum',
'iso2' => 'FYM'
],[
'country_id' => 65,
'name' => 'Giza',
'iso2' => 'GZ'
],[
'country_id' => 65,
'name' => 'Red Sea',
'iso2' => 'BA'
],[
'country_id' => 65,
'name' => 'Beheira',
'iso2' => 'BH'
],[
'country_id' => 65,
'name' => 'Luxor',
'iso2' => 'LX'
],[
'country_id' => 65,
'name' => 'Minya',
'iso2' => 'MN'
],[
'country_id' => 65,
'name' => 'Ismailia',
'iso2' => 'IS'
],[
'country_id' => 65,
'name' => 'Dakahlia',
'iso2' => 'DK'
],[
'country_id' => 65,
'name' => 'New Valley',
'iso2' => 'WAD'
],[
'country_id' => 65,
'name' => 'Qena',
'iso2' => 'KN'
],[
'country_id' => 65,
'name' => 'Sharqia',
'iso2' => 'SHR'
],
];
		foreach($jayParsedAry as $data){
			State::create($data);
		}
	}
}
