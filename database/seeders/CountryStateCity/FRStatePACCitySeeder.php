<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class FRStatePACCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1285,
'name' => 'Aix-en-Provence'
],[
'state_id' => 1285,
'name' => 'Allauch'
],[
'state_id' => 1285,
'name' => 'Alleins'
],[
'state_id' => 1285,
'name' => 'Alpes-Maritimes'
],[
'state_id' => 1285,
'name' => 'Alpes-de-Haute-Provence'
],[
'state_id' => 1285,
'name' => 'Althen-des-Paluds'
],[
'state_id' => 1285,
'name' => 'Annot'
],[
'state_id' => 1285,
'name' => 'Ansouis'
],[
'state_id' => 1285,
'name' => 'Antibes'
],[
'state_id' => 1285,
'name' => 'Apt'
],[
'state_id' => 1285,
'name' => 'Arenc'
],[
'state_id' => 1285,
'name' => 'Arles'
],[
'state_id' => 1285,
'name' => 'Aspremont'
],[
'state_id' => 1285,
'name' => 'Aubagne'
],[
'state_id' => 1285,
'name' => 'Aubignan'
],[
'state_id' => 1285,
'name' => 'Aups'
],[
'state_id' => 1285,
'name' => 'Aureille'
],[
'state_id' => 1285,
'name' => 'Auribeau-sur-Siagne'
],[
'state_id' => 1285,
'name' => 'Auriol'
],[
'state_id' => 1285,
'name' => 'Avignon'
],[
'state_id' => 1285,
'name' => 'Bagnols-en-Forêt'
],[
'state_id' => 1285,
'name' => 'Baille'
],[
'state_id' => 1285,
'name' => 'Bandol'
],[
'state_id' => 1285,
'name' => 'Barbentane'
],[
'state_id' => 1285,
'name' => 'Barcelonnette'
],[
'state_id' => 1285,
'name' => 'Bargemon'
],[
'state_id' => 1285,
'name' => 'Barjols'
],[
'state_id' => 1285,
'name' => 'Beaulieu-sur-Mer'
],[
'state_id' => 1285,
'name' => 'Beaumes-de-Venise'
],[
'state_id' => 1285,
'name' => 'Beaumont-de-Pertuis'
],[
'state_id' => 1285,
'name' => 'Beausoleil'
],[
'state_id' => 1285,
'name' => 'Belcodène'
],[
'state_id' => 1285,
'name' => 'Belgentier'
],[
'state_id' => 1285,
'name' => 'Belle de Mai'
],[
'state_id' => 1285,
'name' => 'Belsunce'
],[
'state_id' => 1285,
'name' => 'Berre-l\'Étang'
],[
'state_id' => 1285,
'name' => 'Berre-les-Alpes'
],[
'state_id' => 1285,
'name' => 'Besse-sur-Issole'
],[
'state_id' => 1285,
'name' => 'Biot'
],[
'state_id' => 1285,
'name' => 'Blausasc'
],[
'state_id' => 1285,
'name' => 'Bollène'
],[
'state_id' => 1285,
'name' => 'Bon-Secours'
],[
'state_id' => 1285,
'name' => 'Bonneveine'
],[
'state_id' => 1285,
'name' => 'Bonnieux'
],[
'state_id' => 1285,
'name' => 'Borel'
],[
'state_id' => 1285,
'name' => 'Bormes-les-Mimosas'
],[
'state_id' => 1285,
'name' => 'Bouc-Bel-Air'
],[
'state_id' => 1285,
'name' => 'Boulbon'
],[
'state_id' => 1285,
'name' => 'Bras'
],[
'state_id' => 1285,
'name' => 'Breil-sur-Roya'
],[
'state_id' => 1285,
'name' => 'Briançon'
],[
'state_id' => 1285,
'name' => 'Brignoles'
],[
'state_id' => 1285,
'name' => 'Bédarrides'
],[
'state_id' => 1285,
'name' => 'Bédoin'
],[
'state_id' => 1285,
'name' => 'Cabannes'
],[
'state_id' => 1285,
'name' => 'Cabasse'
],[
'state_id' => 1285,
'name' => 'Cabris'
],[
'state_id' => 1285,
'name' => 'Cabriès'
],[
'state_id' => 1285,
'name' => 'Cadenet'
],[
'state_id' => 1285,
'name' => 'Caderousse'
],[
'state_id' => 1285,
'name' => 'Cadolive'
],[
'state_id' => 1285,
'name' => 'Cagnes-sur-Mer'
],[
'state_id' => 1285,
'name' => 'Callas'
],[
'state_id' => 1285,
'name' => 'Callian'
],[
'state_id' => 1285,
'name' => 'Camaret-sur-Aigues'
],[
'state_id' => 1285,
'name' => 'Camps-la-Source'
],[
'state_id' => 1285,
'name' => 'Cannes'
],[
'state_id' => 1285,
'name' => 'Cantaron'
],[
'state_id' => 1285,
'name' => 'Cap-d’Ail'
],[
'state_id' => 1285,
'name' => 'Carcès'
],[
'state_id' => 1285,
'name' => 'Carnoules'
],[
'state_id' => 1285,
'name' => 'Carnoux-en-Provence'
],[
'state_id' => 1285,
'name' => 'Caromb'
],[
'state_id' => 1285,
'name' => 'Carpentras'
],[
'state_id' => 1285,
'name' => 'Carqueiranne'
],[
'state_id' => 1285,
'name' => 'Carros'
],[
'state_id' => 1285,
'name' => 'Carry-le-Rouet'
],[
'state_id' => 1285,
'name' => 'Cassis'
],[
'state_id' => 1285,
'name' => 'Castagniers'
],[
'state_id' => 1285,
'name' => 'Castellane'
],[
'state_id' => 1285,
'name' => 'Caumont-sur-Durance'
],[
'state_id' => 1285,
'name' => 'Cavaillon'
],[
'state_id' => 1285,
'name' => 'Cavalaire-sur-Mer'
],[
'state_id' => 1285,
'name' => 'Ceyreste'
],[
'state_id' => 1285,
'name' => 'Charleval'
],[
'state_id' => 1285,
'name' => 'Cheval-Blanc'
],[
'state_id' => 1285,
'name' => 'Chorges'
],[
'state_id' => 1285,
'name' => 'Chutes-Lavie'
],[
'state_id' => 1285,
'name' => 'Châteauneuf-Grasse'
],[
'state_id' => 1285,
'name' => 'Châteauneuf-de-Gadagne'
],[
'state_id' => 1285,
'name' => 'Châteauneuf-du-Pape'
],[
'state_id' => 1285,
'name' => 'Châteauneuf-le-Rouge'
],[
'state_id' => 1285,
'name' => 'Châteauneuf-les-Martigues'
],[
'state_id' => 1285,
'name' => 'Châteaurenard'
],[
'state_id' => 1285,
'name' => 'Cinq Avenues'
],[
'state_id' => 1285,
'name' => 'Cogolin'
],[
'state_id' => 1285,
'name' => 'Collobrières'
],[
'state_id' => 1285,
'name' => 'Colomars'
],[
'state_id' => 1285,
'name' => 'Contes'
],[
'state_id' => 1285,
'name' => 'Cornillon-Confoux'
],[
'state_id' => 1285,
'name' => 'Cotignac'
],[
'state_id' => 1285,
'name' => 'Coudoux'
],[
'state_id' => 1285,
'name' => 'Courthézon'
],[
'state_id' => 1285,
'name' => 'Cucuron'
],[
'state_id' => 1285,
'name' => 'Cuers'
],[
'state_id' => 1285,
'name' => 'Cuges-les-Pins'
],[
'state_id' => 1285,
'name' => 'Céreste'
],[
'state_id' => 1285,
'name' => 'Digne-les-Bains'
],[
'state_id' => 1285,
'name' => 'Draguignan'
],[
'state_id' => 1285,
'name' => 'Drap'
],[
'state_id' => 1285,
'name' => 'Département des Bouches-du-Rhône'
],[
'state_id' => 1285,
'name' => 'Département du Vaucluse'
],[
'state_id' => 1285,
'name' => 'Embrun'
],[
'state_id' => 1285,
'name' => 'Ensuès-la-Redonne'
],[
'state_id' => 1285,
'name' => 'Entraigues-sur-la-Sorgue'
],[
'state_id' => 1285,
'name' => 'Eygalières'
],[
'state_id' => 1285,
'name' => 'Eyguières'
],[
'state_id' => 1285,
'name' => 'Eyragues'
],[
'state_id' => 1285,
'name' => 'Falicon'
],[
'state_id' => 1285,
'name' => 'Fayence'
],[
'state_id' => 1285,
'name' => 'Figanières'
],[
'state_id' => 1285,
'name' => 'Flassans-sur-Issole'
],[
'state_id' => 1285,
'name' => 'Flayosc'
],[
'state_id' => 1285,
'name' => 'Fontvieille'
],[
'state_id' => 1285,
'name' => 'Forcalqueiret'
],[
'state_id' => 1285,
'name' => 'Forcalquier'
],[
'state_id' => 1285,
'name' => 'Fos-sur-Mer'
],[
'state_id' => 1285,
'name' => 'Fréjus'
],[
'state_id' => 1285,
'name' => 'Fuveau'
],[
'state_id' => 1285,
'name' => 'Gap'
],[
'state_id' => 1285,
'name' => 'Gardanne'
],[
'state_id' => 1285,
'name' => 'Gargas'
],[
'state_id' => 1285,
'name' => 'Garéoult'
],[
'state_id' => 1285,
'name' => 'Gassin'
],[
'state_id' => 1285,
'name' => 'Gattières'
],[
'state_id' => 1285,
'name' => 'Gignac-la-Nerthe'
],[
'state_id' => 1285,
'name' => 'Gilette'
],[
'state_id' => 1285,
'name' => 'Ginasservis'
],[
'state_id' => 1285,
'name' => 'Gonfaron'
],[
'state_id' => 1285,
'name' => 'Gorbio'
],[
'state_id' => 1285,
'name' => 'Gordes'
],[
'state_id' => 1285,
'name' => 'Goult'
],[
'state_id' => 1285,
'name' => 'Grambois'
],[
'state_id' => 1285,
'name' => 'Grans'
],[
'state_id' => 1285,
'name' => 'Grasse'
],[
'state_id' => 1285,
'name' => 'Graveson'
],[
'state_id' => 1285,
'name' => 'Grillon'
],[
'state_id' => 1285,
'name' => 'Grimaud'
],[
'state_id' => 1285,
'name' => 'Gréasque'
],[
'state_id' => 1285,
'name' => 'Gréoux-les-Bains'
],[
'state_id' => 1285,
'name' => 'Guillestre'
],[
'state_id' => 1285,
'name' => 'Gémenos'
],[
'state_id' => 1285,
'name' => 'Hautes-Alpes'
],[
'state_id' => 1285,
'name' => 'Hyères'
],[
'state_id' => 1285,
'name' => 'Istres'
],[
'state_id' => 1285,
'name' => 'Jausiers'
],[
'state_id' => 1285,
'name' => 'Jonquerettes'
],[
'state_id' => 1285,
'name' => 'Jonquières'
],[
'state_id' => 1285,
'name' => 'Jouques'
],[
'state_id' => 1285,
'name' => 'L\'Estaque'
],[
'state_id' => 1285,
'name' => 'La Barasse'
],[
'state_id' => 1285,
'name' => 'La Bastide-des-Jourdans'
],[
'state_id' => 1285,
'name' => 'La Blancarde'
],[
'state_id' => 1285,
'name' => 'La Bouilladisse'
],[
'state_id' => 1285,
'name' => 'La Bâtie-Neuve'
],[
'state_id' => 1285,
'name' => 'La Cabucelle'
],[
'state_id' => 1285,
'name' => 'La Calade'
],[
'state_id' => 1285,
'name' => 'La Capelette'
],[
'state_id' => 1285,
'name' => 'La Celle'
],[
'state_id' => 1285,
'name' => 'La Ciotat'
],[
'state_id' => 1285,
'name' => 'La Colle-sur-Loup'
],[
'state_id' => 1285,
'name' => 'La Conception'
],[
'state_id' => 1285,
'name' => 'La Crau'
],[
'state_id' => 1285,
'name' => 'La Croix-Rouge'
],[
'state_id' => 1285,
'name' => 'La Croix-Valmer'
],[
'state_id' => 1285,
'name' => 'La Delorme'
],[
'state_id' => 1285,
'name' => 'La Destrousse'
],[
'state_id' => 1285,
'name' => 'La Fare-les-Oliviers'
],[
'state_id' => 1285,
'name' => 'La Farlède'
],[
'state_id' => 1285,
'name' => 'La Fourragère'
],[
'state_id' => 1285,
'name' => 'La Garde'
],[
'state_id' => 1285,
'name' => 'La Garde-Freinet'
],[
'state_id' => 1285,
'name' => 'La Gaude'
],[
'state_id' => 1285,
'name' => 'La Joliette'
],[
'state_id' => 1285,
'name' => 'La Londe-les-Maures'
],[
'state_id' => 1285,
'name' => 'La Millère'
],[
'state_id' => 1285,
'name' => 'La Motte'
],[
'state_id' => 1285,
'name' => 'La Page'
],[
'state_id' => 1285,
'name' => 'La Panouse'
],[
'state_id' => 1285,
'name' => 'La Penne-sur-Huveaune'
],[
'state_id' => 1285,
'name' => 'La Pointe Rouge'
],[
'state_id' => 1285,
'name' => 'La Pomme'
],[
'state_id' => 1285,
'name' => 'La Roche-des-Arnauds'
],[
'state_id' => 1285,
'name' => 'La Roque-d’Anthéron'
],[
'state_id' => 1285,
'name' => 'La Roquebrussanne'
],[
'state_id' => 1285,
'name' => 'La Roquette-sur-Siagne'
],[
'state_id' => 1285,
'name' => 'La Rose'
],[
'state_id' => 1285,
'name' => 'La Seyne-sur-Mer'
],[
'state_id' => 1285,
'name' => 'La Timone'
],[
'state_id' => 1285,
'name' => 'La Trinité'
],[
'state_id' => 1285,
'name' => 'La Turbie'
],[
'state_id' => 1285,
'name' => 'La Valbarelle'
],[
'state_id' => 1285,
'name' => 'La Valentine'
],[
'state_id' => 1285,
'name' => 'La Valette-du-Var'
],[
'state_id' => 1285,
'name' => 'La Villette'
],[
'state_id' => 1285,
'name' => 'La Viste'
],[
'state_id' => 1285,
'name' => 'Lagnes'
],[
'state_id' => 1285,
'name' => 'Lamanon'
],[
'state_id' => 1285,
'name' => 'Lambesc'
],[
'state_id' => 1285,
'name' => 'Lantosque'
],[
'state_id' => 1285,
'name' => 'Lançon-Provence'
],[
'state_id' => 1285,
'name' => 'Lapalud'
],[
'state_id' => 1285,
'name' => 'Laragne-Montéglin'
],[
'state_id' => 1285,
'name' => 'Lauris'
],[
'state_id' => 1285,
'name' => 'Le Bar-sur-Loup'
],[
'state_id' => 1285,
'name' => 'Le Beausset'
],[
'state_id' => 1285,
'name' => 'Le Broc'
],[
'state_id' => 1285,
'name' => 'Le Brusquet'
],[
'state_id' => 1285,
'name' => 'Le Cabot'
],[
'state_id' => 1285,
'name' => 'Le Camas'
],[
'state_id' => 1285,
'name' => 'Le Canet'
],[
'state_id' => 1285,
'name' => 'Le Cannet'
],[
'state_id' => 1285,
'name' => 'Le Cannet-des-Maures'
],[
'state_id' => 1285,
'name' => 'Le Castellet'
],[
'state_id' => 1285,
'name' => 'Le Chapitre'
],[
'state_id' => 1285,
'name' => 'Le Lavandou'
],[
'state_id' => 1285,
'name' => 'Le Luc'
],[
'state_id' => 1285,
'name' => 'Le Merlan'
],[
'state_id' => 1285,
'name' => 'Le Monêtier-les-Bains'
],[
'state_id' => 1285,
'name' => 'Le Muy'
],[
'state_id' => 1285,
'name' => 'Le Pharo'
],[
'state_id' => 1285,
'name' => 'Le Plan-de-la-Tour'
],[
'state_id' => 1285,
'name' => 'Le Pontet'
],[
'state_id' => 1285,
'name' => 'Le Pradet'
],[
'state_id' => 1285,
'name' => 'Le Puy-Sainte-Réparade'
],[
'state_id' => 1285,
'name' => 'Le Redon'
],[
'state_id' => 1285,
'name' => 'Le Revest-les-Eaux'
],[
'state_id' => 1285,
'name' => 'Le Rouret'
],[
'state_id' => 1285,
'name' => 'Le Rove'
],[
'state_id' => 1285,
'name' => 'Le Tholonet'
],[
'state_id' => 1285,
'name' => 'Le Thor'
],[
'state_id' => 1285,
'name' => 'Le Thoronet'
],[
'state_id' => 1285,
'name' => 'Le Tignet'
],[
'state_id' => 1285,
'name' => 'Le Val'
],[
'state_id' => 1285,
'name' => 'Les Accates'
],[
'state_id' => 1285,
'name' => 'Les Arcs'
],[
'state_id' => 1285,
'name' => 'Les Arnavaux'
],[
'state_id' => 1285,
'name' => 'Les Aygalades'
],[
'state_id' => 1285,
'name' => 'Les Baumettes'
],[
'state_id' => 1285,
'name' => 'Les Caillols'
],[
'state_id' => 1285,
'name' => 'Les Camoins'
],[
'state_id' => 1285,
'name' => 'Les Chartreux'
],[
'state_id' => 1285,
'name' => 'Les Crottes'
],[
'state_id' => 1285,
'name' => 'Les Grands Carmes'
],[
'state_id' => 1285,
'name' => 'Les Médecins'
],[
'state_id' => 1285,
'name' => 'Les Mées'
],[
'state_id' => 1285,
'name' => 'Les Olives'
],[
'state_id' => 1285,
'name' => 'Les Pennes-Mirabeau'
],[
'state_id' => 1285,
'name' => 'Les Trois-Lucs'
],[
'state_id' => 1285,
'name' => 'Levens'
],[
'state_id' => 1285,
'name' => 'Lodi'
],[
'state_id' => 1285,
'name' => 'Lorgues'
],[
'state_id' => 1285,
'name' => 'Loriol-du-Comtat'
],[
'state_id' => 1285,
'name' => 'Lourmarin'
],[
'state_id' => 1285,
'name' => 'Lucéram'
],[
'state_id' => 1285,
'name' => 'L’Escale'
],[
'state_id' => 1285,
'name' => 'L’Escarène'
],[
'state_id' => 1285,
'name' => 'L’Isle-sur-la-Sorgue'
],[
'state_id' => 1285,
'name' => 'Maillane'
],[
'state_id' => 1285,
'name' => 'Malaucène'
],[
'state_id' => 1285,
'name' => 'Malemort-du-Comtat'
],[
'state_id' => 1285,
'name' => 'Malijai'
],[
'state_id' => 1285,
'name' => 'Mallemoisson'
],[
'state_id' => 1285,
'name' => 'Mallemort'
],[
'state_id' => 1285,
'name' => 'Malpassé'
],[
'state_id' => 1285,
'name' => 'Mandelieu-la-Napoule'
],[
'state_id' => 1285,
'name' => 'Mane'
],[
'state_id' => 1285,
'name' => 'Manosque'
],[
'state_id' => 1285,
'name' => 'Marignane'
],[
'state_id' => 1285,
'name' => 'Marseille'
],[
'state_id' => 1285,
'name' => 'Marseille 01'
],[
'state_id' => 1285,
'name' => 'Marseille 02'
],[
'state_id' => 1285,
'name' => 'Marseille 03'
],[
'state_id' => 1285,
'name' => 'Marseille 04'
],[
'state_id' => 1285,
'name' => 'Marseille 05'
],[
'state_id' => 1285,
'name' => 'Marseille 06'
],[
'state_id' => 1285,
'name' => 'Marseille 07'
],[
'state_id' => 1285,
'name' => 'Marseille 08'
],[
'state_id' => 1285,
'name' => 'Marseille 09'
],[
'state_id' => 1285,
'name' => 'Marseille 10'
],[
'state_id' => 1285,
'name' => 'Marseille 11'
],[
'state_id' => 1285,
'name' => 'Marseille 12'
],[
'state_id' => 1285,
'name' => 'Marseille 13'
],[
'state_id' => 1285,
'name' => 'Marseille 14'
],[
'state_id' => 1285,
'name' => 'Marseille 15'
],[
'state_id' => 1285,
'name' => 'Marseille 16'
],[
'state_id' => 1285,
'name' => 'Marseille Bompard'
],[
'state_id' => 1285,
'name' => 'Marseille Endoume'
],[
'state_id' => 1285,
'name' => 'Marseille Prefecture'
],[
'state_id' => 1285,
'name' => 'Marseille Roucas-Blanc'
],[
'state_id' => 1285,
'name' => 'Marseille Saint-Victor'
],[
'state_id' => 1285,
'name' => 'Marseille Vauban'
],[
'state_id' => 1285,
'name' => 'Martigues'
],[
'state_id' => 1285,
'name' => 'Maubec'
],[
'state_id' => 1285,
'name' => 'Maussane-les-Alpilles'
],[
'state_id' => 1285,
'name' => 'Mazan'
],[
'state_id' => 1285,
'name' => 'Mazargues'
],[
'state_id' => 1285,
'name' => 'Menpenti'
],[
'state_id' => 1285,
'name' => 'Menton'
],[
'state_id' => 1285,
'name' => 'Meyrargues'
],[
'state_id' => 1285,
'name' => 'Meyreuil'
],[
'state_id' => 1285,
'name' => 'Mimet'
],[
'state_id' => 1285,
'name' => 'Miramas'
],[
'state_id' => 1285,
'name' => 'Mollégès'
],[
'state_id' => 1285,
'name' => 'Mondragon'
],[
'state_id' => 1285,
'name' => 'Montauroux'
],[
'state_id' => 1285,
'name' => 'Monteux'
],[
'state_id' => 1285,
'name' => 'Montfavet'
],[
'state_id' => 1285,
'name' => 'Montferrat'
],[
'state_id' => 1285,
'name' => 'Montolivet'
],[
'state_id' => 1285,
'name' => 'Montredon'
],[
'state_id' => 1285,
'name' => 'Morières-lès-Avignon'
],[
'state_id' => 1285,
'name' => 'Mormoiron'
],[
'state_id' => 1285,
'name' => 'Mornas'
],[
'state_id' => 1285,
'name' => 'Mouans-Sartoux'
],[
'state_id' => 1285,
'name' => 'Mougins'
],[
'state_id' => 1285,
'name' => 'Mouret'
],[
'state_id' => 1285,
'name' => 'Mouriès'
],[
'state_id' => 1285,
'name' => 'Ménerbes'
],[
'state_id' => 1285,
'name' => 'Méounes-lès-Montrieux'
],[
'state_id' => 1285,
'name' => 'Mérindol'
],[
'state_id' => 1285,
'name' => 'Nans-les-Pins'
],[
'state_id' => 1285,
'name' => 'Nice'
],[
'state_id' => 1285,
'name' => 'Noailles'
],[
'state_id' => 1285,
'name' => 'Notre-Dame Limite'
],[
'state_id' => 1285,
'name' => 'Notre-Dame du Mont'
],[
'state_id' => 1285,
'name' => 'Noves'
],[
'state_id' => 1285,
'name' => 'Néoules'
],[
'state_id' => 1285,
'name' => 'Ollioules'
],[
'state_id' => 1285,
'name' => 'Opio'
],[
'state_id' => 1285,
'name' => 'Oppède le Vieux'
],[
'state_id' => 1285,
'name' => 'Opéra'
],[
'state_id' => 1285,
'name' => 'Oraison'
],[
'state_id' => 1285,
'name' => 'Orange'
],[
'state_id' => 1285,
'name' => 'Orgon'
],[
'state_id' => 1285,
'name' => 'Palais de Justice'
],[
'state_id' => 1285,
'name' => 'Palama'
],[
'state_id' => 1285,
'name' => 'Paradou'
],[
'state_id' => 1285,
'name' => 'Peille'
],[
'state_id' => 1285,
'name' => 'Peillon'
],[
'state_id' => 1285,
'name' => 'Peipin'
],[
'state_id' => 1285,
'name' => 'Pernes-les-Fontaines'
],[
'state_id' => 1285,
'name' => 'Pertuis'
],[
'state_id' => 1285,
'name' => 'Peymeinade'
],[
'state_id' => 1285,
'name' => 'Peynier'
],[
'state_id' => 1285,
'name' => 'Peypin'
],[
'state_id' => 1285,
'name' => 'Peyrolles-en-Provence'
],[
'state_id' => 1285,
'name' => 'Peyruis'
],[
'state_id' => 1285,
'name' => 'Pierrefeu-du-Var'
],[
'state_id' => 1285,
'name' => 'Pierrevert'
],[
'state_id' => 1285,
'name' => 'Pignans'
],[
'state_id' => 1285,
'name' => 'Piolenc'
],[
'state_id' => 1285,
'name' => 'Plan-d\'Aups-Sainte-Baume'
],[
'state_id' => 1285,
'name' => 'Plan-de-Cuques'
],[
'state_id' => 1285,
'name' => 'Pont de Vivaux'
],[
'state_id' => 1285,
'name' => 'Port-Saint-Louis-du-Rhône'
],[
'state_id' => 1285,
'name' => 'Port-de-Bouc'
],[
'state_id' => 1285,
'name' => 'Pourrières'
],[
'state_id' => 1285,
'name' => 'Puget-Théniers'
],[
'state_id' => 1285,
'name' => 'Puget-Ville'
],[
'state_id' => 1285,
'name' => 'Puget-sur-Argens'
],[
'state_id' => 1285,
'name' => 'Puyloubier'
],[
'state_id' => 1285,
'name' => 'Pégomas'
],[
'state_id' => 1285,
'name' => 'Pélissanne'
],[
'state_id' => 1285,
'name' => 'Périer'
],[
'state_id' => 1285,
'name' => 'Ramatuelle'
],[
'state_id' => 1285,
'name' => 'Reillanne'
],[
'state_id' => 1285,
'name' => 'Rians'
],[
'state_id' => 1285,
'name' => 'Riez'
],[
'state_id' => 1285,
'name' => 'Robion'
],[
'state_id' => 1285,
'name' => 'Rocbaron'
],[
'state_id' => 1285,
'name' => 'Rognac'
],[
'state_id' => 1285,
'name' => 'Rognes'
],[
'state_id' => 1285,
'name' => 'Rognonas'
],[
'state_id' => 1285,
'name' => 'Roquebillière'
],[
'state_id' => 1285,
'name' => 'Roquebrune-Cap-Martin'
],[
'state_id' => 1285,
'name' => 'Roquebrune-sur-Argens'
],[
'state_id' => 1285,
'name' => 'Roquefort-la-Bédoule'
],[
'state_id' => 1285,
'name' => 'Roquevaire'
],[
'state_id' => 1285,
'name' => 'Rouet'
],[
'state_id' => 1285,
'name' => 'Rougiers'
],[
'state_id' => 1285,
'name' => 'Rousset'
],[
'state_id' => 1285,
'name' => 'Roussillon'
],[
'state_id' => 1285,
'name' => 'Régusse'
],[
'state_id' => 1285,
'name' => 'Sablet'
],[
'state_id' => 1285,
'name' => 'Saignon'
],[
'state_id' => 1285,
'name' => 'Saint-Andiol'
],[
'state_id' => 1285,
'name' => 'Saint-André'
],[
'state_id' => 1285,
'name' => 'Saint-André-de-la-Roche'
],[
'state_id' => 1285,
'name' => 'Saint-Antoine'
],[
'state_id' => 1285,
'name' => 'Saint-Barnabé'
],[
'state_id' => 1285,
'name' => 'Saint-Barthélémy'
],[
'state_id' => 1285,
'name' => 'Saint-Bonnet-en-Champsaur'
],[
'state_id' => 1285,
'name' => 'Saint-Cannat'
],[
'state_id' => 1285,
'name' => 'Saint-Chaffrey'
],[
'state_id' => 1285,
'name' => 'Saint-Chamas'
],[
'state_id' => 1285,
'name' => 'Saint-Charles'
],[
'state_id' => 1285,
'name' => 'Saint-Cyr-sur-Mer'
],[
'state_id' => 1285,
'name' => 'Saint-Cézaire-sur-Siagne'
],[
'state_id' => 1285,
'name' => 'Saint-Didier'
],[
'state_id' => 1285,
'name' => 'Saint-Giniez'
],[
'state_id' => 1285,
'name' => 'Saint-Henri'
],[
'state_id' => 1285,
'name' => 'Saint-Jean du Désert'
],[
'state_id' => 1285,
'name' => 'Saint-Jean-Cap-Ferrat'
],[
'state_id' => 1285,
'name' => 'Saint-Jeannet'
],[
'state_id' => 1285,
'name' => 'Saint-Joseph'
],[
'state_id' => 1285,
'name' => 'Saint-Julien'
],[
'state_id' => 1285,
'name' => 'Saint-Just'
],[
'state_id' => 1285,
'name' => 'Saint-Jérôme'
],[
'state_id' => 1285,
'name' => 'Saint-Lambert'
],[
'state_id' => 1285,
'name' => 'Saint-Laurent-du-Var'
],[
'state_id' => 1285,
'name' => 'Saint-Lazare'
],[
'state_id' => 1285,
'name' => 'Saint-Louis'
],[
'state_id' => 1285,
'name' => 'Saint-Loup'
],[
'state_id' => 1285,
'name' => 'Saint-Mandrier-sur-Mer'
],[
'state_id' => 1285,
'name' => 'Saint-Marc-Jaumegarde'
],[
'state_id' => 1285,
'name' => 'Saint-Marcel'
],[
'state_id' => 1285,
'name' => 'Saint-Martin-Vésubie'
],[
'state_id' => 1285,
'name' => 'Saint-Martin-de-Crau'
],[
'state_id' => 1285,
'name' => 'Saint-Martin-de-Queyrières'
],[
'state_id' => 1285,
'name' => 'Saint-Martin-du-Var'
],[
'state_id' => 1285,
'name' => 'Saint-Mauront'
],[
'state_id' => 1285,
'name' => 'Saint-Maximin-la-Sainte-Baume'
],[
'state_id' => 1285,
'name' => 'Saint-Menet'
],[
'state_id' => 1285,
'name' => 'Saint-Michel-l’Observatoire'
],[
'state_id' => 1285,
'name' => 'Saint-Mitre'
],[
'state_id' => 1285,
'name' => 'Saint-Mitre-les-Remparts'
],[
'state_id' => 1285,
'name' => 'Saint-Paul-de-Vence'
],[
'state_id' => 1285,
'name' => 'Saint-Paul-en-Forêt'
],[
'state_id' => 1285,
'name' => 'Saint-Pierre'
],[
'state_id' => 1285,
'name' => 'Saint-Raphaël'
],[
'state_id' => 1285,
'name' => 'Saint-Rémy-de-Provence'
],[
'state_id' => 1285,
'name' => 'Saint-Saturnin-lès-Apt'
],[
'state_id' => 1285,
'name' => 'Saint-Saturnin-lès-Avignon'
],[
'state_id' => 1285,
'name' => 'Saint-Savournin'
],[
'state_id' => 1285,
'name' => 'Saint-Tronc'
],[
'state_id' => 1285,
'name' => 'Saint-Tropez'
],[
'state_id' => 1285,
'name' => 'Saint-Vallier-de-Thiey'
],[
'state_id' => 1285,
'name' => 'Saint-Victoret'
],[
'state_id' => 1285,
'name' => 'Saint-Zacharie'
],[
'state_id' => 1285,
'name' => 'Saint-Étienne-de-Tinée'
],[
'state_id' => 1285,
'name' => 'Saint-Étienne-du-Grès'
],[
'state_id' => 1285,
'name' => 'Sainte-Agnès'
],[
'state_id' => 1285,
'name' => 'Sainte-Anastasie-sur-Issole'
],[
'state_id' => 1285,
'name' => 'Sainte-Anne'
],[
'state_id' => 1285,
'name' => 'Sainte-Cécile-les-Vignes'
],[
'state_id' => 1285,
'name' => 'Sainte-Marguerite'
],[
'state_id' => 1285,
'name' => 'Sainte-Marthe'
],[
'state_id' => 1285,
'name' => 'Sainte-Maxime'
],[
'state_id' => 1285,
'name' => 'Sainte-Tulle'
],[
'state_id' => 1285,
'name' => 'Saintes-Maries-de-la-Mer'
],[
'state_id' => 1285,
'name' => 'Salernes'
],[
'state_id' => 1285,
'name' => 'Salon-de-Provence'
],[
'state_id' => 1285,
'name' => 'Sanary-sur-Mer'
],[
'state_id' => 1285,
'name' => 'Sarrians'
],[
'state_id' => 1285,
'name' => 'Sault'
],[
'state_id' => 1285,
'name' => 'Sausset-les-Pins'
],[
'state_id' => 1285,
'name' => 'Seillans'
],[
'state_id' => 1285,
'name' => 'Septèmes-les-Vallons'
],[
'state_id' => 1285,
'name' => 'Serres'
],[
'state_id' => 1285,
'name' => 'Seyne-les-Alpes'
],[
'state_id' => 1285,
'name' => 'Signes'
],[
'state_id' => 1285,
'name' => 'Simiane-Collongue'
],[
'state_id' => 1285,
'name' => 'Sisteron'
],[
'state_id' => 1285,
'name' => 'Six-Fours-les-Plages'
],[
'state_id' => 1285,
'name' => 'Solliès-Pont'
],[
'state_id' => 1285,
'name' => 'Solliès-Toucas'
],[
'state_id' => 1285,
'name' => 'Solliès-Ville'
],[
'state_id' => 1285,
'name' => 'Sorgues'
],[
'state_id' => 1285,
'name' => 'Sormiou'
],[
'state_id' => 1285,
'name' => 'Sospel'
],[
'state_id' => 1285,
'name' => 'Spéracèdes'
],[
'state_id' => 1285,
'name' => 'Sénas'
],[
'state_id' => 1285,
'name' => 'Sérignan-du-Comtat'
],[
'state_id' => 1285,
'name' => 'Taillades'
],[
'state_id' => 1285,
'name' => 'Tallard'
],[
'state_id' => 1285,
'name' => 'Tanneron'
],[
'state_id' => 1285,
'name' => 'Taradeau'
],[
'state_id' => 1285,
'name' => 'Tarascon'
],[
'state_id' => 1285,
'name' => 'Tende'
],[
'state_id' => 1285,
'name' => 'Thiers'
],[
'state_id' => 1285,
'name' => 'Théoule-sur-Mer'
],[
'state_id' => 1285,
'name' => 'Toulon'
],[
'state_id' => 1285,
'name' => 'Tourrette-Levens'
],[
'state_id' => 1285,
'name' => 'Tourrettes-sur-Loup'
],[
'state_id' => 1285,
'name' => 'Tourves'
],[
'state_id' => 1285,
'name' => 'Trans-en-Provence'
],[
'state_id' => 1285,
'name' => 'Trets'
],[
'state_id' => 1285,
'name' => 'Uchaux'
],[
'state_id' => 1285,
'name' => 'Vacqueyras'
],[
'state_id' => 1285,
'name' => 'Vaison-la-Romaine'
],[
'state_id' => 1285,
'name' => 'Valbonne'
],[
'state_id' => 1285,
'name' => 'Valensole'
],[
'state_id' => 1285,
'name' => 'Vallauris'
],[
'state_id' => 1285,
'name' => 'Valréas'
],[
'state_id' => 1285,
'name' => 'Var'
],[
'state_id' => 1285,
'name' => 'Vedène'
],[
'state_id' => 1285,
'name' => 'Velaux'
],[
'state_id' => 1285,
'name' => 'Velleron'
],[
'state_id' => 1285,
'name' => 'Venasque'
],[
'state_id' => 1285,
'name' => 'Vence'
],[
'state_id' => 1285,
'name' => 'Venelles'
],[
'state_id' => 1285,
'name' => 'Ventabren'
],[
'state_id' => 1285,
'name' => 'Verduron'
],[
'state_id' => 1285,
'name' => 'Vernègues'
],[
'state_id' => 1285,
'name' => 'Veynes'
],[
'state_id' => 1285,
'name' => 'Vidauban'
],[
'state_id' => 1285,
'name' => 'Vieille Chapelle'
],[
'state_id' => 1285,
'name' => 'Villar-Saint-Pancrace'
],[
'state_id' => 1285,
'name' => 'Villecroze'
],[
'state_id' => 1285,
'name' => 'Villefranche-sur-Mer'
],[
'state_id' => 1285,
'name' => 'Villelaure'
],[
'state_id' => 1285,
'name' => 'Villeneuve'
],[
'state_id' => 1285,
'name' => 'Villeneuve-Loubet'
],[
'state_id' => 1285,
'name' => 'Villes-sur-Auzon'
],[
'state_id' => 1285,
'name' => 'Vinon-sur-Verdon'
],[
'state_id' => 1285,
'name' => 'Violès'
],[
'state_id' => 1285,
'name' => 'Visan'
],[
'state_id' => 1285,
'name' => 'Vitrolles'
],[
'state_id' => 1285,
'name' => 'Volonne'
],[
'state_id' => 1285,
'name' => 'Volx'
],[
'state_id' => 1285,
'name' => 'Èze'
],[
'state_id' => 1285,
'name' => 'Éguilles'
],[
'state_id' => 1285,
'name' => 'Éoures'
],[
'state_id' => 1285,
'name' => 'Évenos'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
