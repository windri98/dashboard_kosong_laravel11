@extends('dashboard.index')

@section('content')
<section class="roles-section" id="edit-roles">
    <div class="roles-header">
        <h1>Edit Role</h1>
        <a href="/showrole" class="back-button">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M19 12H5M12 19l-7-7 7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
            </svg>
            Kembali
        </a>
    </div>
    
    @if (session('success'))
        <div class="alert success-alert">
            {{ session('success') }}
        </div>
    @endif

    <div class="container-edit">
        <form action="{{ route('update.role', $role->id) }}" method="POST" class="form-container">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="role" class="form-label">Nama Role:</label>
                <input type="text" name="role" class="form-control" placeholder="Masukkan nama role" value="{{ $role->role }}" required>
            </div>

            <div class="form-group">
                <label class="form-label">Hak Akses:</label>
                @php
                    $permissionModules = [
                    'manage-roles.role' => 'Manajemen Role & User',
                    'change-password' => 'Ubah Password',
                    'manage-bukti-jackpot.buktijackpot' => 'Manajemen Bukti Jackpot',
                    'manage-priority.priority' => 'Manajemen Prioritas',
                    'manage-social-media.socialmedia' => 'Manajemen Social Media',
                    'manage-website.website' => 'Manajemen Website',
                    'manage-game.game' => 'Manajemen Game',
                    'manage-kategori-game.kategorigame' => 'Manajemen Kategori Game',
                    'manage-link-website.linkwebsite' => 'Manajemen Link Website'
                    ];
                    
                    $actions = ['read' => 'Lihat', 'create' => 'Tambah', 'edit' => 'Edit', 'delete' => 'Hapus'];
                    
                    // Decode existing permissions if it's a string, or use as is if already an array
                    $existingPermissions = is_string($role->akses) ? json_decode($role->akses, true) : $role->akses;
                    $existingPermissions = $existingPermissions ?: [];
                @endphp
                <div class="permission-card">
                    <div class="table-responsive">
                        <table class="roles-table permission-table">
                            <thead>
                                <tr>
                                    <th>Modul</th>
                                    @foreach($actions as $actionKey => $actionName)
                                        <th class="text-center">{{ $actionName }}</th>
                                    @endforeach
                                    <th class="text-center">Semua</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($permissionModules as $moduleKey => $moduleName)
                                    <tr>
                                        <td>{{ $moduleName }}</td>
                                        @foreach($actions as $actionKey => $actionName)
                                            <td class="text-center">
                                                <div class="checkbox-wrapper">
                                                    <input class="custom-checkbox module-action" 
                                                        type="checkbox" 
                                                        id="{{ $moduleKey }}_{{ $actionKey }}" 
                                                        name="permissions[{{ $moduleKey }}][]" 
                                                        value="{{ $actionKey }}"
                                                        data-module="{{ $moduleKey }}"
                                                        {{ (isset($existingPermissions[$moduleKey]) && 
                                                          ((is_array($existingPermissions[$moduleKey]) && in_array($actionKey, $existingPermissions[$moduleKey])) || 
                                                           $existingPermissions[$moduleKey] === true)) ? 'checked' : '' }}>
                                                    <label for="{{ $moduleKey }}_{{ $actionKey }}"></label>
                                                </div>
                                            </td>
                                        @endforeach
                                        <td class="text-center">
                                            <div class="checkbox-wrapper">
                                                <input class="custom-checkbox select-all" 
                                                    type="checkbox" 
                                                    id="select_all_{{ $moduleKey }}" 
                                                    data-module="{{ $moduleKey }}"
                                                    {{ (isset($existingPermissions[$moduleKey]) && $existingPermissions[$moduleKey] === true) ? 'checked' : '' }}>
                                                <label for="select_all_{{ $moduleKey }}"></label>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td><strong>Pilih Semua</strong></td>
                                    @foreach($actions as $actionKey => $actionName)
                                        <td class="text-center">
                                            <div class="checkbox-wrapper">
                                                <input class="custom-checkbox select-all-action" 
                                                    type="checkbox" 
                                                    id="select_all_{{ $actionKey }}" 
                                                    data-action="{{ $actionKey }}">
                                                <label for="select_all_{{ $actionKey }}"></label>
                                            </div>
                                        </td>
                                    @endforeach
                                    <td class="text-center">
                                        <div class="checkbox-wrapper">
                                            <input class="custom-checkbox" 
                                                type="checkbox" 
                                                id="select_all_permissions">
                                            <label for="select_all_permissions"></label>
                                        </div>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>

            <div class="button-group">
                <button class="primary-button" type="submit">Update</button>

            </div>
        </form>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Select all checkboxes for a specific module
    const selectAllModuleCheckboxes = document.querySelectorAll('.select-all');
    selectAllModuleCheckboxes.forEach(checkbox => {
        const moduleKey = checkbox.dataset.module;
        
        // Initial state check
        updateSelectAllModuleCheckbox(moduleKey);
        
        checkbox.addEventListener('change', function() {
            const isChecked = this.checked;
            const moduleCheckboxes = document.querySelectorAll(`.module-action[data-module="${moduleKey}"]`);
            
            moduleCheckboxes.forEach(moduleCheckbox => {
                moduleCheckbox.checked = isChecked;
            });
        });
    });
    
    // Select all checkboxes for a specific action
    const selectAllActionCheckboxes = document.querySelectorAll('.select-all-action');
    selectAllActionCheckboxes.forEach(checkbox => {
        const actionKey = checkbox.dataset.action;
        
        // Initial state check
        updateSelectAllActionCheckbox(actionKey);
        
        checkbox.addEventListener('change', function() {
            const isChecked = this.checked;
            const actionCheckboxes = document.querySelectorAll(`input[name$="[]"][value="${actionKey}"]`);
            
            actionCheckboxes.forEach(actionCheckbox => {
                actionCheckbox.checked = isChecked;
            });
        });
    });
    
    // Select all permissions
    const selectAllPermissionsCheckbox = document.getElementById('select_all_permissions');
    
    // Initial state check
    updateSelectAllPermissionsCheckbox();
    
    selectAllPermissionsCheckbox.addEventListener('change', function() {
        const isChecked = this.checked;
        const allCheckboxes = document.querySelectorAll('.module-action');
        
        allCheckboxes.forEach(checkbox => {
            checkbox.checked = isChecked;
        });
        
        // Update module "Select All" checkboxes
        selectAllModuleCheckboxes.forEach(checkbox => {
            checkbox.checked = isChecked;
        });
        
        // Update action "Select All" checkboxes
        selectAllActionCheckboxes.forEach(checkbox => {
            checkbox.checked = isChecked;
        });
    });
    
    // Individual module action checkbox change
    const moduleActionCheckboxes = document.querySelectorAll('.module-action');
    moduleActionCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const moduleKey = this.dataset.module;
            const actionKey = this.value;
            
            // Update the module's "Select All" checkbox
            updateSelectAllModuleCheckbox(moduleKey);
            
            // Update the action's "Select All" checkbox
            updateSelectAllActionCheckbox(actionKey);
            
            // Update the global "Select All" checkbox
            updateSelectAllPermissionsCheckbox();
        });
    });
    
    // Function to update a module's "Select All" checkbox
    function updateSelectAllModuleCheckbox(moduleKey) {
        const moduleCheckboxes = document.querySelectorAll(`.module-action[data-module="${moduleKey}"]`);
        const selectAllModuleCheckbox = document.querySelector(`#select_all_${moduleKey}`);
        
        if (selectAllModuleCheckbox) {
            const allChecked = Array.from(moduleCheckboxes).every(checkbox => checkbox.checked);
            selectAllModuleCheckbox.checked = allChecked;
        }
    }
    
    // Function to update an action's "Select All" checkbox
    function updateSelectAllActionCheckbox(actionKey) {
        const actionCheckboxes = document.querySelectorAll(`input[name$="[]"][value="${actionKey}"]`);
        const selectAllActionCheckbox = document.querySelector(`#select_all_${actionKey}`);
        
        if (selectAllActionCheckbox) {
            const allChecked = Array.from(actionCheckboxes).every(checkbox => checkbox.checked);
            selectAllActionCheckbox.checked = allChecked;
        }
    }
    
    // Function to update the global "Select All" checkbox
    function updateSelectAllPermissionsCheckbox() {
        const allModuleActionCheckboxes = document.querySelectorAll('.module-action');
        const allChecked = Array.from(allModuleActionCheckboxes).every(checkbox => checkbox.checked);
        
        if (selectAllPermissionsCheckbox) {
            selectAllPermissionsCheckbox.checked = allChecked;
        }
    }
});
</script>

@endsection