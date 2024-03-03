<?php

// All status


const PAYMENT_STATUS_PENDING = 0;
const PAYMENT_STATUS_PAID = 1;
const PAYMENT_STATUS_CANCELLED = 2;
const PAYMENT_STATUS_BANK = 'bank';

const STATUS_PENDING = 0;
const STATUS_ACTIVE = 1;
const STATUS_CANCELED = 2;
const STATUS_REJECT = 3;
const STATUS_DEACTIVATE = 4;
const STATUS_SUSPENDED = 5;

const STATUS_DISABLE = 6;

// User Role Type
const USER_STATUS_INACTIVE = 0;
const USER_STATUS_ACTIVE = 1;
const USER_STATUS_UNVERIFIED = 2;
const USER_STATUS_PENDING = 3;

const USER_ROLE_ADMIN = 1;
const USER_ROLE_USER = 2;
const USER_ROLE_CUSTOMER = 3;
const USER_ROLE_AFFILIATE = 4;

const TRANSACTION_WITHDRAWAL = 1;
const TRANSACTION_WITHDRAWAL_DISBURSED = 2;

// Message constant
// Message
const SOMETHING_WENT_WRONG = "Something went wrong! Please try again";
const CREATED_SUCCESSFULLY = "Created Successfully";
const FAVORITES_SUCCESSFULLY = "Image add to favorite list";
const FAVORITES_REMOVE_SUCCESSFULLY = "Image removed from favorite list";
const UPDATED_SUCCESSFULLY = "Updated Successfully";
const SUBMIT_SUCCESSFULLY = "Submit Successfully";
const STATUS_UPDATED_SUCCESSFULLY = "Status Updated Successfully";
const DELETED_SUCCESSFULLY = "Deleted Successfully";
const UPLOADED_SUCCESSFULLY = "Uploaded Successfully";
const DATA_FETCH_SUCCESSFULLY = "Data Fetch Successfully";
const SENT_SUCCESSFULLY = "Sent Successfully";
const PAY_SUCCESSFULLY = "Pay Successfully";
const ASSIGNED_SUCCESSFULLY = "Assigned Successfully";

const SEARCH_FOUND = "Search Found";
const SEARCH_NOT_FOUND = "No Search Found";
const DO_NOT_HAVE_PERMISSION = 7;

// Currency placement
const CURRENCY_SYMBOL_BEFORE = 1;
const CURRENCY_SYMBOL_AFTER = 2;

// storage driver
const STORAGE_DRIVER_PUBLIC = 'public';
const STORAGE_DRIVER_AWS = 'aws';
const STORAGE_DRIVER_WASABI = 'wasabi';
const STORAGE_DRIVER_VULTR = 'vultr';
const STORAGE_DRIVER_DO = 'do';

const ACTIVE = 1;
const INITIATE = 2;
const DEACTIVATE = 0;

//Billing Cycle
const BILLING_CYCLE_ONETIME = 1;
const BILLING_CYCLE_AUTO_RENEW = 2;
const BILLING_CYCLE_EXPIRE_AFTER = 3;

const DURATION_MONTH = 1;
const DURATION_YEAR = 2;

const BILLING_CYCLE_LIST = 1;
const BILLING_CYCLE_AUTO_GENERATED = 2;

const DISCOUNT_TYPE_FLAT = 1;
const DISCOUNT_TYPE_PERCENT = 2;

const TAX_TYPE_FLAT = 1;
const TAX_TYPE_PERCENT = 2;

const COMMISSION_TYPE_FLAT = 1;
const COMMISSION_TYPE_PERCENT = 2;

const REDEMPTION_TYPE_ONETIME = 1;
const REDEMPTION_TYPE_FOREVER = 2;
const REDEMPTION_TYPE_LIMITED_NUMBER = 3;

const GATEWAY_MODE_LIVE = 1;
const GATEWAY_MODE_SANDBOX = 2;

//Gateway name
const PAYPAL = 'paypal';
const STRIPE = 'stripe';
const RAZORPAY = 'razorpay';
const INSTAMOJO = 'instamojo';
const MOLLIE = 'mollie';
const PAYSTACK = 'paystack';
const SSLCOMMERZ = 'sslcommerz';
const MERCADOPAGO = 'mercadopago';
const FLUTTERWAVE = 'flutterwave';
const BANK = 'bank';
const WALLET = 'wallet';
const COINBASE = 'coinbase';

