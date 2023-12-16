<?php

namespace rokan\olualaraformbuilder;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use rokan\olualaraformbuilder\Interfaces\ApiConsumeInterface;
use rokan\olualaraformbuilder\Traits\CommonService;

class SingleFormBuilderController extends Controller
{
    use CommonService;
    public function buildSingleForm()
    {
        $dataTypes = $this->getAllDataType();
        $htmlInputElements = $this->getAllHTMLInputElement();
        $validationRules = $this->getValidationRules('','');
        return view('olualaraformbuilder::single-form',compact('dataTypes','htmlInputElements','validationRules'));
    }
    public static function getAllDataType($key = null,$exclude = null){
        $dataTypes = [
            'numeric types' => [
                'tinyInteger' => 4,
                'smallInteger' => 6,
                'mediumInteger' => 9,
                'integer' => 11,
                'bigInteger' => 20,
                'float' => [8, 2],
                'double' => [8, 2],
                'decimal' => [8, 2],
            ],
            'date and time types' => [
                'date' => null,
                'time' => null,
                'dateTime' => null,
                'timestamp' => null,
                'year' => 4,
            ],
            'string types' => [
                'char' => 255,
                'string' => 255,
                'binary' => 255,
                'varbinary' => null,
                'tinyblob' => null,
                'blob' => null,
                'mediumblob' => null,
                'longblob' => null,
                'tinytext' => null,
                'text' => null,
                'mediumtext' => null,
                'longtext' => null,
                'enum' => null,
                'set' => null,
            ],
            'other types' => [
                'boolean' => null,
                'json' => null,
                'geometry' => null,
                'point' => null,
                'linestring' => null,
                'polygon' => null,
                'geometrycollection' => null,
                'bit' => 1,
                'serial' => null,
            ],
        ];
        if ($key){
            $value = null;
            foreach ($dataTypes as $category => $types) {
                if (isset($types[$key])) {
                    $value = $types[$key];
                    break;
                }
            }
            return $value;
        }
        if ($exclude){
            return array_diff_key($dataTypes, array_flip($exclude));

        }

        return $dataTypes;

    }

    public static function getAllHTMLInputElement(){
        return $htmlInputComponents = [
            'Text' => 'text',
            'Password' => 'password',
            'Email' => 'email',
            'Number' => 'number',
            'Date' => 'date',
            'Time' => 'time',
            'File' => 'file',
            'Multiple File' => 'multiple_file',
            'Single Checkbox' => 'checkbox',
            'Inline Checkbox' => 'inline_checkbox',
            'Multiple Checkbox' => 'multiple_checkbox',
            'Single Radio' => 'radio',
            'Inline Radio' => 'inline_radio',
            'Multiple Radio' => 'multiple_radio',
            'Textarea' => 'textarea',
            'Select' => 'select',
            'Hidden' => 'hidden',
            'Select2' => 'select2',
            'Switches' => 'switches',
        ];

    }

