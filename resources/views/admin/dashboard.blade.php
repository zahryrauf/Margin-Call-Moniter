@extends('layouts.app')
@section('content')
<div class="flex justify-center items-center min-h-screen bg-gradient-to-br from-blue-50 to-gray-100 py-8">
    <div class="w-full max-w-7xl shadow-2xl rounded-2xl p-12 border border-blue-100 bg-gradient-to-br from-blue-50 to-gray-100">
        <h2 class="text-3xl font-extrabold mb-8 text-blue-800 text-center tracking-tight">Admin Dashboard - Manage Brokers</h2>
        @if(session('error'))
            <div id="alert-error" class="relative mb-4 p-3 rounded bg-red-100 text-red-800 font-semibold shadow text-center flex items-center justify-center">
                <span class="flex-1">{{ session('error') }}</span>
                <button onclick="document.getElementById('alert-error').style.display='none'" class="absolute right-3 top-1/2 -translate-y-1/2 text-red-500 hover:text-red-700 text-xl font-bold">&times;</button>
            </div>
        @endif
        @if(session('success'))
            <div id="alert-success" class="relative mb-4 p-3 rounded bg-green-100 text-green-800 font-semibold shadow text-center flex items-center justify-center">
                <span class="flex-1">{{ session('success') }}</span>
                <button onclick="document.getElementById('alert-success').style.display='none'" class="absolute right-3 top-1/2 -translate-y-1/2 text-green-500 hover:text-green-700 text-xl font-bold">&times;</button>
            </div>
        @endif
        <div class="overflow-x-auto rounded-2xl shadow-lg border border-blue-100">
            <table class="w-full min-w-[1100px] divide-y divide-blue-200 text-base">
                <thead class="bg-blue-100">
                    <tr>
                        <th class="px-4 py-2 text-left text-xs font-bold text-blue-700 uppercase tracking-wider">ID</th>
                        <th class="px-4 py-2 text-left text-xs font-bold text-blue-700 uppercase tracking-wider">Name</th>
                        <th class="px-4 py-2 text-left text-xs font-bold text-blue-700 uppercase tracking-wider">Email</th>
                        <th class="px-4 py-2 text-left text-xs font-bold text-blue-700 uppercase tracking-wider">Role</th>
                        <th class="px-4 py-2 text-center text-xs font-bold text-blue-700 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-blue-50">
                    @foreach($brokers as $broker)
                        <tr class="transition @if($broker->id == auth()->user()->id) bg-yellow-100 @else hover:bg-blue-50 @endif" data-broker-id="{{ $broker->id }}">
                            <td class="px-4 py-2 font-mono text-blue-900">{{ $broker->id }}</td>
                            <td class="px-4 py-2">
                                <span class="broker-name">{{ $broker->name }}</span>
                                <input type="text" value="{{ $broker->name }}" class="broker-name-input hidden w-full rounded border border-blue-300 px-2 py-1 focus:ring-2 focus:ring-blue-400" />
                            </td>
                            <td class="px-4 py-2">
                                <span class="broker-email">{{ $broker->email }}</span>
                                <input type="email" value="{{ $broker->email }}" class="broker-email-input hidden w-full rounded border border-blue-300 px-2 py-1 focus:ring-2 focus:ring-blue-400" />
                            </td>
                            <td class="px-4 py-2">
                                <span class="broker-role">{{ $broker->role ?? 'User' }}</span>
                                <select class="broker-role-input hidden block w-28 rounded-lg border border-blue-300 bg-white px-2 py-1 pr-8 text-blue-800 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-400">
                                    <option value="User" @if(($broker->role ?? 'User') == 'User') selected @endif>User</option>
                                    <option value="Admin" @if(($broker->role ?? 'User') == 'Admin') selected @endif>Admin</option>
                                </select>
                            </td>
                            <td class="px-4 py-2 flex gap-3 items-center justify-center min-w-[240px] text-center">
                                <button type="button"
                                    class="edit-btn px-4 py-2 w-28 rounded-lg shadow-md text-sm font-bold text-white border-2 border-transparent transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-offset-2 @if($broker->id == auth()->user()->id) bg-gray-200 bg-gradient-to-r from-gray-300 to-gray-400 cursor-not-allowed opacity-60 @else bg-gradient-to-r from-indigo-500 via-blue-600 to-blue-700 hover:from-blue-600 hover:to-indigo-700 active:scale-95 hover:border-blue-500 @endif"
                                    @if($broker->id == auth()->user()->id) tabindex="-1" aria-disabled="true" title="You cannot edit your own broker account." style="pointer-events: none;" @endif
                                >Edit</button>
                                <form action="{{ route('admin.brokers.destroy', $broker->id) }}" method="POST" style="display:inline-block;" class="delete-broker-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" onclick="showDeleteModal(this)" class="delete-btn px-4 py-2 w-28 rounded-lg shadow-md text-sm font-bold text-white border-2 border-transparent transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-red-400 focus:ring-offset-2 @if($broker->id == auth()->user()->id) bg-gray-200 bg-gradient-to-r from-gray-300 to-gray-400 cursor-not-allowed opacity-60 @else bg-gradient-to-r from-pink-500 via-red-500 to-rose-600 hover:from-red-600 hover:to-pink-700 active:scale-95 hover:border-red-500 @endif" {{ $broker->id == auth()->user()->id ? 'disabled' : '' }}>Delete</button>
                                </form>
                                <button type="button" class="cancel-btn px-4 py-2 rounded-lg shadow-md text-sm font-bold text-gray-700 border-2 border-transparent transition-all duration-200 bg-gradient-to-r from-gray-200 to-gray-300 hover:from-gray-300 hover:to-gray-400 hover:border-gray-500 focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-offset-2 opacity-0 pointer-events-none">Cancel</button>
                                <form action="{{ route('admin.brokers.updateRole', $broker->id) }}" method="POST" class="edit-save-form hidden">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="name" />
                                    <input type="hidden" name="email" />
                                    <input type="hidden" name="role" />
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
// Inline edit logic for admin broker table
document.addEventListener('DOMContentLoaded', function() {
    let currentlyEditingRow = null;
    const allRows = Array.from(document.querySelectorAll('tr[data-broker-id]'));
    allRows.forEach(function(row) {
        const editBtn = row.querySelector('.edit-btn');
        const nameSpan = row.querySelector('.broker-name');
        const nameInput = row.querySelector('.broker-name-input');
        const emailSpan = row.querySelector('.broker-email');
        const emailInput = row.querySelector('.broker-email-input');
        const roleSpan = row.querySelector('.broker-role');
        const roleInput = row.querySelector('.broker-role-input');
        const saveForm = row.querySelector('.edit-save-form');
        const cancelBtn = row.querySelector('.cancel-btn');
        const deleteBtn = row.querySelector('.delete-btn');
    let editing = false;
    let changed = false;
    let originalRole = roleInput.value;

        // Track changes
        [nameInput, emailInput, roleInput].forEach(function(input) {
            input.addEventListener('input', function() {
                changed = true;
            });
        });

        editBtn.addEventListener('click', function() {
            if (!editing) {
                // If another row is being edited, do nothing
                if (currentlyEditingRow && currentlyEditingRow !== row) {
                    return;
                }
                // Enter edit mode
                editing = true;
                changed = false;
                currentlyEditingRow = row;
                // Disable all other edit buttons
                allRows.forEach(function(otherRow) {
                    if (otherRow !== row) {
                        const otherEditBtn = otherRow.querySelector('.edit-btn');
                        otherEditBtn.disabled = true;
                        otherEditBtn.classList.add('opacity-50','cursor-not-allowed');
                    }
                });
                nameSpan.classList.add('hidden');
                nameInput.classList.remove('hidden');
                emailSpan.classList.add('hidden');
                emailInput.classList.remove('hidden');
                roleSpan.classList.add('hidden');
                roleInput.classList.remove('hidden');
                editBtn.textContent = 'Confirm';
                editBtn.classList.remove('bg-yellow-400','hover:bg-yellow-500','bg-gradient-to-r','from-indigo-500','via-blue-600','to-blue-700','hover:from-blue-600','hover:to-indigo-700');
                editBtn.classList.add('bg-gradient-to-r','from-emerald-500','via-green-600','to-emerald-700','hover:from-green-600','hover:to-emerald-800');
                deleteBtn.classList.add('hidden');
                cancelBtn.classList.remove('opacity-0','pointer-events-none');
                cancelBtn.classList.add('opacity-100','pointer-events-auto');
            } else {
                // Confirm/save: only submit if changes were made
                if (!changed) {
                    alert('No changes made.');
                    // Revert UI to normal mode
                    nameSpan.classList.remove('hidden');
                    nameInput.classList.add('hidden');
                    emailSpan.classList.remove('hidden');
                    emailInput.classList.add('hidden');
                    roleSpan.classList.remove('hidden');
                    roleInput.classList.add('hidden');
                    editBtn.textContent = 'Edit';
                    editBtn.classList.remove('bg-green-600','hover:bg-green-700','bg-gradient-to-r','from-emerald-500','via-green-600','to-emerald-700','hover:from-green-600','hover:to-emerald-800');
                    editBtn.classList.add('bg-gradient-to-r','from-indigo-500','via-blue-600','to-blue-700','hover:from-blue-600','hover:to-indigo-700');
                    editing = false;
                    changed = false;
                    currentlyEditingRow = null;
                    // Enable all edit buttons
                    allRows.forEach(function(otherRow) {
                        const otherEditBtn = otherRow.querySelector('.edit-btn');
                        otherEditBtn.disabled = false;
                        otherEditBtn.classList.remove('opacity-50','cursor-not-allowed');
                    });
                    deleteBtn.classList.remove('hidden');
                    cancelBtn.classList.add('opacity-0','pointer-events-none');
                    cancelBtn.classList.remove('opacity-100','pointer-events-auto');
                    return;
                }
                // If role changed, ask for password and validate via AJAX
                let requirePassword = (roleInput.value !== originalRole);
                let proceed = function(password) {
                    showSaveModal(function(confirmed) {
                        if (!confirmed) return;
                        // Fill and submit hidden form
                        saveForm.querySelector('input[name="name"]').value = nameInput.value;
                        saveForm.querySelector('input[name="email"]').value = emailInput.value;
                        saveForm.querySelector('input[name="role"]').value = roleInput.value;
                        // Add password field if needed
                        if (requirePassword) {
                            let pwInput = saveForm.querySelector('input[name="admin_password"]');
                            if (!pwInput) {
                                pwInput = document.createElement('input');
                                pwInput.type = 'hidden';
                                pwInput.name = 'admin_password';
                                saveForm.appendChild(pwInput);
                            }
                            pwInput.value = password;
                        }
                        // Revert UI to normal mode for instant feedback
                        nameSpan.textContent = nameInput.value;
                        emailSpan.textContent = emailInput.value;
                        roleSpan.textContent = roleInput.options[roleInput.selectedIndex].text;
                        nameSpan.classList.remove('hidden');
                        nameInput.classList.add('hidden');
                        emailSpan.classList.remove('hidden');
                        emailInput.classList.add('hidden');
                        roleSpan.classList.remove('hidden');
                        roleInput.classList.add('hidden');
                        editBtn.textContent = 'Edit';
                        editBtn.classList.remove('bg-green-600','hover:bg-green-700','bg-gradient-to-r','from-emerald-500','via-green-600','to-emerald-700','hover:from-green-600','hover:to-emerald-800');
                        editBtn.classList.add('bg-gradient-to-r','from-indigo-500','via-blue-600','to-blue-700','hover:from-blue-600','hover:to-indigo-700');
                        editing = false;
                        changed = false;
                        currentlyEditingRow = null;
                        // Enable all edit buttons
                        allRows.forEach(function(otherRow) {
                            const otherEditBtn = otherRow.querySelector(' .edit-btn');
                            otherEditBtn.disabled = false;
                            otherEditBtn.classList.remove('opacity-50','cursor-not-allowed');
                        });
                        deleteBtn.classList.remove('hidden');
                        cancelBtn.classList.add('opacity-0','pointer-events-none');
                        cancelBtn.classList.remove('opacity-100','pointer-events-auto');
                        saveForm.submit();
                    });
                };
// Professional save confirmation modal logic
function showSaveModal(callback) {
    const overlay = document.getElementById('save-modal-overlay');
    const modal = document.getElementById('save-modal');
    overlay.classList.remove('hidden');
    modal.classList.remove('hidden');
    function cleanup() {
        overlay.classList.add('hidden');
        modal.classList.add('hidden');
        confirmBtn.removeEventListener('click', onConfirm);
        cancelBtn.removeEventListener('click', onCancel);
    }
    const confirmBtn = document.getElementById('save-modal-confirm');
    const cancelBtn = document.getElementById('save-modal-cancel');
    function onConfirm() {
        cleanup();
        callback(true);
    }
    function onCancel() {
        cleanup();
        callback(false);
    }
    confirmBtn.addEventListener('click', onConfirm);
    cancelBtn.addEventListener('click', onCancel);
}
                if (requirePassword) {
                    let adminEmail = @json(auth()->user()->email);
                    showPasswordModal(adminEmail, function(password, errorCb) {
                        if (!password) {
                            errorCb('Password is required to change role.');
                            return;
                        }
                        fetch("{{ route('admin.validatePassword') }}", {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content
                            },
                            body: JSON.stringify({admin_password: password})
                        })
                        .then(function(response) {
                            if (!response.ok) throw new Error('Invalid password');
                            return response.json();
                        })
                        .then(function(data) {
                            hidePasswordModal();
                            proceed(password);
                        })
                        .catch(function() {
                            errorCb('Incorrect password. Role not changed.');
                        });
                    });
                } else {
                    proceed();
                }
            }
        });

        cancelBtn.addEventListener('click', function() {
            nameSpan.classList.remove('hidden');
            nameInput.classList.add('hidden');
            emailSpan.classList.remove('hidden');
            emailInput.classList.add('hidden');
            roleSpan.classList.remove('hidden');
            roleInput.classList.add('hidden');
            editBtn.textContent = 'Edit';
            editBtn.classList.remove('bg-green-600','hover:bg-green-700','bg-gradient-to-r','from-emerald-500','via-green-600','to-emerald-700','hover:from-green-600','hover:to-emerald-800');
            editBtn.classList.add('bg-gradient-to-r','from-indigo-500','via-blue-600','to-blue-700','hover:from-blue-600','hover:to-indigo-700');
            editing = false;
            changed = false;
            currentlyEditingRow = null;
            allRows.forEach(function(otherRow) {
                const otherEditBtn = otherRow.querySelector('.edit-btn');
                otherEditBtn.disabled = false;
                otherEditBtn.classList.remove('opacity-50','cursor-not-allowed');
            });
            deleteBtn.classList.remove('hidden');
            cancelBtn.classList.add('opacity-0','pointer-events-none');
            cancelBtn.classList.remove('opacity-100','pointer-events-auto');
        });
    });
});
// Password modal logic
function showPasswordModal(email, onConfirm) {
    let modal = document.getElementById('password-modal');
    let overlay = document.getElementById('password-modal-overlay');
    let input = document.getElementById('password-modal-input');
    let error = document.getElementById('password-modal-error');
    let confirmBtn = document.getElementById('password-modal-confirm');
    let cancelBtn = document.getElementById('password-modal-cancel');
    document.getElementById('password-modal-email').textContent = email;
    input.value = '';
    error.textContent = '';
    modal.classList.remove('hidden');
    overlay.classList.remove('hidden');
    input.focus();
    function cleanup() {
        confirmBtn.onclick = null;
        cancelBtn.onclick = null;
    }
    confirmBtn.onclick = function() {
        error.textContent = '';
        onConfirm(input.value, function(msg) { error.textContent = msg; });
    };
    cancelBtn.onclick = function() {
        hidePasswordModal();
        cleanup();
    };
    input.onkeydown = function(e) {
        if (e.key === 'Enter') confirmBtn.onclick();
        if (e.key === 'Escape') cancelBtn.onclick();
    };
}
function hidePasswordModal() {
    document.getElementById('password-modal').classList.add('hidden');
    document.getElementById('password-modal-overlay').classList.add('hidden');
}

