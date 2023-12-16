<?php

namespace rokan\olualaraformbuilder\Services;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;
use rokan\olualaraformbuilder\Interfaces\ApiConsumeInterface;

class ApiConsumeService implements ApiConsumeInterface
{

    public function callApi($endpoint, $moduleName, $columns ,$header, $script,$licenseKey)
    {
        $response = Http::withHeaders([
            'licenseKey' =>  $licenseKey,
            'Content-Type' => 'application/json'])
            ->get($endpoint, [
            'module_name' => $moduleName,
            'columns' => $columns,
            'header'=>$header,
            'script'=>$script
        ]);

        if ($response->successful()) {
            return json_decode($response->body());
        } else {
            return json_decode($response->body());
        }
    }

    public function writeContent($filePath, $content)
    {
        try {
            Storage::put($filePath, $content);
        } catch (\Exception $e) {
            Log::error("Failed to write content to $filePath: " . $e->getMessage());
            throw new \Exception("Failed to write content to $filePath");
        }
    }
}