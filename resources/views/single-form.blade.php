<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta content="IE=edge" http-equiv="X-UA-Compatible" />
        <title>Olua Laravel Form Builder</title>
        <meta content="" name="description" />
        <meta content="width=device-width,initial-scale=1" name="viewport" />
        <meta content="{{ csrf_token() }}" name="csrf-token" />
        <meta content="all,follow" name="robots" />
        <link crossorigin="anonymous" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" rel="stylesheet" />
    </head>
    <body>
        <div class="container-fluid">
            <div class="container" id="alert-container">
                @if(session('success'))
                <div class="alert alert-success" role="alert">{{ session('success') }}</div>
                @endif @if(session('error'))
                <div class="alert alert-danger" role="alert">{{ session('error') }}</div>
                @endif
            </div>
            <section class="row">
                <div class="col-md-12">
                    <div class="card mb-4">
                        <div class="card-header"><h3 class="card-title">Create Module</h3></div>
                        <div class="card-body">
                            <form action="{{ route('single-form.submit') }}" id="createItemForm" method="POST">
                                @csrf
                                <div class="row mb-3">
                                    <div class="col-md-3">
                                        <label class="form-label required-label" for="tableName">Module Name<i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top"  title="Please type your module or table name for example employee, payroll. keep note that always write the singular form."></i></label>
                                        <input class="form-control text-lowercase" id="name" maxlength="30" name="name" required value="{{ old('name') }}" />
                                    </div>
                                </div>
                                <div class="row mb-3 field_items">
                                    <div class="col-md-3">
                                        <label class="form-label required-label" for="field_name">Field Name <i class="fa fa-info-circle" title="{{__('message.field_name_tooltip')}}"></i></label>
                                        <input class="form-control text-lowercase field_name" id="field_name" maxlength="30" name="field_name[]" required />
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label required-label" for="levelName">Level Name <i class="fa fa-info-circle" title="{{__('message.level_name_tooltip')}}"></i></label>
                                        <input class="form-control" id="levelName" maxlength="30" name="level_name[]" required />
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label required-label" for="dataType">Data Type <i class="fa fa-info-circle" title="{{__('message.data_type_tooltip')}}"></i></label>
                                        <select class="form-select" id="dataType" name="data_type[]" required>
                                            <option value="" disabled selected>Choose...</option>
                                            @foreach($dataTypes as $parent=>$types)
                                            <optgroup label="{{$parent}}">@foreach($types as $type=>$length)<option value="{{$type}}">{{$type}} - {{json_encode($length)}}</option>@endforeach</optgroup>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-1">
                                        <label class="form-label" for="fieldSize">Field Size <i class="fa fa-info-circle" title="{{__('message.field_size_tooltip')}}"></i></label>
                                        <input class="form-control" id="fieldSize" maxlength="4" name="field_size[]" />
                                    </div>
                                    <div class="col-md-1">
                                        <label class="form-label" for="default">Default <i class="fa fa-info-circle" title="{{__('message.default_value_tooltip')}}"></i></label>
                                        <input class="form-control" id="default" maxlength="8" name="default[]" />
                                    </div>
                                    <div class="col-md-1 mb-3">
                                        <label class="form-label" for="nullable">Nullable</label>
                                        <select class="form-select" id="nullable" name="nullable[]">
                                            <option value="Y">Yes</option>
                                            <option value="N">No</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label required-label" for="inputType">Input Type <i class="fa fa-info-circle" title="{{__('message.input_type_tooltip')}}"></i></label>
                                        <select class="form-select" id="inputType" name="input_type[]" required>
                                            <option value="" disabled selected>Choose...</option>
                                            @foreach($htmlInputElements as $key=>$value)
                                            <option value="{{$value}}">{{$key}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6 validationRuleSection" id="validationRuleSection">
                                        <div class="border border-primary p-3 rounded">
                                            <h5 class="border-bottom pb-2">Validation Rules<i class="fa fa-info-circle" title="{{__('message.validation_rules_tooltip')}}"></i></h5>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <select class="form-select validation_rule" id="validation_rule" name="validation_rule[]">
                                                        <option value="" disabled selected>Choose...</option>
                                                        @foreach($validationRules as $key => $data)
                                                        <option value="{{$key}}" name="{{$data['value']}}">{{$data['value']}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-6 dynamicValidationField" id="dynamicValidationField"></div>
                                                <div class="col-md-1 align-items-end d-flex">
                                                    <button class="btn addValidationRuleBtn btn-outline-info" type="button" id="addValidationRuleBtn">+</button>
                                                    <button class="btn btn-danger removeValidationRuleBtn" type="button" id="removeValidationRuleBtn">-</button>
                                                </div>
                                            </div>
                                            <div class="validationRulesItem" id="validationRulesItem"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-1 align-items-end d-flex"><button class="btn btn-primary" type="button" id="addItemBtn">+</button></div>
                                </div>
                                <div id="itemRows"></div>
                                <div class="mt-1"><button class="btn btn-primary" type="submit">Submit</button></div>
                            </form>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <script crossorigin="anonymous" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
        <script crossorigin="anonymous" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
        <script>
            $(document).ready(function () {
                $(function () {
  $('[data-toggle="tooltip"]').tooltip()
})
                $("#addItemBtn").click(function () {
                    var html = `
                    <div class="row mb-3 item field_items">
                                <div class="col-md-3">
                                    <input class="form-control field_name text-lowercase" id="field_name" name="field_name[]" type="text" required maxlength="30">
                                </div>
                                <div class="col-md-3">
                                    <input class="form-control" id="levelName" name="level_name[]" type="text" required maxlength="30">
                                </div>
                                <div class="col-md-3">
                                    <select class="form-select" id="dataType" name="data_type[]" required>
                                        <option value="" selected disabled>Choose...</option>
                                         @foreach($dataTypes as $parent=>$types)
            <optgroup label="{{$parent}}">
                                               @foreach($types as $type=>$length)
            <option value="{{$type}}">{{$type}} - {{json_encode($length)}}</option>
                                                @endforeach
            </optgroup>
@endforeach
            </select>
        </div>
        <div class="col-md-1">
            <input class="form-control" id="fieldSize" name="field_size[]" type="text" maxlength="4">
        </div>
        <div class="col-md-1">
            <input class="form-control" id="default" name="default[]" type="text">
        </div>
        <div class="col-md-1 mb-3">
            <select class="form-select" id="nullable" name="nullable[]">
                <option value="Y">Yes</option>
                <option value="N">No</option>
            </select>
        </div>
        <div class="col-md-3">
            <select class="form-select" id="inputType" name="input_type[]" required>
                <option value="" selected disabled>Choose...</option>
@foreach($htmlInputElements as $key=>$value)
            <option value="{{$value}}">{{$key}}</option>
                                        @endforeach
            </select>
        </div>
        <div class="col-md-6 validationRuleSection" id="validationRuleSection">
                                    <div class="border border-primary rounded p-3">
                                        <h5 class="border-bottom pb-2">Validation Rules</h5>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <select class="form-select validation_rule" id="validation_rule" name="validation_rule[]">
                                                    <option value="" selected disabled>Choose...</option>
                                                    @foreach($validationRules as $key => $data)
            <option value="{{$key}}" name="{{$data['value']}}">{{$data['value']}}</option>
                                                    @endforeach
            </select>
        </div>
        <div id="dynamicValidationField" class="col-md-6 dynamicValidationField">
        </div>
        <div class="col-md-1 d-flex align-items-end">
            <button class="btn btn-outline-info addValidationRuleBtn" type="button" id="addValidationRuleBtn">+</button>
        </div>
    </div>
    <div class="validationRulesItem" id="validationRulesItem"></div>
</div>
</div>
<div class="col-md-1 d-flex align-items-end">
<button class="btn btn-danger removeItemBtn" type="button">X</button>
</div>
</div>
`;

                    $("#itemRows").append(html);
                    $(".removeItemBtn").click(function () {
                        var parentDiv = $(this).closest(".item");
                        parentDiv.remove();
                    });
                    $(".validationRuleSection").on("click", ".addValidationRuleBtn", function () {
                        const $this = $(this);
                        addValidationRule($this);
                    });
                    $(".validationRuleSection").on("click", ".removeValidationRuleBtn", function () {
                        var parentDiv = $(this).closest(".row");
                        parentDiv.remove();
                    });
                    $(".validationRuleSection").on("change", ".validation_rule", function () {
                        const $this = $(this);
                        validationRuleOnChange($this);
                    });
                    $(".form-control").on("input", function () {
                        let $this = $(this);
                        controlInputField($this);
                    });
                });
                $(".validationRuleSection").on("click", ".addValidationRuleBtn", function () {
                    const $this = $(this);
                    addValidationRule($this);
                });
                $(".validationRuleSection").on("click", ".removeValidationRuleBtn", function () {
                    var parentDiv = $(this).closest(".row");
                    parentDiv.remove();
                });
                $(".validationRuleSection").on("change", ".validation_rule", function () {
                    const $this = $(this);
                    validationRuleOnChange($this);
                });
            });

            function addValidationRule($element) {
                let selectedRowFieldName = $element.parents().filter(".field_items").find(".field_name").val();
                const lastItem = $element.closest(".validationRuleSection").find(".validationRulesItem").find(".row:last");
                if (!selectedRowFieldName) {
                    alert("please select field name");
                    return;
                }
                if (!lastItem.find(".validation_rule")) {
                    alert("please select a rule");
                    return;
                }
                let allFieldsFilled = true;
                lastItem.find("input[required]").each(function () {
                    if (!$(this).val()) {
                        allFieldsFilled = false;
                        return false;
                    }
                });

                if (!allFieldsFilled) {
                    alert("Not all required fields are filled.");
                    return;
                }

                const validationModalHtml = `<div class="col-md-4 mt-1">
                                                <select class="form-select validation_rule" id="validation_rule" name="validation_rule[]" required>
                                                    <option value="" selected disabled>Choose...</option>
                                                    @foreach($validationRules as $key=>$data)
        <option value="{{$key}}" name="{{$data['value']}}">{{$data['value']}}</option>
                                                    @endforeach
        </select>
    </div>
<div id="dynamicValidationField" class="col-md-6 dynamicValidationField mt-1">
                                    </div>
                                    <div class="col-md-1 d-flex align-items-end mt-1">
                                        <button class="btn btn-danger removeValidationRuleBtn" type="button" id="removeValidationRuleBtn">-</button>
                                    </div>
`;
                const rowValidationModalHtmlDiv = '<div class="row">' + validationModalHtml + "</div>";
                $element.closest(".validationRuleSection").find(".validationRulesItem").append(rowValidationModalHtmlDiv);
            }

            function validationRuleOnChange($element) {
                let selectedRowFieldName = $element.parents().filter(".field_items").find(".field_name").val();
                if (!selectedRowFieldName) {
                    alert("please select field name");
                    return false;
                }
                const selectedOption = $element.find(":selected");
                const selectedValidationName = selectedOption.val();
                const optionName = selectedOption.attr("name");
                const variableMatches = extractVariableFromString(optionName);

                // Find the .dynamicValidationField within the same modal
                const dynamicField = $element.closest(".row").find(".dynamicValidationField");

                // Clear the existing content within the .dynamicValidationField
                dynamicField.empty();
                let inputField = "";
                if (variableMatches.length > 0) {
                    $.each(variableMatches, function (index, inputName) {
                        let inputNameVarible = "validation_attribute" + "[" + selectedRowFieldName + "][" + selectedValidationName + "][" + inputName + "][]";
                        inputField += '<div class="col-md-5"><input class="form-control" type="text" name="' + inputNameVarible + '" placeholder="' + inputName + '" required maxlength="30"></div>';
                    });

                    let rowDiv = '<div class="row">' + inputField + "</div>";
                    dynamicField.append(rowDiv);
                } else {
                    let inputNameVarible = "validation_attribute" + "[" + selectedRowFieldName + "][" + selectedValidationName + "][" + selectedValidationName + "][]";
                    inputField = '<div class="col-md-5"><input class="form-control" type="hidden" name="' + inputNameVarible + '" ></div>';
                    let rowDiv = '<div class="row">' + inputField + "</div>";
                    dynamicField.append(rowDiv);
                }
            }

            $(".form-control").on("input", function () {
                let $this = $(this);
                controlInputField($this);
            });

            function extractVariableFromString(string) {
                const regex = /\{(?<variable>\w+)\}/g;
                const matches = [...string.matchAll(regex)];
                if (matches && matches.length > 0) {
                    const variables = matches.map((match) => match.groups.variable);
                    return variables;
                } else {
                    return [];
                }
            }

            function controlInputField($element) {
                let inputValue = $element.val();
                let sanitizedValue = inputValue.replace(/[^a-zA-Z0-9_\s]/g, "");
                $element.val(sanitizedValue);
            }
        </script>
    </body>
</html>
