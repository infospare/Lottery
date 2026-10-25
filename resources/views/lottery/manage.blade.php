@extends('layouts.app')

@section('title', 'Manage Lottery Draw Results')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-5xl">
    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 1rem; gap: 0.75rem; flex-wrap: wrap;">
        <p style="margin: 0; color: #1a3d2e; font-size: 0.875rem; font-weight: 600;">
            Logged in as {{ auth()->user()->name }}
        </p>
        <div style="display: flex; flex-direction: row; align-items: center; gap: 0.5rem; flex-wrap: wrap;">
            <button id="lottery-btn" type="button" class="btn btn-primary">
                Lottery
            </button>
            <button id="upload-btn" type="button" class="btn btn-primary">
                + Upload Result
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
                Latest Lottery Draw Results
            </h1>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full border-collapse" style="font-size: 0.75rem; line-height: 1.2;">
                <thead>
                    <tr style="background-color: rgb(255, 255, 255); color: rgb(0, 0, 0);">
                        <th style="padding: 0.2rem 0.5rem; text-align: left; font-weight: 600; font-size: 0.75rem; border: 1px solid #FFB6A6;">Lottery/DrawNo</th>
                        <th style="padding: 0.2rem 0.5rem; text-align: left; font-weight: 600; font-size: 0.75rem; border: 1px solid #FFB6A6;">Draw Date</th>
                        <th style="padding: 0.2rem 0.5rem; text-align: left; font-weight: 600; font-size: 0.75rem; border: 1px solid #FFB6A6;">Status</th>
                        <th style="padding: 0.2rem 0.5rem; text-align: center; font-weight: 600; font-size: 0.75rem; border: 1px solid #FFB6A6; width: 8rem;">Download</th>
                        <th style="padding: 0.2rem 0.5rem; text-align: left; font-weight: 600; font-size: 0.75rem; border: 1px solid #FFB6A6;">Description</th>
                        <th style="padding: 0.2rem 0.5rem; text-align: center; font-weight: 600; font-size: 0.75rem; border: 1px solid #FFB6A6; width: 5.5rem;">Remove</th>
                    </tr>
                </thead>
                <tbody id="results-table-body">
                    @forelse($draws as $draw)
                    <tr style="background-color: #FFF8F0;" onmouseover="this.style.backgroundColor='#FFEBD3'" onmouseout="this.style.backgroundColor='#FFF8F0'">
                        <td style="padding: 0.15rem 0.5rem; border: 1px solid #FFB6A6; color: #1a3d2e; font-weight: 500; font-size: 0.75rem;">
                            {{ $draw->display_label }}
                        </td>
                        <td style="padding: 0.15rem 0.5rem; border: 1px solid #FFB6A6; color: #1a3d2e; font-size: 0.75rem;">
                            {{ $draw->formatted_draw_date }}
                        </td>
                        <td style="padding: 0.15rem 0.5rem; border: 1px solid #FFB6A6; color: #1a3d2e; font-size: 0.75rem;">
                            {{ $draw->status ?: 'Live' }}
                        </td>
                        <td style="padding: 0.15rem 0.5rem; border: 1px solid #FFB6A6; text-align: center; font-size: 0.75rem;">
                            @if($draw->file_path)
                            <a href="{{ route('lottery.results.download', $draw->id) }}"
                               style="color: #1d4ed8; font-weight: 500; text-decoration: none; font-size: 0.75rem;"
                               onmouseover="this.style.textDecoration='underline'"
                               onmouseout="this.style.textDecoration='none'">
                                Download
                            </a>
                            @else
                            <span style="color: #6b7280; font-size: 0.75rem;">—</span>
                            @endif
                        </td>
                        <td style="padding: 0.15rem 0.5rem; border: 1px solid #FFB6A6; color: #1a3d2e; font-size: 0.75rem; white-space: pre-wrap; word-break: break-word; max-width: 280px;">
                            {{ $draw->description ?: '—' }}
                        </td>
                        <td style="padding: 0.15rem 0.5rem; border: 1px solid #FFB6A6; text-align: center;">
                            <form method="POST" action="{{ route('lottery.results.destroy', $draw->id) }}" style="margin: 0;"
                                  onsubmit="return confirm({{ json_encode('Remove ' . $draw->display_label . '?') }});">
                                @csrf
                                <button type="submit" class="btn btn-danger">Remove</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" style="padding: 0.75rem 0.5rem; text-align: center; color: #1a3d2e; background-color: #FFF8F0; border: 1px solid #FFB6A6; font-size: 0.75rem;">
                            No lottery results available yet. Click <strong>+ Upload Result</strong> above to add one.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if($draws->hasPages())
    <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 1rem; gap: 0.75rem; flex-wrap: wrap; font-size: 0.875rem; color: #1a3d2e;">
        <div>
            Showing {{ $draws->firstItem() }}–{{ $draws->lastItem() }} of {{ $draws->total() }}
        </div>
        <div style="display: flex; gap: 0.35rem; flex-wrap: wrap; align-items: center;">
            @if($draws->onFirstPage())
                <span class="btn btn-secondary" style="opacity: 0.5; cursor: default;">Previous</span>
            @else
                <a href="{{ $draws->previousPageUrl() }}" class="btn btn-secondary">Previous</a>
            @endif

            @foreach($draws->getUrlRange(max(1, $draws->currentPage() - 2), min($draws->lastPage(), $draws->currentPage() + 2)) as $page => $url)
                @if($page == $draws->currentPage())
                    <span class="btn btn-primary" style="cursor: default;">{{ $page }}</span>
                @else
                    <a href="{{ $url }}" class="btn btn-secondary">{{ $page }}</a>
                @endif
            @endforeach

            @if($draws->hasMorePages())
                <a href="{{ $draws->nextPageUrl() }}" class="btn btn-secondary">Next</a>
            @else
                <span class="btn btn-secondary" style="opacity: 0.5; cursor: default;">Next</span>
            @endif
        </div>
    </div>
    @endif
