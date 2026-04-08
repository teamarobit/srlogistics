<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class CAStateNSCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 701,
'name' => 'Amherst'
],[
'state_id' => 701,
'name' => 'Annapolis County'
],[
'state_id' => 701,
'name' => 'Antigonish'
],[
'state_id' => 701,
'name' => 'Berwick'
],[
'state_id' => 701,
'name' => 'Bridgewater'
],[
'state_id' => 701,
'name' => 'Cape Breton County'
],[
'state_id' => 701,
'name' => 'Chester'
],[
'state_id' => 701,
'name' => 'Colchester'
],[
'state_id' => 701,
'name' => 'Cole Harbour'
],[
'state_id' => 701,
'name' => 'Cow Bay'
],[
'state_id' => 701,
'name' => 'Dartmouth'
],[
'state_id' => 701,
'name' => 'Digby'
],[
'state_id' => 701,
'name' => 'Digby County'
],[
'state_id' => 701,
'name' => 'English Corner'
],[
'state_id' => 701,
'name' => 'Eskasoni 3'
],[
'state_id' => 701,
'name' => 'Fall River'
],[
'state_id' => 701,
'name' => 'Glace Bay'
],[
'state_id' => 701,
'name' => 'Greenwood'
],[
'state_id' => 701,
'name' => 'Halifax'
],[
'state_id' => 701,
'name' => 'Hantsport'
],[
'state_id' => 701,
'name' => 'Hayes Subdivision'
],[
'state_id' => 701,
'name' => 'Kentville'
],[
'state_id' => 701,
'name' => 'Lake Echo'
],[
'state_id' => 701,
'name' => 'Lantz'
],[
'state_id' => 701,
'name' => 'Lower Sackville'
],[
'state_id' => 701,
'name' => 'Lunenburg'
],[
'state_id' => 701,
'name' => 'Middleton'
],[
'state_id' => 701,
'name' => 'New Glasgow'
],[
'state_id' => 701,
'name' => 'Oxford'
],[
'state_id' => 701,
'name' => 'Parrsboro'
],[
'state_id' => 701,
'name' => 'Pictou'
],[
'state_id' => 701,
'name' => 'Pictou County'
],[
'state_id' => 701,
'name' => 'Port Hawkesbury'
],[
'state_id' => 701,
'name' => 'Port Williams'
],[
'state_id' => 701,
'name' => 'Princeville'
],[
'state_id' => 701,
'name' => 'Shelburne'
],[
'state_id' => 701,
'name' => 'Springhill'
],[
'state_id' => 701,
'name' => 'Sydney'
],[
'state_id' => 701,
'name' => 'Sydney Mines'
],[
'state_id' => 701,
'name' => 'Truro'
],[
'state_id' => 701,
'name' => 'Windsor'
],[
'state_id' => 701,
'name' => 'Wolfville'
],[
'state_id' => 701,
'name' => 'Yarmouth'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
