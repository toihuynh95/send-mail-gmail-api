/*ROUTER DEFINE*/
// Define route genalaads
var URL_SERVER = 'https://teamweb-backend.dev-altamedia.com/';
var BASE_URL = URL_SERVER + 'api/';

// User
var USER_URL = BASE_URL + 'user/';

var API_USER_SHOW = USER_URL + 'show';
var API_USER_SHOW_BY_ID = USER_URL + 'show/';
var API_USER_ME = USER_URL + 'me';
var API_USER_LOGIN = USER_URL + 'login';
var API_USER_LOGOUT = USER_URL + 'logout';
var API_USER_STORE = USER_URL + 'store';
var API_USER_DESTROY = USER_URL + 'destroy/';
var API_USER_LOCK = USER_URL + 'lock/';
var API_USER_UNLOCK = USER_URL + 'unlock/';
var API_USER_UPDATE = USER_URL + 'update/';
var API_USER_UPDATE_PROFILE = USER_URL + 'update-profile';
var API_USER_UPDATE_AVATAR = USER_URL + 'update-avatar';
var API_USER_RESET_PASSWORD = USER_URL + 'reset';
var API_USER_GENERATE_PASSWORD = USER_URL + 'generate-password';
var API_USER_FORGOT = USER_URL + 'forgot';
var API_USER_CHECK_TOKEN_RESET = USER_URL + 'check-token-reset/';
var API_USER_CREATE_NEW_PASSWORD = USER_URL + 'create-new-password/';

// Customer
var CUSTOMER_URL = BASE_URL + 'customer/';

var API_CUSTOMER_SHOW = CUSTOMER_URL + 'show';
var API_CUSTOMER_SHOW_ALL = CUSTOMER_URL + 'show-all';
var API_CUSTOMER_UPDATE_PERSONAL_INFO = CUSTOMER_URL + 'update-personal-info';
var API_CUSTOMER_SHOW_PERSONAL_INFO = CUSTOMER_URL + 'show-personal-info';

// Contact Group
var CONTACT_GROUP_URL = BASE_URL + 'contact-group/';

var API_CONTACT_GROUP_SHOW = CONTACT_GROUP_URL + 'show';
var API_CONTACT_GROUP_SHOW_BY_ID = CONTACT_GROUP_URL + 'show/';
var API_CONTACT_GROUP_SHOW_IS_ACTIVE = CONTACT_GROUP_URL + 'show-active/';
var API_CONTACT_GROUP_SHOW_ALL = CONTACT_GROUP_URL + 'show-all/';
var API_CONTACT_GROUP_STORE = CONTACT_GROUP_URL + 'store';
var API_CONTACT_GROUP_UPDATE = CONTACT_GROUP_URL + 'update/';
var API_CONTACT_GROUP_DESTROY = CONTACT_GROUP_URL + 'destroy/';

// Contact
var CONTACT_URL = BASE_URL + 'contact/';

var API_CONTACT_SHOW = CONTACT_URL + 'show';
var API_CONTACT_SHOW_EXCEPT_IN_GROUP = CONTACT_URL + 'show-except-in-group/';
var API_CONTACT_SHOW_BY_ID = CONTACT_URL + 'show/';
var API_CONTACT_STORE = CONTACT_URL + 'store';
var API_CONTACT_IMPORT = CONTACT_URL + 'import';
var API_CONTACT_EXPORT = CONTACT_URL + 'export';
var API_CONTACT_UPDATE = CONTACT_URL + 'update/';
var API_CONTACT_DESTROY = CONTACT_URL + 'destroy/';

// Contact Group Detail
var CONTACT_GROUP_DETAIL_URL = BASE_URL + 'contact-group-detail/';

var API_CONTACT_GROUP_DETAIL_SHOW_BY_GROUP = CONTACT_GROUP_DETAIL_URL + 'show-by-group/';
var API_CONTACT_GROUP_DETAIL_STORE = CONTACT_GROUP_DETAIL_URL + 'store';
var API_CONTACT_GROUP_DETAIL_DESTROY = CONTACT_GROUP_DETAIL_URL + 'destroy/';

