<?php

namespace App\Controllers;

use Exception;

error_reporting(1);
date_default_timezone_set('Asia/Dubai');

include_once "execute_sp.php";

class SapIntegrationController
{
    //latest
    private $mysqli;
    private $sessionId;
    private $baseUrl;

    public function __construct($mysqli, $selectedDate = '')
    {
        $this->mysqli = $mysqli;
        $this->baseUrl = 'http://tech.sapvista.com:50000/sap/opu/odata/SAP';
    }

    public function importItemsMaster()
    {
        $baseUrl = "http://tech.sapvista.com:50000/sap/opu/odata/sap/API_PRODUCT_SRV/A_Product";

        $getUrl = $baseUrl;

        $pageno = 1;
        $valueSets = [];
        $table = "int_imp_sap_items";
        $columns = [];

        do {
            $itemResponse = $this->callApi("GET", $getUrl, null, $this->sessionId);

            if (isset($itemResponse) && is_array($itemResponse->d->results)) {
                foreach ($itemResponse->d->results as $key => $item) {

                    $itemResult  = $this->preparedItemsMasterPayload($item);
                    $valueSets[] = $itemResult['values'];
                    $columns     = $itemResult['columns'];
                }
            } else {
                $this->logMessage("Unexpected response format or no data received.");
            }

            $this->logMessage($getUrl);

            $getUrl = isset($itemResponse->d->{'__next'}) ? $itemResponse->d->{'__next'} : false;
            $pageno++;
        } while ($getUrl);

        if (count($valueSets) > 0) {

            $this->truncateTable($table);

            $query = $this->insertQuery($table, $columns, $valueSets);

            // $this->logMessage(json_encode(['query' => ''], JSON_PRETTY_PRINT), 'importItems.log');

            $this->logMessage($query, 'importItems.log');

            executequery($this->mysqli, $query);
        }
    }