</div>

<!-- Upload Modal -->
<div id="upload-modal" style="display: none; position: fixed; inset: 0; z-index: 50; align-items: center; justify-content: center; background-color: rgba(0,0,0,0.5); padding: 1rem;">
    <div style="background: #ffffff; border-radius: 0.5rem; box-shadow: 0 20px 25px rgba(0,0,0,0.15); width: 100%; max-width: 28rem;">
        <div style="display: flex; align-items: center; justify-content: space-between; padding: 1rem 1.5rem; border-bottom: 1px solid #e5e7eb;">
            <h2 style="font-size: 1.125rem; font-weight: 600; color: #111827; margin: 0;">Upload Lottery Result</h2>
            <button id="close-modal" type="button" style="color: #6b7280; font-size: 1.5rem; line-height: 1; border: none; background: none; cursor: pointer;">&times;</button>
        </div>
        <form id="upload-form" style="padding: 1.5rem;" enctype="multipart/form-data">
            @csrf
            <div style="margin-bottom: 1rem;">
                <label for="lottery_name" style="display: block; font-size: 0.875rem; font-weight: 500; color: #374151; margin-bottom: 0.25rem;">Lottery Name</label>
                <select id="lottery_name" name="lottery_name" required
                        style="width: 100%; padding: 0.5rem 0.75rem; border: 1px solid #d1d5db; border-radius: 0.5rem; box-sizing: border-box; background: #fff;">
                    <option value="">Select lottery</option>
                    @foreach($lotteries as $lottery)
                        <option value="{{ $lottery->name }}" data-next-code="{{ $nextDrawCodes[$lottery->name] ?? '' }}">{{ $lottery->name }}</option>
                    @endforeach
                </select>
            </div>
            <div style="margin-bottom: 1rem;">
                <label for="draw_code" style="display: block; font-size: 0.875rem; font-weight: 500; color: #374151; margin-bottom: 0.25rem;">Draw Code</label>
                <input type="text" id="draw_code" name="draw_code" required
                       placeholder="e.g. SS-534"
                       style="width: 100%; padding: 0.5rem 0.75rem; border: 1px solid #d1d5db; border-radius: 0.5rem; box-sizing: border-box;">
            </div>
            <div style="margin-bottom: 1rem;">
                <label for="draw_date" style="display: block; font-size: 0.875rem; font-weight: 500; color: #374151; margin-bottom: 0.25rem;">Draw Date</label>
                <input type="date" id="draw_date" name="draw_date" required
                       style="width: 100%; padding: 0.5rem 0.75rem; border: 1px solid #d1d5db; border-radius: 0.5rem; box-sizing: border-box;">
            </div>
            <div style="margin-bottom: 1rem;">
                <label for="status" style="display: block; font-size: 0.875rem; font-weight: 500; color: #374151; margin-bottom: 0.25rem;">Status</label>
                <select id="status" name="status" required
                        style="width: 100%; padding: 0.5rem 0.75rem; border: 1px solid #d1d5db; border-radius: 0.5rem; box-sizing: border-box; background: #fff;">
                    <option value="Live" selected>Live</option>
                    <option value="official">official</option>
                    <option value="-">-</option>
                </select>
            </div>
            <div style="margin-bottom: 1rem;">
                <label for="description" style="display: block; font-size: 0.875rem; font-weight: 500; color: #374151; margin-bottom: 0.25rem;">Description</label>
                <div style="display: flex; gap: 0.5rem; align-items: flex-start;">
                    <textarea id="description" name="description" rows="6"
                              placeholder="Enter a full description or paragraph..."
                              style="flex: 1; padding: 0.5rem 0.75rem; border: 1px solid #d1d5db; border-radius: 0.5rem; box-sizing: border-box; resize: vertical; font-family: inherit;"></textarea>
                    <button type="button" id="description-from-file" class="btn btn-secondary" title="Load description from a text file">
                        From TXT
                    </button>
                    <input type="file" id="description-file" accept=".txt,text/plain" style="display: none;">
                </div>
            </div>
            <div style="margin-bottom: 1rem;">
                <label for="file" style="display: block; font-size: 0.875rem; font-weight: 500; color: #374151; margin-bottom: 0.25rem;">Result File (PDF, Image, TXT, or HTM) — optional</label>
                <input type="file" id="file" name="file" accept=".pdf,.jpg,.jpeg,.png,.txt,.htm,.html"
                       style="width: 100%; padding: 0.5rem 0.75rem; border: 1px solid #d1d5db; border-radius: 0.5rem; box-sizing: border-box;">
            </div>
            <div id="upload-error" style="display: none; font-size: 0.875rem; color: #dc2626; margin-bottom: 0.5rem;"></div>
            <div id="upload-success" style="display: none; font-size: 0.875rem; color: #16a34a; margin-bottom: 0.5rem;"></div>
            <div style="display: flex; gap: 0.75rem; padding-top: 0.5rem;">
                <button type="submit" id="submit-upload" class="btn btn-primary" style="flex: 1;">
                    Upload
                </button>
                <button type="button" id="cancel-upload" class="btn btn-secondary" style="flex: 1;">
                    Cancel
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Manage Lotteries Modal --}}
<div id="lottery-modal" style="display: none; position: fixed; inset: 0; z-index: 50; align-items: center; justify-content: center; background-color: rgba(0,0,0,0.5); padding: 1rem;">
    <div style="background: #ffffff; border-radius: 0.5rem; box-shadow: 0 20px 25px rgba(0,0,0,0.15); width: 100%; max-width: 32rem; max-height: 90vh; overflow: auto;">
        <div style="display: flex; align-items: center; justify-content: space-between; padding: 1rem 1.5rem; border-bottom: 1px solid #e5e7eb;">
            <h2 style="font-size: 1.125rem; font-weight: 600; color: #111827; margin: 0;">Manage Lotteries</h2>
            <button id="close-lottery-modal" type="button" style="color: #6b7280; font-size: 1.5rem; line-height: 1; border: none; background: none; cursor: pointer;">&times;</button>
        </div>
        <div style="padding: 1.5rem;">
            <form id="lottery-form" style="display: flex; gap: 0.5rem; margin-bottom: 1rem; align-items: flex-end;">
                <input type="hidden" id="lottery-edit-id" value="">
                <div style="flex: 1;">
                    <label for="lottery-name-input" style="display: block; font-size: 0.875rem; font-weight: 500; color: #374151; margin-bottom: 0.25rem;">Lottery Name</label>
                    <input type="text" id="lottery-name-input" required
                           placeholder="e.g. DHANALEKSHMI"
                           style="width: 100%; padding: 0.5rem 0.75rem; border: 1px solid #d1d5db; border-radius: 0.5rem; box-sizing: border-box;">
                </div>
                <button type="submit" id="lottery-save-btn" class="btn btn-primary">Add</button>
                <button type="button" id="lottery-cancel-edit" class="btn btn-secondary" style="display: none;">Cancel</button>
            </form>
            <div id="lottery-error" style="display: none; font-size: 0.875rem; color: #dc2626; margin-bottom: 0.75rem;"></div>
            <div id="lottery-success" style="display: none; font-size: 0.875rem; color: #16a34a; margin-bottom: 0.75rem;"></div>
            <div style="border: 1px solid #e5e7eb; border-radius: 0.5rem; overflow: hidden;">
                <table class="w-full border-collapse" style="font-size: 0.8125rem;">
                    <thead>
                        <tr style="background: #f3f4f6;">
                            <th style="padding: 0.5rem 0.75rem; text-align: left; border-bottom: 1px solid #e5e7eb;">Name</th>
                            <th style="padding: 0.5rem 0.75rem; text-align: center; border-bottom: 1px solid #e5e7eb; width: 9rem;">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="lottery-table-body">
                        @forelse($lotteries as $lottery)
                        <tr data-id="{{ $lottery->id }}" data-name="{{ $lottery->name }}">
                            <td style="padding: 0.5rem 0.75rem; border-bottom: 1px solid #e5e7eb; color: #1a3d2e; font-weight: 500;">{{ $lottery->name }}</td>
                            <td style="padding: 0.5rem 0.75rem; border-bottom: 1px solid #e5e7eb; text-align: center;">
                                <button type="button" class="btn btn-secondary lottery-edit-btn" style="margin-right: 0.25rem;">Edit</button>
                                <button type="button" class="btn btn-danger lottery-delete-btn">Remove</button>
                            </td>
                        </tr>
                        @empty
                        <tr id="lottery-empty-row">
                            <td colspan="2" style="padding: 0.75rem; text-align: center; color: #6b7280;">No lotteries yet. Add one above.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('upload-modal');
    const uploadBtn = document.getElementById('upload-btn');
    const closeModal = document.getElementById('close-modal');
    const cancelUpload = document.getElementById('cancel-upload');
    const uploadForm = document.getElementById('upload-form');
    const uploadError = document.getElementById('upload-error');
    const uploadSuccess = document.getElementById('upload-success');
    const submitBtn = document.getElementById('submit-upload');
    const lotteryNameSelect = document.getElementById('lottery_name');
    const drawCodeInput = document.getElementById('draw_code');
    const nextDrawCodes = @json($nextDrawCodes);

    function fillNextDrawCode() {
        const option = lotteryNameSelect.options[lotteryNameSelect.selectedIndex];
        const name = lotteryNameSelect.value;
        let next = '';
        if (option && option.getAttribute('data-next-code')) {
            next = option.getAttribute('data-next-code');
        } else if (name && nextDrawCodes[name]) {
            next = nextDrawCodes[name];
        }
        drawCodeInput.value = next || '';
    }

    lotteryNameSelect.addEventListener('change', fillNextDrawCode);

    function openModal() {
        modal.style.display = 'flex';
        uploadError.style.display = 'none';
        uploadSuccess.style.display = 'none';
        fillNextDrawCode();
    }

    function closeModalFn() {
        modal.style.display = 'none';
        uploadForm.reset();
        uploadError.style.display = 'none';
        uploadSuccess.style.display = 'none';
    }

    uploadBtn.addEventListener('click', openModal);
    closeModal.addEventListener('click', closeModalFn);
    cancelUpload.addEventListener('click', closeModalFn);
    modal.addEventListener('click', function(e) {
        if (e.target === modal) closeModalFn();
    });

    const descriptionInput = document.getElementById('description');
    const descriptionFromFileBtn = document.getElementById('description-from-file');
    const descriptionFileInput = document.getElementById('description-file');

    descriptionFromFileBtn.addEventListener('click', function() {
        descriptionFileInput.click();
    });

    descriptionFileInput.addEventListener('change', function() {
        const file = descriptionFileInput.files && descriptionFileInput.files[0];
        if (!file) return;

        const reader = new FileReader();
        reader.onload = function(e) {
            descriptionInput.value = (e.target.result || '').toString();
        };
        reader.onerror = function() {
            uploadError.textContent = 'Could not read the text file.';
            uploadError.style.display = 'block';
        };
        reader.readAsText(file);
        descriptionFileInput.value = '';
    });

    uploadForm.addEventListener('submit', function(e) {
        e.preventDefault();
        uploadError.style.display = 'none';
        uploadSuccess.style.display = 'none';
        submitBtn.disabled = true;
        submitBtn.textContent = 'Uploading...';
        submitBtn.style.opacity = '0.7';

        const formData = new FormData(uploadForm);

        fetch('{{ route("lottery.results.upload") }}', {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: formData
        })
        .then(response => response.json().then(data => ({ status: response.status, data })))
        .then(({ status, data }) => {
            if (status >= 200 && status < 300 && data.success) {
                uploadSuccess.textContent = data.message || 'Uploaded successfully!';
                uploadSuccess.style.display = 'block';
                setTimeout(() => window.location.reload(), 800);
            } else {
                let message = data.message || 'Upload failed.';
                if (data.errors) {
                    message = Object.values(data.errors).flat().join(' ');
                }
                uploadError.textContent = message;
                uploadError.style.display = 'block';
            }
        })
        .catch(() => {
            uploadError.textContent = 'Network error. Please try again.';
            uploadError.style.display = 'block';
        })
        .finally(() => {
            submitBtn.disabled = false;
            submitBtn.textContent = 'Upload';
            submitBtn.style.opacity = '1';
        });
    });

    // --- Lottery CRUD ---
    const lotteryModal = document.getElementById('lottery-modal');
    const lotteryBtn = document.getElementById('lottery-btn');
    const closeLotteryModal = document.getElementById('close-lottery-modal');
    const lotteryForm = document.getElementById('lottery-form');
    const lotteryEditId = document.getElementById('lottery-edit-id');
    const lotteryNameInput = document.getElementById('lottery-name-input');
    const lotterySaveBtn = document.getElementById('lottery-save-btn');
    const lotteryCancelEdit = document.getElementById('lottery-cancel-edit');
    const lotteryError = document.getElementById('lottery-error');
    const lotterySuccess = document.getElementById('lottery-success');
    const lotteryTableBody = document.getElementById('lottery-table-body');
    const csrfToken = '{{ csrf_token() }}';

    function openLotteryModal() {
        lotteryModal.style.display = 'flex';
        resetLotteryForm();
        lotteryError.style.display = 'none';
        lotterySuccess.style.display = 'none';
    }

    function closeLotteryModalFn() {
        lotteryModal.style.display = 'none';
        resetLotteryForm();
        lotteryError.style.display = 'none';
        lotterySuccess.style.display = 'none';
    }

    function resetLotteryForm() {
        lotteryEditId.value = '';
        lotteryNameInput.value = '';
        lotterySaveBtn.textContent = 'Add';
        lotteryCancelEdit.style.display = 'none';
    }

    function showLotteryError(message) {
        lotterySuccess.style.display = 'none';
        lotteryError.textContent = message;
        lotteryError.style.display = 'block';
    }

    function showLotterySuccess(message) {
        lotteryError.style.display = 'none';
        lotterySuccess.textContent = message;
        lotterySuccess.style.display = 'block';
    }

    function syncLotterySelect() {
        const selected = lotteryNameSelect.value;
        const names = Array.from(lotteryTableBody.querySelectorAll('tr[data-id]'))
            .map(row => row.getAttribute('data-name'))
            .filter(Boolean)
            .sort();

        lotteryNameSelect.innerHTML = '<option value="">Select lottery</option>';
        names.forEach(function(name) {
            const option = document.createElement('option');
            option.value = name;
            option.textContent = name;
            option.setAttribute('data-next-code', nextDrawCodes[name] || '');
            if (name === selected) option.selected = true;
            lotteryNameSelect.appendChild(option);
        });
        fillNextDrawCode();
    }

    function buildLotteryRow(lottery) {
        const tr = document.createElement('tr');
        tr.setAttribute('data-id', lottery.id);
        tr.setAttribute('data-name', lottery.name);
        tr.innerHTML =
            '<td style="padding: 0.5rem 0.75rem; border-bottom: 1px solid #e5e7eb; color: #1a3d2e; font-weight: 500;"></td>' +
            '<td style="padding: 0.5rem 0.75rem; border-bottom: 1px solid #e5e7eb; text-align: center;">' +
            '<button type="button" class="btn btn-secondary lottery-edit-btn" style="margin-right: 0.25rem;">Edit</button>' +
            '<button type="button" class="btn btn-danger lottery-delete-btn">Remove</button>' +
            '</td>';
        tr.children[0].textContent = lottery.name;
        return tr;
    }

    function removeEmptyRow() {
        const empty = document.getElementById('lottery-empty-row');
        if (empty) empty.remove();
    }

    function ensureEmptyRow() {
        if (lotteryTableBody.querySelectorAll('tr[data-id]').length === 0) {
            lotteryTableBody.innerHTML =
                '<tr id="lottery-empty-row"><td colspan="2" style="padding: 0.75rem; text-align: center; color: #6b7280;">No lotteries yet. Add one above.</td></tr>';
        }
    }

    lotteryBtn.addEventListener('click', openLotteryModal);
    closeLotteryModal.addEventListener('click', closeLotteryModalFn);
    lotteryModal.addEventListener('click', function(e) {
        if (e.target === lotteryModal) closeLotteryModalFn();
    });
    lotteryCancelEdit.addEventListener('click', resetLotteryForm);

    lotteryForm.addEventListener('submit', function(e) {
        e.preventDefault();
        lotteryError.style.display = 'none';
        lotterySuccess.style.display = 'none';

        const name = lotteryNameInput.value.trim();
        if (!name) {
            showLotteryError('Lottery name is required.');
            return;
        }

        const editId = lotteryEditId.value;
        const isEdit = !!editId;
        const url = isEdit
            ? '{{ url("/lottery/lotteries") }}/' + editId
            : '{{ route("lottery.lotteries.store") }}';

        lotterySaveBtn.disabled = true;

        fetch(url, {
            method: isEdit ? 'PUT' : 'POST',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'X-HTTP-Method-Override': isEdit ? 'PUT' : 'POST'
            },
            body: JSON.stringify({ name: name })
        })
        .then(response => response.json().then(data => ({ status: response.status, data })))
        .then(({ status, data }) => {
            if (status >= 200 && status < 300 && data.success) {
                const lottery = data.data;
                if (isEdit) {
                    const row = lotteryTableBody.querySelector('tr[data-id="' + editId + '"]');
                    if (row) {
                        const oldName = row.getAttribute('data-name');
                        if (oldName && oldName !== lottery.name && Object.prototype.hasOwnProperty.call(nextDrawCodes, oldName)) {
                            nextDrawCodes[lottery.name] = nextDrawCodes[oldName];
                            delete nextDrawCodes[oldName];
                        }
                        row.setAttribute('data-name', lottery.name);
                        row.children[0].textContent = lottery.name;
                    }
                } else {
                    removeEmptyRow();
                    lotteryTableBody.appendChild(buildLotteryRow(lottery));
                    nextDrawCodes[lottery.name] = nextDrawCodes[lottery.name] || '';
                }
                syncLotterySelect();
                resetLotteryForm();
                showLotterySuccess(data.message || (isEdit ? 'Updated.' : 'Added.'));
            } else {
                let message = data.message || 'Save failed.';
                if (data.errors) {
                    message = Object.values(data.errors).flat().join(' ');
                }
                showLotteryError(message);
            }
        })
        .catch(() => showLotteryError('Network error. Please try again.'))
        .finally(() => { lotterySaveBtn.disabled = false; });
    });

    lotteryTableBody.addEventListener('click', function(e) {
        const editBtn = e.target.closest('.lottery-edit-btn');
        const deleteBtn = e.target.closest('.lottery-delete-btn');
        const row = e.target.closest('tr[data-id]');
        if (!row) return;

        const id = row.getAttribute('data-id');
        const name = row.getAttribute('data-name');

        if (editBtn) {
            lotteryEditId.value = id;
            lotteryNameInput.value = name;
            lotterySaveBtn.textContent = 'Save';
            lotteryCancelEdit.style.display = 'inline-block';
            lotteryNameInput.focus();
            return;
        }

        if (deleteBtn) {
            if (!confirm('Remove lottery "' + name + '"?')) return;

            fetch('{{ url("/lottery/lotteries") }}/' + id, {
                method: 'DELETE',
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                }
            })
            .then(response => response.json().then(data => ({ status: response.status, data })))
            .then(({ status, data }) => {
                if (status >= 200 && status < 300 && data.success) {
                    if (lotteryEditId.value === id) resetLotteryForm();
                    delete nextDrawCodes[name];
                    row.remove();
                    ensureEmptyRow();
                    syncLotterySelect();
                    showLotterySuccess(data.message || 'Removed.');
                } else {
                    showLotteryError(data.message || 'Remove failed.');
                }
            })
            .catch(() => showLotteryError('Network error. Please try again.'));
        }
    });
});
</script>
@endsection
