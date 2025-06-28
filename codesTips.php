=================
$selectFields = [
'CardCode', 'CardName', 'CardForeignName', 'CardType', 'GroupCode', 'MailAddress', 'Phone1',
'Phone2', 'Cellular', 'CreditLimit', 'SalesPersonCode', 'PayTermsGrpCode', 'U_Division',
'U_AreaName', 'U_Area', 'U_ArCode', 'U_SupViAr', 'U_ManagId', 'U_ManagNam', 'U_SprViId',
'U_SprViNam', 'ContactPerson', 'BPAddresses', 'ContactEmployees', 'CreditLimit', 'City',
'County', 'Valid', 'U_ARType', 'U_NoOfBills', 'U_InvPayTerm', 'U_SubGroup', 'U_AllowARColl',
'U_PayDays', 'BilltoDefault',
];

// Convert fields to a comma-separated string for the URL
$select = implode(',', $selectFields);

// Set up the filter condition
$filter = "CardType eq 'C'";

// Build the query URL using http_build_query to ensure proper encoding
$queryParams = http_build_query([
'$select' => $select,
'$filter' => $filter,
]);

// Define the base URL and combine it with the query parameters
$baseUrl = 'https://192.168.1.150:50000/b1s/v1/BusinessPartners';
$getUrl = "{$baseUrl}?{$queryParams}";
=================



===========================
$select =
'CardCode,CardName,CardForeignName,CardType,GroupCode,MailAddress,Phone1,Phone2,Cellular,CreditLimit,SalesPersonCode,PayTermsGrpCode,U_Division,U_AreaName,U_Area,U_ArCode,U_SupViAr,U_ManagId,U_ManagNam,U_SprViId,U_SprViNam,ContactPerson,BPAddresses,ContactEmployees,CreditLimit,City,County,Valid,U_ARType,U_NoOfBills,U_InvPayTerm,U_SubGroup,U_AllowARColl,U_PayDays,BilltoDefault';

$filter = '$filter';

$getUrl = 'https://192.168.1.150:50000/b1s/v1/BusinessPartners?$select=' . $select . "& $filter = CardType eq 'C'";
===========================

// =====================
$selectFields = [
'CardCode', 'CardName', 'CardForeignName', 'CardType', 'GroupCode', 'MailAddress', 'Phone1',
'Phone2', 'Cellular', 'CreditLimit', 'SalesPersonCode', 'PayTermsGrpCode', 'U_Division',
'U_AreaName', 'U_Area', 'U_ArCode', 'U_SupViAr', 'U_ManagId', 'U_ManagNam', 'U_SprViId',
'U_SprViNam', 'ContactPerson', 'BPAddresses', 'ContactEmployees', 'CreditLimit', 'City',
'County', 'Valid', 'U_ARType', 'U_NoOfBills', 'U_InvPayTerm', 'U_SubGroup', 'U_AllowARColl',
'U_PayDays', 'BilltoDefault',
];

// Convert fields to a comma-separated string
return $select = implode(',', $selectFields);

// Set up the filter condition
$filter = "CardType eq 'C'";

// Manually build the query URL with `$select` as a string
$baseUrl = 'https://192.168.1.150:50000/b1s/v1/BusinessPartners';
$getUrl = "{$baseUrl}?\$select={$select}&\$filter={$filter}";

// =====================