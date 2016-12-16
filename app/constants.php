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
define('FAIL_TO_LIKE_POST', 1002);
define('FAIL_TO_TOGGLE_PUBLISH', 1003);
define('FAIL_TO_DELETE_POST', 1004);
