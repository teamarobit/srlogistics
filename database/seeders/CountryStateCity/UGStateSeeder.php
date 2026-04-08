<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\State;

class UGStateSeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'country_id' => 229,
'name' => 'Rukungiri District',
'iso2' => '412'
],[
'country_id' => 229,
'name' => 'Kyankwanzi District',
'iso2' => '123'
],[
'country_id' => 229,
'name' => 'Kabarole District',
'iso2' => '405'
],[
'country_id' => 229,
'name' => 'Mpigi District',
'iso2' => '106'
],[
'country_id' => 229,
'name' => 'Apac District',
'iso2' => '302'
],[
'country_id' => 229,
'name' => 'Abim District',
'iso2' => '314'
],[
'country_id' => 229,
'name' => 'Yumbe District',
'iso2' => '313'
],[
'country_id' => 229,
'name' => 'Rukiga District',
'iso2' => '431'
],[
'country_id' => 229,
'name' => 'Northern Region',
'iso2' => 'N'
],[
'country_id' => 229,
'name' => 'Serere District',
'iso2' => '232'
],[
'country_id' => 229,
'name' => 'Kamuli District',
'iso2' => '205'
],[
'country_id' => 229,
'name' => 'Amuru District',
'iso2' => '316'
],[
'country_id' => 229,
'name' => 'Kaberamaido District',
'iso2' => '213'
],[
'country_id' => 229,
'name' => 'Namutumba District',
'iso2' => '224'
],[
'country_id' => 229,
'name' => 'Kibuku District',
'iso2' => '227'
],[
'country_id' => 229,
'name' => 'Ibanda District',
'iso2' => '417'
],[
'country_id' => 229,
'name' => 'Iganga District',
'iso2' => '203'
],[
'country_id' => 229,
'name' => 'Dokolo District',
'iso2' => '317'
],[
'country_id' => 229,
'name' => 'Lira District',
'iso2' => '307'
],[
'country_id' => 229,
'name' => 'Bukedea District',
'iso2' => '219'
],[
'country_id' => 229,
'name' => 'Alebtong District',
'iso2' => '323'
],[
'country_id' => 229,
'name' => 'Koboko District',
'iso2' => '319'
],[
'country_id' => 229,
'name' => 'Kiryandongo District',
'iso2' => '421'
],[
'country_id' => 229,
'name' => 'Kiboga District',
'iso2' => '103'
],[
'country_id' => 229,
'name' => 'Kitgum District',
'iso2' => '305'
],[
'country_id' => 229,
'name' => 'Bududa District',
'iso2' => '218'
],[
'country_id' => 229,
'name' => 'Mbale District',
'iso2' => '209'
],[
'country_id' => 229,
'name' => 'Namayingo District',
'iso2' => '230'
],[
'country_id' => 229,
'name' => 'Amuria District',
'iso2' => '216'
],[
'country_id' => 229,
'name' => 'Amudat District',
'iso2' => '324'
],[
'country_id' => 229,
'name' => 'Masindi District',
'iso2' => '409'
],[
'country_id' => 229,
'name' => 'Kiruhura District',
'iso2' => '419'
],[
'country_id' => 229,
'name' => 'Masaka District',
'iso2' => '105'
],[
'country_id' => 229,
'name' => 'Pakwach District',
'iso2' => '332'
],[
'country_id' => 229,
'name' => 'Rubanda District',
'iso2' => '429'
],[
'country_id' => 229,
'name' => 'Tororo District',
'iso2' => '212'
],[
'country_id' => 229,
'name' => 'Kamwenge District',
'iso2' => '413'
],[
'country_id' => 229,
'name' => 'Adjumani District',
'iso2' => '301'
],[
'country_id' => 229,
'name' => 'Wakiso District',
'iso2' => '113'
],[
'country_id' => 229,
'name' => 'Moyo District',
'iso2' => '309'
],[
'country_id' => 229,
'name' => 'Mityana District',
'iso2' => '115'
],[
'country_id' => 229,
'name' => 'Butaleja District',
'iso2' => '221'
],[
'country_id' => 229,
'name' => 'Gomba District',
'iso2' => '121'
],[
'country_id' => 229,
'name' => 'Jinja District',
'iso2' => '204'
],[
'country_id' => 229,
'name' => 'Kayunga District',
'iso2' => '112'
],[
'country_id' => 229,
'name' => 'Kween District',
'iso2' => '228'
],[
'country_id' => 229,
'name' => 'Western Region',
'iso2' => 'W'
],[
'country_id' => 229,
'name' => 'Mubende District',
'iso2' => '107'
],[
'country_id' => 229,
'name' => 'Eastern Region',
'iso2' => 'E'
],[
'country_id' => 229,
'name' => 'Kanungu District',
'iso2' => '414'
],[
'country_id' => 229,
'name' => 'Omoro District',
'iso2' => '331'
],[
'country_id' => 229,
'name' => 'Bukomansimbi District',
'iso2' => '118'
],[
'country_id' => 229,
'name' => 'Lyantonde District',
'iso2' => '114'
],[
'country_id' => 229,
'name' => 'Buikwe District',
'iso2' => '117'
],[
'country_id' => 229,
'name' => 'Nwoya District',
'iso2' => '328'
],[
'country_id' => 229,
'name' => 'Zombo District',
'iso2' => '330'
],[
'country_id' => 229,
'name' => 'Buyende District',
'iso2' => '226'
],[
'country_id' => 229,
'name' => 'Bunyangabu District',
'iso2' => '430'
],[
'country_id' => 229,
'name' => 'Kampala District',
'iso2' => '102'
],[
'country_id' => 229,
'name' => 'Isingiro District',
'iso2' => '418'
],[
'country_id' => 229,
'name' => 'Butambala District',
'iso2' => '119'
],[
'country_id' => 229,
'name' => 'Bukwo District',
'iso2' => '220'
],[
'country_id' => 229,
'name' => 'Bushenyi District',
'iso2' => '402'
],[
'country_id' => 229,
'name' => 'Bugiri District',
'iso2' => '201'
],[
'country_id' => 229,
'name' => 'Butebo District',
'iso2' => '233'
],[
'country_id' => 229,
'name' => 'Buliisa District',
'iso2' => '416'
],[
'country_id' => 229,
'name' => 'Otuke District',
'iso2' => '329'
],[
'country_id' => 229,
'name' => 'Buhweju District',
'iso2' => '420'
],[
'country_id' => 229,
'name' => 'Agago District',
'iso2' => '322'
],[
'country_id' => 229,
'name' => 'Nakapiripirit District',
'iso2' => '311'
],[
'country_id' => 229,
'name' => 'Kalungu District',
'iso2' => '122'
],[
'country_id' => 229,
'name' => 'Moroto District',
'iso2' => '308'
],[
'country_id' => 229,
'name' => 'Central Region',
'iso2' => 'C'
],[
'country_id' => 229,
'name' => 'Oyam District',
'iso2' => '321'
],[
'country_id' => 229,
'name' => 'Kaliro District',
'iso2' => '222'
],[
'country_id' => 229,
'name' => 'Kakumiro District',
'iso2' => '428'
],[
'country_id' => 229,
'name' => 'Namisindwa District',
'iso2' => '234'
],[
'country_id' => 229,
'name' => 'Kole District',
'iso2' => '325'
],[
'country_id' => 229,
'name' => 'Kyenjojo District',
'iso2' => '415'
],[
'country_id' => 229,
'name' => 'Kagadi District',
'iso2' => '427'
],[
'country_id' => 229,
'name' => 'Ntungamo District',
'iso2' => '411'
],[
'country_id' => 229,
'name' => 'Kalangala District',
'iso2' => '101'
],[
'country_id' => 229,
'name' => 'Nakasongola District',
'iso2' => '109'
],[
'country_id' => 229,
'name' => 'Sheema District',
'iso2' => '426'
],[
'country_id' => 229,
'name' => 'Pader District',
'iso2' => '312'
],[
'country_id' => 229,
'name' => 'Kisoro District',
'iso2' => '408'
],[
'country_id' => 229,
'name' => 'Mukono District',
'iso2' => '108'
],[
'country_id' => 229,
'name' => 'Lamwo District',
'iso2' => '326'
],[
'country_id' => 229,
'name' => 'Pallisa District',
'iso2' => '210'
],[
'country_id' => 229,
'name' => 'Gulu District',
'iso2' => '304'
],[
'country_id' => 229,
'name' => 'Buvuma District',
'iso2' => '120'
],[
'country_id' => 229,
'name' => 'Mbarara District',
'iso2' => '410'
],[
'country_id' => 229,
'name' => 'Amolatar District',
'iso2' => '315'
],[
'country_id' => 229,
'name' => 'Lwengo District',
'iso2' => '124'
],[
'country_id' => 229,
'name' => 'Mayuge District',
'iso2' => '214'
],[
'country_id' => 229,
'name' => 'Bundibugyo District',
'iso2' => '401'
],[
'country_id' => 229,
'name' => 'Katakwi District',
'iso2' => '207'
],[
'country_id' => 229,
'name' => 'Maracha District',
'iso2' => '320'
],[
'country_id' => 229,
'name' => 'Ntoroko District',
'iso2' => '424'
],[
'country_id' => 229,
'name' => 'Nakaseke District',
'iso2' => '116'
],[
'country_id' => 229,
'name' => 'Ngora District',
'iso2' => '231'
],[
'country_id' => 229,
'name' => 'Kumi District',
'iso2' => '208'
],[
'country_id' => 229,
'name' => 'Kabale District',
'iso2' => '404'
],[
'country_id' => 229,
'name' => 'Sembabule District',
'iso2' => '111'
],[
'country_id' => 229,
'name' => 'Bulambuli District',
'iso2' => '225'
],[
'country_id' => 229,
'name' => 'Sironko District',
'iso2' => '215'
],[
'country_id' => 229,
'name' => 'Napak District',
'iso2' => '327'
],[
'country_id' => 229,
'name' => 'Busia District',
'iso2' => '202'
],[
'country_id' => 229,
'name' => 'Kapchorwa District',
'iso2' => '206'
],[
'country_id' => 229,
'name' => 'Luwero District',
'iso2' => '104'
],[
'country_id' => 229,
'name' => 'Kaabong District',
'iso2' => '318'
],[
'country_id' => 229,
'name' => 'Mitooma District',
'iso2' => '423'
],[
'country_id' => 229,
'name' => 'Kibaale District',
'iso2' => '407'
],[
'country_id' => 229,
'name' => 'Kyegegwa District',
'iso2' => '422'
],[
'country_id' => 229,
'name' => 'Manafwa District',
'iso2' => '223'
],[
'country_id' => 229,
'name' => 'Rakai District',
'iso2' => '110'
],[
'country_id' => 229,
'name' => 'Kasese District',
'iso2' => '406'
],[
'country_id' => 229,
'name' => 'Budaka District',
'iso2' => '217'
],[
'country_id' => 229,
'name' => 'Rubirizi District',
'iso2' => '425'
],[
'country_id' => 229,
'name' => 'Kotido District',
'iso2' => '306'
],[
'country_id' => 229,
'name' => 'Soroti District',
'iso2' => '211'
],[
'country_id' => 229,
'name' => 'Luuka District',
'iso2' => '229'
],[
'country_id' => 229,
'name' => 'Nebbi District',
'iso2' => '310'
],[
'country_id' => 229,
'name' => 'Arua District',
'iso2' => '303'
],[
'country_id' => 229,
'name' => 'Kyotera District',
'iso2' => '125'
],
];
		foreach($jayParsedAry as $data){
			State::create($data);
		}
	}
}