    private function preparedItemsMasterPayload($item)
    {
        $item = (array)$item;
        $paramArray = [
            'product'                              => $item['Product'] ?? '',
            'product_type'                         => $item['ProductType'] ?? '',
            'cross_plant_status'                   => $item['CrossPlantStatus'] ?? '',
            'cross_plant_status_validity_date'     => $this->formatedDate($item['CrossPlantStatusValidityDate'])  ?? '',
            'creation_date'                        => $this->formatedDate($item['CreationDate']) ?? '',
            'created_by_user'                      => $item['CreatedByUser'] ?? '',
            'last_change_date'                     => $this->formatedDate($item['LastChangeDate']) ?? '',
            'last_changed_by_user'                 => $item['LastChangedByUser'] ?? '',
            // 'last_change_date_time'                => $this->formatedDate($item['LastChangeDateTime']) ?? '',
            'is_marked_for_deletion'               => $this->sanitizeBooleanInt($item['IsMarkedForDeletion']) ?? '',
            'product_old_id'                       => $item['ProductOldId'] ?? '',
            'gross_weight'                         => $item['GrossWeight'] ?? '',
            'purchase_order_quantity_unit'         => $item['PurchaseOrderQuantityUnit'] ?? '',
            'source_of_supply'                     => $item['SourceOfSupply'] ?? '',
            'weight_unit'                          => $item['WeightUnit'] ?? '',
            'net_weight'                           => $item['NetWeight'] ?? '',
            'country_of_origin'                    => $item['CountryOfOrigin'] ?? '',
            'competitor_id'                        => $item['CompetitorId'] ?? '',
            'product_group'                        => $item['ProductGroup'] ?? '',
            'base_unit'                            => $item['BaseUnit'] ?? '',
            'item_category_group'                  => $item['ItemCategoryGroup'] ?? '',
            'product_hierarchy'                    => $item['ProductHierarchy'],
            'division'                             => $item['Division'],
            'varbl_pur_ord_unit_is_active'         => $item['VarblPurOrdUnitIsActive'],
            'volume_unit'                          => $item['VolumeUnit'],
            'material_volume'                      => $item['MaterialVolume'],
            'anp_code'                             => $item['AnpCode'] ?? '',
            'brand'                                => $item['Brand'],
            'procurement_rule'                     => $item['ProcurementRule'],
            'validity_start_date'                  => $this->formatedDate($item['ValidityStartDate']) ?? '',
            'low_level_code'                       => $item['LowLevelCode'],
            'prod_no_in_gen_prod_in_prepack_prod'  => $item['ProdNoInGenProdInPrepackProd'],
            'serial_identifier_assgmt_profile'     => $item['SerialIdentifierAssgmtProfile'],
            'size_or_dimension_text'               => $item['SizeOrDimensionText'],
            'industry_standard_name'               => $item['IndustryStandardName'],
            'product_standard_id'                  => $item['ProductStandardId'] ?? '',
            'international_article_number_cat'     => $item['InternationalArticleNumberCat'],
            'product_is_configurable'              => $this->sanitizeBooleanInt($item['ProductIsConfigurable']) ?? '',
            'is_batch_management_required'         => $this->sanitizeBooleanInt($item['IsBatchManagementRequired']) ?? '',
            'external_product_group'               => $item['ExternalProductGroup'],
            'cross_plant_configurable_product'     => $item['CrossPlantConfigurableProduct'],
            'serial_no_explicitness_level'         => $item['SerialNoExplicitnessLevel'],
            'product_manufacturer_number'          => $item['ProductManufacturerNumber'],
            'manufacturer_number'                  => $item['ManufacturerNumber'],
            'manufacturer_part_profile'            => $item['ManufacturerPartProfile'],
            'qlty_mgmt_in_procmt_is_active'        => $this->sanitizeBooleanInt($item['QltyMgmtInProcmtIsActive']) ?? '',
            'industry_sector'                      => $item['IndustrySector'],
            'change_number'                        => $item['ChangeNumber'],
            'material_revision_level'              => $item['MaterialRevisionLevel'],
            'handling_indicator'                   => $item['HandlingIndicator'],
            'warehouse_product_group'              => $item['WarehouseProductGroup'],
            'warehouse_storage_condition'          => $item['WarehouseStorageCondition'],
            'standard_handling_unit_type'          => $item['StandardHandlingUnitType'],
            'serial_number_profile'                => $item['SerialNumberProfile'],
            'adjustment_profile'                   => $item['AdjustmentProfile'],
            'preferred_unit_of_measure'            => $item['PreferredUnitOfMeasure'],
            'is_pilferable'                        => $this->sanitizeBooleanInt($item['IsPilferable']) ?? '',
            'is_relevant_for_hzds_substances'      => $this->sanitizeBooleanInt($item['IsRelevantForHzdsSubstances']),
            'quarantine_period'                    => $item['QuarantinePeriod'],
            'time_unit_for_quarantine_period'      => $item['TimeUnitForQuarantinePeriod'],
            'quality_inspection_group'             => $item['QualityInspectionGroup'],
            'authorization_group'                  => $item['AuthorizationGroup'],
            'document_is_created_by_cad'           => $this->sanitizeBooleanInt($item['DocumentIsCreatedByCad'] ?? '') ?? '',
            'handling_unit_type'                   => $item['HandlingUnitType'],
            'has_variable_tare_weight'             => $this->sanitizeBooleanInt($item['HasVariableTareWeight']),
            'maximum_packaging_length'             => $item['MaximumPackagingLength'] ?? '',
            'maximum_packaging_width'              => $item['MaximumPackagingWidth'] ?? '',
            'maximum_packaging_height'             => $item['MaximumPackagingHeight'] ?? '',
            'unit_for_max_packaging_dimensions'    => $item['UnitForMaxPackagingDimensions'] ?? '',
            'cdate'                                => date('y-m-d'),
        ];

        // return $paramArray;

        $valueSets = "('" . implode("', '", $paramArray) . "')";

        return [
            'columns' => array_keys($paramArray),
            'values' => $valueSets,
        ];
    }

