<?php
$I = new ApiTester($scenario);
$I->wantTo('create a API Test');
$I->sendPOST('/photo');
$I->seeResponseCodeIs("200");
$I->seeResponseIsJson();
$I->seeResponseContains('{"result":"true"}');