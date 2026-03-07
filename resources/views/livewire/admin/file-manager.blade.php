<div class="file-manager-container mx-3">
    <div class="d-flex justify-content-between align-items-center mb-4 bg-white p-3 rounded shadow-sm border">
        <div class="d-flex align-items-center gap-3">
            <div class="filter-group d-flex align-items-center bg-light px-3 py-1 rounded-pill border">
                <i class="fas fa-search text-muted mr-2"></i>
                <select wire:model.live="modelFilter" class="form-control-plaintext form-control-sm font-weight-bold" style="width: 150px;">
                    <option value="all">All Files</option>
                    <option value="App\Models\Project">Projects</option>
                    <option value="App\Models\Team">Team Assets</option>
                    <option value="App\Models\Event">Event Media</option>
                </select>
            </div>
            <span class="text-muted small border-left pl-3">
                <strong class="text-dark">{{ $totalCount }}</strong> items stored
            </span>
        </div>

        <div class="actions d-flex gap-2">
            @if(count($selectedFiles) > 0)
                <button wire:click="deleteSelected" wire:confirm="Delete {{ count($selectedFiles) }} items?" class="btn btn-sm btn-outline-danger px-3 rounded-pill">
                    <i class="fas fa-trash mr-1"></i> Delete
                </button>
            @endif
            <button class="btn btn-sm btn-primary px-4 rounded-pill shadow-sm" data-toggle="modal" data-target="#fileModal" wire:click="$set('editingFileId', null)">
                <i class="fas fa-cloud-upload-alt mr-1"></i> Upload File
            </button>
        </div>
    </div>

    @if($fileGroups->isEmpty())
        <div class="text-center py-5 bg-white rounded border shadow-sm">
            <img src="https://cdn-icons-png.flaticon.com/512/4076/4076432.png" style="width: 120px; opacity: 0.5;">
            <h5 class="mt-3 text-muted">No files found in this category</h5>
        </div>
    @else
        @foreach($fileGroups as $type => $files)
            <div class="mb-5">
                <div class="d-flex align-items-center mb-3">
                    <h6 class="text-uppercase font-weight-bold text-secondary mb-0 tracking-wider" style="font-size: 0.8rem;">
                        {{ class_basename($type) }}
                    </h6>
                    <div class="flex-grow-1 ml-3 border-top"></div>
                </div>

                <div class="row row-cols-2 row-cols-md-4 row-cols-lg-6 g-3">
                    @foreach($files as $file)
                        <div class="col mb-3">
                            <div class="card h-100 file-card border-0 shadow-sm {{ in_array($file->id, $selectedFiles) ? 'selected' : '' }}">
                                <div class="file-selection">
                                    <input type="checkbox" wire:model.live="selectedFiles" value="{{ $file->id }}">
                                </div>

                                <div class="file-preview bg-light d-flex align-items-center justify-content-center position-relative">
                                    @if($file->is_image)
                                        <img src="{{ asset('storage/' . $file->file_path) }}" class="img-fluid file-thumb">
                                    @else
                                        <div class="text-center">
                                            <i class="fas {{ $file->icon_data['icon'] }} {{ $file->icon_data['color'] }} fa-3x"></i>
                                        </div>
                                    @endif
                                    
                                    <div class="file-overlay">
                                        <div class="d-flex gap-1">
                                            <a href="{{ asset('storage/' . $file->file_path) }}" target="_blank" class="btn btn-xs btn-light shadow-sm"><i class="fas fa-eye"></i></a>
                                            <button wire:click="edit({{ $file->id }})" class="btn btn-xs btn-light shadow-sm"><i class="fas fa-pen"></i></button>
                                        </div>
                                    </div>
                                </div>

                                <div class="card-body p-2">
                                    <p class="file-name text-truncate mb-0" title="{{ $file->caption }}">
                                        {{ $file->caption }}
                                    </p>
                                    <span class="file-meta text-muted text-uppercase">{{ $file->extension }} • {{ $file->created_at->format('d M') }}</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    @endif

    <div wire:ignore.self class="modal fade" id="fileModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg">
                <form wire:submit.prevent="save">
                    <div class="modal-header border-0 bg-primary text-white">
                        <h5 class="modal-title font-weight-light">{{ $editingFileId ? 'Edit File Details' : 'Upload New Media' }}</h5>
                        <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body p-4">
                        @if(!$editingFileId)
                            <div class="upload-zone border-dashed text-center p-4 rounded mb-3 bg-light" 
                                 onclick="document.getElementById('fileInput').click()" style="cursor: pointer;">
                                <i class="fas fa-cloud-upload-alt fa-3x text-primary mb-2"></i>
                                <p class="mb-0 text-muted">Click to browse or drag your file here</p>
                                <input type="file" wire:model="file" class="d-none" id="fileInput">
                                <div wire:loading wire:target="file" class="mt-2 text-primary small">
                                    <i class="fas fa-spinner fa-spin mr-1"></i> Processing...
                                </div>
                            </div>
                            @error('file') <span class="text-danger small d-block mb-3">{{ $message }}</span> @enderror
                        @endif

                        <div class="form-group">
                            <label class="small font-weight-bold">Label / Caption</label>
                            <input type="text" wire:model="caption" class="form-control form-control-sm border-0 bg-light rounded" placeholder="e.g. Annual Report 2026">
                        </div>
                    </div>
                    <div class="modal-footer border-0">
                        <button type="button" class="btn btn-link text-muted" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary px-4 rounded-pill" wire:loading.attr="disabled">
                            {{ $editingFileId ? 'Update' : 'Upload' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <style>
        .file-card { transition: all 0.2s; border-radius: 10px; overflow: hidden; }
        .file-card:hover { transform: translateY(-3px); box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important; }
        .file-card.selected { border: 2px solid #007bff !important; background: #f0f7ff; }
        
        .file-preview { height: 130px; border-bottom: 1px solid #f1f1f1; }
        .file-thumb { height: 100%; width: 100%; object-fit: cover; }
        
        .file-overlay {
            position: absolute; inset: 0; background: rgba(0,0,0,0.2); 
            display: flex; align-items: center; justify-content: center; opacity: 0; transition: 0.2s;
        }
        .file-card:hover .file-overlay { opacity: 1; }
        
        .file-selection { position: absolute; top: 8px; left: 8px; z-index: 10; }
        .file-name { font-size: 0.85rem; font-weight: 600; color: #333; }
        .file-meta { font-size: 0.65rem; letter-spacing: 0.5px; }
        
        .btn-xs { padding: 2px 8px; font-size: 0.75rem; }
        .border-dashed { border: 2px dashed #dee2e6; }
        .tracking-wider { letter-spacing: 1px; }
    </style>

    <script>
        document.addEventListener('livewire:init', () => {
           Livewire.on('hide-file-modal', () => {
               $('#fileModal').modal('hide');
           });
           Livewire.on('show-file-modal', () => {
               $('#fileModal').modal('show');
           });
        });
    </script>
</div>