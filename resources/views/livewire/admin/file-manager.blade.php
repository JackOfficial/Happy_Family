<div class="file-manager-wrapper" 
     x-data="{ 
        showModal: false, 
        isDragging: false,
        selectedCount: @entangle('selectedFiles').live 
     }" 
     @show-file-modal.window="showModal = true"
     @hide-file-modal.window="showModal = false"
     x-cloak>

    <div class="container-fluid px-3">
        <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 bg-white p-3 rounded-lg shadow-sm border-0 gap-3">
            <div class="d-flex align-items-center gap-2">
                <div class="input-group input-group-sm" style="width: 250px;">
                    <div class="input-group-prepend">
                        <span class="input-group-text bg-light border-0"><i class="fas fa-search text-muted"></i></span>
                    </div>
                    <input type="text" wire:model.live.debounce.300ms="search" class="form-control border-0 bg-light" placeholder="Search assets...">
                </div>

                <select wire:model.live="modelFilter" class="form-control form-control-sm border-0 bg-light font-weight-bold ml-2" style="width: 150px;">
                    <option value="all">All Types</option>
                    <option value="App\Models\Project">Projects</option>
                    <option value="App\Models\Team">Team Assets</option>
                </select>
            </div>

            <div class="actions d-flex align-items-center">
                <template x-if="selectedCount && selectedCount.length > 0">
                    <button wire:click="deleteSelected" wire:confirm="Delete selected items?" class="btn btn-sm btn-danger mr-3 animate__animated animate__fadeIn">
                        <i class="fas fa-trash-alt mr-1"></i> Delete (<span x-text="selectedCount.length"></span>)
                    </button>
                </template>
                
                <button class="btn btn-sm shadow-sm px-4 text-white font-weight-bold btn-upload" 
                        @click="showModal = true; $wire.set('editingFileId', null)">
                    <i class="fas fa-plus mr-1"></i> New Asset
                </button>
            </div>
        </div>

        <div wire:loading.flex wire:target="search, modelFilter, gotoPage" class="row">
            @for($i=0; $i<6; $i++)
                <div class="col-6 col-md-2 mb-4">
                    <div class="skeleton-card"></div>
                </div>
            @endfor
        </div>

        <div wire:loading.remove wire:target="search, modelFilter, gotoPage">
            <div class="row">
                @forelse($fileGroups as $type => $files)
                    <div class="col-12 mt-3 mb-2">
                        <div class="d-flex align-items-center">
                            <span class="badge badge-primary-soft text-uppercase letter-spacing-1 px-3 py-1 mr-3" style="font-size: 0.65rem;">
                                {{ class_basename($type) }}
                            </span>
                            <div class="flex-grow-1 border-top opacity-1"></div>
                        </div>
                    </div>

                    @foreach($files as $file)
                        <div class="col-6 col-sm-4 col-md-3 col-lg-2 mb-4" wire:key="file-{{ $file->id }}">
                            <div class="card h-100 file-card border-0 shadow-sm {{ in_array($file->id, $selectedFiles) ? 'selected-border' : '' }}">
                                
                                <label class="custom-checkbox-container">
                                    <input type="checkbox" wire:model.live="selectedFiles" value="{{ $file->id }}">
                                    <span class="checkmark"></span>
                                </label>

                                <div class="file-preview">
                                    @if($file->is_image)
                                        <img src="{{ asset('storage/' . $file->file_path) }}" loading="lazy">
                                    @else
                                        <div class="d-flex align-items-center justify-content-center h-100 bg-soft-light">
                                            <i class="fas {{ $file->icon_data['icon'] }} fa-3x {{ $file->icon_data['color'] }}"></i>
                                        </div>
                                    @endif

                                    <div class="file-actions-overlay">
                                        <div class="btn-group shadow-lg">
                                            <a href="{{ asset('storage/' . $file->file_path) }}" target="_blank" class="btn btn-white btn-sm">
                                                <i class="fas fa-eye text-primary"></i>
                                            </a>
                                            <button wire:click="edit({{ $file->id }})" class="btn btn-white btn-sm">
                                                <i class="fas fa-pen text-success"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <div class="card-body p-2 bg-white text-center">
                                    <p class="mb-0 text-truncate font-weight-bold small text-dark">{{ $file->caption }}</p>
                                    <span class="text-muted" style="font-size: 0.6rem;">{{ strtoupper(pathinfo($file->file_path, PATHINFO_EXTENSION)) }}</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @empty
                    <div class="col-12 text-center py-5">
                        <div class="empty-state">
                            <i class="fas fa-folder-open fa-4x text-light mb-3"></i>
                            <h5 class="text-muted">No Assets Found</h5>
                            <p class="text-secondary small">Try adjusting your search or filters</p>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>

        <div class="d-flex justify-content-center mt-4">
            {{ $files->links() }}
        </div>

        <div x-show="showModal" class="modal-backdrop-custom" @click.self="showModal = false" x-transition>
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border-0 shadow-2xl rounded-xl overflow-hidden">
                    <form wire:submit.prevent="save">
                        <div class="modal-header border-0 bg-light">
                            <h6 class="modal-title font-weight-bold">
                                {{ $editingFileId ? '✏️ Edit Asset Info' : '🚀 Upload New Asset' }}
                            </h6>
                            <button type="button" class="close" @click="showModal = false">&times;</button>
                        </div>
                        <div class="modal-body p-4">
                            @if(!$editingFileId)
                                <div class="upload-area" 
                                     :class="isDragging ? 'dragging' : ''"
                                     @dragover.prevent="isDragging = true"
                                     @dragleave.prevent="isDragging = false"
                                     @drop.prevent="isDragging = false"
                                     onclick="document.getElementById('fileInput').click()">
                                    
                                    <input type="file" wire:model="file" id="fileInput" class="d-none">
                                    
                                    <div wire:loading.remove wire:target="file">
                                        <i class="fas fa-cloud-upload-alt fa-3x text-primary mb-3"></i>
                                        <p class="mb-0 font-weight-bold">Drag & Drop or Click</p>
                                        <small class="text-muted">Max size: 20MB</small>
                                    </div>

                                    <div wire:loading wire:target="file" class="py-3">
                                        <div class="spinner-grow text-primary" role="status"></div>
                                        <p class="mt-2 mb-0 small font-weight-bold text-primary">Processing File...</p>
                                    </div>
                                </div>
                            @endif

                            <div class="form-group mt-4">
                                <label class="small text-uppercase font-weight-bold text-muted">Display Caption</label>
                                <input type="text" wire:model="caption" class="form-control form-control-lg border-0 bg-light shadow-none" placeholder="Give it a name...">
                                @error('caption') <span class="text-danger small">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="modal-footer border-0 bg-light d-flex justify-content-between">
                            <button type="button" class="btn btn-link text-muted font-weight-bold" @click="showModal = false">Discard</button>
                            <button type="submit" class="btn btn-primary px-5 shadow-sm rounded-pill font-weight-bold">
                                {{ $editingFileId ? 'Save Changes' : 'Complete Upload' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>