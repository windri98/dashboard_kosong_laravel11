@extends('dashboard.index')

@section('content')

<section class="roles-section" id="role">
    <div class="roles-header">
        <h1>Roles</h1>
        <a href="{{ route('add.role') }}" class="add-button">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M12 5V19M5 12H19" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
            </svg>
            Add New Role
        </a>
    </div>

    <div class="table-container">
        <div class="table-responsive">
            <table class="roles-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Role Name</th>
                        <th>Description</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                    <tbody>
                        @forelse ($roles as $index => $role)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $role->role }}</td>
                                <td>
                                    @php
                                        $permissions = json_decode($role->akses, true) ?: [];
                                        $permissionLabels = [
                                            'read' => '<span class="badge bg-info">Read</span>',
                                            'create' => '<span class="badge bg-success">Create</span>',
                                            'edit' => '<span class="badge bg-warning">Edit</span>',
                                            'delete' => '<span class="badge bg-danger">Delete</span>'
                                        ];
                                        $moduleNames = [
                                            'manage-bukti-jackpot.buktijackpot' => 'Bukti Jackpot',
                                            'manage-priority.priority' => 'Prioritas',
                                            'manage-social-media.socialmedia' => 'Footer',
                                            'manage-website.website' => 'Website',
                                            'manage-game.game' => 'Game',
                                            'manage-kategori-game.kategorigame' => 'Kategori Game',
                                            'manage-link-website.linkwebsite' => 'Link Website'
                                        ];
                                    @endphp
                                    
                                    @if(empty($permissions))
                                        <span class="badge bg-secondary">Tanpa akses</span>
                                    @else
                                        @foreach($permissions as $module => $actions)
                                            <div class="mb-1">
                                                <strong>{{ $moduleNames[$module] ?? $module }}:</strong>
                                                @if(is_array($actions))
                                                    @foreach($actions as $action)
                                                        | {!! $permissionLabels[$action] ?? "<span class='badge bg-secondary'>{$action}</span>" !!}
                                                    @endforeach
                                                @elseif($actions === true)
                                                    <span class="badge bg-primary">Akses Penuh</span>
                                                @endif
                                            </div>
                                        @endforeach
                                    @endif
                                </td>
                                
                                <td class="action-cell">
                                    <div class="action-buttons">
                                        <a href="#" class="view-button">
                                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                                <circle cx="12" cy="12" r="3" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></circle>
                                            </svg>
                                            View
                                        </a>
                
                                        <a href="{{ route('edit.role', $role->id) }}" class="edit-button">
                                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                            </svg>
                                            Edit
                                        </a>
                
                                        <form action="{{ route('delete.role', $role->id) }}" method="POST" class="delete-form" onsubmit="return confirm('Are you sure you want to delete this role?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="delete-button" style="border: none;">
                                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M3 6h18M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2M10 11v6M14 11v6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                                </svg>
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center">Tidak ada data role</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </table>
        </div>
    </div>
</section>

<script>
    // alert
    document.addEventListener('DOMContentLoaded', function() {
    // SweetAlert2 - Tampilkan Notifikasi Jika Data Berhasil atau Gagal
    let successMessage = @json(session('success'));
    let errorMessage = @json(session('error'));

    if (successMessage) {
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: successMessage,
            confirmButtonColor: '#1f6e8c',
            confirmButtonText: 'OK',
            customClass: {
                popup: 'custom-success-popup',
                title: 'custom-title',
                content: 'custom-text',
                confirmButton: 'custom-confirm-button'
            }
        });
    }

    if (errorMessage) {
        Swal.fire({
            icon: 'error',
            title: 'Gagal!',
            text: errorMessage,
            confirmButtonColor: '#ff0000',
            confirmButtonText: 'Coba Lagi',
            customClass: {
                popup: 'custom-error-popup',
                title: 'custom-title',
                content: 'custom-text',
                confirmButton: 'custom-confirm-button'
            }
        });
    }
});

</script>
{{-- alert --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@endsection