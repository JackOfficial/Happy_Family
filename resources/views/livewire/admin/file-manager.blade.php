<div class="file-manager-wrapper" x-data="{ 
    showModal: false, 
    isDragging: false,
    selectedCount: @entangle('selectedFiles').live 
}" x-cloak>
    
    <div class="mx-3">
        <div class="d-flex justify-content-between align-items-center mb-4 bg-white p-3 rounded shadow-sm border">
            <div>
                <select wire:model.live="modelFilter" class="form-control form-control-sm d-inline-block" style="width: auto;">
                    <option value="all">All Files</option>
                    <option value="App\Models\Project">Projects</option>
                    <option value="App\Models\Team">Team Assets</option>
                </select>
                <span class="ml-2 text-muted small"><strong>{{ $totalCount }}</strong> items</span>
            </div>

            <div class="d-flex align-items-center">
                <template x-if="selectedCount && selectedCount.length > 0">
                    <button wire:click="deleteSelected" wire:confirm="Are you sure?" class="btn btn-sm btn-outline-danger mr-2">
                        Delete (<span x-text="selectedCount.length"></span>)
                    </button>
                </template>
                
                <button class="btn btn-sm btn-primary" @click="showModal = true; $wire.set('editingFileId', null)">
                    <i class="fas fa-plus"></i> Upload File
                </button>
            </div>
        </div>

        <div class="row">
            @forelse($fileGroups as $type => $files)
                <div class="col-12 mt-3"><h6 class="text-muted">{{ class_basename($type) }}</h6><hr></div>
                @foreach($files as $file)
                    <div class="col-md-2 mb-3" wire:key="file-{{ $file->id }}">
                        <div class="card shadow-sm h-100 {{ in_array($file->id, $selectedFiles) ? 'border-primary' : '' }}">
                            <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 120px; overflow: hidden;">
                                @if($file->is_image)
                                    <img src="{{ asset('storage/' . $file->file_path) }}" class="img-fluid">
                                @else
                                    <i class="fas {{ $file->icon_data['icon'] }} fa-3x text-secondary"></i>
                                @endif
                            </div>
                            <div class="card-footer p-2 d-flex align-items-center">
                                <input type="checkbox" wire:model.live="selectedFiles" value="{{ $file->id }}" class="mr-2">
                                <small class="text-truncate">{{ $file->caption }}</small>
                            </div>
                        </div>
                    </div>
                @endforeach
            @empty
                <div class="col-12 text-center py-5">No files found.</div>
            @endforelse
        </div>

        <div x-show="showModal" 
             class="modal d-block" 
             style="background: rgba(0,0,0,0.6); z-index: 1050;"
             @keydown.escape.window="showModal = false">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <form wire:submit.prevent="save">
                        <div class="modal-header">
                            <h5 class="modal-title">File Details</h5>
                            <button type="button" class="close" @click="showModal = false">&times;</button>
                        </div>
                        <div class="modal-body">
                            @if(!$editingFileId)
                                <div class="form-group">
                                    <label>File</label>
                                    <input type="file" wire:model="file" class="form-control-file">
                                    <div wire:loading wire:target="file" class="text-primary mt-1">Uploading...</div>
                                </div>
                            @endif
                            <div class="form-group">
                                <label>Caption</label>
                                <input type="text" wire:model="caption" class="form-control">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" @click="showModal = false">Close</button>
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>