    public function importBusinessPartner()
    {
        // $jj = $this->importCustomerSalesAreaByBusinessPartner();
        // dl($jj);

        $baseUrl = 'http://tech.sapvista.com:50000/sap/opu/odata/SAP/API_BUSINESS_PARTNER/A_BusinessPartner?$expand=to_Customer,to_BusinessPartner';

        // $filter = urlencode("SalesItem eq 'Y'");
        // $select = urlencode("ItemCode,ItemName,ForeignName,BarCode,SalesUnit,ItemsGroupCode,Valid,ItemPrices,SalesVATGroup,U_Product,U_Category,U_PrdType");
        // $getUrl = "$baseUrl?\$filter=$filter&\$select=$select";

        $getUrl = $baseUrl;

        $valueSets = [];
        $table = "business_partners";
        $columns = [
            'business_partner',                      // 1
            'customer',                             // 2
            'supplier',                             // 3
            'academic_title',                       // 4
            'authorization_group',                  // 5
            'business_partner_category',            // 6
            'business_partner_full_name',           // 7
            'business_partner_grouping',            // 8
            'business_partner_name',                // 9
            'business_partner_uuid',                // 10
            'correspondence_language',              // 11
            'created_by_user',                      // 12
            'creation_date',                        // 13
            'creation_time',                        // 14
            'first_name',                          // 15
            'form_of_address',                     // 16
            'industry',                            // 17
            'international_location_number1',      // 18
            'international_location_number2',      // 19
            'is_female',                          // 20
            'is_male',                            // 21
            'is_natural_person',                  // 22
            'is_sex_unknown',                     // 23
            'gender_code_name',                   // 24
            'language',                          // 25
            'last_change_date',                   // 26
            'last_change_time',                   // 27
            'last_changed_by_user',               // 28
            'last_name',                         // 29
            'legal_form',                        // 30
            'organization_bp_name1',              // 31
            'organization_bp_name2',              // 32
            'organization_bp_name3',              // 33
            'organization_bp_name4',              // 34
            'organization_foundation_date',       // 35
            'organization_liquidation_date',      // 36
            'search_term1',                      // 37
            'search_term2',                      // 38
            'additional_last_name',               // 39
            'birth_date',                        // 40
            'business_partner_is_blocked',        // 41
            'business_partner_type',              // 42
            'etag',                             // 43
            'group_business_partner_name1',       // 44
            'group_business_partner_name2',       // 45
            'independent_address_id',             // 46
            'international_location_number3',      // 47
            'middle_name',                       // 48
            'name_country',                      // 49
            'name_format',                       // 50
            'person_full_name',                  // 51
            'person_number',                     // 52
            'is_marked_for_archiving',            // 53
            'business_partner_id_by_ext_system',  // 54
            'business_partner_print_format',      // 55
            'business_partner_occupation',        // 56
            'bus_part_marital_status',            // 57
            'bus_part_nationality',               // 58
            'business_partner_birth_name',        // 59
            'business_partner_supplement_name',   // 60
            'natural_person_employer_name',       // 61
            'last_name_prefix',                  // 62
            'last_name_second_prefix',           // 63
            'initials',                         // 64
            'bp_data_controller_is_not_required', // 65
            'trading_partner',                   // 66

            "created_at", // always last: Creation Date

        ];
        $itemResponse = $this->callApi("GET", $getUrl, null, $this->sessionId);

        if (isset($itemResponse) && is_array($itemResponse->d->results)) {
            foreach ($itemResponse->d->results as $key => $item) {
                $valueSets[] = $this->preparedBusinessPartnerPayload($item);
            }
        } else {
            $this->logMessage("Unexpected response format or no data received.");
        }

        $this->logMessage(json_encode(['valueSets' => $valueSets,], JSON_PRETTY_PRINT), 'api.log');

        $this->logMessage(json_encode(['url' => $getUrl, 'response' => 1], JSON_PRETTY_PRINT));

        if (count($valueSets) > 0) {

            $this->truncateTable($table);

            $query = $this->insertQuery($table, $columns, $valueSets);

            $this->logMessage($query);

            executequery($this->mysqli, $query);

            $this->importCustomerCompanyByBusinessPartner();

            $this->importCustomerSalesAreaByBusinessPartner();
        }
    }

