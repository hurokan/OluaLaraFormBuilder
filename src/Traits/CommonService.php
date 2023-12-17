<?php

namespace rokan\olualaraformbuilder\Traits;
use Illuminate\Http;
use Illuminate\Support\Str;

trait CommonService
{
    public static function getEndPoints():array {
        $serverAdd = "http://rokan.bio/api/v1";
        return  [
            [
                'endpoint' => $serverAdd.'/module/migration/content',
                'destination' => database_path('migrations'),
                'file_key' => 'file',
                'content_key' => 'content',
                'endpoint_key' => 'migration',

            ],
            [
                'endpoint' => $serverAdd.'/module/model/content',
                'destination' => app_path('Models'),
                'file_key' => 'file',
                'content_key' => 'content',
                'endpoint_key' => 'model',
            ],
            [
                'endpoint' => $serverAdd.'/module/create/form-request',
                'destination' => app_path('Http/Requests'),
                'file_key' => 'file',
                'content_key' => 'content',
                'endpoint_key' => 'validation',
            ],
            [
                'endpoint' => $serverAdd.'/module/controller/content',
                'destination' => app_path('Http/Controllers'),
                'file_key' => 'file',
                'content_key' => 'content',
                'endpoint_key' => 'controller',
            ],
            [
                'endpoint' => $serverAdd.'/module/create/forms',
                'destination' => resource_path('views').'/',
                'file_key' => 'file',
                'content_key' => 'content',
                'endpoint_key' => 'html',
            ],
            [
                'endpoint' => $serverAdd.'/module/route/content',
                'destination' => base_path('routes/web.php'),
                'file_key' => 'file',
                'content_key' => 'content',
                'endpoint_key' => 'route',
            ],
            [
                'endpoint' => $serverAdd.'/module/nav/content',
                'destination' => config('olua.fileLocation.navigationRoute'),
                'file_key' => 'file',
                'content_key' => 'content',
                'endpoint_key' => 'nav',
            ]
        ];
    }

    public static function checkDirectory($directory, $endPoint_key,$file): string
    {
        if (!in_array($endPoint_key,['nav','route'])){
            if (!is_dir($directory)) {
                mkdir($directory, 0755, true);
            }
            return  $directory.'/'.$file;
        }else{
            return  $file;
        }

    }
    public static function updateExistingFileContent($filePath,$endPoint,$content,$action):string{
        $existingContent = file_get_contents($filePath);
        if ($endPoint === 'route'){
            $routingFileContents = $content->{$action['content_key']};
            $existingContent = str_replace('<?php', '', $existingContent);
            $updateContent = "<?php" . $content->import . $existingContent . $routingFileContents;
        }else{
            $updateContent = $existingContent.$content->{$action['content_key']};
        }
        return $updateContent;
    }
}
