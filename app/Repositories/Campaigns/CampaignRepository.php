<?php

namespace App\Repositories\Campaigns;

use App\Core\Repositories\BaseRepository;
use App\Models\Campaigns\Campaign;
use App\Repositories\Campaigns\Contract\CampaignRepositoryInterface;

class CampaignRepository extends BaseRepository implements CampaignRepositoryInterface {

    protected $model;

    public function __construct(Campaign $campaign)
    {
        parent::__construct($campaign);
        $this->model = $campaign;
    }

    /**
     * Format item in $data: key => value
     * type => string or null
     * discount => int
     * price_raw => int
     * price => int
     * bonus => string
     * uses => int
     * 
     */
    public function createCampDetail(array $details){
        $project = $this->model->project()->first();
        foreach($details as $detail){
            $type = $detail['type'];
            unset($detail['type']);
            $camp = $this->model->campaignDetails()->create($detail);

            if(!empty($type)){
                $price = $project->getPrice($type);
                $camp->price()->associate($price);
                $camp->save();
            }
        }
    }

 
}