    private function preparedBusinessPartnerPayload($item)
    {
        $partner = (array)$item;
        $paramArray = [
            $partner['BusinessPartner'] ?? null,                      // 1
            $partner['Customer'] ?? null,                             // 2
            $partner['Supplier'] ?? null,                             // 3
            $partner['AcademicTitle'] ?? null,                        // 4
            $partner['AuthorizationGroup'] ?? null,                   // 5
            $partner['BusinessPartnerCategory'] ?? null,              // 6
            $partner['BusinessPartnerFullName'] ?? null,               // 7
            $partner['BusinessPartnerGrouping'] ?? null,               // 8
            $partner['BusinessPartnerName'] ?? null,                   // 9
            $partner['BusinessPartnerUUID'] ?? null,                   // 10
            $partner['CorrespondenceLanguage'] ?? null,                // 11
            $partner['CreatedByUser'] ?? null,                         // 12
            $this->formatedDate($partner['CreationDate'], $partner['BusinessPartner']),            // 13
            $partner['CreationTime'] ?? null,                          // 14
            $partner['FirstName'] ?? null,                             // 15
            $partner['FormOfAddress'] ?? null,                         // 16
            $partner['Industry'] ?? null,                              // 17
            $partner['InternationalLocationNumber1'] ?? null,          // 18
            $partner['InternationalLocationNumber2'] ?? null,          // 19
            $this->sanitizeBooleanInt($partner['IsFemale']),            //20
            $this->sanitizeBooleanInt($partner['IsMale']),              // 21
            $partner['IsNaturalPerson'] ?? null,                       // 22
            $this->sanitizeBooleanInt($partner['IsSexUnknown']),     // 23
            $partner['GenderCodeName'] ?? null,                        // 24
            $partner['Language'] ?? null,                              // 25
            $this->formatedDate($partner['LastChangeDate'], $partner['BusinessPartner']),            // 26
            $partner['LastChangeTime'] ?? null,                        // 27
            $partner['LastChangedByUser'] ?? null,                     // 28
            $partner['LastName'] ?? null,                              // 29
            $partner['LegalForm'] ?? null,                             // 30
            $partner['OrganizationBPName1'] ?? null,                   // 31
            $partner['OrganizationBPName2'] ?? null,                   // 32
            $partner['OrganizationBPName3'] ?? null,                   // 33
            $partner['OrganizationBPName4'] ?? null,                   // 34
            $this->formatedDate($partner['OrganizationFoundationDate']), // 35
            $this->formatedDate($partner['OrganizationLiquidationDate']), // 36
            $partner['SearchTerm1'] ?? null,                           // 37
            $partner['SearchTerm2'] ?? null,                           // 38
            $partner['AdditionalLastName'] ?? null,
            $this->formatedDate($partner['BirthDate']),            // 40
            $this->sanitizeBooleanInt($partner['BusinessPartnerIsBlocked']), // 41
            $partner['BusinessPartnerType'] ?? null,                   // 42
            $partner['ETag'] ?? null,                                  // 43
            $partner['GroupBusinessPartnerName1'] ?? null,             // 44
            $partner['GroupBusinessPartnerName2'] ?? null,             // 45
            $partner['IndependentAddressID'] ?? null,                   // 46
            $partner['InternationalLocationNumber3'] ?? null,           // 47
            $partner['MiddleName'] ?? null,                             // 48
            $partner['NameCountry'] ?? null,                            // 49
            $partner['NameFormat'] ?? null,                             // 50
            $partner['PersonFullName'] ?? null,                         // 51
            $partner['PersonNumber'] ?? null,                           // 52
            $this->sanitizeBooleanInt($partner['IsMarkedForArchiving']), // 53
            $partner['BusinessPartnerIDByExtSystem'] ?? null,           // 54
            $partner['BusinessPartnerPrintFormat'] ?? null,             // 55
            $partner['BusinessPartnerOccupation'] ?? null,              // 56
            $partner['BusPartMaritalStatus'] ?? null,                    // 57
            $partner['BusPartNationality'] ?? null,                      // 58
            $partner['BusinessPartnerBirthName'] ?? null,                // 59
            $partner['BusinessPartnerSupplementName'] ?? null,           // 60
            $partner['NaturalPersonEmployerName'] ?? null,               // 61
            $partner['LastNamePrefix'] ?? null,                         // 62
            $partner['LastNameSecondPrefix'] ?? null,                   // 63
            $partner['Initials'] ?? null,                               // 64
            $this->sanitizeBooleanInt($partner['BPDataControllerIsNotRequired']),           // 65
            $partner['TradingPartner'] ?? null,                         // 66
        ];

        $valueSets = "('" . implode("', '", $paramArray) . "', NOW())";
        return $valueSets;
    }

