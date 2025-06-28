<?php

namespace App\Controllers;

use App\Controllers\SapIntegrationController;
use App\Core\Response;

class ApiController
{
    protected $db;

    public function __construct($mysqli)
    {
        $this->db = $mysqli;
    }

    public function handle($api, $selectedDate)
    {
        $sap = new SapIntegrationController($this->db, $selectedDate);

        switch ($api) {
            case '/API_BUSINESS_PARTNER/A_BusinessPartner':
                $data = $sap->importBusinessPartner();
                // Session::set('success', 'Item Master imported successfully.');
                Response::json('Business Partner imported successfully.', $data, true);
                break;
            case '/API_PRODUCT_SRV/A_Product':
                $data = $sap->importItemsMaster();
                // Session::set('success', 'Item Master imported successfully.');
                Response::json('Item Master imported successfully.', $data, true);
                break;

            default:
                Response::json('Invalid API selected.', [], false);
        }
    }
}