    public static function getValidationRules($rule = null,$search_key = null){

        $rules = [
            'required' => ['value' => 'required', 'desc' => 'The field is required.'],
            'required_if' => ['value' => 'required_if:{another_field}:{value}', 'desc' => 'The field is required if another field is equal to a certain value.'],
            'required_unless' => ['value' => 'required_unless:{another_field}:{value}', 'desc' => 'The field is required unless another field is equal to a certain value.'],
            'required_with' => ['value' => 'required_with:{another_field}', 'desc' => 'The field is required if another field is present.'],
            'required_without' => ['value' => 'required_without:{another_field}', 'desc' => 'The field is required if another field is not present.'],
            'same' => ['value' => 'same:{another_field}', 'desc' => 'The field must be the same as another field.'],
            'different' => ['value' => 'different:{another_field}', 'desc' => 'The field must be different from another field.'],
            'accepted_if' => ['value' => 'accepted_if:{another_field}:{value}', 'desc' => 'The field must be accepted if another field is equal to a certain value.'],
            'declined_if' => ['value' => 'declined_if:{another_field}:{value}', 'desc' => 'The field must be declined if another field is equal to a certain value.'],
            'missing_if' => ['value' => 'missing_if:{another_field}:{value}', 'desc' => 'The field must be missing if another field is equal to a certain value.'],
            'missing_unless' => ['value' => 'missing_unless:{another_field}:{value}', 'desc' => 'The field must be missing unless another field is equal to a certain value.'],
            'prohibited_if' => ['value' => 'prohibited_if:{another_field}:{value}', 'desc' => 'The field must be prohibited if another field is equal to a certain value.'],
            'prohibited_unless' => ['value' => 'prohibited_unless:{another_field}:{value}', 'desc' => 'The field must be prohibited unless another field is equal to a certain value.'],
            'prohibits' => ['value' => 'prohibits:{another_field}', 'desc' => 'The field must prohibit another field.'],
            'required_if_accepted' => ['value' => 'required_if_accepted:{another_field}', 'desc' => 'The field is required if another field is accepted.'],
            'required_with_all' => ['value' => 'required_with_all:{another_field}', 'desc' => 'The field is required if all of the specified fields are present.'],
            'required_without_all' => ['value' => 'required_without_all:{another_field}', 'desc' => 'The field is required if any of the specified fields are not present.'],

            'string' => ['value' => 'string', 'desc' => 'The field must be a string.'],
            'doesnt_start_with' => ['value' => 'doesnt_start_with:{string}', 'desc' => 'The field must not start with a specified string.'],
            'doesnt_end_with' => ['value' => 'doesnt_end_with:{string}', 'desc' => 'The field must not end with a specified string.'],
            'ends_with' => ['value' => 'ends_with:{string}', 'desc' => 'The field must end with a specified string.'],
            'starts_with' => ['value' => 'starts_with:{string}', 'desc' => 'The field must start with the specified string.'],

            'alpha' => ['value' => 'alpha', 'desc' => 'The field must contain only alphabetic characters.'],
            'alpha_num' => ['value' => 'alpha_num', 'desc' => 'The field must contain only alphabetic and numeric characters.'],
            'alpha_dash' => ['value' => 'alpha_dash', 'desc' => 'The field must contain only alphabetic, numeric, and underscore characters.'],
            'email' => ['value' => 'email', 'desc' => 'The field must contain a valid email address.'],
            'url' => ['value' => 'url', 'desc' => 'The field must contain a valid URL.'],
            'ip' => ['value' => 'ip', 'desc' => 'The field must contain a valid IP address.'],
            'max' => ['value' => 'max:{max}', 'desc' => 'The field must be no more than a certain number of characters.'],
            'min' => ['value' => 'min:{min}', 'desc' => 'The field must be at least a certain number of characters.'],
            'regex' => ['value' => 'regex:{regex}', 'desc' => 'The field must match a certain regular expression.'],
            'confirmed' => ['value' => 'confirmed', 'desc' => 'The field must match the confirmation field.'],
            'unique' => ['value' => 'unique:{table},{column}', 'desc' => 'The field must be unique in the database.'],
            'exists' => ['value' => 'exists:{table},{column}', 'desc' => 'The field must exist in the database.'],

            'size' => ['value' => 'size:{size}', 'desc' => 'The field must be a certain size.'],
            'in' => ['value' => 'in:{values}', 'desc' => 'The field must be one of the specified values.'],
            'not_regex' => ['value' => 'not_regex:{regex}', 'desc' => 'The field must not match a certain regular expression.'],

            'date_equals' => ['value' => 'date_equals:{date}', 'desc' => 'The field must be equal to a certain date.'],
            'date_not_equals' => ['value' => 'date_not_equals:{date}', 'desc' => 'The field must not be equal to a certain date.'],
            'date_after' => ['value' => 'date_after:{date}', 'desc' => 'The field must be after a certain date.'],
            'date_before' => ['value' => 'date_before:{date}', 'desc' => 'The field must be before a certain date.'],
            'date_between' => ['value' => 'date_between:{start},{end}', 'desc' => 'The field must be between two dates.'],

            'file' => ['value' => 'file', 'desc' => 'The field must be a file.'],
            'image' => ['value' => 'image', 'desc' => 'The field must be an image file.'],
            'mimes' => ['value' => 'mimes:{mimes}', 'desc' => 'The field must be a file of a certain MIME type.'],
            'max_size' => ['value' => 'max_size:{size}', 'desc' => 'The file must be no more than a certain size.'],
            'integer' => ['value' => 'integer', 'desc' => 'The field must be an integer.'],
            'numeric' => ['value' => 'numeric', 'desc' => 'The field must be a number.'],
            'accepted' => ['value' => 'accepted', 'desc' => 'The field must be accepted.'],

            'active_url' => ['value' => 'active_url', 'desc' => 'The field must be a valid, active URL.'],
            'decimal' => ['value' => 'decimal', 'desc' => 'The field must be a decimal number.'],
            'declined' => ['value' => 'declined', 'desc' => 'The field must be declined.'],

            'digits' => ['value' => 'digits:{digits}', 'desc' => 'The field must be a numeric value with a specified number of digits.'],
            'digits_between' => ['value' => 'digits_between:{min},{max}', 'desc' => 'The field must be a numeric value with a specified number of digits, between two specified values.'],
            'dimensions' => ['value' => 'dimensions:{width},{height}', 'desc' => 'The image file must have the specified dimensions.'],
            'distinct' => ['value' => 'distinct', 'desc' => 'The field must contain unique values.'],

            'filled' => ['value' => 'filled', 'desc' => 'The field must be filled.'],
            'greater_than' => ['value' => 'gt:{value}', 'desc' => 'The field must be greater than a specified value.'],
            'greater_than_or_equal' => ['value' => 'gte:{value}', 'desc' => 'The field must be greater than or equal to a specified value.'],
            'in_array' => ['value' => 'in_array', 'desc' => 'The field must be present in the specified array.'],
            'ip_address' => ['value' => 'ip', 'desc' => 'The field must be a valid IP address.'],
            'less_than' => ['value' => 'lt:{value}', 'desc' => 'The field must be less than a specified value.'],
            'less_than_or_equal' => ['value' => 'lte:{value}', 'desc' => 'The field must be less than or equal to a specified value.'],
            'lowercase' => ['value' => 'lowercase', 'desc' => 'The field must contain only lowercase characters.'],
            'mac_address' => ['value' => 'mac_address', 'desc' => 'The field must be a valid MAC address.'],
            'max_digits' => ['value' => 'max_digits:{digits}', 'desc' => 'The field must be a numeric value with no more than a specified number of digits.'],
            'mime_types' => ['value' => 'mimetypes:{mimetypes}', 'desc' => 'The file must have one of the specified MIME types.'],
            'mime_type_by_file_extension' => ['value' => 'mimetype_by_extension:{extension}', 'desc' => 'The file must have the specified MIME type based on its file extension.'],
            'min_digits' => ['value' => 'min_digits:{digits}', 'desc' => 'The field must be a numeric value with at least a specified number of digits.'],
            'missing' => ['value' => 'missing', 'desc' => 'The field must be missing.'],

            'password' => ['value' => 'password', 'desc' => 'The field must be a valid password.'],
            'present' => ['value' => 'present', 'desc' => 'The field must be present.'],
            'prohibited' => ['value' => 'prohibited', 'desc' => 'The field must be prohibited.'],

            'required_array_keys' => ['value' => 'required_array_keys:{keys}', 'desc' => 'The array must have the specified keys.'],
            'sometimes' => ['value' => 'sometimes', 'desc' => 'The field is not required, but may be present.'],
            'timezone' => ['value' => 'timezone', 'desc' => 'The field must be a valid timezone.'],
            'uppercase' => ['value' => 'uppercase', 'desc' => 'The field must contain only uppercase characters.'],
            'ulid' => ['value' => 'ulid', 'desc' => 'The field must be a valid ULID.'],
            'uuid' => ['value' => 'uuid', 'desc' => 'The field must be a valid UUID.'],
        ];

        if ($rule){
            if (array_key_exists($rule, $rules)) {
                return [$rule => $rules[$rule]];
            } else {
                return []; // Rule not found
            }
        }

        if ($search_key){
            $filteredRules = [];
            foreach ($rules as $ruleKey => $ruleData) {
                if (str_contains($ruleKey, $search_key)) {
                    $filteredRules[$ruleKey] = $ruleData;
                }
            }
            if (!empty($filteredRules)) {
                return $filteredRules;
            } else {
                return []; // No matching rules found
            }
        }
        return  $rules;

    }

