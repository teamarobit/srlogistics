<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\State;

class CNStateSeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'country_id' => 45,
'name' => 'Zhejiang',
'iso2' => 'ZJ'
],[
'country_id' => 45,
'name' => 'Fujian',
'iso2' => 'FJ'
],[
'country_id' => 45,
'name' => 'Shanghai',
'iso2' => 'SH'
],[
'country_id' => 45,
'name' => 'Jiangsu',
'iso2' => 'JS'
],[
'country_id' => 45,
'name' => 'Anhui',
'iso2' => 'AH'
],[
'country_id' => 45,
'name' => 'Shandong',
'iso2' => 'SD'
],[
'country_id' => 45,
'name' => 'Jilin',
'iso2' => 'JL'
],[
'country_id' => 45,
'name' => 'Shanxi',
'iso2' => 'SX'
],[
'country_id' => 45,
'name' => 'Taiwan',
'iso2' => 'TW'
],[
'country_id' => 45,
'name' => 'Jiangxi',
'iso2' => 'JX'
],[
'country_id' => 45,
'name' => 'Beijing',
'iso2' => 'BJ'
],[
'country_id' => 45,
'name' => 'Hunan',
'iso2' => 'HN'
],[
'country_id' => 45,
'name' => 'Henan',
'iso2' => 'HA'
],[
'country_id' => 45,
'name' => 'Yunnan',
'iso2' => 'YN'
],[
'country_id' => 45,
'name' => 'Guizhou',
'iso2' => 'GZ'
],[
'country_id' => 45,
'name' => 'Ningxia Huizu',
'iso2' => 'NX'
],[
'country_id' => 45,
'name' => 'Xinjiang',
'iso2' => 'XJ'
],[
'country_id' => 45,
'name' => 'Xizang',
'iso2' => 'XZ'
],[
'country_id' => 45,
'name' => 'Heilongjiang',
'iso2' => 'HL'
],[
'country_id' => 45,
'name' => 'Macau SAR',
'iso2' => 'MO'
],[
'country_id' => 45,
'name' => 'Hong Kong SAR',
'iso2' => 'HK'
],[
'country_id' => 45,
'name' => 'Liaoning',
'iso2' => 'LN'
],[
'country_id' => 45,
'name' => 'Inner Mongolia',
'iso2' => 'NM'
],[
'country_id' => 45,
'name' => 'Qinghai',
'iso2' => 'QH'
],[
'country_id' => 45,
'name' => 'Chongqing',
'iso2' => 'CQ'
],[
'country_id' => 45,
'name' => 'Shaanxi',
'iso2' => 'SN'
],[
'country_id' => 45,
'name' => 'Hainan',
'iso2' => 'HI'
],[
'country_id' => 45,
'name' => 'Hubei',
'iso2' => 'HB'
],[
'country_id' => 45,
'name' => 'Gansu',
'iso2' => 'GS'
],[
'country_id' => 45,
'name' => 'Tianjin',
'iso2' => 'TJ'
],[
'country_id' => 45,
'name' => 'Sichuan',
'iso2' => 'SC'
],[
'country_id' => 45,
'name' => 'Guangxi Zhuang',
'iso2' => 'GX'
],[
'country_id' => 45,
'name' => 'Guangdong',
'iso2' => 'GD'
],[
'country_id' => 45,
'name' => 'Hebei',
'iso2' => 'HE'
],
];
		foreach($jayParsedAry as $data){
			State::create($data);
		}
	}
}