// Professional delete confirmation modal logic
let deleteModalForm = null;
function showDeleteModal(button) {
    deleteModalForm = button.closest('form');
    document.getElementById('delete-modal').classList.remove('hidden');
    document.getElementById('delete-modal-overlay').classList.remove('hidden');
}
function hideDeleteModal() {
    document.getElementById('delete-modal').classList.add('hidden');
    document.getElementById('delete-modal-overlay').classList.add('hidden');
    deleteModalForm = null;
}
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('delete-modal-cancel').onclick = hideDeleteModal;
    document.getElementById('delete-modal-confirm').onclick = function() {
        if (deleteModalForm) deleteModalForm.submit();
        hideDeleteModal();
    };
});
</script>

<!-- Save Confirmation Modal -->
<div id="save-modal-overlay" class="fixed inset-0 bg-black bg-opacity-40 z-40 hidden"></div>
<div id="save-modal" class="fixed z-50 inset-0 flex items-center justify-center hidden">
    <div class="bg-white rounded-xl shadow-2xl p-8 w-full max-w-sm relative border-t-4 border-blue-500">
        <div class="flex items-center mb-4">
            <svg class="w-8 h-8 text-blue-500 mr-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M12 20c4.418 0 8-3.582 8-8s-3.582-8-8-8-8 3.582-8 8 3.582 8 8 8z"/></svg>
            <h3 class="text-xl font-bold text-blue-700">Confirm Save</h3>
        </div>
        <p class="mb-6 text-gray-700 text-base">Are you sure you want to <span class="font-semibold text-blue-600">save changes to this broker</span>?</p>
        <div class="flex justify-end gap-2 mt-2">
            <button id="save-modal-cancel" type="button" class="px-4 py-1.5 rounded-lg bg-gradient-to-r from-gray-300 to-gray-400 text-gray-700 font-semibold shadow-md border-2 border-transparent transition-all duration-200 hover:from-gray-400 hover:to-gray-500 focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-offset-2 hover:border-gray-500">Cancel</button>
            <button id="save-modal-confirm" type="button" class="px-4 py-1.5 rounded-lg bg-gradient-to-r from-blue-500 via-blue-600 to-indigo-700 text-white font-bold shadow-md border-2 border-transparent transition-all duration-200 hover:from-blue-600 hover:to-indigo-800 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-offset-2 hover:border-blue-600">Save</button>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="delete-modal-overlay" class="fixed inset-0 bg-black bg-opacity-40 z-40 hidden"></div>