    public function submitSingleForm(Request $request, ApiConsumeInterface $apiConsumeInterface)
    {

        $data = $request->all();
        $module_name= $data['name'];
        $columns = array();
        $rules = [
            'name' => [
                'required',
                Rule::unique('app_generators')->where(function ($query) use($module_name){
                    return $query
                        ->where('name', Str::plural(Str::snake($module_name)))
                        ->where('ddl_mode', 'CREATE');
                }),
            ]
        ];
        $messages = [
            'name.required' => 'The name field is required.',
            'name.unique' => 'This table name already created. you can alter or drop only'
        ];
        $data['name'] = Str::plural(Str::snake($module_name));
        $validator = Validator::make($data, $rules, $messages);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();

        }

        foreach ($data['field_name'] as $key=>$val ){
            $columns[] = [
                'name' => $val,
                'type' => $data['data_type'][$key],
                'level' => $data['level_name'][$key],
                'fieldSize' => $data['field_size'][$key],
                'default' => $data['default'][$key],
                'nullable' => $data['nullable'][$key],
                'inputType' => $data['input_type'][$key]
            ];
        }

        $columns[0]['validation_attribute'] = $data['validation_attribute']??[];

        try {
            $actions = $this->getEndPoints();
            foreach ($actions as $action) {
                $content = $apiConsumeInterface->callApi(
                    $action['endpoint'],
                    $module_name,
                    $columns,
                    config('olua.bladeLayout.header'),
                    config('olua.bladeLayout.script'),
                    env('OLUA_LC_KEY'),
                );
                if ($content->statusCode === "401"){
                    $request->session()->flash('error', $content->message);
                    return redirect()->route('build.single-form');
                }else{
                    if (!in_array($action['endpoint_key'],['nav','route','html'])){
                        $filePath = $this->checkDirectory($action['destination'],$action['endpoint_key'],$content->{$action['file_key']});
                        file_put_contents($filePath, $content->{$action['content_key']});
                    }
                    if ($action['endpoint_key'] === 'html'){
                        $directory = $action['destination'].Str::plural(Str::snake($module_name));
                        if (!is_dir($directory)) {
                            mkdir($directory, 0755, true);
                        }

                        $htmlFilePath = $directory.'/';
                        foreach (['index', 'edit', 'create'] as $contentType) {
                            $htmlFileContent = $content->{$contentType};
                            if (!$htmlFileContent) {
                                Log::error("Failed to fetch content to $contentType page");
                                throw new \Exception("No $contentType content found in response");
                            }
                            $FilePath = $htmlFilePath.$htmlFileContent->file;
                            $writeSuccess = file_put_contents($FilePath, $htmlFileContent->content);

                            if ($writeSuccess === false) {
                                Log::error("Failed to write content to $contentType page");
                                throw new Exception("Failed to write content to $contentType page");
                            }
                        }
                    }
                    if ($action['endpoint_key'] === 'route' || $action['endpoint_key'] === 'nav'){
                        Log::error("fetch to destination ".$action['destination'].' '.$action['endpoint_key']);
                        $updatedContent = $this->updateExistingFileContent($action['destination'],$action['endpoint_key'],$content,$action);
                        $writeSuccess = file_put_contents($action['destination'], $updatedContent);
                        if ($writeSuccess === false) {
                            Log::error("Failed to write content to ".$action['endpoint_key']);
                            throw new Exception("Failed to write content to ".$action['endpoint_key']);
                        }
                    }
                }
//                $apiConsumeInterface->writeContent($filePath, $content->{$action['content_key']});
            }
            // Return a success response if all operations complete successfully
            $request->session()->flash('success', 'All files created successfully');
            return redirect()->route('build.single-form');
        } catch (\Exception $e) {
            Log::error('Single orm Error: ' . $e);
            $request->session()->flash('error', 'Internal Server Error');
            return redirect()->route('build.single-form');
        }

    }

}