<div class="modal modal-blur fade" id="ajaxModel" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modelHeading">New {{ $title }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="userForm" name="userForm" class="form-horizontal">
                    <div class="row">
                    <input type="hidden" name="user_id" id="user_id">
                    @foreach ($form as $field)
                        <div class="form-group mb-3 col-md-{{ $field['width'] ?? 12 }}">
                            <label for="{{ $field['field'] }}" class="control-label">
                                {{ $field['label'] }}
                                @if ($field['required'] ?? false)
                                    <span class="text-danger">*</span>
                                @endif
                            </label>
                            @if ($field['type'] === 'textarea')
                                <textarea class="form-control" id="{{ $field['field'] }}" name="{{ $field['field'] }}" placeholder="{{ $field['placeholder'] }}" {{ $field['required'] ?? false ? 'required' : '' }}></textarea>
                            @elseif ($field['type'] === 'file')
                                <input type="file" class="form-control" id="{{ $field['field'] }}" name="{{ $field['field'] }}" {{ $field['required'] ?? false ? 'required' : '' }}>
                            @elseif ($field['type'] === 'password')
                                <input type="password" class="form-control" id="{{ $field['field'] }}" name="{{ $field['field'] }}" placeholder="{{ $field['placeholder'] }}" {{ $field['required'] ?? false ? 'required' : '' }}>
                            @elseif ($field['type'] === 'email')
                                <input type="email" class="form-control" id="{{ $field['field'] }}" name="{{ $field['field'] }}" placeholder="{{ $field['placeholder'] }}" {{ $field['required'] ?? false ? 'required' : '' }}>
                            @elseif ($field['type'] === 'number')
                                <input type="number" class="form-control" id="{{ $field['field'] }}" name="{{ $field['field'] }}" placeholder="{{ $field['placeholder'] }}" {{ $field['required'] ?? false ? 'required' : '' }}>
                            @elseif ($field['type'] === 'date')
                                <input type="date" class="form-control" id="{{ $field['field'] }}" name="{{ $field['field'] }}" placeholder="{{ $field['placeholder'] }}" {{ $field['required'] ?? false ? 'required' : '' }}>
                            @elseif ($field['type'] === 'select')
                                <select class="form-control" id="{{ $field['field'] }}" name="{{ $field['field'] }}" {{ $field['required'] ?? false ? 'required' : '' }}>
                                    <option value="" disabled selected>{{ $field['placeholder'] }}</option>
                                    @foreach ($field['options'] as $value => $label)
                                        <option value="{{ $value }}">{{ $label }}</option>
                                    @endforeach
                                </select>
                            @else
                                <input type="text" class="form-control" id="{{ $field['field'] }}" name="{{ $field['field'] }}" placeholder="{{ $field['placeholder'] }}" {{ $field['required'] ?? false ? 'required' : '' }} {{ $field['disabled'] ?? false ? 'disabled' : '' }}>
                            @endif
                            <span class="text-danger" id="{{ $field['field'] }}Error"></span>
                        </div>
                    @endforeach
                </div>
                    <div class="col-sm-offset-2 col-sm-10 mt-3">
                        <button type="submit" class="btn btn-gr" id="saveBtn" value="create">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

