<?php
// Constants file

// Restful api response http code.
define('REST_GET_SUCCESS', 200);
define('REST_CREATE_SUCCESS', 201);
define('REST_UPDATE_SUCCESS', 200);
define('REST_DELETE_SUCCESS', 204);
define('REST_NOT_MODIFIED', 304);
define('REST_BAD_REQUEST', 400);
define('REST_INVALID_FIELDS', 422);
define('REST_RESOURCE_NOT_FOUND', 404);
define('REST_REQUEST_LIMIT', 429);

// Post
define('POST_NOT_FOUND', 1001);
define('FAIL_TO_CREATE_POST', 1002);
define('FAIL_TO_UPDATE_POST', 1003);
define('FAIL_TO_DELETE_POST', 1004);
define('FAIL_TO_LIKE_POST', 1005);
define('FAIL_TO_TOGGLE_PUBLISH', 1006);

// Comment
define('FAIL_TO_TOGGLE_VALID', 2001);
define('FAIL_TO_TOGGLE_SEEN', 2002);
define('FAIL_TO_DELETE_COMMENT', 2003);

// Setting
define('FAIL_TO_ADD_LINK', 3001);
define('FAIL_TO_UPDATE_LINK', 3002);
define('FAIL_TO_UPDATE_AUTH', 3003);

// Page
define('PAGE_NOT_FOUND', 4001);