<div id="delete-modal" class="fixed z-50 inset-0 flex items-center justify-center hidden">
    <div class="bg-white rounded-xl shadow-2xl p-8 w-full max-w-sm relative border-t-4 border-red-500">
        <div class="flex items-center mb-4">
            <svg class="w-8 h-8 text-red-500 mr-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01M21 12c0 4.97-4.03 9-9 9s-9-4.03-9-9 4.03-9 9-9 9 4.03 9 9z"/></svg>
            <h3 class="text-xl font-bold text-red-700">Confirm Delete</h3>
        </div>
        <p class="mb-6 text-gray-700 text-base">Are you sure you want to <span class="font-semibold text-red-600">delete this broker</span>? This action cannot be undone.</p>
        <div class="flex justify-end gap-2 mt-2">
            <button id="delete-modal-cancel" type="button" class="px-4 py-1.5 rounded-lg bg-gradient-to-r from-gray-300 to-gray-400 text-gray-700 font-semibold shadow-md border-2 border-transparent transition-all duration-200 hover:from-gray-400 hover:to-gray-500 focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-offset-2 hover:border-gray-500">Cancel</button>
            <button id="delete-modal-confirm" type="button" class="px-4 py-1.5 rounded-lg bg-gradient-to-r from-pink-500 via-red-500 to-rose-600 text-white font-bold shadow-md border-2 border-transparent transition-all duration-200 hover:from-red-600 hover:to-pink-700 focus:outline-none focus:ring-2 focus:ring-red-400 focus:ring-offset-2 hover:border-red-600">Delete</button>
        </div>
    </div>