    public function importCustomerCompanyByBusinessPartner()
    {
        $valueSets = [];
        $table = "customer_companies";
        $columns = [
            'customer', // 1
            'company_code', // 2
            'account_by_customer', // 3
            'accounting_clerk', // 4
            'apar_tolerance_group', // 5
            'payment_terms', // 6

            "created_at", // always last: Creation Date
        ];

        $sql = ' SELECT customer FROM business_partners WHERE customer != "" AND last_change_date >= CURDATE() - INTERVAL 2 DAY ';
        $allCustomers = executequery($this->mysqli, $sql);
        $allCustomersIds = pluck($allCustomers[0], 'customer');
        dl($allCustomersIds);

        // $allCustomers = executequery($this->mysqli, 'select customer from business_partners where customer != ""');
        // $allCustomersIds = pluck($allCustomers[0], 'customer');

        $select = '$select=Customer,CompanyCode,AccountByCustomer,AccountingClerk,CustomerAccountGroup,PaymentTerms';

        $customerCompanyArr = [];
        foreach ($allCustomersIds as $key => $customerId) {

            // if ($key > 5) {
            //     break;
            // }

            $url = $this->baseUrl . "/API_BUSINESS_PARTNER/A_Customer('$customerId')/to_CustomerCompany?" . $select;

            $itemResponse = $this->callApi("GET", $url, null, $this->sessionId);

            $customerCompanyArr[] = $itemResponse;

            if (isset($itemResponse) && is_array($itemResponse->d->results)) {
                foreach ($itemResponse->d->results as $key => $item) {
                    $valueSets[] = $this->preparedCustomerCompanyPayload($item);
                }
            } else {
                $this->logMessage("Unexpected response format or no data received.");
            }
        }

        if (count($valueSets) > 0) {

            $this->truncateTable($table);

            $query = $this->insertQuery($table, $columns, $valueSets);

            executequery($this->mysqli, $query);
        }
    }

    private function preparedCustomerCompanyPayload($item)
    {
        $partner = (array)$item;
        $paramArray = [
            $partner['Customer'] ?? null,                      // 1
            $partner['CompanyCode'] ?? null,                   // 2
            $partner['AccountByCustomer'] ?? null,             // 3
            $partner['AccountingClerk'] ?? null,                // 4
            $partner['CustomerAccountGroup'] ?? null,           // 5
            $partner['PaymentTerms'] ?? null,                   // 6
        ];

        // $valueSets = "('" . implode("', '", $paramArray) . "')";
        // return $valueSets;

        $valueSets = "('" . implode("', '", $paramArray) . "', NOW())";
        return $valueSets;
    }