//Frontend settings Section id
const HERO_SECTION_ID = 1;
const TRADING_PLATFORM_SECTION_ID = 2;
const CRYPTOCURRENCY_SECTION_ID = 3;
const PAYMENT_SECTION_ID = 4;
const TRUSTED_PLATFORM_SECTION_ID = 5;
const NEWS_AND_ARTICLES_SECTION_ID = 6;
const GET_IN_TOUCH_SECTION_ID = 7;

const DURATION_TYPE_DAY = 1;
const DURATION_TYPE_MONTH = 2;
const DURATION_TYPE_YEAR = 3;
const DEPOSIT_TYPE_BUY = 1;
const DEPOSIT_TYPE_DEPOSIT = 2;

const ORDER_TYPE_DEPOSIT = 1;
const ORDER_TYPE_HARDWARE = 2;
const ORDER_TYPE_PLAN = 3;

const RETURN_TYPE_FIXED = 1;
const RETURN_TYPE_RANDOM = 2;

const DELIVERY_STATUS_PENDING = 1;
const DELIVERY_STATUS_DELIVERED = 2;

const PAGE_ABOUT_US = 1;
const PAGE_PRIVACY_POLICY = 2;
const PAGE_TERMS_OF_SERVICE = 3;
const PAGE_COOKIE_POLICY = 4;
const PAGE_REFUND_POLICY = 5;

const EVENT_TYPE_FREE = 1;
const EVENT_TYPE_PAID = 2;

//employee status
const FULL_TIME = 1;
const PART_TIME = 2;
const CONTRACTUAL = 3;
const REMOTE_WORKER = 4;

//job post status
const JOB_STATUS_PENDING = 0;
const JOB_STATUS_APPROVED = 1;
const JOB_STATUS_CANCELED = 2;




// email templates
const EMAIL_TEMPLATE_PAYMENT_SUCCESS = 1;
const EMAIL_TEMPLATE_PAYMENT_FAILURE = 2;
const EMAIL_TEMPLATE_INVOICE = 3;
const EMAIL_TEMPLATE_SUBSCRIPTION_CANCELLATION = 4;
const EMAIL_TEMPLATE_FORGOT_PASSWORD = 5;
const EMAIL_TEMPLATE_PAYMENT_CANCEL = 6;
const EMAIL_TEMPLATE_EMAIL_VERIFY = 7;

//webhook
const WEBHOOK_EVENT_TYPE_PAYMENT = 1;

const WEBHOOK_EVENT_STATUS_PENDING = 0;
const WEBHOOK_EVENT_STATUS_SUCCESS = 1;
const WEBHOOK_EVENT_STATUS_FAILED = 2;

//webhook

const STATUS_SUCCESS = 1;

// history status
const SMS_STATUS_DELIVERED = 1;
const SMS_STATUS_PENDING = 2;
const SMS_STATUS_FAILED = 3;

// checkout page status
const CHECKOUT_PAGE_SETTING_STATUS_ACTIVE = 1;
const CHECKOUT_PAGE_SETTING_STATUS_PENDING = 2;

const FORM_STEP_ONE = 1;
const FORM_STEP_TWO = 2;
const FORM_STEP_THREE = 3;
const FORM_STEP_FOUR = 4;
const FORM_STEP_FIVE = 5;
const FORM_STEP_SIX = 6;

// shipping
const SHIPPING_METHOD_FREE = 1;
const SHIPPING_METHOD_PAID = 2;

// invoice setting
const INVOICE_SETTING_TYPE_ORDER = 1;

// table column
const TABLE_COLUMN_PRODUCT = 1;
const TABLE_COLUMN_PLAN = 2;
const TABLE_COLUMN_PLAN_CODE = 3;
const TABLE_COLUMN_PRICE = 4;
const TABLE_COLUMN_QUANTITY = 5;
const TABLE_COLUMN_TOTAL = 6;
const TABLE_SETUP_FEE = 7;

// package rules
const RULES_CUSTOMER = 1;
const RULES_PRODUCT = 2;
const RULES_SUBSCRIPTION = 3;

const PAYMENT_TYPE_FIRST = 1;
const PAYMENT_TYPE_RECURRING = 2;

//beneficiary type

const BENEFICIARY_BANK=1;
const BENEFICIARY_CARD=2;
const BENEFICIARY_PAYPAL=3;
