<div>
    <div class="file-manager-container mx-3" 
         x-data="{ 
            showModal: false, 
            isDragging: false,
            selectedCount: @entangle('selectedFiles').live.count 
         }"
         @hide-file-modal.window="showModal = false"
         @show-file-modal.window="showModal = true"
         x-cloak>

        <div class="d-flex justify-content-between align-items-center mb-4 bg-white p-3 rounded shadow-sm border">
            <div class="d-flex align-items-center gap-3">
                <div class="filter-group d-flex align-items-center bg-light px-3 py-1 rounded-pill border">
                    <i class="fas fa-filter text-muted mr-2 small"></i>
                    <select wire:model.live="modelFilter" class="form-control-plaintext form-control-sm font-weight-bold" style="width: 150px;">
                        <option value="all">All Files</option>
                        <option value="App\Models\Project">Projects</option>
                        <option value="App\Models\Team">Team Assets</option>
                        <option value="App\Models\Event">Event Media</option>
                    </select>
                </div>
                <span class="text-muted small border-left pl-3">
                    <strong class="text-dark">{{ $totalCount }}</strong> items
                </span>
            </div>

            <div class="actions d-flex gap-2">
                <template x-if="selectedCount > 0">
                    <button wire:click="deleteSelected" wire:confirm="Delete items?" class="btn btn-sm btn-outline-danger px-3 rounded-pill transition-all">
                        <i class="fas fa-trash mr-1"></i> Delete (<span x-text="selectedCount"></span>)
                    </button>
                </template>
                
                <button class="btn btn-sm btn-primary px-4 rounded-pill shadow-sm" @click="showModal = true; $wire.set('editingFileId', null)">
                    <i class="fas fa-cloud-upload-alt mr-1"></i> Upload File
                </button>
            </div>
        </div>

        @if($fileGroups->isEmpty())
            <div class="text-center py-5 bg-white rounded border shadow-sm">
                <img src="https://cdn-icons-png.flaticon.com/512/4076/4076432.png" style="width: 80px; opacity: 0.3;">
                <p class="mt-3 text-muted">No files found.</p>
            </div>
        @else
            @foreach($fileGroups as $type => $files)
                <div class="mb-5" wire:key="group-{{ Str::slug($type) }}">
                    <div class="d-flex align-items-center mb-3">
                        <h6 class="text-uppercase font-weight-bold text-secondary mb-0 tracking-wider" style="font-size: 0.75rem;">
                            {{ class_basename($type) }}
                        </h6>
                        <div class="flex-grow-1 ml-3 border-top opacity-50"></div>
                    </div>

                    <div class="row row-cols-2 row-cols-md-4 row-cols-lg-6 g-3">
                        @foreach($files as $file)
                            <div class="col mb-3" wire:key="file-{{ $file->id }}">
                                <div class="card h-100 file-card border-0 shadow-sm position-relative"
                                     :class="{ 'selected-card': @js(in_array($file->id, $selectedFiles)) }">
                                    
                                    <div class="file-selection">
                                        <input type="checkbox" wire:model.live="selectedFiles" value="{{ $file->id }}" class="custom-checkbox">
                                    </div>

                                    <div class="file-preview bg-light d-flex align-items-center justify-content-center">
                                        @if($file->is_image)
                                            <img src="{{ asset('storage/' . $file->file_path) }}" class="img-fluid file-thumb rounded-top">
                                        @else
                                            <div class="text-center py-4">
                                                <i class="fas {{ $file->icon_data['icon'] }} {{ $file->icon_data['color'] }} fa-3x"></i>
                                            </div>
                                        @endif
                                        
                                        <div class="file-overlay rounded-top">
                                            <div class="d-flex gap-1">
                                                <a href="{{ asset('storage/' . $file->file_path) }}" target="_blank" class="btn btn-xs btn-light shadow-sm"><i class="fas fa-eye"></i></a>
                                                <button wire:click="edit({{ $file->id }})" class="btn btn-xs btn-light shadow-sm"><i class="fas fa-pen"></i></button>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card-body p-2 border-top bg-white">
                                        <p class="file-name text-truncate mb-0 small" title="{{ $file->caption }}">
                                            {{ $file->caption }}
                                        </p>
                                        <div class="d-flex justify-content-between align-items-center mt-1">
                                            <span class="file-meta text-muted text-uppercase" style="font-size: 0.6rem;">{{ $file->extension }}</span>
                                            <span class="file-meta text-muted" style="font-size: 0.6rem;">{{ $file->created_at->format('d M') }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        @endif

        <div x-show="showModal" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100"
             class="modal d-block shadow-lg" 
             style="background: rgba(0,0,0,0.5)"
             @click.self="showModal = false"
             tabindex="-1">
            
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border-0 overflow-hidden" @click.stop>
                    <form wire:submit.prevent="save">
                        <div class="modal-header border-0 bg-primary text-white py-3">
                            <h6 class="modal-title font-weight-bold">{{ $editingFileId ? 'Edit File Details' : 'Upload New Media' }}</h6>
                            <button type="button" class="close text-white outline-none" @click="showModal = false">&times;</button>
                        </div>
                        
                        <div class="modal-body p-4">
                            @if(!$editingFileId)
                                <div class="upload-zone border-dashed text-center p-5 rounded transition-all"
                                     :class="isDragging ? 'bg-primary-subtle border-primary' : 'bg-light'"
                                     @dragover.prevent="isDragging = true"
                                     @dragleave.prevent="isDragging = false"
                                     @drop.prevent="isDragging = false"
                                     onclick="document.getElementById('fileInput').click()" 
                                     style="cursor: pointer;">
                                    
                                    <i class="fas fa-cloud-upload-alt fa-3x text-primary mb-3"></i>
                                    <p class="mb-1 text-dark font-weight-bold">Drop your file here</p>
                                    <p class="small text-muted mb-0">or click to browse from device</p>
                                    
                                    <input type="file" wire:model="file" class="d-none" id="fileInput">
                                    
                                    <div wire:loading wire:target="file" class="mt-3 text-primary small">
                                        <div class="spinner-border spinner-border-sm mr-2" role="status"></div>
                                        Uploading to server...
                                    </div>
                                </div>
                                @error('file') <span class="text-danger x-small d-block mt-2">{{ $message }}</span> @enderror
                            @endif

                            <div class="form-group mt-3">
                                <label class="x-small font-weight-bold text-uppercase text-muted">File Label / Caption</label>
                                <input type="text" wire:model="caption" class="form-control border-0 bg-light rounded shadow-none" placeholder="Give this file a name...">
                            </div>
                        </div>

                        <div class="modal-footer border-0 bg-light py-2">
                            <button type="button" class="btn btn-sm btn-link text-muted" @click="showModal = false">Cancel</button>
                            <button type="submit" class="btn btn-sm btn-primary px-4 rounded-pill shadow-sm" wire:loading.attr="disabled">
                                <span wire:loading.remove wire:target="save">{{ $editingFileId ? 'Save Changes' : 'Start Upload' }}</span>
                                <span wire:loading wire:target="save">Saving...</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>