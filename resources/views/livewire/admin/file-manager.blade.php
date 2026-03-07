<div class="file-manager-wrapper" x-data="{ 
    showModal: false, 
    isDragging: false,
    selectedCount: @entangle('selectedFiles').live 
}" x-cloak>
    
    <div class="container-fluid px-3">
        <div class="d-flex justify-content-between align-items-center mb-4 bg-white p-3 rounded shadow-sm border-0">
            <div class="d-flex align-items-center">
                <div class="input-group input-group-sm mr-3" style="width: 200px;">
                    <div class="input-group-prepend">
                        <span class="input-group-text bg-light border-0"><i class="fas fa-filter text-muted"></i></span>
                    </div>
                    <select wire:model.live="modelFilter" class="form-control border-0 bg-light font-weight-bold">
                        <option value="all">All Assets</option>
                        <option value="App\Models\Project">Projects</option>
                        <option value="App\Models\Team">Team</option>
                        <option value="App\Models\Event">Events</option>
                    </select>
                </div>
                <span class="badge badge-pill badge-light text-muted px-3 py-2 border">{{ $totalCount }} items</span>
            </div>

            <div class="d-flex align-items-center">
                <template x-if="selectedCount && selectedCount.length > 0">
                    <button wire:click="deleteSelected" wire:confirm="Delete selected items?" class="btn btn-sm btn-danger mr-2 px-3 shadow-sm">
                        <i class="fas fa-trash-alt mr-1"></i> Delete (<span x-text="selectedCount.length"></span>)
                    </button>
                </template>
                
                <button class="btn btn-sm btn-pink shadow-sm px-4" @click="showModal = true; $wire.set('editingFileId', null)" style="background-color: #e83e8c; color: white; border-radius: 20px;">
                    <i class="fas fa-cloud-upload-alt mr-1"></i> Upload Media
                </button>
            </div>
        </div>

        <div class="row">
            @forelse($fileGroups as $type => $files)
                <div class="col-12 mt-4 mb-2">
                    <div class="d-flex align-items-center">
                        <h6 class="text-uppercase font-weight-bold text-muted mb-0 letter-spacing-1" style="font-size: 0.75rem;">
                            {{ class_basename($type) }}
                        </h6>
                        <div class="flex-grow-1 ml-3 border-top opacity-2"></div>
                    </div>
                </div>

                @foreach($files as $file)
                    <div class="col-6 col-sm-4 col-md-3 col-lg-2 mb-4" wire:key="file-{{ $file->id }}">
                        <div class="card h-100 file-card shadow-sm border-0 transition-all {{ in_array($file->id, $selectedFiles) ? 'ring-active' : '' }}" style="border-radius: 12px; overflow: hidden;">
                            
                            <div class="position-absolute p-2" style="z-index: 10; top: 0; left: 0;">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" wire:model.live="selectedFiles" value="{{ $file->id }}" class="custom-control-input" id="check-{{ $file->id }}">
                                    <label class="custom-control-label" for="check-{{ $file->id }}"></label>
                                </div>
                            </div>

                            <div class="file-preview-container bg-light d-flex align-items-center justify-content-center" style="height: 140px; position: relative;">
                                @if($file->is_image)
                                    <img src="{{ asset('storage/' . $file->file_path) }}" class="w-100 h-100 object-fit-cover">
                                @else
                                    <i class="fas {{ $file->icon_data['icon'] }} fa-3x {{ $file->icon_data['color'] }}"></i>
                                @endif

                                <div class="file-actions-overlay">
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ asset('storage/' . $file->file_path) }}" target="_blank" class="btn btn-light"><i class="fas fa-eye text-primary"></i></a>
                                        <button wire:click="edit({{ $file->id }})" class="btn btn-light"><i class="fas fa-edit text-success"></i></button>
                                    </div>
                                </div>
                            </div>

                            <div class="card-body p-2 bg-white">
                                <p class="card-text mb-0 text-truncate font-weight-600 small text-dark" title="{{ $file->caption }}">
                                    {{ $file->caption }}
                                </p>
                                <div class="d-flex justify-content-between align-items-center mt-1">
                                    <span class="text-muted text-uppercase font-weight-bold" style="font-size: 0.6rem;">{{ $file->extension }}</span>
                                    <span class="text-muted" style="font-size: 0.6rem;">{{ $file->created_at->format('M d, Y') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @empty
                <div class="col-12 text-center py-5 bg-white rounded shadow-sm">
                    <div class="mb-3"><i class="fas fa-folder-open fa-3x text-light"></i></div>
                    <p class="text-muted">No media items found in this category.</p>
                </div>
            @endforelse
        </div>

        <div x-show="showModal" class="modal d-block" style="background: rgba(33, 37, 41, 0.8); z-index: 1060;" @keydown.escape.window="showModal = false">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border-0 shadow-lg" style="border-radius: 15px;">
                    <form wire:submit.prevent="save">
                        <div class="modal-header border-0 pb-0">
                            <h5 class="modal-title font-weight-bold">{{ $editingFileId ? 'Asset Details' : 'Upload Asset' }}</h5>
                            <button type="button" class="close" @click="showModal = false">&times;</button>
                        </div>
                        <div class="modal-body">
                            @if(!$editingFileId)
                                <div class="upload-drop-zone border-dashed p-4 text-center mb-3 rounded-lg" style="border: 2px dashed #dee2e6; background: #f8f9fa;">
                                    <input type="file" wire:model="file" class="d-none" id="fileUpload">
                                    <label for="fileUpload" class="mb-0 cursor-pointer">
                                        <i class="fas fa-cloud-upload-alt fa-2x text-primary mb-2"></i>
                                        <p class="mb-0 small font-weight-bold text-dark">Click to browse or drop file</p>
                                    </label>
                                    <div wire:loading wire:target="file" class="mt-2 text-primary small">
                                        <div class="spinner-border spinner-border-sm mr-1"></div> Processing...
                                    </div>
                                </div>
                            @endif
                            <div class="form-group">
                                <label class="small font-weight-bold text-muted text-uppercase">Asset Caption</label>
                                <input type="text" wire:model="caption" class="form-control form-control-alternative border-0 shadow-sm" style="background: #f1f3f5;" placeholder="Enter description...">
                            </div>
                        </div>
                        <div class="modal-footer border-0">
                            <button type="button" class="btn btn-link text-muted font-weight-bold" @click="showModal = false">Cancel</button>
                            <button type="submit" class="btn btn-pink px-4" style="background-color: #e83e8c; color: white; border-radius: 10px;">Save Asset</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>