<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\State;

class JPStateSeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'country_id' => 109,
'name' => 'Okayama Prefecture',
'iso2' => '33'
],[
'country_id' => 109,
'name' => 'Chiba Prefecture',
'iso2' => '12'
],[
'country_id' => 109,
'name' => 'Ōita Prefecture',
'iso2' => '44'
],[
'country_id' => 109,
'name' => 'Tokyo',
'iso2' => '13'
],[
'country_id' => 109,
'name' => 'Nara Prefecture',
'iso2' => '29'
],[
'country_id' => 109,
'name' => 'Shizuoka Prefecture',
'iso2' => '22'
],[
'country_id' => 109,
'name' => 'Shimane Prefecture',
'iso2' => '32'
],[
'country_id' => 109,
'name' => 'Aichi Prefecture',
'iso2' => '23'
],[
'country_id' => 109,
'name' => 'Hiroshima Prefecture',
'iso2' => '34'
],[
'country_id' => 109,
'name' => 'Akita Prefecture',
'iso2' => '05'
],[
'country_id' => 109,
'name' => 'Ishikawa Prefecture',
'iso2' => '17'
],[
'country_id' => 109,
'name' => 'Hyōgo Prefecture',
'iso2' => '28'
],[
'country_id' => 109,
'name' => 'Hokkaidō Prefecture',
'iso2' => '01'
],[
'country_id' => 109,
'name' => 'Mie Prefecture',
'iso2' => '24'
],[
'country_id' => 109,
'name' => 'Kyōto Prefecture',
'iso2' => '26'
],[
'country_id' => 109,
'name' => 'Yamaguchi Prefecture',
'iso2' => '35'
],[
'country_id' => 109,
'name' => 'Tokushima Prefecture',
'iso2' => '36'
],[
'country_id' => 109,
'name' => 'Yamagata Prefecture',
'iso2' => '06'
],[
'country_id' => 109,
'name' => 'Toyama Prefecture',
'iso2' => '16'
],[
'country_id' => 109,
'name' => 'Aomori Prefecture',
'iso2' => '02'
],[
'country_id' => 109,
'name' => 'Kagoshima Prefecture',
'iso2' => '46'
],[
'country_id' => 109,
'name' => 'Niigata Prefecture',
'iso2' => '15'
],[
'country_id' => 109,
'name' => 'Kanagawa Prefecture',
'iso2' => '14'
],[
'country_id' => 109,
'name' => 'Nagano Prefecture',
'iso2' => '20'
],[
'country_id' => 109,
'name' => 'Wakayama Prefecture',
'iso2' => '30'
],[
'country_id' => 109,
'name' => 'Shiga Prefecture',
'iso2' => '25'
],[
'country_id' => 109,
'name' => 'Kumamoto Prefecture',
'iso2' => '43'
],[
'country_id' => 109,
'name' => 'Fukushima Prefecture',
'iso2' => '07'
],[
'country_id' => 109,
'name' => 'Fukui Prefecture',
'iso2' => '18'
],[
'country_id' => 109,
'name' => 'Nagasaki Prefecture',
'iso2' => '42'
],[
'country_id' => 109,
'name' => 'Tottori Prefecture',
'iso2' => '31'
],[
'country_id' => 109,
'name' => 'Ibaraki Prefecture',
'iso2' => '08'
],[
'country_id' => 109,
'name' => 'Yamanashi Prefecture',
'iso2' => '19'
],[
'country_id' => 109,
'name' => 'Okinawa Prefecture',
'iso2' => '47'
],[
'country_id' => 109,
'name' => 'Tochigi Prefecture',
'iso2' => '09'
],[
'country_id' => 109,
'name' => 'Miyazaki Prefecture',
'iso2' => '45'
],[
'country_id' => 109,
'name' => 'Iwate Prefecture',
'iso2' => '03'
],[
'country_id' => 109,
'name' => 'Miyagi Prefecture',
'iso2' => '04'
],[
'country_id' => 109,
'name' => 'Gifu Prefecture',
'iso2' => '21'
],[
'country_id' => 109,
'name' => 'Ōsaka Prefecture',
'iso2' => '27'
],[
'country_id' => 109,
'name' => 'Saitama Prefecture',
'iso2' => '11'
],[
'country_id' => 109,
'name' => 'Fukuoka Prefecture',
'iso2' => '40'
],[
'country_id' => 109,
'name' => 'Gunma Prefecture',
'iso2' => '10'
],[
'country_id' => 109,
'name' => 'Saga Prefecture',
'iso2' => '41'
],[
'country_id' => 109,
'name' => 'Kagawa Prefecture',
'iso2' => '37'
],[
'country_id' => 109,
'name' => 'Ehime Prefecture',
'iso2' => '38'
],[
'country_id' => 109,
'name' => 'Kōchi Prefecture',
'iso2' => '39'
],
];
		foreach($jayParsedAry as $data){
			State::create($data);
		}
	}
}
