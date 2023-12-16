<?php

namespace rokan\olualaraformbuilder\Interfaces;

interface ApiConsumeInterface
{

    public function callApi($endpoint, $moduleName, $columns,$header, $script,$licenseKey);

    public function writeContent($filePath, $content);
}