// Project Type
var PROJECT_TYPE_URL = BASE_URL + 'project-type/';

var API_PROJECT_TYPE_SHOW = PROJECT_TYPE_URL + 'show';
var API_PROJECT_TYPE_SHOW_ALL = PROJECT_TYPE_URL + 'show-all';
var API_PROJECT_TYPE_SHOW_BY_ID = PROJECT_TYPE_URL + 'show/';
var API_PROJECT_TYPE_STORE = PROJECT_TYPE_URL + 'store';
var API_PROJECT_TYPE_UPDATE = PROJECT_TYPE_URL + 'update/';
var API_PROJECT_TYPE_DESTROY = PROJECT_TYPE_URL + 'destroy/';

// Mailing Service
var MAILING_SERVICE_URL = BASE_URL + 'mailing-service/';

var API_MAILING_SERVICE_SHOW = MAILING_SERVICE_URL + 'show';
var API_MAILING_SERVICE_SHOW_ALL = MAILING_SERVICE_URL + 'show-all';
var API_MAILING_SERVICE_SHOW_BY_ID = MAILING_SERVICE_URL + 'show/';
var API_MAILING_SERVICE_STORE = MAILING_SERVICE_URL + 'store';
var API_MAILING_SERVICE_UPDATE = MAILING_SERVICE_URL + 'update/';
var API_MAILING_SERVICE_DESTROY = MAILING_SERVICE_URL + 'destroy/';


// Template
var TEMPLATE_URL = BASE_URL + 'template/';

var API_TEMPLATE_SHOW = TEMPLATE_URL + 'show';
var API_TEMPLATE_SHOW_ALL = TEMPLATE_URL + 'show-all';
var API_TEMPLATE_SHOW_BY_ID = TEMPLATE_URL + 'show/';
var API_TEMPLATE_STORE = TEMPLATE_URL + 'store';
var API_TEMPLATE_UPDATE = TEMPLATE_URL + 'update/';
var API_TEMPLATE_DESTROY = TEMPLATE_URL + 'destroy/';


// Project
var PROJECT_URL = BASE_URL + 'project/';

var API_PROJECT_SHOW = PROJECT_URL + 'show';
var API_PROJECT_SHOW_BY_ID = PROJECT_URL + 'show/';
var API_PROJECT_CHECK_CONTACT_GROUP = PROJECT_URL + 'check-contact_group/';
var API_PROJECT_SHOW_BY_CUSTOMER_CURRENT = PROJECT_URL + 'show-by-customer-current/';
var API_PROJECT_SHOW_LIST = PROJECT_URL + 'show-list';
var API_PROJECT_STORE = PROJECT_URL + 'store';
var API_PROJECT_UPDATE = PROJECT_URL + 'update/';
var API_PROJECT_DESTROY = PROJECT_URL + 'destroy/';

// Campaign
var CAMPAIGN_URL = BASE_URL + 'campaign/';

var API_CAMPAIGN_SHOW = CAMPAIGN_URL + 'show';
var API_CAMPAIGN_SHOW_BY_ID = CAMPAIGN_URL + 'show/';
var API_CAMPAIGN_STORE = CAMPAIGN_URL + 'store';
var API_CAMPAIGN_UPDATE = CAMPAIGN_URL + 'update/';

// Campaign Log
var CAMPAIGN_LOG_URL = BASE_URL + 'campaign-log/';

var API_CAMPAIGN_LOG_SHOW = CAMPAIGN_LOG_URL + 'show/';
var API_CAMPAIGN_LOG_COUNT_SEND = CAMPAIGN_LOG_URL + 'count-send/';

// Statistic

var STATISTIC_URL = BASE_URL + 'statistic/';

var API_VIEW_BY_MONTH_TOTAL = STATISTIC_URL + 'view-by-month-total';
var API_VIEW_BY_MONTH_DETAIL = STATISTIC_URL + 'view-by-month-detail';
var API_REPORT = STATISTIC_URL + 'report';

// Support

var CHECK_AMOUNT_PROJECT_BY_CONTACT_GROUP = BASE_URL + '';
