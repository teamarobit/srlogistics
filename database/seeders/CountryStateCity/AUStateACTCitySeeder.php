<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class AUStateACTCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 210,
'name' => 'Acton'
],[
'state_id' => 210,
'name' => 'Ainslie'
],[
'state_id' => 210,
'name' => 'Amaroo'
],[
'state_id' => 210,
'name' => 'Aranda'
],[
'state_id' => 210,
'name' => 'Banks'
],[
'state_id' => 210,
'name' => 'Barton'
],[
'state_id' => 210,
'name' => 'Belconnen'
],[
'state_id' => 210,
'name' => 'Bonner'
],[
'state_id' => 210,
'name' => 'Bonython'
],[
'state_id' => 210,
'name' => 'Braddon'
],[
'state_id' => 210,
'name' => 'Bruce'
],[
'state_id' => 210,
'name' => 'Calwell'
],[
'state_id' => 210,
'name' => 'Campbell'
],[
'state_id' => 210,
'name' => 'Canberra'
],[
'state_id' => 210,
'name' => 'Casey'
],[
'state_id' => 210,
'name' => 'Chapman'
],[
'state_id' => 210,
'name' => 'Charnwood'
],[
'state_id' => 210,
'name' => 'Chifley'
],[
'state_id' => 210,
'name' => 'Chisholm'
],[
'state_id' => 210,
'name' => 'City'
],[
'state_id' => 210,
'name' => 'Conder'
],[
'state_id' => 210,
'name' => 'Cook'
],[
'state_id' => 210,
'name' => 'Coombs'
],[
'state_id' => 210,
'name' => 'Crace'
],[
'state_id' => 210,
'name' => 'Curtin'
],[
'state_id' => 210,
'name' => 'Deakin'
],[
'state_id' => 210,
'name' => 'Dickson'
],[
'state_id' => 210,
'name' => 'Downer'
],[
'state_id' => 210,
'name' => 'Duffy'
],[
'state_id' => 210,
'name' => 'Dunlop'
],[
'state_id' => 210,
'name' => 'Evatt'
],[
'state_id' => 210,
'name' => 'Fadden'
],[
'state_id' => 210,
'name' => 'Farrer'
],[
'state_id' => 210,
'name' => 'Fisher'
],[
'state_id' => 210,
'name' => 'Florey'
],[
'state_id' => 210,
'name' => 'Flynn'
],[
'state_id' => 210,
'name' => 'Forde'
],[
'state_id' => 210,
'name' => 'Forrest'
],[
'state_id' => 210,
'name' => 'Franklin'
],[
'state_id' => 210,
'name' => 'Fraser'
],[
'state_id' => 210,
'name' => 'Garran'
],[
'state_id' => 210,
'name' => 'Gilmore'
],[
'state_id' => 210,
'name' => 'Giralang'
],[
'state_id' => 210,
'name' => 'Gordon'
],[
'state_id' => 210,
'name' => 'Gowrie'
],[
'state_id' => 210,
'name' => 'Greenway'
],[
'state_id' => 210,
'name' => 'Griffith'
],[
'state_id' => 210,
'name' => 'Gungahlin'
],[
'state_id' => 210,
'name' => 'Hackett'
],[
'state_id' => 210,
'name' => 'Harrison'
],[
'state_id' => 210,
'name' => 'Hawker'
],[
'state_id' => 210,
'name' => 'Higgins'
],[
'state_id' => 210,
'name' => 'Holder'
],[
'state_id' => 210,
'name' => 'Holt'
],[
'state_id' => 210,
'name' => 'Hughes'
],[
'state_id' => 210,
'name' => 'Isaacs'
],[
'state_id' => 210,
'name' => 'Isabella Plains'
],[
'state_id' => 210,
'name' => 'Kaleen'
],[
'state_id' => 210,
'name' => 'Kambah'
],[
'state_id' => 210,
'name' => 'Kingston'
],[
'state_id' => 210,
'name' => 'Latham'
],[
'state_id' => 210,
'name' => 'Lyneham'
],[
'state_id' => 210,
'name' => 'Lyons'
],[
'state_id' => 210,
'name' => 'Macarthur'
],[
'state_id' => 210,
'name' => 'Macgregor'
],[
'state_id' => 210,
'name' => 'Macquarie'
],[
'state_id' => 210,
'name' => 'Mawson'
],[
'state_id' => 210,
'name' => 'McKellar'
],[
'state_id' => 210,
'name' => 'Melba'
],[
'state_id' => 210,
'name' => 'Monash'
],[
'state_id' => 210,
'name' => 'Narrabundah'
],[
'state_id' => 210,
'name' => 'Ngunnawal'
],[
'state_id' => 210,
'name' => 'Nicholls'
],[
'state_id' => 210,
'name' => 'O\'Connor'
],[
'state_id' => 210,
'name' => 'Oxley'
],[
'state_id' => 210,
'name' => 'Page'
],[
'state_id' => 210,
'name' => 'Palmerston'
],[
'state_id' => 210,
'name' => 'Pearce'
],[
'state_id' => 210,
'name' => 'Phillip'
],[
'state_id' => 210,
'name' => 'Red Hill'
],[
'state_id' => 210,
'name' => 'Reid'
],[
'state_id' => 210,
'name' => 'Richardson'
],[
'state_id' => 210,
'name' => 'Rivett'
],[
'state_id' => 210,
'name' => 'Scullin'
],[
'state_id' => 210,
'name' => 'Spence'
],[
'state_id' => 210,
'name' => 'Stirling'
],[
'state_id' => 210,
'name' => 'Theodore'
],[
'state_id' => 210,
'name' => 'Torrens'
],[
'state_id' => 210,
'name' => 'Turner'
],[
'state_id' => 210,
'name' => 'Wanniassa'
],[
'state_id' => 210,
'name' => 'Waramanga'
],[
'state_id' => 210,
'name' => 'Watson'
],[
'state_id' => 210,
'name' => 'Weetangera'
],[
'state_id' => 210,
'name' => 'Weston'
],[
'state_id' => 210,
'name' => 'Wright'
],[
'state_id' => 210,
'name' => 'Yarralumla'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