    public function importCustomerSalesAreaByBusinessPartner()
    {
        $valueSets = [];
        $table = "customer_sales_areas";
        $columns = [];

        $allCustomers = executequery($this->mysqli, 'select customer from business_partners where customer != ""');
        $allCustomersIds = pluck($allCustomers[0], 'customer');

        // $select = '$select=Customer,CompanyCode,AccountByCustomer,AccountingClerk,CustomerAccountGroup,PaymentTerms';
        $select = '';

        $customerCustomerSalesArr = [];
        foreach ($allCustomersIds as $key => $customerId) {

            // if ($key > 1) {
            //     break;
            // }

            $url = $this->baseUrl . "/API_BUSINESS_PARTNER/A_Customer('$customerId')/to_CustomerSalesArea?" . $select;

            $itemResponse = $this->callApi("GET", $url, null, $this->sessionId);

            $customerCustomerSalesArr[] = $itemResponse;

            if (isset($itemResponse) && is_array($itemResponse->d->results)) {
                foreach ($itemResponse->d->results as $key => $item) {
                    $itemResult = $this->preparedCustomerSalesAreaPayload($item);
                    $valueSets[] = $itemResult['values'];
                    $columns = $itemResult['columns'];
                }
            } else {
                $this->logMessage("Unexpected response format or no data received.");
            }
        }
        if (count($valueSets) > 0) {

            $this->truncateTable($table);

            $query = $this->insertQuery($table, $columns, $valueSets);

            executequery($this->mysqli, $query);
        }
    }

    private function preparedCustomerSalesAreaPayload($item)
    {
        $customer = (array)$item;
        $paramArray = [
            'customer' => $customer['Customer'],
            'sales_organization' => $customer['SalesOrganization'],
            'distribution_channel' => $customer['DistributionChannel'],
            'division' => $customer['Division'],
            'account_by_customer' => $customer['AccountByCustomer'],
            'authorization_group' => $customer['AuthorizationGroup'],
            'billing_is_blocked_for_customer' => $customer['BillingIsBlockedForCustomer'],
            'complete_delivery_is_defined' => $this->sanitizeBooleanInt($customer['CompleteDeliveryIsDefined']),
            'credit_control_area' => $customer['CreditControlArea'],
            'currency' => $customer['Currency'],
            'cust_is_rlvt_for_settlmt_mgmt' => $this->sanitizeBooleanInt($customer['CustIsRlvtForSettlmtMgmt']),
            'customer_abc_classification' => $customer['CustomerABCClassification'],
            'customer_account_assignment_group' => $customer['CustomerAccountAssignmentGroup'],
            'customer_group' => $customer['CustomerGroup'],
            'customer_is_rebate_relevant' => $this->sanitizeBooleanInt($customer['CustomerIsRebateRelevant']),
            'customer_payment_terms' => $customer['CustomerPaymentTerms'],
            'customer_price_group' => $customer['CustomerPriceGroup'],
            'customer_pricing_procedure' => $customer['CustomerPricingProcedure'],
            'cust_prod_proposal_procedure' => $customer['CustProdProposalProcedure'],
            'delivery_is_blocked_for_customer' => $customer['DeliveryIsBlockedForCustomer'],
            'delivery_priority' => $customer['DeliveryPriority'],
            'incoterms_classification' => $customer['IncotermsClassification'],
            'incoterms_location2' => $customer['IncotermsLocation2'],
            'incoterms_version' => $customer['IncotermsVersion'],
            'incoterms_location1' => $customer['IncotermsLocation1'],
            'incoterms_sup_chn_loc1_addl_uuid' => $customer['IncotermsSupChnLoc1AddlUUID'],
            'incoterms_sup_chn_loc2_addl_uuid' => $customer['IncotermsSupChnLoc2AddlUUID'],
            'incoterms_sup_chn_dvtg_loc_addl_uuid' => $customer['IncotermsSupChnDvtgLocAddlUUID'],
            'deletion_indicator' => $this->sanitizeBooleanInt($customer['DeletionIndicator']),
            'incoterms_transfer_location' => $customer['IncotermsTransferLocation'],
            'insp_sbst_has_no_time_or_quantity' => $this->sanitizeBooleanInt($customer['InspSbstHasNoTimeOrQuantity']),
            'invoice_date' => $customer['InvoiceDate'],
            'item_order_probability_in_percent' => $customer['ItemOrderProbabilityInPercent'],
            'manual_invoice_maint_is_relevant' => $this->sanitizeBooleanInt($customer['ManualInvoiceMaintIsRelevant']),
            'max_nmbr_of_partial_delivery' => $customer['MaxNmbrOfPartialDelivery'],
            'order_combination_is_allowed' => $this->sanitizeBooleanInt($customer['OrderCombinationIsAllowed']),
            'order_is_blocked_for_customer' => $customer['OrderIsBlockedForCustomer'],
            'overdeliv_tolrtd_lmt_ratio_in_pct' => $customer['OverdelivTolrtdLmtRatioInPct'],
            'partial_delivery_is_allowed' => $customer['PartialDeliveryIsAllowed'],
            'price_list_type' => $customer['PriceListType'],
            'product_unit_group' => $customer['ProductUnitGroup'],
            'proof_of_delivery_time_value' => $customer['ProofOfDeliveryTimeValue'],
            'sales_group' => $customer['SalesGroup'],
            'sales_item_proposal' => $customer['SalesItemProposal'],
            'sales_office' => $customer['SalesOffice'],
            'shipping_condition' => $customer['ShippingCondition'],
            'sls_doc_is_rlvt_for_proof_of_deliv' => $this->sanitizeBooleanInt($customer['SlsDocIsRlvtForProofOfDeliv']),
            'sls_unlmtd_ovrdeliv_is_allwd' => $this->sanitizeBooleanInt($customer['SlsUnlmtdOvrdelivIsAllwd']),
            'supplying_plant' => $customer['SupplyingPlant'],
            'sales_district' => $customer['SalesDistrict'],
            'underdeliv_tolrtd_lmt_ratio_in_pct' => $customer['UnderdelivTolrtdLmtRatioInPct'],
            'invoice_list_schedule' => $customer['InvoiceListSchedule'],
            'exchange_rate_type' => $customer['ExchangeRateType'],
            'additional_customer_group1' => $customer['AdditionalCustomerGroup1'],
            'additional_customer_group2' => $customer['AdditionalCustomerGroup2'],
            'additional_customer_group3' => $customer['AdditionalCustomerGroup3'],
            'additional_customer_group4' => $customer['AdditionalCustomerGroup4'],
            'additional_customer_group5' => $customer['AdditionalCustomerGroup5'],
            'payment_guarantee_procedure' => $customer['PaymentGuaranteeProcedure'],
            'customer_account_group' => $customer['CustomerAccountGroup'],

            // Optional: encode nested objects as JSON
            // 'to_partner_function' => json_encode($customer['to_PartnerFunction'] ?? null),
            // 'to_sales_area_tax' => json_encode($customer['to_SalesAreaTax'] ?? null),
            // 'to_sales_area_text' => json_encode($customer['to_SalesAreaText'] ?? null),
            // 'to_sls_area_addr_depdnt_info' => json_encode($customer['to_SlsAreaAddrDepdntInfo'] ?? null),
        ];

        // return $paramArray;

        $valueSets = "('" . implode("', '", $paramArray) . "')";

        // $valueSets = "('" . implode("', '", $paramArray) . "', NOW())";

        return [
            'columns' => array_keys($paramArray),
            'values' => $valueSets,
        ];
    }