</div>

<!-- Password Modal -->
<div id="password-modal-overlay" class="fixed inset-0 bg-black bg-opacity-40 z-40 hidden"></div>
<div id="password-modal" class="fixed z-50 inset-0 flex items-center justify-center hidden">
    <div class="bg-white rounded-xl shadow-2xl p-8 w-full max-w-sm relative">
        <h3 class="text-xl font-bold text-blue-800 mb-2">Admin Password Required</h3>
        <p class="mb-4 text-gray-700 text-sm">To change the role, please enter your password for <span id="password-modal-email" class="font-semibold"></span>:</p>
        <input id="password-modal-input" type="password" class="w-full rounded border border-blue-300 px-3 py-2 mb-2 focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition" placeholder="Enter your password" autocomplete="current-password" />
        <div id="password-modal-error" class="text-red-600 text-xs mb-2 min-h-[1.5em]"></div>
        <div class="flex justify-end gap-2 mt-2">
            <button id="password-modal-cancel" type="button" class="px-4 py-1.5 rounded-lg bg-gradient-to-r from-gray-300 to-gray-400 text-gray-700 font-semibold shadow-md border-2 border-transparent transition-all duration-200 hover:from-gray-400 hover:to-gray-500 focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-offset-2 hover:border-gray-500">Cancel</button>
            <button id="password-modal-confirm" type="button" class="px-4 py-1.5 rounded-lg bg-gradient-to-r from-emerald-500 via-green-600 to-emerald-700 text-white font-bold shadow-md border-2 border-transparent transition-all duration-200 hover:from-green-600 hover:to-emerald-800 focus:outline-none focus:ring-2 focus:ring-emerald-400 focus:ring-offset-2 hover:border-emerald-600">Confirm</button>
        </div>
    </div>
</div>
@endsection
