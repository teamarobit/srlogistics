<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class AUStateVICCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 206,
'name' => 'Abbotsford'
],[
'state_id' => 206,
'name' => 'Aberfeldie'
],[
'state_id' => 206,
'name' => 'Airport West'
],[
'state_id' => 206,
'name' => 'Albanvale'
],[
'state_id' => 206,
'name' => 'Albert Park'
],[
'state_id' => 206,
'name' => 'Albion'
],[
'state_id' => 206,
'name' => 'Alexandra'
],[
'state_id' => 206,
'name' => 'Alfredton'
],[
'state_id' => 206,
'name' => 'Allansford'
],[
'state_id' => 206,
'name' => 'Alphington'
],[
'state_id' => 206,
'name' => 'Alpine'
],[
'state_id' => 206,
'name' => 'Altona'
],[
'state_id' => 206,
'name' => 'Altona Meadows'
],[
'state_id' => 206,
'name' => 'Altona North'
],[
'state_id' => 206,
'name' => 'Anglesea'
],[
'state_id' => 206,
'name' => 'Apollo Bay'
],[
'state_id' => 206,
'name' => 'Ararat'
],[
'state_id' => 206,
'name' => 'Ardeer'
],[
'state_id' => 206,
'name' => 'Armadale'
],[
'state_id' => 206,
'name' => 'Armstrong Creek'
],[
'state_id' => 206,
'name' => 'Ascot'
],[
'state_id' => 206,
'name' => 'Ascot Vale'
],[
'state_id' => 206,
'name' => 'Ashburton'
],[
'state_id' => 206,
'name' => 'Ashwood'
],[
'state_id' => 206,
'name' => 'Aspendale'
],[
'state_id' => 206,
'name' => 'Aspendale Gardens'
],[
'state_id' => 206,
'name' => 'Attwood'
],[
'state_id' => 206,
'name' => 'Avenel'
],[
'state_id' => 206,
'name' => 'Avoca'
],[
'state_id' => 206,
'name' => 'Avondale Heights'
],[
'state_id' => 206,
'name' => 'Bacchus Marsh'
],[
'state_id' => 206,
'name' => 'Badger Creek'
],[
'state_id' => 206,
'name' => 'Bairnsdale'
],[
'state_id' => 206,
'name' => 'Balaclava'
],[
'state_id' => 206,
'name' => 'Ballan'
],[
'state_id' => 206,
'name' => 'Ballarat'
],[
'state_id' => 206,
'name' => 'Ballarat Central'
],[
'state_id' => 206,
'name' => 'Ballarat East'
],[
'state_id' => 206,
'name' => 'Ballarat North'
],[
'state_id' => 206,
'name' => 'Balnarring'
],[
'state_id' => 206,
'name' => 'Balwyn'
],[
'state_id' => 206,
'name' => 'Balwyn North'
],[
'state_id' => 206,
'name' => 'Bannockburn'
],[
'state_id' => 206,
'name' => 'Banyule'
],[
'state_id' => 206,
'name' => 'Baranduda'
],[
'state_id' => 206,
'name' => 'Barwon Heads'
],[
'state_id' => 206,
'name' => 'Bass Coast'
],[
'state_id' => 206,
'name' => 'Baw Baw'
],[
'state_id' => 206,
'name' => 'Baxter'
],[
'state_id' => 206,
'name' => 'Bayside'
],[
'state_id' => 206,
'name' => 'Bayswater'
],[
'state_id' => 206,
'name' => 'Bayswater North'
],[
'state_id' => 206,
'name' => 'Beaconsfield'
],[
'state_id' => 206,
'name' => 'Beaconsfield Upper'
],[
'state_id' => 206,
'name' => 'Beaufort'
],[
'state_id' => 206,
'name' => 'Beaumaris'
],[
'state_id' => 206,
'name' => 'Beechworth'
],[
'state_id' => 206,
'name' => 'Belgrave'
],[
'state_id' => 206,
'name' => 'Belgrave Heights'
],[
'state_id' => 206,
'name' => 'Belgrave South'
],[
'state_id' => 206,
'name' => 'Bell Park'
],[
'state_id' => 206,
'name' => 'Bell Post Hill'
],[
'state_id' => 206,
'name' => 'Bellfield'
],[
'state_id' => 206,
'name' => 'Belmont'
],[
'state_id' => 206,
'name' => 'Benalla'
],[
'state_id' => 206,
'name' => 'Bendigo'
],[
'state_id' => 206,
'name' => 'Bendigo city centre'
],[
'state_id' => 206,
'name' => 'Bentleigh'
],[
'state_id' => 206,
'name' => 'Bentleigh East'
],[
'state_id' => 206,
'name' => 'Berwick'
],[
'state_id' => 206,
'name' => 'Beveridge'
],[
'state_id' => 206,
'name' => 'Bittern'
],[
'state_id' => 206,
'name' => 'Black Hill'
],[
'state_id' => 206,
'name' => 'Black Rock'
],[
'state_id' => 206,
'name' => 'Blackburn'
],[
'state_id' => 206,
'name' => 'Blackburn North'
],[
'state_id' => 206,
'name' => 'Blackburn South'
],[
'state_id' => 206,
'name' => 'Blairgowrie'
],[
'state_id' => 206,
'name' => 'Blind Bight'
],[
'state_id' => 206,
'name' => 'Bonbeach'
],[
'state_id' => 206,
'name' => 'Boronia'
],[
'state_id' => 206,
'name' => 'Boroondara'
],[
'state_id' => 206,
'name' => 'Botanic Ridge'
],[
'state_id' => 206,
'name' => 'Box Hill'
],[
'state_id' => 206,
'name' => 'Box Hill North'
],[
'state_id' => 206,
'name' => 'Box Hill South'
],[
'state_id' => 206,
'name' => 'Braybrook'
],[
'state_id' => 206,
'name' => 'Briagolong'
],[
'state_id' => 206,
'name' => 'Briar Hill'
],[
'state_id' => 206,
'name' => 'Bright'
],[
'state_id' => 206,
'name' => 'Brighton'
],[
'state_id' => 206,
'name' => 'Brighton East'
],[
'state_id' => 206,
'name' => 'Brimbank'
],[
'state_id' => 206,
'name' => 'Broadford'
],[
'state_id' => 206,
'name' => 'Broadmeadows'
],[
'state_id' => 206,
'name' => 'Brookfield'
],[
'state_id' => 206,
'name' => 'Brooklyn'
],[
'state_id' => 206,
'name' => 'Brown Hill'
],[
'state_id' => 206,
'name' => 'Brunswick'
],[
'state_id' => 206,
'name' => 'Brunswick East'
],[
'state_id' => 206,
'name' => 'Brunswick West'
],[
'state_id' => 206,
'name' => 'Bulleen'
],[
'state_id' => 206,
'name' => 'Buloke'
],[
'state_id' => 206,
'name' => 'Bundoora'
],[
'state_id' => 206,
'name' => 'Buninyong'
],[
'state_id' => 206,
'name' => 'Bunyip'
],[
'state_id' => 206,
'name' => 'Burnside'
],[
'state_id' => 206,
'name' => 'Burnside Heights'
],[
'state_id' => 206,
'name' => 'Burwood'
],[
'state_id' => 206,
'name' => 'Burwood East'
],[
'state_id' => 206,
'name' => 'Cairnlea'
],[
'state_id' => 206,
'name' => 'California Gully'
],[
'state_id' => 206,
'name' => 'Camberwell'
],[
'state_id' => 206,
'name' => 'Campaspe'
],[
'state_id' => 206,
'name' => 'Campbellfield'
],[
'state_id' => 206,
'name' => 'Campbells Creek'
],[
'state_id' => 206,
'name' => 'Camperdown'
],[
'state_id' => 206,
'name' => 'Canadian'
],[
'state_id' => 206,
'name' => 'Canterbury'
],[
'state_id' => 206,
'name' => 'Cape Woolamai'
],[
'state_id' => 206,
'name' => 'Cardinia'
],[
'state_id' => 206,
'name' => 'Carisbrook'
],[
'state_id' => 206,
'name' => 'Carlton'
],[
'state_id' => 206,
'name' => 'Carlton North'
],[
'state_id' => 206,
'name' => 'Carnegie'
],[
'state_id' => 206,
'name' => 'Caroline Springs'
],[
'state_id' => 206,
'name' => 'Carrum'
],[
'state_id' => 206,
'name' => 'Carrum Downs'
],[
'state_id' => 206,
'name' => 'Casey'
],[
'state_id' => 206,
'name' => 'Casterton'
],[
'state_id' => 206,
'name' => 'Castlemaine'
],[
'state_id' => 206,
'name' => 'Caulfield'
],[
'state_id' => 206,
'name' => 'Caulfield East'
],[
'state_id' => 206,
'name' => 'Caulfield North'
],[
'state_id' => 206,
'name' => 'Caulfield South'
],[
'state_id' => 206,
'name' => 'Central Goldfields'
],[
'state_id' => 206,
'name' => 'Chadstone'
],[
'state_id' => 206,
'name' => 'Charlton'
],[
'state_id' => 206,
'name' => 'Chelsea'
],[
'state_id' => 206,
'name' => 'Chelsea Heights'
],[
'state_id' => 206,
'name' => 'Cheltenham'
],[
'state_id' => 206,
'name' => 'Chewton'
],[
'state_id' => 206,
'name' => 'Chiltern'
],[
'state_id' => 206,
'name' => 'Chirnside Park'
],[
'state_id' => 206,
'name' => 'Churchill'
],[
'state_id' => 206,
'name' => 'Clarinda'
],[
'state_id' => 206,
'name' => 'Clayton'
],[
'state_id' => 206,
'name' => 'Clayton South'
],[
'state_id' => 206,
'name' => 'Clifton Hill'
],[
'state_id' => 206,
'name' => 'Clifton Springs'
],[
'state_id' => 206,
'name' => 'Clunes'
],[
'state_id' => 206,
'name' => 'Clyde'
],[
'state_id' => 206,
'name' => 'Clyde North'
],[
'state_id' => 206,
'name' => 'Cobden'
],[
'state_id' => 206,
'name' => 'Cobram'
],[
'state_id' => 206,
'name' => 'Coburg'
],[
'state_id' => 206,
'name' => 'Coburg North'
],[
'state_id' => 206,
'name' => 'Cockatoo'
],[
'state_id' => 206,
'name' => 'Cohuna'
],[
'state_id' => 206,
'name' => 'Colac'
],[
'state_id' => 206,
'name' => 'Colac-Otway'
],[
'state_id' => 206,
'name' => 'Coldstream'
],[
'state_id' => 206,
'name' => 'Collingwood'
],[
'state_id' => 206,
'name' => 'Coolaroo'
],[
'state_id' => 206,
'name' => 'Corangamite'
],[
'state_id' => 206,
'name' => 'Corio'
],[
'state_id' => 206,
'name' => 'Corryong'
],[
'state_id' => 206,
'name' => 'Cowes'
],[
'state_id' => 206,
'name' => 'Craigieburn'
],[
'state_id' => 206,
'name' => 'Cranbourne'
],[
'state_id' => 206,
'name' => 'Cranbourne East'
],[
'state_id' => 206,
'name' => 'Cranbourne North'
],[
'state_id' => 206,
'name' => 'Cranbourne South'
],[
'state_id' => 206,
'name' => 'Cranbourne West'
],[
'state_id' => 206,
'name' => 'Cremorne'
],[
'state_id' => 206,
'name' => 'Creswick'
],[
'state_id' => 206,
'name' => 'Crib Point'
],[
'state_id' => 206,
'name' => 'Croydon'
],[
'state_id' => 206,
'name' => 'Croydon Hills'
],[
'state_id' => 206,
'name' => 'Croydon North'
],[
'state_id' => 206,
'name' => 'Croydon South'
],[
'state_id' => 206,
'name' => 'Dallas'
],[
'state_id' => 206,
'name' => 'Dandenong'
],[
'state_id' => 206,
'name' => 'Dandenong North'
],[
'state_id' => 206,
'name' => 'Darebin'
],[
'state_id' => 206,
'name' => 'Darley'
],[
'state_id' => 206,
'name' => 'Daylesford'
],[
'state_id' => 206,
'name' => 'Deer Park'
],[
'state_id' => 206,
'name' => 'Delacombe'
],[
'state_id' => 206,
'name' => 'Delahey'
],[
'state_id' => 206,
'name' => 'Dennington'
],[
'state_id' => 206,
'name' => 'Derrimut'
],[
'state_id' => 206,
'name' => 'Devon Meadows'
],[
'state_id' => 206,
'name' => 'Diamond Creek'
],[
'state_id' => 206,
'name' => 'Diggers Rest'
],[
'state_id' => 206,
'name' => 'Dimboola'
],[
'state_id' => 206,
'name' => 'Dingley Village'
],[
'state_id' => 206,
'name' => 'Dinner Plain'
],[
'state_id' => 206,
'name' => 'Docklands'
],[
'state_id' => 206,
'name' => 'Donald'
],[
'state_id' => 206,
'name' => 'Doncaster'
],[
'state_id' => 206,
'name' => 'Doncaster East'
],[
'state_id' => 206,
'name' => 'Donvale'
],[
'state_id' => 206,
'name' => 'Doreen'
],[
'state_id' => 206,
'name' => 'Doveton'
],[
'state_id' => 206,
'name' => 'Dromana'
],[
'state_id' => 206,
'name' => 'Drouin'
],[
'state_id' => 206,
'name' => 'Drysdale'
],[
'state_id' => 206,
'name' => 'Eagle Point'
],[
'state_id' => 206,
'name' => 'Eaglehawk'
],[
'state_id' => 206,
'name' => 'Eaglemont'
],[
'state_id' => 206,
'name' => 'East Bairnsdale'
],[
'state_id' => 206,
'name' => 'East Bendigo'
],[
'state_id' => 206,
'name' => 'East Geelong'
],[
'state_id' => 206,
'name' => 'East Gippsland'
],[
'state_id' => 206,
'name' => 'East Melbourne'
],[
'state_id' => 206,
'name' => 'Echuca'
],[
'state_id' => 206,
'name' => 'Eden Park'
],[
'state_id' => 206,
'name' => 'Edithvale'
],[
'state_id' => 206,
'name' => 'Elliminyt'
],[
'state_id' => 206,
'name' => 'Elsternwick'
],[
'state_id' => 206,
'name' => 'Eltham'
],[
'state_id' => 206,
'name' => 'Eltham North'
],[
'state_id' => 206,
'name' => 'Elwood'
],[
'state_id' => 206,
'name' => 'Emerald'
],[
'state_id' => 206,
'name' => 'Endeavour Hills'
],[
'state_id' => 206,
'name' => 'Epping'
],[
'state_id' => 206,
'name' => 'Epsom'
],[
'state_id' => 206,
'name' => 'Essendon'
],[
'state_id' => 206,
'name' => 'Essendon North'
],[
'state_id' => 206,
'name' => 'Essendon West'
],[
'state_id' => 206,
'name' => 'Eumemmerring'
],[
'state_id' => 206,
'name' => 'Euroa'
],[
'state_id' => 206,
'name' => 'Eynesbury'
],[
'state_id' => 206,
'name' => 'Fairfield'
],[
'state_id' => 206,
'name' => 'Falls Creek'
],[
'state_id' => 206,
'name' => 'Fawkner'
],[
'state_id' => 206,
'name' => 'Ferntree Gully'
],[
'state_id' => 206,
'name' => 'Ferny Creek'
],[
'state_id' => 206,
'name' => 'Fitzroy'
],[
'state_id' => 206,
'name' => 'Fitzroy North'
],[
'state_id' => 206,
'name' => 'Flemington'
],[
'state_id' => 206,
'name' => 'Flora Hill'
],[
'state_id' => 206,
'name' => 'Footscray'
],[
'state_id' => 206,
'name' => 'Forest Hill'
],[
'state_id' => 206,
'name' => 'Foster'
],[
'state_id' => 206,
'name' => 'Frankston'
],[
'state_id' => 206,
'name' => 'Frankston East'
],[
'state_id' => 206,
'name' => 'Frankston North'
],[
'state_id' => 206,
'name' => 'Frankston South'
],[
'state_id' => 206,
'name' => 'Gannawarra'
],[
'state_id' => 206,
'name' => 'Garfield'
],[
'state_id' => 206,
'name' => 'Geelong'
],[
'state_id' => 206,
'name' => 'Geelong West'
],[
'state_id' => 206,
'name' => 'Geelong city centre'
],[
'state_id' => 206,
'name' => 'Gembrook'
],[
'state_id' => 206,
'name' => 'Gisborne'
],[
'state_id' => 206,
'name' => 'Gladstone Park'
],[
'state_id' => 206,
'name' => 'Glen Eira'
],[
'state_id' => 206,
'name' => 'Glen Huntly'
],[
'state_id' => 206,
'name' => 'Glen Iris'
],[
'state_id' => 206,
'name' => 'Glen Waverley'
],[
'state_id' => 206,
'name' => 'Glenelg'
],[
'state_id' => 206,
'name' => 'Glenferrie'
],[
'state_id' => 206,
'name' => 'Glengarry'
],[
'state_id' => 206,
'name' => 'Glenroy'
],[
'state_id' => 206,
'name' => 'Golden Plains'
],[
'state_id' => 206,
'name' => 'Golden Point'
],[
'state_id' => 206,
'name' => 'Golden Square'
],[
'state_id' => 206,
'name' => 'Gordon'
],[
'state_id' => 206,
'name' => 'Gowanbrae'
],[
'state_id' => 206,
'name' => 'Greater Bendigo'
],[
'state_id' => 206,
'name' => 'Greater Dandenong'
],[
'state_id' => 206,
'name' => 'Greater Geelong'
],[
'state_id' => 206,
'name' => 'Greater Shepparton'
],[
'state_id' => 206,
'name' => 'Greensborough'
],[
'state_id' => 206,
'name' => 'Greenvale'
],[
'state_id' => 206,
'name' => 'Grovedale'
],[
'state_id' => 206,
'name' => 'Haddon'
],[
'state_id' => 206,
'name' => 'Hadfield'
],[
'state_id' => 206,
'name' => 'Hallam'
],[
'state_id' => 206,
'name' => 'Hamilton'
],[
'state_id' => 206,
'name' => 'Hamlyn Heights'
],[
'state_id' => 206,
'name' => 'Hampton'
],[
'state_id' => 206,
'name' => 'Hampton East'
],[
'state_id' => 206,
'name' => 'Hampton Park'
],[
'state_id' => 206,
'name' => 'Hastings'
],[
'state_id' => 206,
'name' => 'Haven'
],[
'state_id' => 206,
'name' => 'Hawthorn'
],[
'state_id' => 206,
'name' => 'Hawthorn East'
],[
'state_id' => 206,
'name' => 'Hawthorn South'
],[
'state_id' => 206,
'name' => 'Hazelwood North'
],[
'state_id' => 206,
'name' => 'Healesville'
],[
'state_id' => 206,
'name' => 'Heathcote'
],[
'state_id' => 206,
'name' => 'Heatherton'
],[
'state_id' => 206,
'name' => 'Heathmont'
],[
'state_id' => 206,
'name' => 'Heidelberg'
],[
'state_id' => 206,
'name' => 'Heidelberg Heights'
],[
'state_id' => 206,
'name' => 'Heidelberg West'
],[
'state_id' => 206,
'name' => 'Hepburn'
],[
'state_id' => 206,
'name' => 'Herne Hill'
],[
'state_id' => 206,
'name' => 'Heyfield'
],[
'state_id' => 206,
'name' => 'Heywood'
],[
'state_id' => 206,
'name' => 'Highett'
],[
'state_id' => 206,
'name' => 'Highton'
],[
'state_id' => 206,
'name' => 'Hillside'
],[
'state_id' => 206,
'name' => 'Hindmarsh'
],[
'state_id' => 206,
'name' => 'Hmas Cerberus'
],[
'state_id' => 206,
'name' => 'Hobsons Bay'
],[
'state_id' => 206,
'name' => 'Hoppers Crossing'
],[
'state_id' => 206,
'name' => 'Horsham'
],[
'state_id' => 206,
'name' => 'Hotham Heights'
],[
'state_id' => 206,
'name' => 'Hughesdale'
],[
'state_id' => 206,
'name' => 'Hume'
],[
'state_id' => 206,
'name' => 'Huntingdale'
],[
'state_id' => 206,
'name' => 'Huntly'
],[
'state_id' => 206,
'name' => 'Hurstbridge'
],[
'state_id' => 206,
'name' => 'Indented Head'
],[
'state_id' => 206,
'name' => 'Indigo'
],[
'state_id' => 206,
'name' => 'Inverleigh'
],[
'state_id' => 206,
'name' => 'Inverloch'
],[
'state_id' => 206,
'name' => 'Invermay Park'
],[
'state_id' => 206,
'name' => 'Ironbark'
],[
'state_id' => 206,
'name' => 'Irymple'
],[
'state_id' => 206,
'name' => 'Ivanhoe'
],[
'state_id' => 206,
'name' => 'Ivanhoe East'
],[
'state_id' => 206,
'name' => 'Jacana'
],[
'state_id' => 206,
'name' => 'Jackass Flat'
],[
'state_id' => 206,
'name' => 'Jan Juc'
],[
'state_id' => 206,
'name' => 'Junction Village'
],[
'state_id' => 206,
'name' => 'Junortoun'
],[
'state_id' => 206,
'name' => 'Kalimna'
],[
'state_id' => 206,
'name' => 'Kallista'
],[
'state_id' => 206,
'name' => 'Kalorama'
],[
'state_id' => 206,
'name' => 'Kangaroo Flat'
],[
'state_id' => 206,
'name' => 'Kangaroo Ground'
],[
'state_id' => 206,
'name' => 'Kealba'
],[
'state_id' => 206,
'name' => 'Keilor'
],[
'state_id' => 206,
'name' => 'Keilor Downs'
],[
'state_id' => 206,
'name' => 'Keilor East'
],[
'state_id' => 206,
'name' => 'Keilor Lodge'
],[
'state_id' => 206,
'name' => 'Keilor Park'
],[
'state_id' => 206,
'name' => 'Kennington'
],[
'state_id' => 206,
'name' => 'Kensington'
],[
'state_id' => 206,
'name' => 'Kerang'
],[
'state_id' => 206,
'name' => 'Kew'
],[
'state_id' => 206,
'name' => 'Kew East'
],[
'state_id' => 206,
'name' => 'Keysborough'
],[
'state_id' => 206,
'name' => 'Kialla'
],[
'state_id' => 206,
'name' => 'Kilmore'
],[
'state_id' => 206,
'name' => 'Kilsyth'
],[
'state_id' => 206,
'name' => 'Kilsyth South'
],[
'state_id' => 206,
'name' => 'Kinglake'
],[
'state_id' => 206,
'name' => 'Kinglake West'
],[
'state_id' => 206,
'name' => 'Kings Park'
],[
'state_id' => 206,
'name' => 'Kingsbury'
],[
'state_id' => 206,
'name' => 'Kingston'
],[
'state_id' => 206,
'name' => 'Kingsville'
],[
'state_id' => 206,
'name' => 'Knox'
],[
'state_id' => 206,
'name' => 'Knoxfield'
],[
'state_id' => 206,
'name' => 'Koo-Wee-Rup'
],[
'state_id' => 206,
'name' => 'Koroit'
],[
'state_id' => 206,
'name' => 'Korumburra'
],[
'state_id' => 206,
'name' => 'Kurunjang'
],[
'state_id' => 206,
'name' => 'Kyabram'
],[
'state_id' => 206,
'name' => 'Kyneton'
],[
'state_id' => 206,
'name' => 'Lake Gardens'
],[
'state_id' => 206,
'name' => 'Lake Wendouree'
],[
'state_id' => 206,
'name' => 'Lakes Entrance'
],[
'state_id' => 206,
'name' => 'Lalor'
],[
'state_id' => 206,
'name' => 'Lancefield'
],[
'state_id' => 206,
'name' => 'Lang Lang'
],[
'state_id' => 206,
'name' => 'Langwarrin'
],[
'state_id' => 206,
'name' => 'Langwarrin South'
],[
'state_id' => 206,
'name' => 'Lara'
],[
'state_id' => 206,
'name' => 'Latrobe'
],[
'state_id' => 206,
'name' => 'Launching Place'
],[
'state_id' => 206,
'name' => 'Laverton'
],[
'state_id' => 206,
'name' => 'Leongatha'
],[
'state_id' => 206,
'name' => 'Leopold'
],[
'state_id' => 206,
'name' => 'Lilydale'
],[
'state_id' => 206,
'name' => 'Little River'
],[
'state_id' => 206,
'name' => 'Loddon'
],[
'state_id' => 206,
'name' => 'Long Gully'
],[
'state_id' => 206,
'name' => 'Longford'
],[
'state_id' => 206,
'name' => 'Longwarry'
],[
'state_id' => 206,
'name' => 'Lorne'
],[
'state_id' => 206,
'name' => 'Lovely Banks'
],[
'state_id' => 206,
'name' => 'Lower Plenty'
],[
'state_id' => 206,
'name' => 'Lucknow'
],[
'state_id' => 206,
'name' => 'Lynbrook'
],[
'state_id' => 206,
'name' => 'Lysterfield'
],[
'state_id' => 206,
'name' => 'Macedon'
],[
'state_id' => 206,
'name' => 'Macedon Ranges'
],[
'state_id' => 206,
'name' => 'Macleod'
],[
'state_id' => 206,
'name' => 'Maddingley'
],[
'state_id' => 206,
'name' => 'Maffra'
],[
'state_id' => 206,
'name' => 'Maiden Gully'
],[
'state_id' => 206,
'name' => 'Maidstone'
],[
'state_id' => 206,
'name' => 'Maldon'
],[
'state_id' => 206,
'name' => 'Mallacoota'
],[
'state_id' => 206,
'name' => 'Malvern'
],[
'state_id' => 206,
'name' => 'Malvern East'
],[
'state_id' => 206,
'name' => 'Manifold Heights'
],[
'state_id' => 206,
'name' => 'Manningham'
],[
'state_id' => 206,
'name' => 'Mansfield'
],[
'state_id' => 206,
'name' => 'Maribyrnong'
],[
'state_id' => 206,
'name' => 'Marong'
],[
'state_id' => 206,
'name' => 'Maroondah'
],[
'state_id' => 206,
'name' => 'Maryborough'
],[
'state_id' => 206,
'name' => 'McCrae'
],[
'state_id' => 206,
'name' => 'McKinnon'
],[
'state_id' => 206,
'name' => 'Meadow Heights'
],[
'state_id' => 206,
'name' => 'Melbourne'
],[
'state_id' => 206,
'name' => 'Melbourne City Centre'
],[
'state_id' => 206,
'name' => 'Melton'
],[
'state_id' => 206,
'name' => 'Melton South'
],[
'state_id' => 206,
'name' => 'Melton West'
],[
'state_id' => 206,
'name' => 'Mentone'
],[
'state_id' => 206,
'name' => 'Merbein'
],[
'state_id' => 206,
'name' => 'Mernda'
],[
'state_id' => 206,
'name' => 'Metung'
],[
'state_id' => 206,
'name' => 'Mickleham'
],[
'state_id' => 206,
'name' => 'Middle Park'
],[
'state_id' => 206,
'name' => 'Mildura'
],[
'state_id' => 206,
'name' => 'Mildura Shire'
],[
'state_id' => 206,
'name' => 'Mill Park'
],[
'state_id' => 206,
'name' => 'Millgrove'
],[
'state_id' => 206,
'name' => 'Miners Rest'
],[
'state_id' => 206,
'name' => 'Mirboo North'
],[
'state_id' => 206,
'name' => 'Mitcham'
],[
'state_id' => 206,
'name' => 'Mitchell'
],[
'state_id' => 206,
'name' => 'Moe'
],[
'state_id' => 206,
'name' => 'Moira'
],[
'state_id' => 206,
'name' => 'Monash'
],[
'state_id' => 206,
'name' => 'Monbulk'
],[
'state_id' => 206,
'name' => 'Mont Albert'
],[
'state_id' => 206,
'name' => 'Mont Albert North'
],[
'state_id' => 206,
'name' => 'Montmorency'
],[
'state_id' => 206,
'name' => 'Montrose'
],[
'state_id' => 206,
'name' => 'Moolap'
],[
'state_id' => 206,
'name' => 'Moonee Ponds'
],[
'state_id' => 206,
'name' => 'Moonee Valley'
],[
'state_id' => 206,
'name' => 'Moorabbin'
],[
'state_id' => 206,
'name' => 'Moorabool'
],[
'state_id' => 206,
'name' => 'Moorooduc'
],[
'state_id' => 206,
'name' => 'Mooroolbark'
],[
'state_id' => 206,
'name' => 'Mooroopna'
],[
'state_id' => 206,
'name' => 'Mordialloc'
],[
'state_id' => 206,
'name' => 'Moreland'
],[
'state_id' => 206,
'name' => 'Mornington'
],[
'state_id' => 206,
'name' => 'Mornington Peninsula'
],[
'state_id' => 206,
'name' => 'Mortlake'
],[
'state_id' => 206,
'name' => 'Morwell'
],[
'state_id' => 206,
'name' => 'Mount Alexander'
],[
'state_id' => 206,
'name' => 'Mount Buller'
],[
'state_id' => 206,
'name' => 'Mount Clear'
],[
'state_id' => 206,
'name' => 'Mount Dandenong'
],[
'state_id' => 206,
'name' => 'Mount Duneed'
],[
'state_id' => 206,
'name' => 'Mount Eliza'
],[
'state_id' => 206,
'name' => 'Mount Evelyn'
],[
'state_id' => 206,
'name' => 'Mount Helen'
],[
'state_id' => 206,
'name' => 'Mount Macedon'
],[
'state_id' => 206,
'name' => 'Mount Martha'
],[
'state_id' => 206,
'name' => 'Mount Pleasant'
],[
'state_id' => 206,
'name' => 'Mount Waverley'
],[
'state_id' => 206,
'name' => 'Moyne'
],[
'state_id' => 206,
'name' => 'Mulgrave'
],[
'state_id' => 206,
'name' => 'Murrindindi'
],[
'state_id' => 206,
'name' => 'Murrumbeena'
],[
'state_id' => 206,
'name' => 'Myrtleford'
],[
'state_id' => 206,
'name' => 'Nagambie'
],[
'state_id' => 206,
'name' => 'Narre Warren'
],[
'state_id' => 206,
'name' => 'Narre Warren North'
],[
'state_id' => 206,
'name' => 'Narre Warren South'
],[
'state_id' => 206,
'name' => 'Nathalia'
],[
'state_id' => 206,
'name' => 'Neerim South'
],[
'state_id' => 206,
'name' => 'New Gisborne'
],[
'state_id' => 206,
'name' => 'Newborough'
],[
'state_id' => 206,
'name' => 'Newcomb'
],[
'state_id' => 206,
'name' => 'Newington'
],[
'state_id' => 206,
'name' => 'Newport'
],[
'state_id' => 206,
'name' => 'Newtown'
],[
'state_id' => 206,
'name' => 'Nhill'
],[
'state_id' => 206,
'name' => 'Nichols Point'
],[
'state_id' => 206,
'name' => 'Nicholson'
],[
'state_id' => 206,
'name' => 'Niddrie'
],[
'state_id' => 206,
'name' => 'Nillumbik'
],[
'state_id' => 206,
'name' => 'Noble Park'
],[
'state_id' => 206,
'name' => 'Noble Park North'
],[
'state_id' => 206,
'name' => 'Norlane'
],[
'state_id' => 206,
'name' => 'North Bendigo'
],[
'state_id' => 206,
'name' => 'North Brighton'
],[
'state_id' => 206,
'name' => 'North Geelong'
],[
'state_id' => 206,
'name' => 'North Melbourne'
],[
'state_id' => 206,
'name' => 'North Warrandyte'
],[
'state_id' => 206,
'name' => 'North Wonthaggi'
],[
'state_id' => 206,
'name' => 'Northcote'
],[
'state_id' => 206,
'name' => 'Northern Grampians'
],[
'state_id' => 206,
'name' => 'Notting Hill'
],[
'state_id' => 206,
'name' => 'Numurkah'
],[
'state_id' => 206,
'name' => 'Nunawading'
],[
'state_id' => 206,
'name' => 'Nyora'
],[
'state_id' => 206,
'name' => 'Oak Park'
],[
'state_id' => 206,
'name' => 'Oakleigh'
],[
'state_id' => 206,
'name' => 'Oakleigh East'
],[
'state_id' => 206,
'name' => 'Oakleigh South'
],[
'state_id' => 206,
'name' => 'Ocean Grove'
],[
'state_id' => 206,
'name' => 'Officer'
],[
'state_id' => 206,
'name' => 'Olinda'
],[
'state_id' => 206,
'name' => 'Orbost'
],[
'state_id' => 206,
'name' => 'Ormond'
],[
'state_id' => 206,
'name' => 'Ouyen'
],[
'state_id' => 206,
'name' => 'Pakenham'
],[
'state_id' => 206,
'name' => 'Pakenham Upper'
],[
'state_id' => 206,
'name' => 'Panton Hill'
],[
'state_id' => 206,
'name' => 'Park Orchards'
],[
'state_id' => 206,
'name' => 'Parkdale'
],[
'state_id' => 206,
'name' => 'Parkville'
],[
'state_id' => 206,
'name' => 'Pascoe Vale'
],[
'state_id' => 206,
'name' => 'Pascoe Vale South'
],[
'state_id' => 206,
'name' => 'Patterson Lakes'
],[
'state_id' => 206,
'name' => 'Paynesville'
],[
'state_id' => 206,
'name' => 'Pearcedale'
],[
'state_id' => 206,
'name' => 'Phillip Island'
],[
'state_id' => 206,
'name' => 'Plenty'
],[
'state_id' => 206,
'name' => 'Plumpton'
],[
'state_id' => 206,
'name' => 'Point Cook'
],[
'state_id' => 206,
'name' => 'Point Lonsdale'
],[
'state_id' => 206,
'name' => 'Port Fairy'
],[
'state_id' => 206,
'name' => 'Port Melbourne'
],[
'state_id' => 206,
'name' => 'Port Phillip'
],[
'state_id' => 206,
'name' => 'Portarlington'
],[
'state_id' => 206,
'name' => 'Portland'
],[
'state_id' => 206,
'name' => 'Prahran'
],[
'state_id' => 206,
'name' => 'Preston'
],[
'state_id' => 206,
'name' => 'Princes Hill'
],[
'state_id' => 206,
'name' => 'Puckapunyal'
],[
'state_id' => 206,
'name' => 'Pyrenees'
],[
'state_id' => 206,
'name' => 'Quarry Hill'
],[
'state_id' => 206,
'name' => 'Queenscliff'
],[
'state_id' => 206,
'name' => 'Queenscliffe'
],[
'state_id' => 206,
'name' => 'Ravenhall'
],[
'state_id' => 206,
'name' => 'Red Cliffs'
],[
'state_id' => 206,
'name' => 'Redan'
],[
'state_id' => 206,
'name' => 'Research'
],[
'state_id' => 206,
'name' => 'Reservoir'
],[
'state_id' => 206,
'name' => 'Richmond'
],[
'state_id' => 206,
'name' => 'Ringwood'
],[
'state_id' => 206,
'name' => 'Ringwood East'
],[
'state_id' => 206,
'name' => 'Ringwood North'
],[
'state_id' => 206,
'name' => 'Ripponlea'
],[
'state_id' => 206,
'name' => 'Robinvale'
],[
'state_id' => 206,
'name' => 'Rochester'
],[
'state_id' => 206,
'name' => 'Rockbank'
],[
'state_id' => 206,
'name' => 'Romsey'
],[
'state_id' => 206,
'name' => 'Rosanna'
],[
'state_id' => 206,
'name' => 'Rosebud'
],[
'state_id' => 206,
'name' => 'Rosebud West'
],[
'state_id' => 206,
'name' => 'Rosedale'
],[
'state_id' => 206,
'name' => 'Ross Creek'
],[
'state_id' => 206,
'name' => 'Rowville'
],[
'state_id' => 206,
'name' => 'Roxburgh Park'
],[
'state_id' => 206,
'name' => 'Rushworth'
],[
'state_id' => 206,
'name' => 'Rutherglen'
],[
'state_id' => 206,
'name' => 'Rye'
],[
'state_id' => 206,
'name' => 'Safety Beach'
],[
'state_id' => 206,
'name' => 'Saint Albans'
],[
'state_id' => 206,
'name' => 'Saint Andrews'
],[
'state_id' => 206,
'name' => 'Saint Andrews Beach'
],[
'state_id' => 206,
'name' => 'Saint Helena'
],[
'state_id' => 206,
'name' => 'Saint Kilda'
],[
'state_id' => 206,
'name' => 'Saint Leonards'
],[
'state_id' => 206,
'name' => 'Sale'
],[
'state_id' => 206,
'name' => 'San Remo'
],[
'state_id' => 206,
'name' => 'Sandhurst'
],[
'state_id' => 206,
'name' => 'Sandringham'
],[
'state_id' => 206,
'name' => 'Sassafras'
],[
'state_id' => 206,
'name' => 'Scoresby'
],[
'state_id' => 206,
'name' => 'Seabrook'
],[
'state_id' => 206,
'name' => 'Seaford'
],[
'state_id' => 206,
'name' => 'Seaholme'
],[
'state_id' => 206,
'name' => 'Sebastopol'
],[
'state_id' => 206,
'name' => 'Seddon'
],[
'state_id' => 206,
'name' => 'Selby'
],[
'state_id' => 206,
'name' => 'Seville'
],[
'state_id' => 206,
'name' => 'Seymour'
],[
'state_id' => 206,
'name' => 'Shepparton'
],[
'state_id' => 206,
'name' => 'Shepparton East'
],[
'state_id' => 206,
'name' => 'Silvan'
],[
'state_id' => 206,
'name' => 'Skye'
],[
'state_id' => 206,
'name' => 'Smythes Creek'
],[
'state_id' => 206,
'name' => 'Smythesdale'
],[
'state_id' => 206,
'name' => 'Soldiers Hill'
],[
'state_id' => 206,
'name' => 'Somers'
],[
'state_id' => 206,
'name' => 'Somerville'
],[
'state_id' => 206,
'name' => 'Sorrento'
],[
'state_id' => 206,
'name' => 'South Gippsland'
],[
'state_id' => 206,
'name' => 'South Kingsville'
],[
'state_id' => 206,
'name' => 'South Melbourne'
],[
'state_id' => 206,
'name' => 'South Morang'
],[
'state_id' => 206,
'name' => 'South Yarra'
],[
'state_id' => 206,
'name' => 'Southbank'
],[
'state_id' => 206,
'name' => 'Southern Grampians'
],[
'state_id' => 206,
'name' => 'Spotswood'
],[
'state_id' => 206,
'name' => 'Springvale'
],[
'state_id' => 206,
'name' => 'Springvale South'
],[
'state_id' => 206,
'name' => 'St Albans Park'
],[
'state_id' => 206,
'name' => 'St Helena'
],[
'state_id' => 206,
'name' => 'St Kilda East'
],[
'state_id' => 206,
'name' => 'St Kilda West'
],[
'state_id' => 206,
'name' => 'Stawell'
],[
'state_id' => 206,
'name' => 'Stonnington'
],[
'state_id' => 206,
'name' => 'Stratford'
],[
'state_id' => 206,
'name' => 'Strathbogie'
],[
'state_id' => 206,
'name' => 'Strathdale'
],[
'state_id' => 206,
'name' => 'Strathfieldsaye'
],[
'state_id' => 206,
'name' => 'Strathmerton'
],[
'state_id' => 206,
'name' => 'Strathmore'
],[
'state_id' => 206,
'name' => 'Sunbury'
],[
'state_id' => 206,
'name' => 'Sunshine'
],[
'state_id' => 206,
'name' => 'Sunshine North'
],[
'state_id' => 206,
'name' => 'Sunshine West'
],[
'state_id' => 206,
'name' => 'Surf Coast'
],[
'state_id' => 206,
'name' => 'Surrey Hills'
],[
'state_id' => 206,
'name' => 'Swan Hill'
],[
'state_id' => 206,
'name' => 'Sydenham'
],[
'state_id' => 206,
'name' => 'Tallangatta'
],[
'state_id' => 206,
'name' => 'Tarneit'
],[
'state_id' => 206,
'name' => 'Tatura'
],[
'state_id' => 206,
'name' => 'Taylors Hill'
],[
'state_id' => 206,
'name' => 'Taylors Lakes'
],[
'state_id' => 206,
'name' => 'Tecoma'
],[
'state_id' => 206,
'name' => 'Teesdale'
],[
'state_id' => 206,
'name' => 'Templestowe'
],[
'state_id' => 206,
'name' => 'Templestowe Lower'
],[
'state_id' => 206,
'name' => 'Terang'
],[
'state_id' => 206,
'name' => 'The Basin'
],[
'state_id' => 206,
'name' => 'The Patch'
],[
'state_id' => 206,
'name' => 'Thomastown'
],[
'state_id' => 206,
'name' => 'Thomson'
],[
'state_id' => 206,
'name' => 'Thornbury'
],[
'state_id' => 206,
'name' => 'Timboon'
],[
'state_id' => 206,
'name' => 'Tongala'
],[
'state_id' => 206,
'name' => 'Tooradin'
],[
'state_id' => 206,
'name' => 'Toorak'
],[
'state_id' => 206,
'name' => 'Tootgarook'
],[
'state_id' => 206,
'name' => 'Torquay'
],[
'state_id' => 206,
'name' => 'Towong'
],[
'state_id' => 206,
'name' => 'Trafalgar'
],[
'state_id' => 206,
'name' => 'Traralgon'
],[
'state_id' => 206,
'name' => 'Travancore'
],[
'state_id' => 206,
'name' => 'Trentham'
],[
'state_id' => 206,
'name' => 'Truganina'
],[
'state_id' => 206,
'name' => 'Tullamarine'
],[
'state_id' => 206,
'name' => 'Tyabb'
],[
'state_id' => 206,
'name' => 'Upwey'
],[
'state_id' => 206,
'name' => 'Vermont'
],[
'state_id' => 206,
'name' => 'Vermont South'
],[
'state_id' => 206,
'name' => 'Viewbank'
],[
'state_id' => 206,
'name' => 'Wahgunyah'
],[
'state_id' => 206,
'name' => 'Wallan'
],[
'state_id' => 206,
'name' => 'Wallington'
],[
'state_id' => 206,
'name' => 'Wandana Heights'
],[
'state_id' => 206,
'name' => 'Wandin North'
],[
'state_id' => 206,
'name' => 'Wandong'
],[
'state_id' => 206,
'name' => 'Wangaratta'
],[
'state_id' => 206,
'name' => 'Wantirna'
],[
'state_id' => 206,
'name' => 'Wantirna South'
],[
'state_id' => 206,
'name' => 'Warburton'
],[
'state_id' => 206,
'name' => 'Warracknabeal'
],[
'state_id' => 206,
'name' => 'Warragul'
],[
'state_id' => 206,
'name' => 'Warrandyte'
],[
'state_id' => 206,
'name' => 'Warranwood'
],[
'state_id' => 206,
'name' => 'Warrnambool'
],[
'state_id' => 206,
'name' => 'Waterways'
],[
'state_id' => 206,
'name' => 'Watsonia'
],[
'state_id' => 206,
'name' => 'Watsonia North'
],[
'state_id' => 206,
'name' => 'Wattleglen'
],[
'state_id' => 206,
'name' => 'Waurn Ponds'
],[
'state_id' => 206,
'name' => 'Wellington'
],[
'state_id' => 206,
'name' => 'Wendouree'
],[
'state_id' => 206,
'name' => 'Werribee'
],[
'state_id' => 206,
'name' => 'Werribee South'
],[
'state_id' => 206,
'name' => 'Wesburn'
],[
'state_id' => 206,
'name' => 'West Footscray'
],[
'state_id' => 206,
'name' => 'West Melbourne'
],[
'state_id' => 206,
'name' => 'West Wimmera'
],[
'state_id' => 206,
'name' => 'West Wodonga'
],[
'state_id' => 206,
'name' => 'Westmeadows'
],[
'state_id' => 206,
'name' => 'Wheelers Hill'
],[
'state_id' => 206,
'name' => 'White Hills'
],[
'state_id' => 206,
'name' => 'Whitehorse'
],[
'state_id' => 206,
'name' => 'Whittington'
],[
'state_id' => 206,
'name' => 'Whittlesea'
],[
'state_id' => 206,
'name' => 'Williams Landing'
],[
'state_id' => 206,
'name' => 'Williamstown'
],[
'state_id' => 206,
'name' => 'Williamstown North'
],[
'state_id' => 206,
'name' => 'Winchelsea'
],[
'state_id' => 206,
'name' => 'Windsor'
],[
'state_id' => 206,
'name' => 'Wodonga'
],[
'state_id' => 206,
'name' => 'Wollert'
],[
'state_id' => 206,
'name' => 'Wonga Park'
],[
'state_id' => 206,
'name' => 'Wonthaggi'
],[
'state_id' => 206,
'name' => 'Woodend'
],[
'state_id' => 206,
'name' => 'Woori Yallock'
],[
'state_id' => 206,
'name' => 'Wurruk'
],[
'state_id' => 206,
'name' => 'Wy Yung'
],[
'state_id' => 206,
'name' => 'Wyndham'
],[
'state_id' => 206,
'name' => 'Wyndham Vale'
],[
'state_id' => 206,
'name' => 'Yackandandah'
],[
'state_id' => 206,
'name' => 'Yallambie'
],[
'state_id' => 206,
'name' => 'Yallourn North'
],[
'state_id' => 206,
'name' => 'Yarra'
],[
'state_id' => 206,
'name' => 'Yarra Glen'
],[
'state_id' => 206,
'name' => 'Yarra Junction'
],[
'state_id' => 206,
'name' => 'Yarra Ranges'
],[
'state_id' => 206,
'name' => 'Yarragon'
],[
'state_id' => 206,
'name' => 'Yarram'
],[
'state_id' => 206,
'name' => 'Yarrambat'
],[
'state_id' => 206,
'name' => 'Yarraville'
],[
'state_id' => 206,
'name' => 'Yarrawonga'
],[
'state_id' => 206,
'name' => 'Yarriambiack'
],[
'state_id' => 206,
'name' => 'Yea'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