    private function executeQueryBySP($query, $comment = '', $isLog = false)
    {
        $paramArray = [
            str_replace("'", "\'", $query),
            $comment,
        ];

        $params = $this->formatParams($paramArray);
        $call_sp = "CALL int_sp_execute_query($params)";

        if ($isLog) {
            $this->logMessage($call_sp);
        }

        executequery($this->mysqli, $call_sp);
    }

    private function insertQuery($table, $columns, $valueSets)
    {
        $columnString = implode(", ", $columns);
        return $query = "INSERT INTO $table ($columnString) VALUES " . implode(", ", $valueSets) . ";";
    }

    private function truncateTable($table)
    {
        $paramArray = [
            $table,
        ];

        $params = $this->formatParams($paramArray);
        $call_sp = "CALL sp_int_imp_delete_tempdata($params)";
        executequery($this->mysqli, $call_sp);
    }

    public function callApi($method, $url, $data = [], $token = "", $password = "")
    {
        // Log the token if necessary
        //	$this->addedLog($data);
        // 2769d1bc996c917fa63730599872a3

        $username = "SVT_000026";
        $password = "Saphana@1234";

        $curl = curl_init();
        $responseHeaders = [];

        // Set the common cURL options
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_SSL_VERIFYHOST => false, // Disable SSL host verification
            CURLOPT_SSL_VERIFYPEER => false, // Disable SSL peer verification

            CURLOPT_USERPWD => "$username:$password", // Basic Auth with empty password
            CURLOPT_HTTPAUTH => CURLAUTH_BASIC, // Explicitly set Basic Auth

            // --------------
            CURLOPT_HEADER => false, // Don't include response headers in body
            CURLOPT_VERBOSE => true, // Enable verbose output
            CURLOPT_HEADERFUNCTION => function ($curl, $header) use (&$responseHeaders) {
                $len = strlen($header);
                $header = explode(':', $header, 2);
                if (count($header) == 2) {
                    $responseHeaders[trim($header[0])] = trim($header[1]);
                }
                return $len;
            }
            // --------------

        ));

        // Set the HTTP method
        switch (strtoupper($method)) {
            case 'GET':
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'GET');
                if (!empty($data)) {
                    $url = sprintf("%s?%s", $url, http_build_query($data));
                    curl_setopt($curl, CURLOPT_URL, $url);
                }
                break;
            case 'POST':
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST');
                curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
                break;
            case 'PATCH':
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'PATCH');
                curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
                break;
            case 'DELETE':
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'DELETE');
                if (!empty($data)) {
                    curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
                }
                break;
            default:
                return "Invalid HTTP Method";
        }

        // Set the headers
        $headers = [
            'Content-Type: application/json',
            "Accept: application/json",
        ];

        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

        // Execute the cURL request
        $response = curl_exec($curl);
        $info = curl_getinfo($curl);

        // $this->logMessage(json_encode([
        //     'url' => $url,
        //     'headers' => $headers,
        //     'infocurl' => $info,
        //     'responseHeaders' => $responseHeaders,
        //     'response' => json_decode($response)
        // ], JSON_PRETTY_PRINT), 'api.log');

        // echo "<pre>" . json_encode([$postUrl, $postPayload, $token], JSON_PRETTY_PRINT) . "</pre>"; die;

        // Handle cURL errors
        if ($response === false) {
            $error = curl_error($curl);
            $error_no = curl_errno($curl);
            curl_close($curl);
            return "cURL Error: " . $error . " (Error Code: " . $error_no . ") Url is : " . $url . "  Method Is: " . $method;
        }

        curl_close($curl);

        // Decode the response
        $result = json_decode($response);
        return $result;
    }

    private function formatParams(array $paramArray): string
    {
        return "'" . implode("','", $paramArray) . "'";
    }

    private function formatedDate($date, $id = null)
    {
        if (empty($date)) {
            // if ($id != null) {
            $this->logMessage(json_encode(['id' => $id, 'date' => $date], JSON_PRETTY_PRINT), 'api.log');
            // }
            return  date('Y-m-d');
        }

        return  date('Y-m-d', intval(preg_replace('/[^\d]/', '', $date)) / 1000)  ?? NULL;
    }

    public function sanitizeBooleanInt($value, $default = 0)
    {
        if ($value === '' || $value === null) {
            return $default;
        }

        // Normalize string booleans to integers
        if (is_bool($value)) {
            return $value ? 1 : 0;
        }

        $lower = strtolower(trim((string)$value));

        if (in_array($lower, ['true', '1'], true)) {
            return 1;
        }

        if (in_array($lower, ['false', '0'], true)) {
            return 0;
        }

        // If numeric string or number, convert to int
        if (is_numeric($value)) {
            return (int)$value;
        }

        // If none matched, return default
        return $default;
    }

    private function logMessage($message, $logFile = 'log.log')
    {
        $logDir = 'logs';

        if (!is_dir($logDir)) {
            mkdir($logDir, 7777, true);
        }

        $date = date('Y-m-d H:i:s');
        $formattedMessage = "[$date] $message" . PHP_EOL;

        file_put_contents("$logDir/$logFile", $formattedMessage, FILE_APPEND);
    }
}
