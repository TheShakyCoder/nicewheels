<?php

namespace App\Services;

use App\Models\EbayAspect;
use App\Models\EbayCategory;
use App\Models\EbayItem;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class EbayService
{
    private $appId;
    private $cert;
    private $globalId;
    private $siteId;
    private $endpoint;
    private $findingServiceUrl;
    private $itemsPerCategory;
    private $debug;
    private $tokenFile = 'ebayApplicationAccessToken.json';

    public function __construct()
    {
        $credentials             = config('ebay.credentials');
        $this->appId             = $credentials['appId'];
        $this->cert              = $credentials['cert'];

        $settings                = config('ebay.settings');
        $this->globalId          = $settings['globalId'];
        $this->siteId            = $settings['siteId'];
        $this->endpoint          = $settings['endpoint'];
        $this->findingServiceUrl = $settings['findingServiceUrl'];
        $this->shoppingUrl       = $settings['shoppingUrl'];
        $this->itemsPerCategory  = $settings['itemsPerCategory'];
        $this->debug             = $settings['debug'];
    }

    public function findItemsByCategory(EbayCategory $ebayCategory)
    {
        $token = $this->getApplicationAccessToken();

        $response = Http::withOptions([
            'debug' => $this->debug
        ])->withHeaders([
            'Authorization' => 'Bearer '.$token,
            'X-EBAY-SOA-OPERATION-NAME' => 'findItemsByCategory',
            'X-EBAY-SOA-RESPONSE-DATA-FORMAT' => 'JSON',
//            'X-EBAY-SOA-SECURITY-APPNAME' => $this->appId
        ])->get($this->findingServiceUrl, [
            'OPERATION-NAME' => 'findItemsByCategory',
            'GLOBAL-ID' => $this->globalId,
            'SERVICE-VERSION' => '1.12.0',
            'SECURITY-APPNAME' => $this->appId,
            'RESPONSE-DATA-FORMAT' => 'JSON',
            'sortOrder' => 'EndTimeSoonest',
            'itemFilter(0).name' => 'ListingType',
            'itemFilter(0).value(0)' => 'Auction',
            'affiliate.networkId' => '9',
            'affiliate.trackingId' => '5335846304',
            'paginationInput.entriesPerPage' => $this->itemsPerCategory,
            'REST-PAYLOAD' => '',
            'categoryId' => $ebayCategory->id
        ]);

        return json_decode($response->body());
    }

    public function getMultipleItems($itemIds, $isWithAspects = false)
    {
        if(count($itemIds) == 0) {
            return false;
        }

        $token = $this->getApplicationAccessToken();

        $payload = [
            'callname' => 'GetMultipleItems',
            'responseencoding' => 'JSON',
            'appid' => $this->appId,
            'version' => '1157',
            'siteid' => $this->siteId,
            'ItemID' => join(",", $itemIds)
        ];
        if($isWithAspects) {
            $payload['includeSelector'] = 'ItemSpecifics';
        }

        $response = Http::withOptions([
            'debug' => $this->debug
        ])->withHeaders([
            'Authorization' => 'Bearer '.$token,
            'X-EBAY-SOA-OPERATION-NAME' => 'GetMultipleItems',
            'X-EBAY-SOA-RESPONSE-DATA-FORMAT' => 'JSON',
//            'X-EBAY-SOA-SECURITY-APPNAME' => $this->appId
        ])->get($this->shoppingUrl, $payload);

        return json_decode($response->body());
    }




    private function getApplicationAccessToken()
    {
        //  check local file
        if (!Storage::disk('local')->exists($this->tokenFile)) {
            $response = $this->fetchApplicationAccessToken();
            Storage::disk('local')->put($this->tokenFile, $response->body());
        }

        $time = Storage::disk('local')->lastModified($this->tokenFile);

        $file = json_decode(Storage::disk('local')->get($this->tokenFile));

        if($time + $file->expires_in < now()->timestamp) {
            $response = $this->fetchApplicationAccessToken();
            Storage::disk('local')->put($this->tokenFile, $response->body());
        }

        $file = json_decode(Storage::disk('local')->get($this->tokenFile));

        return $file->access_token;
    }

    private function fetchApplicationAccessToken()
    {
        $payload = 'Basic '.base64_encode($this->appId.':'.$this->cert);

        $response = Http::asForm()->withOptions([
            'debug' => $this->debug
        ])->withHeaders([
            'Authorization' => $payload
        ])->post($this->endpoint, [
            'grant_type' => 'client_credentials',
            'scope' => 'https://api.ebay.com/oauth/api_scope'
        ]);

        return $response;
    }
}
