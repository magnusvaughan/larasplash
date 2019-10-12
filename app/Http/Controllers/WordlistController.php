<?php

namespace App\Http\Controllers;

use Goutte\Client;
use DonatelloZa\RakePlus\RakePlus;
use Carbon\Carbon;
use App\Wordlist;
use App\Newspaper;
use App\Phrase;
use App\WordTotal;

class WordlistController extends Controller
{
    public function show() {
        $wordlist = new Wordlist();
        $client = new Client();
        $crawler = $client->request('GET', 'https://www.dailymail.co.uk/home/index.html');
        $crawler->filter('.pufftext > strong')->text();
        $headline_array = $crawler->filter('.pufftext > strong')->each(function ($node){
            return $node->text();
        });

        $keywords_array = [];

        foreach ($headline_array as $headline) {
            $single_headline_array = RakePlus::create($headline)->get();
            foreach ($single_headline_array as $keyword) {
                $keywords_array[] = $keyword;
            }
        }

        // Create Newspaper
        $newspaper = new Newspaper;
        $newspaper->name = "The Mail";
        $newspaper->save();

        $phrase_count_array = [];

        foreach ($keywords_array as $value) {
            if(array_key_exists ( $value , $phrase_count_array )) {
                $phrase_count_array[$value] ++;
            }
            else {
                $phrase_count_array[$value] =1;
            }
        }

        $wordlist = new Wordlist;
        $wordlist->date = Carbon::now();
        $wordlist->newspaper = $newspaper->id;
        $wordlist->save();

        foreach ($phrase_count_array as $phrase => $count) {
            $phrase_record = Phrase::where('name', '=', $phrase)->first();
            if ($phrase_record === null) {
                $phrase_record = new Phrase;
                $phrase_record->name = $phrase;
                $phrase_record->save();
            }
            $wordtotal = new WordTotal;
            $wordtotal->count = $count;
            $wordtotal->wordlist = $wordlist->id;
            $wordtotal->phrase = $phrase_record->id;
            $wordtotal->save();
        }
        // var_dump($keywords_array);
    }
}
