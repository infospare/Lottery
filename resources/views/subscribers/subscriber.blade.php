@extends('layouts.app')

@section('title', 'Subscribers')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-6xl">
    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 1rem; gap: 0.75rem; flex-wrap: wrap;">
        <p style="margin: 0; color: #1a3d2e; font-size: 0.875rem; font-weight: 600;">
            Logged in as {{ auth()->user()->name }}
        </p>
        <div style="display: flex; flex-direction: row; align-items: center; gap: 0.5rem; flex-wrap: wrap;">
            <a href="{{ route('subscribers.export') }}" class="btn btn-secondary">
                Export to Excel
            </a>
            <button id="add-subscriber-btn" type="button" class="btn btn-primary">
                + Add Subscriber
            </button>
        </div>
    </div>

    @if(session('success'))
        <div style="background: #f0fdf4; color: #166534; border: 1px solid #bbf7d0; border-radius: 0.5rem; padding: 0.75rem; margin-bottom: 1rem; font-size: 0.875rem;">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div style="background: #fef2f2; color: #b91c1c; border: 1px solid #fecaca; border-radius: 0.5rem; padding: 0.75rem; margin-bottom: 1rem; font-size: 0.875rem;">
            {{ session('error') }}
        </div>
    @endif

    <div class="rounded-lg overflow-hidden shadow-lg" style="border: 2px solid #FFB6A6;">
        <div style="background-color: #FFB6A6; padding: 0.35rem 0.75rem;">
            <h1 style="color: rgb(0, 0, 0); font-size: 1rem; font-weight: 700; text-align: center; margin: 0; line-height: 1.3;">
                Subscribers
            </h1>
        </div>

        <div style="background: #fff; padding: 0.6rem 0.75rem; border-bottom: 1px solid #FFB6A6;">
            <div style="display: flex; flex-wrap: wrap; gap: 0.6rem; align-items: flex-end;">
                <div style="flex: 1 1 14rem;">
                    <label for="search-subscriber-name" style="display: block; font-size: 0.75rem; font-weight: 600; color: #1a3d2e; margin-bottom: 0.2rem;">Subscriber Name</label>
                    <input type="text" id="search-subscriber-name" placeholder="Search by name"
                           style="width: 100%; padding: 0.4rem 0.6rem; border: 1px solid #d1d5db; border-radius: 0.4rem; box-sizing: border-box; font-size: 0.875rem;">
                </div>
                <div style="flex: 1 1 12rem;">
                    <label for="search-registration-id" style="display: block; font-size: 0.75rem; font-weight: 600; color: #1a3d2e; margin-bottom: 0.2rem;">Registration ID</label>
                    <input type="text" id="search-registration-id" placeholder="Search by registration ID"
                           style="width: 100%; padding: 0.4rem 0.6rem; border: 1px solid #d1d5db; border-radius: 0.4rem; box-sizing: border-box; font-size: 0.875rem;">
                </div>
                <button type="button" id="clear-subscriber-search" class="btn btn-secondary">Clear</button>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full border-collapse" style="font-size: 0.75rem; line-height: 1.2;">
                <thead>
                    <tr style="background-color: rgb(255, 255, 255); color: rgb(0, 0, 0);">
                        <th style="padding: 0.2rem 0.5rem; text-align: left; font-weight: 600; border: 1px solid #FFB6A6; width: 3rem;">ID</th>
                        <th style="padding: 0.2rem 0.5rem; text-align: left; font-weight: 600; border: 1px solid #FFB6A6;">Subscriber Name</th>
                        <th style="padding: 0.2rem 0.5rem; text-align: left; font-weight: 600; border: 1px solid #FFB6A6;">Phone</th>
                        <th style="padding: 0.2rem 0.5rem; text-align: left; font-weight: 600; border: 1px solid #FFB6A6;">Registration ID</th>
                        <th style="padding: 0.2rem 0.5rem; text-align: left; font-weight: 600; border: 1px solid #FFB6A6;">Registration Key</th>
                        <th style="padding: 0.2rem 0.5rem; text-align: left; font-weight: 600; border: 1px solid #FFB6A6;">Expiry Date</th>
                        <th style="padding: 0.2rem 0.5rem; text-align: left; font-weight: 600; border: 1px solid #FFB6A6;">Notes</th>
                        <th style="padding: 0.2rem 0.5rem; text-align: center; font-weight: 600; border: 1px solid #FFB6A6; width: 9rem;">Actions</th>
                    </tr>
                </thead>
                <tbody id="subscribers-table-body">
                    @forelse($subscribers as $subscriber)
                    <tr data-id="{{ $subscriber->id }}"
                        data-subscriber-name="{{ $subscriber->subscriber_name }}"
                        data-phone="{{ $subscriber->phone }}"
                        data-registration-id="{{ $subscriber->registration_id }}"
                        data-registration-key="{{ $subscriber->registration_key }}"
                        data-expiry-date="{{ $subscriber->expiry_date->format('Y-m-d') }}"
                        data-notes="{{ $subscriber->notes }}"
                        style="background-color: {{ $subscriber->is_expired ? '#FEF2F2' : '#FFF8F0' }};"
                        onmouseover="this.style.backgroundColor='{{ $subscriber->is_expired ? '#FEE2E2' : '#FFEBD3' }}'"
                        onmouseout="this.style.backgroundColor='{{ $subscriber->is_expired ? '#FEF2F2' : '#FFF8F0' }}'">
                        <td style="padding: 0.15rem 0.5rem; border: 1px solid #FFB6A6; color: #1a3d2e;">{{ $subscriber->id }}</td>
                        <td style="padding: 0.15rem 0.5rem; border: 1px solid #FFB6A6; color: #1a3d2e; font-weight: 500;">{{ $subscriber->subscriber_name }}</td>
                        <td style="padding: 0.15rem 0.5rem; border: 1px solid #FFB6A6; color: #1a3d2e;">{{ $subscriber->phone ?: '—' }}</td>
                        <td style="padding: 0.15rem 0.5rem; border: 1px solid #FFB6A6; color: #1a3d2e; font-family: monospace;">{{ $subscriber->registration_id ?: '—' }}</td>
                        <td style="padding: 0.15rem 0.5rem; border: 1px solid #FFB6A6; color: #1a3d2e; font-family: monospace;">{{ $subscriber->registration_key }}</td>
                        <td style="padding: 0.15rem 0.5rem; border: 1px solid #FFB6A6; color: {{ $subscriber->is_expired ? '#b91c1c' : '#1a3d2e' }}; font-weight: {{ $subscriber->is_expired ? '600' : '400' }};">
                            {{ $subscriber->formatted_expiry_date }}
                        </td>
                        <td style="padding: 0.15rem 0.5rem; border: 1px solid #FFB6A6; color: #1a3d2e; max-width: 180px; word-break: break-word;">{{ $subscriber->notes ?: '—' }}</td>
                        <td style="padding: 0.15rem 0.5rem; border: 1px solid #FFB6A6; text-align: center;">
                            <button type="button" class="btn btn-secondary edit-subscriber-btn" style="margin-right: 0.25rem;">Edit</button>
                            <button type="button" class="btn btn-danger remove-subscriber-btn">Remove</button>
                        </td>
                    </tr>
                    @empty
                    <tr id="subscribers-empty-row">
                        <td colspan="8" style="padding: 0.75rem 0.5rem; text-align: center; color: #1a3d2e; background-color: #FFF8F0; border: 1px solid #FFB6A6;">
                            No subscribers yet. Click <strong>+ Add Subscriber</strong> above to add one.
                        </td>
                    </tr>
                    @endforelse
                    <tr id="subscribers-no-match" style="display: none;">
                        <td colspan="8" style="padding: 0.75rem 0.5rem; text-align: center; color: #1a3d2e; background-color: #FFF8F0; border: 1px solid #FFB6A6;">
                            No subscribers match this search.
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- Add / Edit Modal --}}
<div id="subscriber-modal" style="display: none; position: fixed; inset: 0; z-index: 50; align-items: center; justify-content: center; background-color: rgba(0,0,0,0.5); padding: 1rem;">
    <div style="background: #ffffff; border-radius: 0.5rem; box-shadow: 0 20px 25px rgba(0,0,0,0.15); width: 100%; max-width: 28rem; max-height: 90vh; overflow: auto;">
        <div style="display: flex; align-items: center; justify-content: space-between; padding: 1rem 1.5rem; border-bottom: 1px solid #e5e7eb;">
            <h2 id="subscriber-modal-title" style="font-size: 1.125rem; font-weight: 600; color: #111827; margin: 0;">Add Subscriber</h2>
            <button id="close-subscriber-modal" type="button" style="color: #6b7280; font-size: 1.5rem; line-height: 1; border: none; background: none; cursor: pointer;">&times;</button>
        </div>
        <form id="subscriber-form" style="padding: 1.5rem;">
            <input type="hidden" id="subscriber-id" value="">
            <div style="margin-bottom: 1rem;">
                <label for="subscriber_name" style="display: block; font-size: 0.875rem; font-weight: 500; color: #374151; margin-bottom: 0.25rem;">Subscriber Name</label>
                <input type="text" id="subscriber_name" name="subscriber_name" required
                       style="width: 100%; padding: 0.5rem 0.75rem; border: 1px solid #d1d5db; border-radius: 0.5rem; box-sizing: border-box;">
            </div>
            <div style="margin-bottom: 1rem;">
                <label for="phone" style="display: block; font-size: 0.875rem; font-weight: 500; color: #374151; margin-bottom: 0.25rem;">Phone</label>
                <input type="text" id="phone" name="phone"
                       placeholder="Optional"
                       style="width: 100%; padding: 0.5rem 0.75rem; border: 1px solid #d1d5db; border-radius: 0.5rem; box-sizing: border-box;">
            </div>
            <div style="margin-bottom: 1rem;">
                <label for="registration_id" style="display: block; font-size: 0.875rem; font-weight: 500; color: #374151; margin-bottom: 0.25rem;">Registration ID</label>
                <input type="text" id="registration_id" name="registration_id"
                       placeholder="Optional"
                       style="width: 100%; padding: 0.5rem 0.75rem; border: 1px solid #d1d5db; border-radius: 0.5rem; box-sizing: border-box;">
            </div>
            <div style="margin-bottom: 1rem;">
                <label for="registration_key" style="display: block; font-size: 0.875rem; font-weight: 500; color: #374151; margin-bottom: 0.25rem;">Registration Key</label>
                <input type="text" id="registration_key" name="registration_key" required
                       style="width: 100%; padding: 0.5rem 0.75rem; border: 1px solid #d1d5db; border-radius: 0.5rem; box-sizing: border-box;">
            </div>
            <div style="margin-bottom: 1rem;">
                <label for="expiry_date" style="display: block; font-size: 0.875rem; font-weight: 500; color: #374151; margin-bottom: 0.25rem;">Expiry Date</label>
                <input type="date" id="expiry_date" name="expiry_date" required
                       style="width: 100%; padding: 0.5rem 0.75rem; border: 1px solid #d1d5db; border-radius: 0.5rem; box-sizing: border-box;">
            </div>
            <div style="margin-bottom: 1rem;">
                <label for="notes" style="display: block; font-size: 0.875rem; font-weight: 500; color: #374151; margin-bottom: 0.25rem;">Notes</label>
                <textarea id="notes" name="notes" rows="3"
                          placeholder="Optional"
                          style="width: 100%; padding: 0.5rem 0.75rem; border: 1px solid #d1d5db; border-radius: 0.5rem; box-sizing: border-box; resize: vertical; font-family: inherit;"></textarea>
            </div>
            <div id="subscriber-error" style="display: none; font-size: 0.875rem; color: #dc2626; margin-bottom: 0.5rem;"></div>
            <div id="subscriber-success" style="display: none; font-size: 0.875rem; color: #16a34a; margin-bottom: 0.5rem;"></div>
            <div style="display: flex; gap: 0.75rem; padding-top: 0.5rem;">
                <button type="submit" id="subscriber-save-btn" class="btn btn-primary" style="flex: 1;">Save</button>
                <button type="button" id="cancel-subscriber" class="btn btn-secondary" style="flex: 1;">Cancel</button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('subscriber-modal');
    const addBtn = document.getElementById('add-subscriber-btn');
    const closeBtn = document.getElementById('close-subscriber-modal');
    const cancelBtn = document.getElementById('cancel-subscriber');
    const form = document.getElementById('subscriber-form');
    const titleEl = document.getElementById('subscriber-modal-title');
    const idInput = document.getElementById('subscriber-id');
    const nameInput = document.getElementById('subscriber_name');
    const phoneInput = document.getElementById('phone');
    const registrationIdInput = document.getElementById('registration_id');
    const keyInput = document.getElementById('registration_key');
    const expiryInput = document.getElementById('expiry_date');
    const notesInput = document.getElementById('notes');
    const errorEl = document.getElementById('subscriber-error');
    const successEl = document.getElementById('subscriber-success');
    const saveBtn = document.getElementById('subscriber-save-btn');
    const tableBody = document.getElementById('subscribers-table-body');
    const searchNameInput = document.getElementById('search-subscriber-name');
    const searchRegistrationIdInput = document.getElementById('search-registration-id');
    const clearSearchBtn = document.getElementById('clear-subscriber-search');
    const noMatchRow = document.getElementById('subscribers-no-match');
    const csrfToken = '{{ csrf_token() }}';

    function applySubscriberSearch() {
        const nameQuery = searchNameInput.value.trim().toLowerCase();
        const registrationIdQuery = searchRegistrationIdInput.value.trim().toLowerCase();
        const rows = tableBody.querySelectorAll('tr[data-id]');
        let shown = 0;

        rows.forEach(function(row) {
            const name = (row.getAttribute('data-subscriber-name') || '').toLowerCase();
            const registrationId = (row.getAttribute('data-registration-id') || '').toLowerCase();
            const matchesName = nameQuery === '' || name.indexOf(nameQuery) !== -1;
            const matchesRegistrationId = registrationIdQuery === '' || registrationId.indexOf(registrationIdQuery) !== -1;
            const visible = matchesName && matchesRegistrationId;
            row.style.display = visible ? '' : 'none';
            if (visible) shown++;
        });

        if (noMatchRow) {
            noMatchRow.style.display = rows.length > 0 && shown === 0 ? '' : 'none';
        }
    }

    searchNameInput.addEventListener('input', applySubscriberSearch);
    searchRegistrationIdInput.addEventListener('input', applySubscriberSearch);
    clearSearchBtn.addEventListener('click', function() {
        searchNameInput.value = '';
        searchRegistrationIdInput.value = '';
        applySubscriberSearch();
        searchNameInput.focus();
    });

    function openModal(edit) {
        modal.style.display = 'flex';
        errorEl.style.display = 'none';
        successEl.style.display = 'none';
        titleEl.textContent = edit ? 'Edit Subscriber' : 'Add Subscriber';
        saveBtn.textContent = edit ? 'Update' : 'Save';
    }

    function closeModal() {
        modal.style.display = 'none';
        form.reset();
        idInput.value = '';
        errorEl.style.display = 'none';
        successEl.style.display = 'none';
    }

    function showError(message) {
        successEl.style.display = 'none';
        errorEl.textContent = message;
        errorEl.style.display = 'block';
    }

    addBtn.addEventListener('click', function() {
        form.reset();
        idInput.value = '';
        openModal(false);
        nameInput.focus();
    });
    closeBtn.addEventListener('click', closeModal);
    cancelBtn.addEventListener('click', closeModal);
    modal.addEventListener('click', function(e) {
        if (e.target === modal) closeModal();
    });

    tableBody.addEventListener('click', function(e) {
        const editBtn = e.target.closest('.edit-subscriber-btn');
        const removeBtn = e.target.closest('.remove-subscriber-btn');
        const row = e.target.closest('tr[data-id]');
        if (!row) return;

        const id = row.getAttribute('data-id');

        if (editBtn) {
            idInput.value = id;
            nameInput.value = row.getAttribute('data-subscriber-name') || '';
            phoneInput.value = row.getAttribute('data-phone') || '';
            registrationIdInput.value = row.getAttribute('data-registration-id') || '';
            keyInput.value = row.getAttribute('data-registration-key') || '';
            expiryInput.value = row.getAttribute('data-expiry-date') || '';
            notesInput.value = row.getAttribute('data-notes') || '';
            openModal(true);
            nameInput.focus();
            return;
        }

        if (removeBtn) {
            const name = row.getAttribute('data-subscriber-name') || 'this subscriber';
            if (!confirm('Remove subscriber "' + name + '"?')) return;

            fetch('{{ url('/subscribers') }}/' + id, {
                method: 'DELETE',
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                }
            })
            .then(response => response.json().then(data => ({ status: response.status, data })))
            .then(({ status, data }) => {
                if (status >= 200 && status < 300 && data.success) {
                    window.location.reload();
                } else {
                    alert(data.message || 'Remove failed.');
                }
            })
            .catch(() => alert('Network error. Please try again.'));
        }
    });

    form.addEventListener('submit', function(e) {
        e.preventDefault();
        errorEl.style.display = 'none';
        successEl.style.display = 'none';

        const editId = idInput.value;
        const isEdit = !!editId;
        const url = isEdit
            ? '{{ url('/subscribers') }}/' + editId
            : '{{ route('subscribers.store') }}';

        const payload = {
            subscriber_name: nameInput.value.trim(),
            phone: phoneInput.value.trim(),
            registration_id: registrationIdInput.value.trim(),
            registration_key: keyInput.value.trim(),
            expiry_date: expiryInput.value,
            notes: notesInput.value.trim()
        };

        saveBtn.disabled = true;

        fetch(url, {
            method: isEdit ? 'PUT' : 'POST',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify(payload)
        })
        .then(response => response.json().then(data => ({ status: response.status, data })))
        .then(({ status, data }) => {
            if (status >= 200 && status < 300 && data.success) {
                successEl.textContent = data.message || 'Saved.';
                successEl.style.display = 'block';
                setTimeout(function() { window.location.reload(); }, 600);
            } else {
                let message = data.message || 'Save failed.';
                if (data.errors) {
                    message = Object.values(data.errors).flat().join(' ');
                }
                showError(message);
            }
        })
        .catch(() => showError('Network error. Please try again.'))
        .finally(() => { saveBtn.disabled = false; });
    });
});
</script>
@endsection
