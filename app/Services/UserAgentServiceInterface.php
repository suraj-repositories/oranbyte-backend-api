<?php

namespace App\Services;

interface UserAgentServiceInterface
{
    function detectDevice($userAgent);

    function detectBrowser($userAgent);

    function detectOS($userAgent);

    function getLocationFromIP($ip);

}
