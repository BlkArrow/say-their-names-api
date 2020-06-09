<?php

use App\Models\PetitionLink;
use App\Models\Statics\PetitionLinkTypes;
use App\Models\Statics\StaticText;
use Illuminate\Database\Seeder;
use Tapp\Airtable\Facades\AirtableFacade;

class PetitionsTableSeeder extends Seeder
{
    public function run()
    {
        $airtableDonations = AirtableFacade::table('petitions')->all();

        foreach ($airtableDonations as $petition) {
            PetitionLink::updateOrCreate(
                ['title' => $petition['fields']['TITLE'] ],
                [
                    'description' => $petition['fields']['DESCRIPTION'],
                    'link' => $petition['fields']['LINK'],
                    'outcome' => isset($petition['fields']['OUTCOME']) ? $petition['fields']['OUTCOME'] : StaticText::CONTRIBUTION_TEXT,
                    'banner_img_url' => $petition['fields']['IMAGE'],
                    'outcome_img_url' => $petition['fields']['OUTCOME IMAGE'],
                    'type_id' => PetitionLinkTypes::FOR_POLICY,
                    'status' => 1,
                ]
            );
        }
    }
}
